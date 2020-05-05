<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Saw_model  extends CI_Model {
    
    function getAturan($var){
        $this->db->where("id_pengaturan",$var);
        return $this->db->get("pengaturan_sistem")->row()->value_pengaturan;
    }

    function updateAturan($var,$val){
        $this->db->set("value_pengaturan",$val);
        $this->db->where("id_pengaturan",$var);
        return $this->db->update("pengaturan_sistem");
    }
    
    function updateBobotDipakai($data){
        $this->db->set(array(
          "id_pengaturan"=>"EIGEN_UNTUK_BOBOT",
          "value_pengaturan"=>$data 
        ));
        return $this->db->update("pengaturan_sistem");
    }

    
    function getAllMax(){
        $this->db->select_max('jmsdr_siswa');
        $this->db->select_max('nrata_siswa');
        $this->db->select_max('pnd_ayah_siswa');
        $this->db->select_max('hasil_ayah_siswa');
        $this->db->select_max('krj_ayah_siswa');
        $this->db->select_max('status_siswa');
        return $this->db->get('normal_data_siswa')->row();
    }
    
    function resetAllWeighted(){
        return $this->db->truncate("weighted_data_siswa");
    }

    function hitungBobot($kriteria,$max,$data){
        $terproses = 0;
        foreach($data as $sw){
            $weighted=array(
                'nis_siswa' =>$sw->nis_siswa,
                'value_weighted' => 0
            );
            $kolom = array_keys($kriteria);
            foreach($kolom as $kr){
                $weighted[$kr]=($sw->$kr/$max->$kr) * $kriteria[$kr];
                $weighted['value_weighted'] += $weighted[$kr];
            }
            $this->db->set($weighted);
            $proses = $this->db->replace('weighted_data_siswa');
            if($proses)
                $terproses++;
        }
        return $terproses;
    }
}