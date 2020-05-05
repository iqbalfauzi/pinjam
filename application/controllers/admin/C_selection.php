<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');


class C_selection extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->library('Loginauth');
		$this->loginauth->view_page();

		$this->load->model('admin/M_selection','model');
	}

	public function index()
	{
		$data['select_contest'] = $this->model->get_select_contest();

		$this->load->view('attribute/header_admin');
		$this->load->view('admin/v_selection',$data);
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

	public function datatable($idBea){
		$fetch_data = $this->model->make_query($idBea);
		$data = array();
		$nmr = 0;
		foreach($fetch_data as $row)
		{
			$nmr+=1;
			$sub_array = array();
			$sub_array[] = $nmr;
			$sub_array[] = $row['nim'];
			$sub_array[] = $row['nama'];
			$sub_array[] = $this->model->getJurusanFakultas($row['idJrs'])->namaFk;
			$sub_array[] = $this->model->getJurusanFakultas($row['idJrs'])->namaJur;
			// $sub_array[] = $row['vektor_s'];
			$sub_array[] = $row['vektor_v'];

			// $sub_array[] = '<a class="chip light-blue darken-1 white-text" href="javascript:void()" onclick="view_detail_score('.$row['id'].','.$idBea.')">Detail</a>';

			if ($row['status']==1) {
				$sub_array[] = '
				<button class="btn btn-sm btn-success" title="Confirmed" type="submit" name="idPengaturan" onclick="seleksi('."'".$row['id']."'".','."'".$row['status']."','".$row['nim']."'".');"><i class="glyphicon glyphicon-ok"></i></button>
				';
			}elseif ($row['status']==0) {
				$sub_array[] = '
				<button class="btn btn-sm btn-danger" title="Not Confirmed" type="submit" name="idPengaturan" onclick="seleksi('."'".$row['id']."'".','."'".$row['status']."','".$row['nim']."'".');"><i class="glyphicon glyphicon-remove"></i></button>
				';
			}
			$data[] = $sub_array;
		}
		$output = array(
			"draw"            =>  intval($_POST["draw"]),
			"recordsTotal"    =>  $nmr,
			"recordsFiltered" =>  $nmr,
			"data"            =>  $data
			);
		echo json_encode($output);
	}

	public function seleksi($idPendaftar, $status, $nim)
	{
		$change_status;
		if ($status=="1") {
			$change_status = "0";
			$data = array(
				'status' => $change_status
				);
			$this->model->seleksi_penerima(array('id' => $idPendaftar), $data);
			echo json_encode(array("status" => TRUE));
		}elseif ($status=="0") {
			$check = $this->model->check_status_penerima($nim);
			if ($check==null) {
				$change_status = "1";
				$data = array(
					'status' => $change_status
					);
				$this->model->seleksi_penerima(array('id' => $idPendaftar), $data);
				echo json_encode(array("status" => TRUE));
        // echo "belum diterima di contest";
			}else{
				$detail_diterima = array(
					'status' => FALSE,
					'nim' => $check->nim,
					'nama' => $check->nama,
					'contest' => $check->nama_contest
					);
				echo json_encode($detail_diterima);
        // echo "telah di terima di contest";
			}
		}
	}
	
}


