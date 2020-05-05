<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <section class="content-header">
    <h1>
      Contests
    </h1>
    <ol class="breadcrumb">
      <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
      <li class="active">Contest</li>
    </ol>
  </section>

  <!-- Main content -->
  <section class="content">
   <div class="box box-primary">
    <div class="box-header with-border">
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
           <th style="width: 1%;">Action</th>
           <th style="width: 1%;">View</th>
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
          <th style="width: 1%;">Action</th>
          <th style="width: 1%;">View</th>
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
  var arr = 0;

  $(document).ready(function() {
    table = $('#table').DataTable({ 
      "processing": true,
      "serverSide": true,
      "ajax": {
        "url": "<?php echo site_url('admin/C_registrant/datatable')?>",
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

  function reload_table()
  {
      table.ajax.reload(null,false); //reload datatable ajax 
    }

    function add_data(id)
    {
      arr = 0;
      save_method = 'add';
      $('#form')[0].reset();
      $('#scoreKriteria').empty();

      //Ajax Load data from ajax
      $.ajax({
        url : "<?php echo site_url('admin/C_registrant/add_data/')?>/" + id,
        type: "GET",
        dataType: "JSON",
        success: function(data)
        {
          $('#idContest').val(data[0].id);
          $("#scoreKriteria").append(data[0].combo);

          $('#modal_form').modal('show');
          $('.modal-title').text('Add Data Athletes');

        },
        error: function (jqXHR, textStatus, errorThrown)
        {
          alert('Error get data from ajax');
        }
      });
    }

    function save()
    {
      var url;
      if(save_method == 'add') 
      {
        url = "<?php echo site_url('admin/C_registrant/simpan')?>";
      }

      $.ajax({
        url : url,
        type: "POST",
        data: $('#form').serialize(),
        dataType: "JSON",
        success: function(data)
        {
         $('#modal_form').modal('hide');
         reload_table();
       },
       error: function (jqXHR, textStatus, errorThrown)
       {
        alert('Error adding / update data');
      }
    });
    }


    function delete_person(id)
    {
      if(confirm('Apakah kamu yakin ingin menghapus data ini ?'))
      {
        // ajax delete data to database
        $.ajax({
          url : "<?php echo site_url('admin/C_registrant/hapus')?>/"+id,
          type: "POST",
          dataType: "JSON",
          success: function(data)
          {
               //if success reload ajax table
               alert('Delete pair Criteria success !!');
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

  <script type="text/javascript">
    $(function () {
          // datepicker
          $('.datepicker').datepicker({
            autoclose: true,
            format: "yyyy-mm-dd",
            todayHighlight: true,
            orientation: "top auto",
            todayBtn: true,
            todayHighlight: true,  
          });
        });
      </script>

      <script type="text/javascript">
        $(document).ready(function(){
         $('#fakultas2').change(function(){
          var fakultas2 =  $('#fakultas2').val();
          $.ajax({
            url: '<?php echo base_url('admin/C_registrant/getJurusan'); ?>',
            type: 'GET',
            data: "fakultas2="+fakultas2,
            dataType: 'json',
            success: function(data){
             var fakultas2=`<select id="jurusan2" name="jurusan">
             <option value="null" disabled selected>-Pilihan Jurusan</option>`;
             for (var i = 0; i < data.length; i++) {
              fakultas2+='<option value="'+data[i].id+'">'+data[i].namaJur+'</option>';
            }
            fakultas2+=`</select>
            <label>Jurusan</label>`;
            $('#jurusan2').html(fakultas2);
          }
        });
        });
       });
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
                <label class="control-label col-md-3">NIM</label>
                <div class="col-md-9">
                  <input name="nim" id="nim" placeholder="NIM" class="form-control" type="text" required="required">
                </div>
              </div>

              <div class="form-group">
                <label class="control-label col-md-3">Nama</label>
                <div class="col-md-9">
                  <input name="nama" id="nama" placeholder="Nama" class="form-control" type="text" required="required">
                </div>
              </div>
              <div class="form-group">
                <label class="control-label col-md-3">TempatLahir</label>
                <div class="col-md-9">
                  <input name="tempatLahir" id="tempatLahir" placeholder="Tempat Lahir" class="form-control" type="text" required="required">
                </div>
              </div>

              <div class="form-group">
                <label class="control-label col-md-3">TanggalLahir</label>
                <div class="col-md-9">
                  <input name="tanggalLahir" id="tanggalLahir" placeholder="Tanggal Lahir" class="form-control datepicker" type="text" required="required">
                </div>
              </div>

              <div class="form-group">
                <label class="control-label col-md-3">No.Hp</label>
                <div class="col-md-9">
                  <input name="noTelp" id="noTelp" placeholder="No.Hp" class="form-control" type="number" required="required">
                </div>
              </div>

              <div class="form-group">
                <label class="control-label col-md-3">Jenis Kelamin</label>
                <div class="col-md-9">
                  <select name="jenisKel" id="jenisKel" class="form-control">
                    <option value="" disabled selected>-Pilih Jenis Kelamin</option>
                    <option value="1">Laki-Laki</option>
                    <option value="2">Perempuan</option>
                  </select>
                </div>
              </div>

              <div class="form-group">
                <label class="control-label col-md-3">Fakultas</label>
                <div class="col-md-9">
                  <select name="fakultas" id="fakultas2" class="form-control">
                    <option value="" disabled selected>-Pilihan Fakultas</option>
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
                  <select name="jurusan" id="jurusan2" class="form-control">
                    <option value="" disabled selected>-Pilihan Jurusan</option>
                  </select>
                </div>
              </div>

              <div class="form-group">
                <h4 style="text-align: center;"><b>Select (Criteria)</b></h4>
              </div>

              <div id="scoreKriteria"></div>

            </div>
            <input type="hidden" name="idContest" id="idContest">
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