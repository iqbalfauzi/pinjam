<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_tugas_selesai extends CI_Model {

	var $table = 'kotak_masuk';//nama table database
	var $select_column = array('kotak_masuk.id_kotakmasuk','kotak_masuk.id_tugas','kotak_masuk.m_file','kotak_masuk.nis','kotak_masuk.nama_siswa','kotak_masuk.id_kelompok','kotak_masuk.tahun_angkatan','kotak_masuk.nama_guru','kotak_masuk.keterangan','kotak_masuk.tanggal','kotak_masuk.judul_tugas','kotak_masuk.pokok_1','kotak_masuk.nilai');

	var $order_column = array('kotak_masuk.id_kotakmasuk','kotak_masuk.id_tugas','kotak_masuk.m_file','kotak_masuk.nis','kotak_masuk.nama_siswa','kotak_masuk.id_kelompok','kotak_masuk.tahun_angkatan','kotak_masuk.nama_guru','kotak_masuk.keterangan','kotak_masuk.tanggal','kotak_masuk.judul_tugas','kotak_masuk.pokok_1','kotak_masuk.nilai',null);
	var $column_search = array('kotak_masuk.id_kotakmasuk','kotak_masuk.id_tugas','kotak_masuk.m_file','kotak_masuk.nis','kotak_masuk.nama_siswa','kotak_masuk.id_kelompok','kotak_masuk.tahun_angkatan','kotak_masuk.nama_guru','kotak_masuk.keterangan','kotak_masuk.tanggal','kotak_masuk.judul_tugas','kotak_masuk.pokok_1','kotak_masuk.nilai');
	var $default_order = 'kotak_masuk.id_kotakmasuk';

	public function __construct()
	{
		parent::__construct();
		$this->load->database();
	}

	private function _get_datatables_query($id_kelompok,$id_tugas)
	{
		$this->db->select($this->select_column);
		$this->db->from($this->table);
		$this->db->join('kelompok', 'kotak_masuk.id_kelompok = kelompok.id_kelompok', 'left');
		$this->db->join('tbl_tugas', 'kotak_masuk.id_tugas = tbl_tugas.id_tugas', 'left');
		$this->db->where('kotak_masuk.status_tugas',0);
		$this->db->where('kotak_masuk.keterangan',1);


		//select 1
		if ($id_kelompok != 0 && $id_tugas == 0) {
			$this->db->where("kotak_masuk.id_kelompok", $id_kelompok);
		}elseif($id_kelompok == 0 && $id_tugas != 0){
			$this->db->where("kotak_masuk.id_tugas", $id_tugas);

		//select 2
		}elseif($id_kelompok != 0 && $id_tugas != 0){
			$this->db->where("kotak_masuk.id_kelompok", $id_kelompok);
			$this->db->where("kotak_masuk.id_tugas", $id_tugas);

		//select 0
		}elseif($id_kelompok == 0 && $id_tugas == 0){
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

	function get_datatables($id_kelompok,$id_tugas)
	{
		$this->_get_datatables_query($id_kelompok,$id_tugas);
		if($_POST['length'] != -1)
			$this->db->limit($_POST['length'], $_POST['start']);
		$query = $this->db->get();
		return $query->result();
	}

	function count_filtered($id_kelompok,$id_tugas)
	{
		$this->_get_datatables_query($id_kelompok,$id_tugas);
		$query = $this->db->get();
		return $query->num_rows();
	}

	public function count_all()
	{
		$this->db->from($this->table);
		return $this->db->count_all_results();
	}

	public function get_by_id($id)
	{
		$this->db->from($this->table);
		$this->db->where('id_kotakmasuk',$id);
		$query = $this->db->get();

		return $query->row();
	}

	public function save($data)
	{
		$this->db->insert($this->table, $data);
		return $this->db->insert_id();
	}

	public function update($where, $data)
	{
		$this->db->update($this->table, $data, $where);
		return $this->db->affected_rows();
	}

	public function delete_by_id($idAgama)
	{
		$this->db->where('idAgama', $idAgama);
		$this->db->delete($this->table);
	}
	public function change_id($where, $data)
	{
		$this->db->update($this->table, $data, $where);
		return $this->db->affected_rows();
	}
	public function getdata($key)
	{
		$this->db->from('kelompok');
		$this->db->where('kelompok.id_kelompok',$key);
		$query = $this->db->get();
		return $query->row();
	}
	public function change_status($where, $data)
	{
		$this->db->update($this->table, $data, $where);
		return $this->db->affected_rows();
	}

}
