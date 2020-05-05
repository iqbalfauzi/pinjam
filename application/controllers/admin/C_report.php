<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');


class C_report extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->library('Loginauth');
		$this->loginauth->view_page();

		$this->load->model('admin/M_report','model');
	}

	public function index()
	{
		$data['select_contest'] = $this->model->get_select_contest();

		$this->load->view('attribute/header_admin');
		$this->load->view('admin/v_report',$data);
		$this->load->view('attribute/footer');
		
	}

	public function getDiterima($idBea)
	{
		$data = $this->model->infoDiterima($idBea);
		echo json_encode($data);
	}
	public function get_scoring_data()
	{
		$data = $this->model->get_scoring();
		echo json_encode($data);
	}

	public function datatable()
	{
		$filterBea = $this->input->post('filterBea')?$this->input->post('filterBea'):0;
		
		$list = $this->model->get_datatables($filterBea);
		$data = array();
		$no = 0;
		foreach ($list as $model) {
			$no+=1;
			$row = array();
			$row[] = $no;
			$row[] = $model->nim;
			$row[] = $model->nama;
			$row[] = $this->model->getJurusanFakultas($model->idJrs)->namaFk;
			$row[] = $this->model->getJurusanFakultas($model->idJrs)->namaJur;
			$row[] = $this->model->getJurusanFakultas($model->idJrs)->namaJur;
			
			$data[] = $row;
		}

		$output = array(
			"draw" => $_POST['draw'],
			"recordsTotal" => $no,
			"recordsFiltered" => $this->model->count_filtered($filterBea),
			"data" => $data,
			);
		echo json_encode($output);
	}

	public function get_print_excell($filterBea)
	{
		$data['databea'] = $this->model->make_query_excell($filterBea);
		$this->load->view('admin/print_excell', $data);
	}

	public function get_print_pdf($filterBea)
	{
		$data['databea'] = $this->model->make_query_excell($filterBea);
		$this->load->view('admin/print_pdf', $data);
	}
	
}


