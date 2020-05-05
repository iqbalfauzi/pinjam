<?php defined('BASEPATH')OR exit('tidak ada akses di izinkan');
/**
 *
 */
class C_login extends CI_Controller
{

	function __construct()
	{
		parent::__construct();
		$this->load->library('Loginauth');
		$this->loginauth->view_page();
		
	}

	public function index()
	{
		if ($this->session->userdata('username') and
			$this->session->userdata('password') and
			$this->session->userdata('idLevel'))
		{
			redirect('C_FunctLogin/prosesLogin',$data);
		} else
		{
			$this->load->view('login_utama');
		}
	}
}
?>
