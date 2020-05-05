<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_contest extends CI_Model {
  var $table = "contest";
  var $select_column = array("contest.id", "contest.nama", "contest.kuota", "contest.dibuka", "contest.ditutup", "contest.seleksiTutup");
  
  var $order_column = array("contest.id", "contest.nama", "contest.kuota", "contest.dibuka", "contest.ditutup", "contest.seleksiTutup",null);
  var $column_search = array("contest.id", "contest.nama", "contest.kuota", "contest.dibuka", "contest.ditutup", "contest.seleksiTutup");
  var $default_order = "contest.id";
  
  public function __construct()
  {
    parent::__construct();
    $this->load->database();
  }

  private function make_query()
  { 
    $this->db->select($this->select_column);
    $this->db->from($this->table);
    $this->db->order_by($this->default_order,'DESC');

    $i = 0;
    foreach ($this->column_search as $item){
      if($_POST['search']['value']){
        if($i===0){
          $this->db->group_start();
          $this->db->like($item, $_POST['search']['value']);
        } else{
          $this->db->or_like($item, $_POST['search']['value']);
        }
        if(count($this->column_search) - 1 == $i)
          $this->db->group_end();
      }
      $i++;
    }

    if(isset($_POST["order"])){
      $this->db->order_by($this->order_column[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
    } else{
      $this->db->order_by($this->default_order, 'DESC');
    }
  }
  function make_datatables(){
    $this->make_query();
    if($_POST['length'] != -1){
      $this->db->limit($_POST['length'], $_POST['start']);
    }
    $query = $this->db->get();
    return $query->result();
  }
  function get_filtered_data(){
    $this->make_query();
    $query = $this->db->get();
    return $query->num_rows();
  }
  function get_all_data()
  {
    $this->db->select("*");
    $this->db->from($this->table);
    return $this->db->count_all_results();
  }
  
  public function get_by_id($id)
  {
    $this->db->from($this->table);
    $this->db->where('jurusan.id_jurusan',$id);
    $query = $this->db->get();
    return $query->row();
  }

  public function save_bea($data)
  {
    $this->db->insert($this->table, $data);
    return $this->db->insert_id();
  }
  public function save_sub_bea($data)
  {
    $this->db->insert_batch('set_contest_kriteria_skor', $data);
    return $this->db->insert_id();
  }

  public function getUpdate($where, $data)
  {
    $this->db->update('jurusan', $data, $where);
    return $this->db->affected_rows();
  }
  public function updateMahasiswa($where, $data)
  {
    $this->db->update('mahasiswa', $data, $where);
    return $this->db->affected_rows();
  }
  public function get_by_id_contest($id)
  {
    $this->db->from($this->table);
    $this->db->where('contest.id',$id);
    $query = $this->db->get();
    return $query->row();
  }
  public function get_skor_by_idContest($id)
  {
    $this->db->select('set_contest_kriteria_skor.idKriteriaSkor, set_contest_kriteria_skor.id');
    $this->db->from('set_contest_kriteria_skor');
    $this->db->where('set_contest_kriteria_skor.idContest',$id);
    $query = $this->db->get();
    return $query->result();
  }
  public function get_scoring()
  {
    $this->db->select('*');
    $this->db->from('kriteria_skor');
    $query = $this->db->get();
    return $query->result();
  }

  public function delete_by_id($id)
  {
    $this->db->where('id', $id);
    $this->db->delete($this->table);

    $this->db->where('idContest', $id);
    $this->db->delete('set_contest_kriteria_skor');

    // $this->db->where('pair_kriteria.id_bea',$id);
    // $this->db->delete('pair_kriteria');

    // $this->db->where('eigen_kriteria.id_bea',$id);
    // $this->db->delete('eigen_kriteria');
  }
  public function delete_pair_kriteria($id)
  {
    $this->db->where('pair_kriteria.id_contest',$id);
    $this->db->delete('pair_kriteria');

    $this->db->where('eigen_kriteria.id_contest',$id);
    $this->db->delete('eigen_kriteria');

    $this->db->where('consistence.id_contest',$id);
    $this->db->delete('consistence');
  }

  // Input Athletes

  public function get_skor_contest($id)
  {
    $this->db->select('set_contest_kriteria_skor.idKriteriaSkor, set_contest_kriteria_skor.id');
    $this->db->from('set_contest_kriteria_skor');
    $this->db->where('set_contest_kriteria_skor.idContest',$id);
    $result = $this->db->get()->result();

    $combo = "";
    foreach ($result as $res) {
      $namaKategori = $this->get_kategori($res->idKriteriaSkor);
      $combo .= '
      <div class="form-group">
        <input type="hidden" name="idKategoriSkor[]" value="'.$res->idKriteriaSkor.'">
        <label class="control-label col-md-3">'.$namaKategori->nama.'</label>
        <div class="col-md-9">
          <select name="score[]" class="form-control" required>
            <option value="" disabled selected>-Pilihan '.$namaKategori->nama.'</option>
            ';
            $subKategori = $this->get_sub_kategori($res->idKriteriaSkor);
            foreach ($subKategori as $kat) {
              $combo .='
              <option value="'.$kat->id.'">'.$kat->nama.'</option>
              ';
            }
            $combo .='
          </select>
        </div>
      </div>
      ';
    }
    return $combo;
  }

  public function get_kategori($id)
  {
    $this->db->select('kriteria_skor.nama');
    $this->db->from('kriteria_skor');
    $this->db->where('kriteria_skor.id',$id);
    $res = $this->db->get();
    return $res->row();
  }

  public function get_sub_kategori($id)
  {
    $this->db->select('set_sub_kriteria_skor.nama, set_sub_kriteria_skor.id');
    $this->db->from('set_sub_kriteria_skor');
    $this->db->where('set_sub_kriteria_skor.idKriteriaSkor',$id);
    $res = $this->db->get();
    return $res->result();
  }
  function count_data_pendaftar($id)
  {
    $this->db->select("nim");
    $this->db->from("pendaftar");
    $this->db->where("pendaftar.id_contest",$id);
    return $this->db->count_all_results();
  }

  public function dataFakultas() {
    $data = $this->db->query("SELECT * from fakultas");
    if ($data) {
      return $data->result();
    } else {
      return false;
    }
  }
  function get_jurusan($fakultas) {
    $getjur ="select j.id,j.namaJur,f.namaFk from jurusan j,fakultas f where j.idFk=f.id and f.id='$fakultas' order by j.namaJur asc";
    return $this->db->query($getjur)->result();
  }
  public function getInsert($data)
  {
    $this->db->insert('pendaftar',$data);
    return $this->db->insert_id();
  }

  public function pendaftarSkor($data)
  {
    $this->db->insert_batch('pendaftar_skor', $data);
    return $this->db->insert_id();
  }

  public function data_jurusan($id)
  {
    $this->db->select('jurusan.namaJur');
    $this->db->from('jurusan');
    $this->db->where('jurusan.id',$id);
    $res = $this->db->get();
    return $res->row();
  }

  public function update_setting_contest($where, $data)
  {
    $this->db->update($this->table, $data, $where);
    return $this->db->affected_rows();
  }

  public function insert_setting_sub_bea($data)
  {
    $this->db->insert('set_contest_kriteria_skor', $data);
    return $this->db->insert_id();
  }

  public function update_setting_sub_bea($where, $data)
  {
    $this->db->update('set_contest_kriteria_skor', $data, $where);
    return $this->db->affected_rows();
  }

  public function delete_setting_sub_bea($id)
  {
    $this->db->where('id', $id);
    $this->db->delete('set_contest_kriteria_skor');
  }
}