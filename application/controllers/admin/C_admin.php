<?php defined('BASEPATH')OR exit('tidak ada akses di izinkan');
/**
 *
 */
class C_admin extends CI_Controller
{

	function __construct()
	{
		parent::__construct();
		$this->load->library('Loginauth');
		$this->loginauth->view_page();
		
	}

	public function index()
	{
		$this->load->view('attribute/header_admin');
		$this->load->view('admin/dashboard');
		$this->load->view('attribute/footer');
		
	}
}
?>
