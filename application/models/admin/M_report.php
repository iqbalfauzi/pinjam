<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_report extends CI_Model {
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

  private function _get_datatables_query($id_contest)
  {
    $this->db->select($this->select_column);
    $this->db->from($this->table);
    $this->db->where('pendaftar.status',1);

    //select 1
    if ($id_contest != 0) {
      $this->db->where("pendaftar.id_contest", $id_contest);

    //select 0
    }elseif($id_contest == 0){

    }
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

  function get_datatables($id_contest)
  {
    $this->_get_datatables_query($id_contest);
    if($_POST['length'] != -1)
      $this->db->limit($_POST['length'], $_POST['start']);
    $query = $this->db->get();
    return $query->result();
  }

  function count_filtered($id_contest)
  {
    $this->_get_datatables_query($id_contest);
    $query = $this->db->get();
    return $query->num_rows();
  }

  public function count_all()
  {
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
  
  public function getJurusanFakultas($id)
  {
    $sql = 'SELECT jurusan.*,fakultas.namaFk from jurusan,fakultas WHERE jurusan.idFk=fakultas.id AND jurusan.id="'.$id.'"';
    $res = $this->db->query($sql);
    return $res->row();
  }

  public function make_query_excell($filterBea) {
    $this->db->select(array("pendaftar.id", "pendaftar.id_contest", "pendaftar.nim", "pendaftar.nama", "pendaftar.idJrs","jurusan.namaJur","fakultas.namaFk","(contest.nama)nama_contest"));
    $this->db->from($this->table);
    $this->db->join('contest', 'pendaftar.id_contest = contest.id', 'left'); 
    $this->db->join('jurusan', 'pendaftar.idJrs = jurusan.id', 'left');        
    $this->db->join('fakultas', 'fakultas.id = jurusan.idFk', 'left');
    $this->db->where("pendaftar.status=1");

        //select 1
    if ($filterBea != 0) {
      $this->db->where("pendaftar.id_contest", $filterBea);

    //select 0
    }elseif($filterBea == 0){

    }
    $query = $this->db->get();
    return $query->result();
  }
}