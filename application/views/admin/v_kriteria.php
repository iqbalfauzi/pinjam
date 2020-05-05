<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <section class="content-header">
    <h1>
      Master of Weighted Criteria
    </h1>
    <ol class="breadcrumb">
      <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
      <li class="active">Master of Criteria</li>
    </ol>
  </section>


  <!-- Main content -->
  <section class="content">
   <div class="box box-primary">
    <div class="box-header with-border">
     <div class="col-xs-12">
      <button class="btn btn-success pull-right" onclick="add_person()"><i class="glyphicon glyphicon-plus"></i> Add data</button>
    </div>
  </br>
  <div class="box-body" style="overflow-x: auto;">
    <table id="table" class="table table-bordered table-hover" cellspacing="0" width="100%">
      <thead>
        <tr class="success">
         <th>No</th>
         <th>Kriteria</th>
         <th>(Bobot) Value</th>
         <th>Action</th>
       </tr>
     </thead>
     <tbody>
     </tbody>
     <tfoot>
      <tr class="success">
        <th>No</th>
        <th>Kriteria</th>
        <th>(Bobot) Value</th>
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
  var arr = 0;
  var table;
  $(document).ready(function() {
    table = $('#table').DataTable({ 
      "processing": true,
      "serverSide": true,
      "ajax": {
        "url": "<?php echo site_url('admin/C_kriteria/datatable')?>",
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
    arr = 0;
    save_method = 'add';
    $('#form')[0].reset();
    $('#scoreInput').empty();
    $('#modal_form').modal('show');
    $('.modal-title').text('Add Data Criteria and Subcriteria');
  }

  function edit_person(id)
  {
    arr = 0;
    save_method = 'update';
    $('#form')[0].reset();
    $('#scoreInput').empty();

      //Ajax Load data from ajax
      $.ajax({
        url : "<?php echo site_url('admin/C_kriteria/edit_data/')?>/" + id,
        type: "GET",
        dataType: "JSON",
        success: function(data)
        {
          $('#kriteria').val(data[0].namaJenis);
          $('#idJenisScoring').val(data[0].idJenis);          

          for (var i = 1; i < data.length; i++) {
            idSub = data[i].idSub;
            sub = data[i].sub;
            skor = data[i].skor;

            score_input = `
            <div class="form-group">
              <label class="control-label col-md-2">Subcriteria `+(arr+1)+`</label>
              <div class="col-md-4">
                <input type="hidden" id="idSub[`+arr+`]" name="idSub[`+arr+`]" value="`+idSub+`" class="validate">
                <input name="score[`+arr+`]" id="score[`+arr+`]" type="text" class="form-control" placeholder="Name of Subcriteria" value="`+sub+`">
              </div>
              <label class="control-label col-md-2">Score `+(arr+1)+`</label>
              <div class="col-md-3">
                <input name="bobot[`+arr+`]" id="bobot[`+arr+`]" type="number" class="form-control" placeholder="Value" value="`+skor+`">
              </div>
            </div>
            `;

            $("#scoreInput").append(score_input);
            arr+=1;
          }

          $('#modal_form').modal('show');
          $('.modal-title').text('Update Data Criteria and Subcriteria');

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

    function add_score_input() {
      score = `
      <div class="form-group">
        <label class="control-label col-md-2">Subcriteria `+(arr+1)+`</label>
        <div class="col-md-4">
          <input type="hidden" id="idSub[`+arr+`]" name="idSub[`+arr+`]" class="validate">
          <input name="score[`+arr+`]" id="score[`+arr+`]" type="text" class="form-control" placeholder="Name of Subcriteria">
        </div>
        <label class="control-label col-md-2">Score `+(arr+1)+`</label>
        <div class="col-md-3">
          <input name="bobot[`+arr+`]" id="bobot[`+arr+`]" type="number" class="form-control" placeholder="Value">
        </div>
      </div>
      `;

      $("#scoreInput").append(score);
      arr+=1;
    }

    function save()
    {
      var url;
      if(save_method == 'add') 
      {
        url = "<?php echo site_url('admin/C_kriteria/simpan')?>";
      }
      else
      {
        url = "<?php echo site_url('admin/C_kriteria/update')?>";
      }

       // ajax adding data to database
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
      if(confirm('Are you sure to delete this data ?'))
      {
        // ajax delete data to database
        $.ajax({
          url : "<?php echo site_url('admin/C_kriteria/hapus')?>/"+id,
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
              <label class="control-label col-md-2">Criteria</label>
              <div class="col-md-10">
                <input type="hidden" id="idJenisScoring" name="idJenisScoring">
                <input type="text" id="kriteria" name="kriteria" placeholder="Name of Criteria" class="form-control">
              </div>
            </div>

            <div id="scoreInput"></div>

            <div class="row">
              <div class="col-md-2"></div>
              <div class="col-md-10">
                <p>** Untuk menghapus, biarkan kosong pada isian scoring.</p>
              </div>
            </div>

          </div>
        </form>
      </div>
      <div class="modal-footer">
       <button class="btn btn-warning pull-left" title="Tambah Scoring" onclick="add_score_input()"><i class="glyphicon glyphicon-plus"></i> Add data Criteria</button>
       <button type="button" id="btnSave" onclick="save()" class="btn btn-success">Save</button>
       <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
     </div>
   </div><!-- /.modal-content -->
 </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
<!-- End Bootstrap modal -->