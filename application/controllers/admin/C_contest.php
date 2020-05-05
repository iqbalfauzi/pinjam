<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');


class C_contest extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->library('Loginauth');
		$this->loginauth->view_page();

		$this->load->model('admin/M_contest','model');
	}

	public function index()
	{
		$this->load->view('attribute/header_admin');
		$this->load->view('admin/v_contest');
		$this->load->view('attribute/footer');
		
	}

	public function pengaturan()
	{
		$id = $this->input->post('idPengaturan');
		if ($id != null) {
			$detail= $this->model->get_by_id_contest($id);
			$data = array(
				'idSetBea' => $id,
				'nama' => $detail->nama,
				'dibuka' => $detail->dibuka,
				'ditutup' => $detail->ditutup,
				'seleksiTutup' =>$detail->seleksiTutup,
				'kuota' => $detail->kuota,
				'skor' => $this->model->get_skor_by_idContest($id),
				'combo' => $this->model->get_scoring()
				);
		}else {
			$data = array(
				'idSetBea' => "",
				'nama' => "",
				'dibuka' => "",
				'ditutup' => "",
				'seleksiTutup' =>"",
				'kuota' => "",
				'skor' => null
				);
		}
		$this->load->view('attribute/header_admin');
		$this->load->view('admin/v_contest_pengaturan', $data);
		$this->load->view('attribute/footer');
	}
	public function get_scoring_data()
	{
		$data = $this->model->get_scoring();
		echo json_encode($data);
	}

	public function add_data()
	{
		$data_contest = array(
			'nama' => $this->input->post('nama'),
			'dibuka' => $this->input->post('dibuka'),
			'ditutup' => $this->input->post('ditutup'),
			'seleksiTutup' => $this->input->post('seleksiTutup'),
			'kuota' => $this->input->post('kuota')
			);
		$insert_bea = $this->model->save_bea($data_contest);
		$count_score = count($this->input->post('score'));
		if ($this->input->post('score')) {
			$data = array();
			for ($i=0;$i<$count_score;$i++) {
				$skor = $this->input->post('score['.$i.']');
				if ($skor != "HAPUS") {
					$data[]= array(
						'idContest' => $insert_bea,
						'idKriteriaSkor' => $skor,
						);
				}
			}
			$insert_sub_bea = $this->model->save_sub_bea($data);
		}
		echo json_encode(array("status" => TRUE));
	}
	public function update_data()
	{
		$data_contest = array(
			'nama' => $this->input->post('nama'),
			'dibuka' => $this->input->post('dibuka'),
			'ditutup' => $this->input->post('ditutup'),
			'seleksiTutup' => $this->input->post('seleksiTutup'),
			'kuota' => $this->input->post('kuota')
			);

		$idSetBea = $this->input->post('idSetBea');
		$this->model->update_setting_contest(array('id' => $idSetBea), $data_contest);

    //Scoring Beasiswa
		$count_score = count($this->input->post('score'));
		for ($i=0;$i<$count_score;$i++) {
			$skor = $this->input->post('score['.$i.']');
			$idSet = $this->input->post('idSet['.$i.']');
			if ($skor != null && $idSet == null && $skor != "HAPUS") {
        # insert kategori
				$data= array(
					'idContest' => $idSetBea,
					'idKriteriaSkor' => $skor,
					);
				$this->model->insert_setting_sub_bea($data);
			}elseif ($skor != null && $idSet != null && $skor != "HAPUS") {
        # update kategori
				$data= array(
					'idContest' => $idSetBea,
					'idKriteriaSkor' => $skor,
					);
				$this->model->update_setting_sub_bea(array('id' => $idSet), $data);
			}elseif ($skor != null && $idSet != null && $skor == "HAPUS") {
        # delete kategori
				$this->model->delete_setting_sub_bea($idSet);
			}
		}
		echo json_encode(array("status" => TRUE));
	}

	public function delete_data()
	{
		$id = $this->input->post('idSetBea');
		$this->model->delete_by_id($id);

		// echo json_encode($id);
		echo json_encode(array("status" => TRUE));
	}

	public function edit($no_induk)
	{
		$data = $this->model->get_by_id($no_induk);
		echo json_encode($data);
	}

	public function update_profile()
	{	
		$id = $this->input->post('idJurusan');
		$data = array(
			'jurusan' 	=> $this->input->post('jurusan'),
			'idFk' 		=> $this->input->post('fakultas')
			);

		$this->db->where('id_jurusan',$id);
		$this->db->update('akses',$data);

		$this->session->set_flashdata("pesan", "<div class=\"alert alert-success alert-dismissible\">Data berhasil di update</div>");
		redirect('penugasan/penugasan/profile');
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
			$row[] = '
			<form action="'.base_url('admin/C_contest/pengaturan').'" method="post">
				<button class="btn btn-xs btn-primary" title="View/Edit" type="submit" name="idPengaturan" value="'.$model->id.'"><i class="glyphicon glyphicon-cog"></i></button>
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


