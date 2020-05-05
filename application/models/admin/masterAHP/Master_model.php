<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Master_model extends CI_Model
{
  //private $pengaturan="
  function autentikasi($auth){
   $this->db->select('password');
   $this->db->where('username',$auth['username']);
   $row=$this->db->get('akun')->row();
   // return password_verify($auth['userpass'],$row->password);
   return $row;
  }
  
  function get_user($username){
   $this->db->select("id_user,level");
   $this->db->where("username",$username);
   $res=$this->db->get('akun');
   return $res->row();
  }
  
  function get_user_byid($id){
   $this->db->select("id_user,username,level");
   $this->db->where("id_user",$id);
   $res=$this->db->get('akun');
   return $res->row();
  }
  
  function get_all_user(){
   $this->db->select('id_user,username,level');
   return $this->db->get('akun')->result();
  }
  
  function add_user($data){
    $this->db->set($data);
    return $this->db->insert('akun');
  }

  function delete_user($id){
    $this->db->where("id_user",$id);
    return $this->db->delete("akun");
  }

  function update_password($userdata){
   $this->db->set('password',password_hash($userdata['passnew'],PASSWORD_DEFAULT));
   $this->db->where('id_user',$userdata['id']);
   return $this->db->update('akun');
  }
  
}