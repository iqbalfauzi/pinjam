<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_master_kriteria extends CI_Model {

	var $table = "kriteria_skor";
	var $select_column = array("kriteria_skor.id", "kriteria_skor.nama");
	var $order_column = array("kriteria_skor.id", "kriteria_skor.nama", null, null);
	var $column_search = array("kriteria_skor.id", "kriteria_skor.nama");
	var $default_order = "kriteria_skor.id";

	function make_query()
	{
		$this->db->select($this->select_column);
		$this->db->from($this->table);
		$this->db->order_by($this->default_order, 'DESC');

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
		if($_POST["length"] != -1)
		{
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

	public function get_sub_score($id)
	{
		$sql="SELECT sub.id, sub.nama, sub.skor FROM set_sub_kriteria_skor sub WHERE sub.idKriteriaSkor='".$id."' ORDER BY sub.skor ASC";
		$query = $this->db->query($sql);
		$data = "";
		$color_label = "purple";

		foreach ($query->result() as $val) {
			$data .= '<span class="label bg-'.$color_label.'">('.$val->skor.') '.$val->nama.'</span>&nbsp;';
		}

		return $data;
	}

	public function save_kriteria($data)
	{
		$this->db->insert($this->table, $data);
		return $this->db->insert_id();
	}

	public function save_sub_kriteria($data)
	{
		$this->db->insert_batch('set_sub_kriteria_skor', $data);
		return $this->db->insert_id();
	}

	public function get_by_id($id)
	{
		$this->db->from('kriteria_skor');
		$this->db->where('kriteria_skor.id',$id);
		$query = $this->db->get();
		return $query->row();
	}

	public function get_by_id_sub($id)
	{
		$this->db->from('set_sub_kriteria_skor');
		$this->db->where('set_sub_kriteria_skor.idKriteriaSkor',$id);
		$query = $this->db->get();
		return $query->result();
	}

	public function update_kriteria($where, $data)
	{
		$this->db->update($this->table, $data, $where);
		return $this->db->affected_rows();
	}

	public function insert_sub_kriteria($dataSub)
	{
		$this->db->insert('set_sub_kriteria_skor', $dataSub);
		return $this->db->insert_id();
	}

	public function update_sub_kriteria($where, $data)
	{
		$this->db->update('set_sub_kriteria_skor', $data, $where);
		return $this->db->affected_rows();
	}

	public function delete_sub_kriteria($idSub)
	{
		$this->db->where('id', $idSub);
		$this->db->delete('set_sub_kriteria_skor');
	}

	public function delete_by_id($id)
	{
		$this->db->where('id', $id);
		$this->db->delete($this->table);
	}

}
