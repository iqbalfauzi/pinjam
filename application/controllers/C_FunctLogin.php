<?php defined('BASEPATH')OR exit('tidak ada akses di izinkan');
/**
 *
 */
class C_FunctLogin extends CI_Controller
{

	function __construct()
	{
		parent::__construct();
		$this->load->model('LoginMod', 'mod');
		
	}

	public function filter($data)
	{	
		$data = preg_replace('/[^a-zA-Z0-9]/', '', $data);
		return $data; 
		unset($data);
	}

	public function index()
	{	
		$this->load->view('login_utama');
	}

	public function logout()
	{
		$this->mod->putus_koneksi();
		$array_sess	= $this->session->all_userdata();

		$this->session->unset_userdata($array_sess);
		unset($array_sess);
		$this->session->sess_destroy();

		redirect('C_login');
	}

	public function prosesLogin()
	{
		$username = $this->input->post('username');
		$username = $this->filter($username);

		$password= $this->input->post('password');
		$password = $this->filter($password);

		$level = $this->input->post('idLevel');

		$prosesLog = $this->mod->actLogin($username, $password, $level)->row();
		$result = count($prosesLog);

		if ($result>0) {
			if ($username==$prosesLog->userId) {
				if ($password==$prosesLog->password) {
					if ($prosesLog->idLevel==1) {
						$data = array(
							'id'		=>$prosesLog->id,
							"username"	=>$prosesLog->userId,
							"password" 	=>$prosesLog->password,
							"idLevel"	=>$prosesLog->idLevel);

						$this->session->set_userdata($data);
						redirect('admin/C_admin');
					}else if($prosesLog->idLevel==2){
						$data = array(
							'id'		=>$prosesLog->id,
							"username"	=>$prosesLog->userId,
							"password" 	=>$prosesLog->password,
							"idLevel"	=>$prosesLog->idLevel);

						$this->session->set_userdata($data);
						redirect('mhs/C_mahasiswa');
					}else{
						$this->session->set_flashdata("pesan", "<div class=\"alert alert-danger alert-dismissible\">Level tidak terpenuhi</div>");
						redirect('C_FunctLogin');
					}
				}else{
					$this->session->set_flashdata("pesan", "<div class=\"alert alert-danger alert-dismissible\">Password tidak tepat</div>");
					redirect('C_FunctLogin');
				}
			}else{
				$this->session->set_flashdata("pesan", "<div class=\"alert alert-danger alert-dismissible\">Username tidak tepat</div>");
				redirect('C_FunctLogin');	
			}
		}else{
			$this->session->set_flashdata("pesan", "<div class=\"alert alert-danger alert-dismissible\">Data anda tidak terdaftar dalam sistem</div>");
			redirect('C_FunctLogin');
		}

		unset($username,$password,$level,$prosesLog,$result,$data);
	}
}
?>