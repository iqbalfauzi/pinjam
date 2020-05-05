<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_selection extends CI_Model {
  var $table = "pendaftar";
  var $select_column = array("pendaftar.id", "pendaftar.id_contest", "pendaftar.nim", "pendaftar.nama", "pendaftar.idJrs");
  
  var $order_column = array("pendaftar.id", "pendaftar.id_contest", "pendaftar.nim", "pendaftar.nama", "pendaftar.idJrs",null);
  var $column_search = array("pendaftar.id", "pendaftar.id_contest", "pendaftar.nim", "pendaftar.nama", "pendaftar.idJrs");
  var $default_order = "pendaftar.id";
  
  public function __construct()
  {
    parent::__construct();
    $this->load->database();
  }

  function make_query($idBea)
  {
   $data_wp = array();
   $bobot_global = array();

   $this->db->select('*');
   $this->db->from('pendaftar');
   $this->db->where('pendaftar.id_contest',$idBea);
   $tbl_alternatif = $this->db->get()->result_array();

   $tbl_subkriteria = $this->db->get_where('eigen_kriteria',array('id_contest'=>$idBea))->result_array();

    //Memasukkan Data Mahasiswa Kedalam Array Data Weighted Product
   for($x=0;$x<count($tbl_alternatif);$x++){
    $data_wp[$x]['id'] = $tbl_alternatif[$x]['id'];
    $data_wp[$x]['nim'] = $tbl_alternatif[$x]['nim'];
    $data_wp[$x]['nama'] = $tbl_alternatif[$x]['nama'];
    $data_wp[$x]['idJrs'] = $tbl_alternatif[$x]['idJrs'];
    $data_wp[$x]['status'] = $tbl_alternatif[$x]['status'];
  }

    //Mengambil Nilai Bobot(Eigen Value) dan menggunakan id_kriteria sebagai index key
  for($x=0;$x<count($tbl_subkriteria);$x++){
    $bobot_global[$tbl_subkriteria[$x]['id_kriteria']]=$tbl_subkriteria[$x]['value_eigen'];
  }

  

    //Mengambil Nilai Mahasiswa
  for($x=0;$x<count($tbl_alternatif);$x++){
      //Mengambil Nilai PerMahasiswa
    $this->db->select(array('pendaftar_skor.*','set_sub_kriteria_skor.skor'));
    $this->db->from('pendaftar_skor');
    $this->db->join('set_sub_kriteria_skor', 'set_sub_kriteria_skor.id = pendaftar_skor.idSubKriteria', 'left');
    $this->db->where('pendaftar_skor.id_contest',$idBea);
    $this->db->where('idPendaftar',$tbl_alternatif[$x]['id']);
    $nilai_alternatif = $this->db->get()->result();

      //Nilai Vektor S Awal adalah 1
    $nilai_vektor = 1;
      //Perulangan Untuk Setiap Nilai Mahasiswa
    foreach($nilai_alternatif as $nilai_alt){
      //Menghitung nilai Vektor dengan mengkuadratkan nilai subkriteria dengan bobot key index subkriteria
      $nilai_vektor = $nilai_vektor * pow($nilai_alt->skor,$bobot_global[$nilai_alt->idKriteria]);
    }

      //Menambah Nilai Vektor S
    $data_wp[$x]['vektor_s'] = $nilai_vektor;
  }

    //Menghitung Total Nilai Vektor S
  $total_vektor_s = 0;
  foreach ($data_wp as $num => $values) {
    $total_vektor_s += $values['vektor_s'];
  }

    //Menghitung Nilai Vektor V dengan Membagi Nilai Vektor S Siswa dengan Total Vektor S
  for($x=0;$x<count($data_wp);$x++){
    $data_wp[$x]['vektor_v'] = $data_wp[$x]['vektor_s']/$total_vektor_s;
  }

    //Mengurutkan DESC vektor_v
  usort($data_wp, function($a, $b) {
    if ($a['vektor_v'] == $b['vektor_v'])
      return 0;
    return $a['vektor_v'] < $b['vektor_v'] ? 1 : -1;
  });

    // return $data_wp;

  $i = 0;
    foreach ($this->column_search as $item) // loop column
    {
      if($_POST['search']['value']) // if datatable send POST for search
      {

        if($i===0) // first loop
        {
          $this->db->group_start(); // open bracket. query Where with OR clause better with bracket. because maybe can combine with other WHERE with AND.
          $this->db->like($item, $_POST['search']['value']);
        }
        else
        {
          $this->db->or_like($item, $_POST['search']['value']);
        }

        if(count($this->column_search) - 1 == $i) //last loop
        $this->db->group_end(); //close bracket
      }
      $i++;
    }
    return $data_wp;
  }

  function make_datatables($idBea){
    $this->make_query($idBea);
    if($_POST['length'] != -1){
      $this->db->limit($_POST['length'], $_POST['start']);
    }
    $query = $this->db->get();
    return $query->result();
  }
  function get_filtered_data($idBea){
    $this->make_query($idBea);
    $query = $this->db->get();
    return $query->num_rows();
  }
  function get_all_data()
  {
    $this->db->select("*");
    $this->db->from($this->table);
    return $this->db->count_all_results();
  }
  
  public function get_select_contest()
  {
    $this->db->select('contest.id, contest.nama');
    $this->db->from('contest');
    $this->db->order_by('contest.id','DESC');
    $query = $this->db->get();
    return $query->result();
  }

  public function infoDiterima($idBea)
  {
    $sql = "SELECT COUNT(status) diterima FROM `pendaftar` WHERE id_contest=".$idBea." && status=1";
    $query = $this->db->query($sql);
    return $query->row()->diterima;
  }

  public function getJurusanFakultas($id)
  {
    $sql = 'SELECT jurusan.*,fakultas.namaFk from jurusan,fakultas WHERE jurusan.idFk=fakultas.id AND jurusan.id="'.$id.'"';
    $res = $this->db->query($sql);
    return $res->row();
  }

  public function seleksi_penerima($where, $data)
  {
    $this->db->update("pendaftar", $data, $where);
    return $this->db->affected_rows();
  }
  public function check_status_penerima($nim)
  {
    $sql = 'SELECT pendaftar.nim,pendaftar.nama, (contest.nama)nama_contest, pendaftar.status FROM `pendaftar`
    LEFT JOIN contest ON contest.id=pendaftar.id_contest
    WHERE pendaftar.status=1 && pendaftar.nim="'.$nim.'"';
    $res = $this->db->query($sql);
    return $res->row();
  }
}