<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');


class C_registrant_list extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->library('Loginauth');
		$this->loginauth->view_page();

		$this->load->model('admin/M_contest','model');
		$this->load->model('admin/M_registrant_list','mod');
	}

	public function index()
	{
		$id_contest = $this->input->post('id');
		$nama 	= $this->input->post('nama');

		$data = array(
			"id_contest"=> $id_contest,
			"nama" 		=> $nama,
			"fakultas" 	=> $this->model->dataFakultas()
			);

		$this->load->view('attribute/header_admin');
		$this->load->view('admin/v_registrant_list',$data);
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

	public function hapus($id)
	{
		$this->db->delete('pendaftar',array('id'=>$id));

		echo json_encode(array("status" => TRUE));
	}

	public function view_detail_score($idPendaftar, $idBea)
	{
		$data = $this->mod->view_detail_score($idPendaftar, $idBea);
		echo json_encode($data);
	}

	public function datatable()
	{
		$id_contest = $this->input->post('id_contest')?$this->input->post('id_contest'):0;

		$list = $this->mod->make_datatables($id_contest);
		$data = array();
		$no = 0;
		foreach ($list as $model) {
			$no+=1;
			$row = array();
			$row[] = $no;
			$row[] = $model->nim;
			$row[] = $model->nama;
			$row[] = $model->tempatLahir;
			$row[] = $model->tglLahir;
			$row[] = $model->noTelp;

			$nama_jurusan = $this->model->data_jurusan($model->idJrs)->namaJur;
			$row[] = $nama_jurusan;

			//add html for action
			$row[] ='
			<a class="btn btn-sm btn-primary" href="javascript:void()" title="View Data Athlete" onclick="view_detail_score('.$model->id.','.$model->id_contest.')"><i class="glyphicon glyphicon-zoom-in"></i> </a>
			';
			$row[] ='
			<a class="btn btn-sm btn-danger" name="add" id="'.$model->id.'" href="javascript:void()" title="Delete data" onclick="delete_person('."'".$model->id."'".')"><i class="glyphicon glyphicon-trash"></i> </a>
			';

			$data[] = $row;
		}

		$output = array(
			"draw" => $_POST['draw'],
			"recordsTotal" => $no,
			"recordsFiltered" => $this->mod->get_filtered_data($id_contest),
			"data" => $data,
			);
		echo json_encode($output);
	}

}


