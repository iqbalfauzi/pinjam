<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <section class="content-header">
   <h1>
    Report Mahasiswa Lolos Seleksi
  </h1>
  <ol class="breadcrumb">
    <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
    <li class="active">Report</li>
  </ol>
</section>

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
          foreach ($select_contest as $row) {
            ;?>
            <option value="<?php echo $row->id;?>"><?php echo $row->nama;?></option>
            <?php }?>
          </select>
        </div>
      </div>
    </div>
    <div class="col-xs-12 pull-right">
      <a class="btn btn-danger" onclick="print_pdf()" title="Print PDF"><i class="glyphicon glyphicon-print"></i> PDF</a>

      <a class="btn btn-success" onclick="print_excell()" title="Print Excell"><i class="glyphicon glyphicon-print"></i> Excell</a>&nbsp;&nbsp;&nbsp;&nbsp;
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
         <th>Contest</th>
       </tr>
     </thead>
     <tbody>
     </tbody>
     <tfoot>
      <tr class="success">
       <th>No</th>
       <th>NIM</th>
       <th>Nama</th>
       <th>Fakultas</th>
       <th>Jurusan</th>
       <th>Contest</th>
     </tr>
   </tfoot>
   
 </table>
</div>
</div>
</div>
</section>
</div>
<!-- /.content-wrapper -->
</div><!-- ./wrapper -->

<script type="text/javascript">
  var save_method;
  var table;
  var filterBea;
  
  document.addEventListener("DOMContentLoaded", function (event) {

  });

  function viewTabel() {
   filterBea = $("#filterBea").val();
   datatable();
 }

 function datatable() {
  table = $('#tabel').DataTable({
    "destroy": true,
    "processing": true,
    "serverSide": true,
    "order": [],
    "ajax":{
     url: "<?php echo base_url('admin/C_report/datatable'); ?>",
     type: "POST",
     data:{'filterBea':filterBea}
   },
   "columnDefs": [
   {
    "targets": [2,-1],
    "orderable":false,
  },
  ],
});
}

function reload_table()
{
  table.ajax.reload(null,false);
}

function print_excell() {
  filterBea = $('#filterBea').val();
  window.open("<?=site_url()?>admin/C_report/get_print_excell/"+filterBea);
}
function print_pdf() {
  filterBea = $('#filterBea').val();
  window.open("<?=site_url()?>admin/C_report/get_print_pdf/"+filterBea);
}

</script>