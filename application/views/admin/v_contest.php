<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <section class="content-header">
    <h1>
      Master of Contest
    </h1>
    <ol class="breadcrumb">
      <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
      <li class="active">Master of Contest</li>
    </ol>
  </section>


  <!-- Main content -->
  <section class="content">
   <div class="box box-primary">
    <div class="box-header with-border">
     <div class="col-xs-12">
      <a class="btn btn-success pull-right" href="<?php echo base_url('admin/C_contest/pengaturan')?>" title="Tambah data"><i class="glyphicon glyphicon-plus"></i> Add data</a>
    </div>
  </br>
  <div class="box-body" style="overflow-x: auto;">
    <table id="table" class="table table-bordered table-hover" cellspacing="0" width="100%">
      <thead>
        <tr class="success">
         <th>No</th>
         <th>Nama</th>
         <th>Kuota</th>
         <th>Dibuka</th>
         <th>Ditutup</th>
         <th>Seleksi Tutup</th>
         <th>Action</th>
       </tr>
     </thead>
     <tbody>
     </tbody>
     <tfoot>
      <tr class="success">
        <th>No</th>
         <th>Nama</th>
         <th>Kuota</th>
         <th>Dibuka</th>
         <th>Ditutup</th>
         <th>Seleksi Tutup</th>
         <th>Action</th>
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
  $(document).ready(function() {
    table = $('#table').DataTable({ 
      "processing": true,
      "serverSide": true,
      "ajax": {
        "url": "<?php echo site_url('admin/C_contest/datatable')?>",
        "type": "POST"
      },
      "columnDefs": [
      { 
        "targets": [ -1 ],
        "orderable": false,
      },
      ],

    });
  });

  
  function add_person()
  {
    save_method = 'add';
      $('#form')[0].reset(); // reset form on modals
      $('#modal_form').modal('show'); // show bootstrap modal
      $('.modal-title').text('Tambah Data Jurusan'); // Set Title to Bootstrap modal title
    }

    function edit_person(no_induk)
    {
      save_method = 'update';
      $('#form')[0].reset(); // reset form on modals

      //Ajax Load data from ajax
      $.ajax({
        url : "<?php echo site_url('admin/Jurusan/edit/')?>/" + no_induk,
        type: "GET",
        dataType: "JSON",
        success: function(data)
        {          
          $('[name="fakultas"]').val(data.idFk);
          $('[name="jurusan"]').val(data.jurusan);
          $('[name="idJurusan"]').val(data.id_jurusan);

            $('#modal_form').modal('show'); // show bootstrap modal when complete loaded
            $('.modal-title').text('Edit Data Siswa'); // Set title to Bootstrap modal title
            
          },
          error: function (jqXHR, textStatus, errorThrown)
          {
            alert('Error get data from ajax');
          }
        });
    }

    function reload_table()
    {
      table.ajax.reload(null,false); //reload datatable ajax 
    }

    function save()
    {
      var url;
      if(save_method == 'add') 
      {
        url = "<?php echo site_url('admin/Jurusan/simpan')?>";
      }
      else
      {
        url = "<?php echo site_url('admin/Jurusan/update')?>";
      }

       // ajax adding data to database
       $.ajax({
        url : url,
        type: "POST",
        data: $('#form').serialize(),
        dataType: "JSON",
        success: function(data)
        {
               //if success close modal and reload ajax table
               $('#modal_form').modal('hide');
               reload_table();
             },
             error: function (jqXHR, textStatus, errorThrown)
             {
              alert('Error adding / update data');
            }
          });
     }

     function delete_person(no_induk)
     {
      if(confirm('Apakah kamu yakin ingin menghapus data ini ?'))
      {
        // ajax delete data to database
        $.ajax({
          url : "<?php echo site_url('admin/Jurusan/hapus')?>/"+no_induk,
          type: "POST",
          dataType: "JSON",
          success: function(data)
          {
               //if success reload ajax table
               $('#modal_form').modal('hide');
               reload_table();
             },
             error: function (jqXHR, textStatus, errorThrown)
             {
              alert('Error adding / update data');
            }
          });

      }
    }
  </script>

  <!-- Bootstrap modal -->
  <div class="modal fade modal-primary" id="modal_form" role="dialog">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <h3 class="modal-title">Form Data Jurusan</h3>
        </div>
        <div class="modal-body form">
          <form action="#" id="form" class="form-horizontal">         

            <div class="form-group">
              <label class="control-label col-md-3">Fakultas</label>
              <div class="col-md-9">
                <select name="fakultas" id="fakultas" class="form-control">
                  <option value="" disabled selected>Pilih Fakultas</option>
                  <?php
                  foreach ($fakultas as $row) { ?>
                  <option value='<?php echo $row->id ?>'><?php echo $row->namaFk ?></option>
                  <?php } ?>
                </select>
              </div>
            </div>

            <div class="form-group">
              <label class="control-label col-md-3">Jurusan</label>
              <div class="col-md-9">
                <input name="jurusan" placeholder="Jurusan" class="form-control" type="text">
              </div>
            </div>

          </div>
          <input type="hidden" name="idJurusan" id="idJurusan">
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" id="btnSave" onclick="save()" class="btn btn-success">Save</button>
        <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
<!-- End Bootstrap modal -->