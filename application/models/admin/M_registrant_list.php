<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_registrant_list extends CI_Model {
  var $table = "pendaftar";
  var $select_column = array("pendaftar.id","pendaftar.id_contest", "pendaftar.nim", "pendaftar.nama", "pendaftar.tempatLahir", "pendaftar.tglLahir", "pendaftar.jenisKel", "pendaftar.noTelp", "pendaftar.idJrs");
  
  var $order_column = array("pendaftar.id","pendaftar.id_contest", "pendaftar.nim", "pendaftar.nama", "pendaftar.tempatLahir", "pendaftar.tglLahir", "pendaftar.jenisKel", "pendaftar.noTelp", "pendaftar.idJrs",null);
  var $column_search = array("pendaftar.id","pendaftar.id_contest", "pendaftar.nim", "pendaftar.nama", "pendaftar.tempatLahir", "pendaftar.tglLahir", "pendaftar.jenisKel", "pendaftar.noTelp", "pendaftar.idJrs");

  var $default_order = "pendaftar.id";
  
  public function __construct()
  {
    parent::__construct();
    $this->load->database();
  }

  private function make_query($id)
  { 
    $this->db->select($this->select_column);
    $this->db->from($this->table);
    $this->db->where("pendaftar.id_contest",$id);
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
  function make_datatables($id){
    $this->make_query($id);
    if($_POST['length'] != -1){
      $this->db->limit($_POST['length'], $_POST['start']);
    }
    $query = $this->db->get();
    return $query->result();
  }
  function get_filtered_data($id){
    $this->make_query($id);
    $query = $this->db->get();
    return $query->num_rows();
  }
  function get_all_data($id)
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

  public function view_detail_score($idPendaftar,$idBea)
  {
    $sql = 'SELECT pendaftar_skor.id_contest, pendaftar.nim, pendaftar.id, kriteria_skor.nama kriteria, set_sub_kriteria_skor.nama pilihan, set_sub_kriteria_skor.skor FROM `pendaftar_skor`
    LEFT JOIN pendaftar ON pendaftar.id=pendaftar_skor.idPendaftar
    LEFT JOIN kriteria_skor ON pendaftar_skor.idKriteria=kriteria_skor.id
    LEFT JOIN set_sub_kriteria_skor ON pendaftar_skor.idSubKriteria=set_sub_kriteria_skor.id
    WHERE pendaftar_skor.idPendaftar = '.$idPendaftar.' && pendaftar_skor.id_contest = '.$idBea;
    $res = $this->db->query($sql);
    return $res->result();
  }
}