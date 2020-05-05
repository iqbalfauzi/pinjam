<?php defined('BASEPATH')OR exit('tidak ada akses di izinkan');
/**
 *
 */
class C_mahasiswa extends CI_Controller
{

	function __construct()
	{
		parent::__construct();
		$this->load->library('Loginauth');
		$this->loginauth->view_page();
		
	}

	public function index()
	{
		$this->load->view('attribute/header_mhs');
		$this->load->view('mahasiswa/dashboard');
		$this->load->view('attribute/footer');
		
	}
}
?>
