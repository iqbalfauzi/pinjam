<?php defined('BASEPATH')OR exit('tidak ada akses di izinkan');
/**
 *
 */
class C_kriteria extends CI_Controller
{

	function __construct()
	{
		parent::__construct();
		$this->load->library('Loginauth');
		$this->loginauth->view_page();
		$this->load->model("admin/M_master_kriteria",'model');
		
	}

	public function index()
	{
		$this->load->view('attribute/header_admin');
		$this->load->view('admin/v_kriteria');
		$this->load->view('attribute/footer');
		
	}

	public function datatable(){
		$fetch_data = $this->model->make_datatables();
		$data = array();
		$nmr = 0;
		foreach($fetch_data as $row)
		{
			$nmr+=1;
			$sub_array = array();
			$sub_array[] = $nmr;
			$sub_array[] = $row->nama;
			$sub_array[] = $this->model->get_sub_score($row->id);
			$sub_array[] = '
			<a class="btn btn-sm btn-primary" name="edit" id="'.$row->id.'" href="javascript:void()" title="Edit" onclick="edit_person('."'".$row->id."'".')"><i class="glyphicon glyphicon-pencil"></i> </a>
			<a class="btn btn-sm btn-danger" name="delete" id="'.$row->id.'" href="javascript:void()" title="Delete" onclick="delete_person('."'".$row->id."'".')"><i class="glyphicon glyphicon-trash"></i> </a>

			';
			$data[] = $sub_array;
		}
		$output = array(
			"draw"            =>  intval($_POST["draw"]),
			"recordsTotal"    =>  $nmr,
			"recordsFiltered" =>  $this->model->get_filtered_data(),
			"data"            =>  $data
			);
		echo json_encode($output);
	}

	public function simpan()
	{
		$data_kriteria = array(
			'nama' => $this->input->post('kriteria'),
			);
		$insert_kriteria = $this->model->save_kriteria($data_kriteria);

		$count_score = count($this->input->post('score'));
		$data = array();
		for ($i=0;$i<$count_score;$i++) {
			$data[$i]= array(
				'idKriteriaSkor' => $insert_kriteria,
				'nama' => $this->input->post('score['.$i.']'),
				'skor' => $this->input->post('bobot['.$i.']'),
				);
		}
		$insert_sub_kriteria = $this->model->save_sub_kriteria($data);
		echo json_encode(array("status" => TRUE));
	}
	public function hapus($id)
	{
		$this->model->delete_by_id($id);
		echo json_encode(array("status" => TRUE));
	}
	public function edit_data($id)
	{
		$kriteria = $this->model->get_by_id($id);
		$namaKriteria = $kriteria->nama;
		$idKriteria = $kriteria->id;

		$subSkor = $this->model->get_by_id_sub($id);
		$data = array();
		$data [0] = array(
			'namaJenis' => $namaKriteria,
			'idJenis' => $idKriteria
			);

		$i = 1;
		foreach ($subSkor as $sub) {
			$data[$i] = array(
				'idSub' => $sub->id,
				'sub' => $sub->nama,
				'skor' => $sub->skor
				);
			$i+=1;
		}
		echo json_encode($data);
	}
	public function update()
	{
		$idKriteria = $this->input->post('idJenisScoring');
		$data_kriteria = array(
			'nama' => $this->input->post('kriteria'),
			);
		$this->model->update_kriteria(array('id' => $idKriteria), $data_kriteria);

		$count_score = count($this->input->post('score'));
		for ($i=0;$i<$count_score;$i++) {
			$idSub = $this->input->post('idSub['.$i.']');
			$sub = $this->input->post('score['.$i.']');
			$skor = $this->input->post('bobot['.$i.']');
			$dataSub = array(
				'idKriteriaSkor' => $idKriteria,
				'nama' => $sub,
				'skor' => $skor,
				);
			if ($idSub==null && $sub!=null) {
        # insert
				$this->model->insert_sub_kriteria($dataSub);
			}elseif ($idSub!=null && $sub!=null) {
        # update
				$this->model->update_sub_kriteria(array('id' => $idSub), $dataSub);
			}elseif ($idSub!=null && $sub==null) {
        # delete
				$this->model->delete_sub_kriteria($idSub);
			}
		}
		echo json_encode(array("status" => TRUE));
	}
}
?>
