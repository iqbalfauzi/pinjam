<?php

if (!defined('BASEPATH'))
  exit('No direct script access allowed');

class Kriteria_model extends CI_Model
{

  public $table = 'set_contest_kriteria_skor';
  public $pairwise = 'pair_kriteria';
  public $id = 'id_kriteria';
  public $pakarLv = array(
     1=>"eigen_krit_kom", // komite sekolah usrlv 1
     "eigen_krit_kes",    // kepala sekolah usrlv 2
     "eigen_krit_dpk"     // dinas pendidikan usrlv 3
     );
  var $kriteriaLabel = array();

  function __construct()
  {
    parent::__construct();
  }

  public function getKriteria($idBea) {
   $this->db->select(array("set_contest_kriteria_skor.idKriteriaSkor","kriteria_skor.nama"));
   $this->db->from('set_contest_kriteria_skor');
   $this->db->join('kriteria_skor', 'kriteria_skor.id = set_contest_kriteria_skor.idKriteriaSkor', 'left');
   $this->db->where('set_contest_kriteria_skor.idContest',$idBea);

   $hasil = $this->db->get()->result();
   foreach($hasil as $kr) {
    $this->kriteriaLabel[] = $kr->idKriteriaSkor;
  }
  return $hasil;
}

public function view_detail($idBea) {
 $this->db->select(array("set_bea_kriteria_skor.idKriteriaSkor","kriteria_skor.nama"));
 $this->db->from('set_bea_kriteria_skor');
 $this->db->join('kriteria_skor', 'kriteria_skor.id = set_bea_kriteria_skor.idKriteriaSkor', 'left');
 $this->db->where('set_bea_kriteria_skor.idBea',$idBea);
 $hasil = $this->db->get()->result_array();
 return $hasil;
}
public function get_beasiswa($tahun) {
  $getbea ="SELECT bea.id,bea.namaBeasiswa,YEAR(bea.beasiswaDibuka) tahun from bea WHERE YEAR(bea.beasiswaDibuka)='$tahun' ORDER by bea.id desc";
  return $this->db->query($getbea)->result();
}

function countKriteria($idBeasiswa){
  $this->db->select(array("set_contest_kriteria_skor.idKriteriaSkor","kriteria_skor.nama"));
  $this->db->from('set_contest_kriteria_skor');
  $this->db->join('kriteria_skor', 'kriteria_skor.id = set_contest_kriteria_skor.idKriteriaSkor', 'left');
  $this->db->where('set_contest_kriteria_skor.idContest',$idBeasiswa);
  $count = $this->db->count_all_results();
  return $count;
}
public function count_kriteria($idBeasiswa)
{
  $sql = 'SELECT SUM(eigen_kriteria.value_eigen) value_eigen FROM eigen_kriteria WHERE eigen_kriteria.id_contest='.$idBeasiswa.'';
  $query = $this->db->query($sql);
  return $query->row();
}
// function get_by_id($idBeasiswa){
//     $this->db->select("bea.namaBeasiswa");
//     $this->db->from("bea");
//     $this->db->where("bea.id",$idBeasiswa);
//     $query = $this->db->get()->row();
//     if ($query) {
//         return $query;
//     }else{
//         return false;
//     }
//     $query =null;
//     unset($idBeasiswa);
// }

public function get_by_id_bea($id)
{
  $this->db->from('contest');
  $this->db->where('contest.id',$id);
  $query = $this->db->get();
  return $query->row();
}
public function get_by_consistence($id)
{
  $this->db->from('consistence');
  $this->db->where('consistence.id_contest',$id);
  $query = $this->db->get();
  return $query->row();
}

    // function getKriteriaByPakar($id_pakar){
    //  //$this->db->select(array("id_kriteria","nama_kriteria",$this->pakarLv[$id_pakar])); //v.1->masih pakai kolom berbeda utk tiap pakar
    //  $this->db->select("eigen_kriteria.id_kriteria, kriteria.nama_kriteria,eigen.kriteria.value_eigen");
    //  $this->db->where("eigen_kriteria.id_kriteria=kriteria.id_kriteria");
    //  $this->db->where("eigen_kriteria.id_user=".$id_pakar);

    //  return $this->db->get($table)->row();
    // }

function update($data){
     //$kolomEigen = $this->pakarLv[$data['user_lv']]; //v.1-> pakai user level. kolom eigen dibedakan per level user 
     $this->deleteKritByUser($data['id_bea']); //reset seluruh nilai kriteria berpasangan untuk pakar tertentu
     $this->getKriteria($data['id_bea']);
     /*foreach($this->getKriteria() as $kr){
      $this->kriteriaLabel[] = $kr->id_kriteria;
    }*/

    for($i=0;$i<count($data['kritEigen']);$i++){
      // update nilai eigen di table eigen_kriteria
      $this->db->set(array(
        'value_eigen' => $data['kritEigen'][$i],
        $this->id     => $this->kriteriaLabel[$i],
        'id_contest'     => $data['id_bea']
        )
      );
      $this->db->insert("eigen_kriteria");

      // memasukkan nilai kriteria berpasangan ke pair_kriteria
      for($j=0;$j<count($data['kritMatriks']);$j++){
       $this->db->set(array(
        'id_kriteria'       => $this->kriteriaLabel[$i],
        'id_kriteria_pair'  => $this->kriteriaLabel[$j],
        'id_contest'        => $data['id_bea'],  // pakai id_user
        'value'             => $data['kritMatriks'][$i][$j]
        ));
       $this->db->replace($this->pairwise);
     }
   } 
 }
 function updateCi_Cr($ahpconsistency)
 {
   $this->deleteCi_Cr($ahpconsistency['id_bea']);
   $this->db->insert("consistence", $ahpconsistency);
   return $this->db->insert_id();
 }

 function deleteCi_Cr($id_bea){
   $this->db->where('id_contest',$id_bea);
     //v.1->pakai user level
   return $this->db->delete('consistence');
 }

    // function updateKriteriaAktif($data){
    //     // data kriteria harus berbentuk batch
    //     $count = 0;
    //     foreach($data['kriteria'] as $krit){
    //         $this->db->set('pakai_kriteria',$krit['pakai_kriteria']);
    //         $this->db->where('id_kriteria',$krit['id_kriteria']);
    //         $this->db->update("kriteria");
    //         $count++;
    //     }
    //     return $count;
    // }

 function deleteKritByUser($id_bea){
   $this->db->where('id_contest',$id_bea);
     //v.1->pakai user level
   return $this->db->delete('eigen_kriteria');
 }

 function resetAllPair($idBeasiswa){
  $this->db->where('pair_kriteria.id_bea',$idBeasiswa);
  $this->db->delete('pair_kriteria');
}
function resetAllEigen($idBeasiswa){
  $this->db->where('eigen_kriteria.id_bea',$idBeasiswa);
  $this->db->delete('eigen_kriteria');
}
function resetAllconsistence($idBeasiswa){
  $this->db->where('consistence.id_bea',$idBeasiswa);
  $this->db->delete('consistence');
}

function getEigenVALL($idBeasiswa,$formatted=false){
  $this->db->select("eigen_kriteria.id,eigen_kriteria.id_kriteria,eigen_kriteria.id_bea,eigen_kriteria.value_eigen,kriteria_skor.nama");
  $this->db->from('eigen_kriteria');
  $this->db->join('kriteria_skor', 'kriteria_skor.id = eigen_kriteria.id_kriteria', 'left');
  $this->db->where('eigen_kriteria.id_bea',$idBeasiswa);
  $this->db->order_by("eigen_kriteria.value_eigen","DESC");
  $bobot = $this->db->get()->result();
  if($formatted){
    $eigenuser = array();
    foreach($bobot as $eg){
      $eigenuser[$eg->nama] = $eg->value_eigen;
    }
    return $eigenuser;
  } else {
    return $bobot;
  }
}

function getEigenValue($idBeasiswa){
  $this->db->select("
    eigen_kriteria.id,
    eigen_kriteria.id_kriteria,
    eigen_kriteria.id_contest,
    eigen_kriteria.value_eigen,
    kriteria_skor.nama
    ");
  $this->db->from('eigen_kriteria');
  $this->db->join('kriteria_skor', 'kriteria_skor.id = eigen_kriteria.id_kriteria', 'left');
  $this->db->where('eigen_kriteria.id_contest',$idBeasiswa);
  $this->db->order_by("eigen_kriteria.value_eigen","DESC");
  $hasil = $this->db->get()->result();
  return $hasil;

  $hasil=null;
  unset($idBeasiswa);
}

// function getEigen($id_user=null,$formatted=false){
//      $this->db->select("eg.id_kriteria,kriteria.nama_kriteria,kriteria.ket_kriteria,eg.id_user,akun.username,akun.level,eg.value_eigen");
//      $this->db->where("eg.id_kriteria = kriteria.id_kriteria");
//      $this->db->where("eg.id_user = akun.id_user");
//      if($id_user!=null)
//       $this->db->where("eg.id_user = ".$id_user);
//      $this->db->order_by("eg.id_user,eg.id_eigen");
//      $bobot = $this->db->get('eigen_kriteria as eg,kriteria,akun')->result();
//      if($formatted){
//         $eigenuser = array();
//         foreach($bobot as $eg){
//             $eigenuser[$eg->nama_kriteria] = $eg->value_eigen;
//         }
//         return $eigenuser;
//      } else {
//         return $bobot;
//      }
//     }


    // /*function avgEigen(){
    //  $this->db->select("nama_kriteria");
    //  $this->db->select("(eigen_krit_kom+eigen_krit_kes+eigen_krit_dpk)/3 as eirata");
    //  $hasil = $this->db->get($this->table)->result();
    //  $arr = array();
    //  foreach($hasil as $hs){
    //      $arr[$hs->nama_kriteria] = $hs->eirata;
    //  }
    //  return $arr;
    // }*/

    // function avgEigen(){
    //     $eigenkrit = $this->getEigen();
    //     $kriterialist=array();
    //     $eigenuser = array(); //init to re-arrange the eigen value table. grouping into each user
    //     $hasilAvg = array(); //init placeholder for eigen average value of all user
    //     foreach($eigenkrit as $eg){
    //         $eigenuser[$eg->id_user][$eg->id_kriteria]['value_eigen'] = $eg->value_eigen;
    //         $kriterialist[$eg->id_kriteria] = $eg->nama_kriteria;
    //     }

    //     foreach(array_keys($kriterialist) as $kr){
    //         $jml = 0;
    //         foreach($eigenuser as $eg){
    //             $jml += $eg[$kr]['value_eigen'];
    //         }
    //         $hasilAvg[$kriterialist[$kr]] = $jml/count($eigenuser);
    //     }
    //     //a better query version: SELECT id_eigen,id_kriteria,id_user,avg(value_eigen) FROM `eigen_kriteria` group by id_kriteria,id_user
    //     //to do (kalo mau pake query sql): sesuaikan struktur array avg utk dipakai pembobotan
    //     return $hasilAvg;
    // }

function getPairKriteria($idBea){
  $this->db->from($this->pairwise);
  $this->db->where('pair_kriteria.id_contest',$idBea);
  $hasil = $this->db->get()->result();
  $arr=array();
  $baris=0;
  foreach($hasil as $pk){
   $arr[$pk->id_kriteria][$pk->id_kriteria_pair] = $pk->value;
 }
 return $arr;
}

    // function countPairKriteria($id_user=null){
    //  if($id_user!=null)
    //   $this->db->where('id_user',$id_user);
    //  $hasil = $this->db->get($this->pairwise)->result();
    //  return count($hasil);
    // }

}