<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');


class C_pair extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->library('Loginauth');
		$this->loginauth->view_page();

		$this->load->model('admin/M_contest','model');
		$this->load->model('admin/masterAHP/Kriteria_model');
	}

	public function index()
	{
		$this->load->view('attribute/header_admin');
		$this->load->view('admin/v_pair');
		$this->load->view('attribute/footer');
		
	}

	public function setting()
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
		$this->load->view('admin/v_pair_setting', $data);
		$this->load->view('attribute/footer');
	}

	public function settings()
	{
		$id = $this->input->post('idPengaturan');
		if ($id != null) {
			$detail = $this->model->get_by_id_contest($id);
			$get_by_consistence = $this->Kriteria_model->get_by_consistence($id);
			$data['get_by_consistence'] = $this->Kriteria_model->get_by_consistence($id);

			$data['idSetBea']     = $id;
			$data['nama']         = $detail->nama;
			$data['dibuka']       = $detail->dibuka;
			$data['ditutup']      = $detail->ditutup;
			$data['seleksiTutup'] = $detail->seleksiTutup;
			$data['kuota']        = $detail->kuota;

			$data['idContest']     = $id;
			$data['namaContest']   = $this->Kriteria_model->get_by_id_bea($id)->nama;
			$data['kriteria']       = $this->Kriteria_model->getKriteria(false);
			$data['kriteriaMatrix'] = $this->Kriteria_model->getKriteria($id);
			$data['jumlahKriteria'] = $this->Kriteria_model->countKriteria($id);
			$data['pK']             = $this->Kriteria_model->getPairKriteria($id);
			if(empty($data['pK'])) {
				foreach($data['kriteriaMatrix'] as $kol1){
					foreach($data['kriteriaMatrix'] as $kol2){
						$data['pK'][$kol1->idKriteriaSkor][$kol2->idKriteriaSkor] = 0;
					}
				}
			}

      //Show Concystency
			if ($get_by_consistence != null) {
				$data['lambda']       = $get_by_consistence->lambda;
				$data['consIndex']    = $get_by_consistence->consIndex;
				$data['consRatio']    = $get_by_consistence->consRatio;
				$data['isConsistence']= $get_by_consistence->isConsistence;
			}else{
				$data['lambda']       = "";
				$data['consIndex']    = "";
				$data['consRatio']    = "";
				$data['isConsistence']= "";
			}

      //Show Nilai Eigen Prioritas
			$getEigen =$this->Kriteria_model->getEigenValue($id);
			$value_eigen =$this->Kriteria_model->count_kriteria($id)->value_eigen;
			if($value_eigen != 0){
				$data['eigenVal'] = $getEigen;
				$data['jumlah']   = number_format($value_eigen,4);
			}else{
				$data['eigenVal'] = $getEigen;
				$data['jumlah']   = 0;
			}


		}else {
			$data['idSetBea']       = "";
			$data['nama']           = "";
			$data['dibuka']         = "";
			$data['ditutup']        = "";
			$data['seleksiTutup']   = "";
			$data['kuota']          = "";

			$data['namaContest']    = "";
			$data['kriteria']       = "";
			$data['kriteriaMatrix'] = "";
			$data['jumlahKriteria'] = "";
			$data['pK']             = "";

			$data['lambda']       = "";
			$data['consIndex']    = "";
			$data['consRatio']    = "";
			$data['isConsistence']= "";
		}
		$this->load->view('attribute/header_admin');
		$this->load->view('admin/v_pair_setting', $data);
		$this->load->view('attribute/footer');
	}

	public function ahpUpdate(){
   //update kriteria berdasarkan level idBeasiswa yang mengakses
		$this->load->library('AHP');
		$ahp = new AHP();
		$ahp->setCriteria($this->input->post("krit"));
  $data['kritMatriks'] = $ahp->altCriteria(); //normalisasi matrix
  $ahp->kuadratMatriks();

  // cek consistence ratio sebelum dimasukkan. jangan simpan nilai kriteria apabila CI > 10% (0.1)
  
  $ahpconsistency = $ahp->consistenceRatio();
  if($ahpconsistency['isConsistence']){
  	$data['kritEigen'] = $ahp->eigenCriteria();
  	$data['id_bea']   = $this->input->post('idContest');
  	$this->Kriteria_model->update($data);

  	$ahpconsistency['id_contest'] = $this->input->post('idContest');
  	$this->Kriteria_model->updateCi_Cr($ahpconsistency);
  }

  $this->session->set_flashdata($ahpconsistency);
  //flash session dengan nilai CI,CR dan lambda dari perhitungan AHP. ditampilkan di halaman input kriteria
  redirect(base_url('admin/C_pair'));
  //print_r($data['kritEigen']);
}

public function delete_data()
{
	$id = $this->input->post('idSetBea');
	$this->model->delete_pair_kriteria($id);

	echo json_encode($id);
	echo json_encode(array("status" => TRUE));
}

public function hapus($id)
{
	$this->db->delete('pair_kriteria',array('id_contest'=>$id));

	$this->db->delete('eigen_kriteria',array('id_contest'=>$id));

	$this->db->delete('consistence',array('id_contest'=>$id));

	echo json_encode(array("status" => TRUE));
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
		<form action="'.base_url('admin/C_pair/settings').'" method="post">
			<button class="btn btn-xs btn-primary" title="View/Edit" type="submit" name="idPengaturan" value="'.$model->id.'"><i class="glyphicon glyphicon-cog"></i></button>
		</form>
		';
		$row[] = '
		<a class="btn btn-xs btn-danger" name="delete" id="'.$model->id.'" href="javascript:void()" title="Delete Data Pair Kriteria" onclick="delete_person('."'".$model->id."'".')"><i class="glyphicon glyphicon-trash"></i> </a>
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


