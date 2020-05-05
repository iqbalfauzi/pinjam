<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');


class C_registrant extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->library('Loginauth');
		$this->loginauth->view_page();

		$this->load->model('admin/M_contest','model');
	}

	public function index()
	{
		$data['fakultas'] = $this->model->dataFakultas();

		$this->load->view('attribute/header_admin');
		$this->load->view('admin/v_registrant',$data);
		$this->load->view('attribute/footer');
		
	}
	public function getJurusan() {
		$fakultas = $_GET['fakultas2'];
		$getjur = $this->model->get_jurusan($fakultas);
		echo json_encode($getjur);
	}

	public function simpan()
	{
		$nim  = $this->input->post('nim');
		$data =array(
			'id_contest' 	=> $this->input->post('idContest'),
			'nim'       	=> $this->input->post('nim'),
			'nama'       	=> $this->input->post('nama'),
			'tempatLahir'  	=> $this->input->post('tempatLahir'),
			'tglLahir'      => $this->input->post('tanggalLahir'),
			'jenisKel'      => $this->input->post('jenisKel'),
			'noTelp' 		=> $this->input->post('noTelp'),
			'idJrs'   		=> $this->input->post('jurusan')
			);

		$pendaftar = $this->model->getInsert($data);

		$count_score = count($this->input->post('idKategoriSkor'));
		$data1 = array();
		for ($i=0;$i<$count_score;$i++) {
			$kategori_skor = $this->input->post('idKategoriSkor['.$i.']');
			$skor          = $this->input->post('score['.$i.']');
			$data1[]= array(
				'idKriteria'    => $kategori_skor,
				'idSubKriteria' => $skor,
				'id_contest'    => $this->input->post('idContest'),
				'idPendaftar'   => $pendaftar
				);
		}
		$this->model->pendaftarSkor($data1);
		echo json_encode(array("score" => TRUE));
	}

	public function add_data($id)
	{
		$kriteria = $this->model->get_by_id_contest($id);
		$idContest = $kriteria->id;
		$nama = $kriteria->nama;

		$data = array();
		$data [0] = array(
			'id' => $idContest,
			'nama' => $nama,
			'combo' => $this->model->get_skor_contest($id)
			);
		echo json_encode($data);
	}

	public function datatable()
	{
		$list = $this->model->make_datatables();
		$data = array();
		$no = 0;
		foreach ($list as $model) {
			$no+=1;
			$row = array();
			$row[] = $no;
			$row[] = $model->nama;
			$row[] = $model->kuota;
			$row[] = $model->dibuka;
			$row[] = $model->ditutup;
			$row[] = $model->seleksiTutup;

			//add html for action
			$count_athletes = $this->model->count_data_pendaftar($model->id);
			$row[] ='
			<a class="btn btn-sm btn-success" name="add" id="'.$model->id.'" href="javascript:void()" title="Add data" onclick="add_data('."'".$model->id."'".')">'.$count_athletes.' <i class="glyphicon glyphicon-plus"></i> </a>
			';

			$alamat = base_url('admin/C_registrant_list');
			$row[] = '
			<form action="'.$alamat.'" method="post">
				<a target="_blank" class="btn btn-sm btn-primary" href="javascript:void()" title="List data Athletes" onclick="parentNode.submit();"><i class="glyphicon glyphicon-cog"></i></a>
				<input type="hidden" name="id" value="'.$model->id.'">
				<input type="hidden" name="nama" value="'.$model->nama.'">
			</form>
			';

			$data[] = $row;
		}

		$output = array(
			"draw" => $_POST['draw'],
			"recordsTotal" => $no,
			"recordsFiltered" => $this->model->get_filtered_data(),
			"data" => $data,
			);
		echo json_encode($output);
	}

}


