<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Loginauth{

  // public $favicon = 'assets/template/img/favicon.png';

  protected $ci;

  public function __construct()
  {
    $this->ci =& get_instance();
  }

  public function view_page()
  {
    if($this->ci->session->userdata('idLevel')=='1'){
      $url =  explode("/",$_SERVER["REQUEST_URI"]);
      if ($url[2]!="admin") {
        redirect('admin/C_admin');
      }
    }elseif ($this->ci->session->userdata('idLevel')=='2') {
      $url =  explode("/",$_SERVER["REQUEST_URI"]);
      if ($url[2]!="mhs") {
        redirect('mhs/C_mahasiswa');
      }
    }else{
      $url =  $_SERVER["REQUEST_URI"];
      if ($url!='/pionir/C_login') {
        redirect('C_login');
      }
    }
  }

}
?>
