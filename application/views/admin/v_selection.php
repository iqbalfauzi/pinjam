<!-- Content Wrapper. Contains page content -->
<style media="screen">
  .informasi{
    position: fixed;
    float: right;
  }

  .isi-info{
    display: block;
    padding: 1px;
    color: #ffffff;
  }

  .jumlah-diterima{
    text-align: center;
    font-size: 15pt;
  }
</style>


<div class="content-wrapper">
  <div class="alert alert-warning informasi">
    <a href="javascript:;" onclick="viewDiterima">
      <span class="isi-info">
        Diterima
        <div class="jumlah-diterima">
          .
        </div>
      </span>
    </a>
  </div>
  <br>

  <section class="content-header">
   <h1 style="text-align: center;">
    Selection Process
  </h1>
  <ol class="breadcrumb">
    <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
    <li class="active">Selection Process</li>
  </ol>
</section>
<br>

<!-- Main content -->
<section class="content">
 <div class="box box-primary">
  <div class="box-header with-border">

    <div class="box-body">
     <div class="form-group">
       <label class="col-sm-2 control-label">Select Contest</label>
       <div class="col-sm-6">
        <select class="form-control" name="filterBea" id="filterBea" onChange="viewTabel()">
          <option value="" disabled selected>~ Select Contest</option>
          <?php
          $arr=0;
          foreach ($select_contest as $cb) {
            echo "<option value='".$arr."-".$cb->id."'>".$cb->nama."</option>";
            $arr+=1;
          }
          ?>
        </select>
      </div>
    </div>
  </div>

</br>
<div class="box-body" style="overflow-x: auto;">
  <table id="tabel" class="table table-bordered table-hover" cellspacing="0" width="100%">
    <thead>
      <tr class="success">
       <th>No</th>
       <th>NIM</th>
       <th>Nama</th>
       <th>Fakultas</th>
       <th>Jurusan</th>
       <!-- <th>Vector S</th> -->
       <th>Nilai Preferensi</th>
       <th>Action</th>
     </tr>
   </thead>
   <tbody>
   </tbody>
   
</table>
</div>
</div>
</div>
</section>
</div>
<!-- /.content-wrapper -->
</div><!-- ./wrapper -->

<script type="text/javascript">
  var dataTable;
  var idBea;
  var myVar;

  document.addEventListener("DOMContentLoaded", function(event) {
  
});

  function viewTabel() {
    dataArr = $("#filterBea").val().split("-");
    this.idBea = dataArr[1];
    getDiterima();
    datatable();
    reload_table(); 
  }

  function myTimer() {
    getDiterima();
    reload_table();
  }

  function seleksi(idPendaftar, status, nim)
  {
    var url = "<?php echo site_url('admin/C_selection/seleksi')?>";
    $.ajax({
      url : url+"/"+idPendaftar+"/"+status+"/"+nim,
      type: "POST",
      data: $('#formInput').serialize(),
      dataType: "JSON",
      success: function(data)
      {
        if (data.status==false) {
          alert("NIM: "+data.nim+", telah diterima di contest '"+data.contest);
        }else {
          getDiterima();
          reload_table();
        }
      },
      error: function (jqXHR, textStatus, errorThrown)
      {
        alert('Error adding/update data');
      }
    });
  }

  function reload_table(){
    dataTable.ajax.reload(null,false);
  }

  function getDiterima()
  {
    if($("#filterBea").val()!="kosong"){
      dataArr = $("#filterBea").val().split("-");
      id_bea = dataArr[1];
      var url = "<?php echo site_url('admin/C_selection/getDiterima')?>";
      $.ajax({
        url : url+"/"+id_bea,
        type: "POST",
        dataType: "JSON",
        success: function(data)
        {
          $(".jumlah-diterima").html(data);
        },
        error: function (jqXHR, textStatus, errorThrown)
        {
          alert('Error get data!');
        }
      });
    }else{
      $(".jumlah-diterima").html("-");
    }
  }

  function datatable() {
    dataTable = $('#tabel').DataTable({
      "destroy":true,
      "processing":true,
      "serverSide":true,
      "order":[],
      "ajax":{
        url:"<?php echo base_url('admin/C_selection/datatable'); ?>/"+this.idBea,
        type:"POST"
      },
      "columnDefs":[
      {
        "targets":[ -1 ],
        "orderable":false,
      },
      ],
      
    });
  }

  function view_detail_score(idPendaftar,idBea) {
    var url = "<?php echo site_url('kasubag/C_seleksiWP/view_detail_score')?>";
    $.ajax({
      url : url+"/"+idPendaftar+"/"+idBea,
      type: "POST",
      dataType: "JSON",
      success: function(data)
      {
        detail = '';
        total_skor_mhs=0;
        for (var i = 0; i < data.length; i++) {
          detail += `
          <tr>
            <td>`+data[i].kriteria+`</td>
            <td>`+data[i].pilihan+`</td>
            <td>`+data[i].skor+`</td>
          </tr>
          `;
          total_skor_mhs += parseInt(data[i].skor);
        }
        $('#nim_mhs').html(data[0].nim);
        $('#detail_skor_mhs').html(detail);
        $('#total_skor_mhs').html(total_skor_mhs);
        $('#modal1').openModal();
      },
      error: function (jqXHR, textStatus, errorThrown)
      {
        alert('Error get data!');
      }
    });
  }

</script>