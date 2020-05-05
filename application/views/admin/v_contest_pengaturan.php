<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <section class="content-header">
    <h1>
      Master of Setting Contest
    </h1>
    <ol class="breadcrumb">
      <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
      <li class="active">Master of Setting Contest</li>
    </ol>
  </section>


  <!-- Main content -->
  <section class="content">
    <div class="row">
     <div class="col-md-12">
      <!-- general form elements -->
      <div class="box box-primary">
        <div class="box-header with-border">
        </div>
        <!-- /.box-header -->
        <!-- form start -->
        <form id="form" class="form-horizontal">
          <input name="idSetBea" type="hidden" value="<?php echo $idSetBea;?>">
          <div class="box-body">
            <div class="form-group">
              <label for="nama" class="control-label col-md-2">Contest Name</label>
              <div class="col-md-10">
                <input type="text" class="form-control" id="nama" name="nama" placeholder="Contest Name" required="required" value="<?php echo $nama;?>">
              </div>
            </div>
            <div class="form-group">
              <label for="kuota" class="control-label col-md-2">Quota</label>
              <div class="col-md-10">
                <input type="number" class="form-control" id="kuota" name="kuota" placeholder="Quota" required="required" value="<?php echo $kuota;?>">
              </div>
            </div>
            <div class="form-group">
              <label for="dibuka" class="control-label col-md-2">Register Opened</label>
              <div class="col-md-10">
                <input type="text" class="form-control datepicker" id="dibuka" name="dibuka" placeholder="Register Opened" required="required" value="<?php echo $dibuka;?>">
              </div>
            </div>
            <div class="form-group">
              <label for="ditutup" class="control-label col-md-2">Register Closed</label>
              <div class="col-md-10">
                <input type="text" class="form-control datepicker" id="ditutup" name="ditutup" placeholder="Register Closed" required="required" value="<?php echo $ditutup;?>">
              </div>
            </div>
            <div class="form-group">
              <label for="seleksiTutup" class="control-label col-md-2">Selection Closed</label>
              <div class="col-md-10">
                <input type="text" class="form-control datepicker" id="seleksiTutup" name="seleksiTutup" placeholder="Selection Closed" required="required" value="<?php echo $seleksiTutup;?>">
              </div>
            </div>
            <div class="callout callout-success">
              <h4 style="text-align: center;">Scoring (Criteria)</h4>
            </div>
            <div id="scoring">
              <?php
              $arrPhp = 0;
              $metode = "add";
              if ($idSetBea != null) {
                $metode = "update";
                foreach ($skor as $sk) {
                  $dt = '
                  <div class="form-group">
                    <label class="control-label col-md-2">Scoring '.($arrPhp+1).'</label>
                    <div class="col-md-10">
                      <input type="hidden" name="idSet[]" value="'.$sk->id.'">
                      <select name="score[]" class="form-control">
                        <option value="" disabled selected>~ Option</option>
                        ';
                        foreach ($combo as $cm) {
                          if ($sk->idKriteriaSkor == $cm->id) {
                            $dt .= '<option value="'.$cm->id.'" selected>'.$cm->nama.'</option>';
                          }else {
                            $dt .= '<option value="'.$cm->id.'">'.$cm->nama.'</option>';
                          }
                        }
                        $dt .= '
                        <option value="HAPUS">-HAPUS-</option>
                      </select>
                    </div>
                  </div>
                  ';
                  echo $dt;
                  $arrPhp+=1;
                }
              }
              ?>
            </div>
          </div>
        </form>
        <!-- /.box-body -->
        <div class="box-body">
          <button class="btn btn-primary pull-left" title="Tambah Scoring" onclick="add_score()"><i class="glyphicon glyphicon-plus"></i> Add data Criteria</button> &nbsp;&nbsp;&nbsp;
          Add for new criteria. <br><br><small style="color: red">**Select "DELETE" for deleted data.</small>
        </div>
        <div class="box-footer">
          <a class="btn btn-warning" href="<?php echo base_url('admin/C_contest')?>"><i class="glyphicon glyphicon-chevron-left"></i> Back</a>
          <?php
          if ($idSetBea != "") {
            ?>
            <button onclick="remove_data('<?php echo $idSetBea ?>')" class="btn btn-danger" title="Hapus Pengaturan Beasiswa"><i class="glyphicon glyphicon-trash"></i> Delete data</button>
            <?php
          }
          ?>
          <button onclick="save()" type="button" class="btn btn-success" title="Save"><i class="glyphicon glyphicon-ok"></i> Save</button>
        </div>
      </div>
    </div>
  </div>
</section>
</div>
<!-- /.content-wrapper -->
</div><!-- ./wrapper -->

<script type="text/javascript">
  var table;
  var arr = <?php echo $arrPhp ?>;
  var save_method = '<?php echo $metode ?>';

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

  function save()
  {
    var url;
    if(save_method == 'add')
    {
      url = "<?php echo site_url('admin/C_contest/add_data')?>";
    }
    else
    {
      url = "<?php echo site_url('admin/C_contest/update_data')?>";
    }
    $.ajax({
      url : url,
      type: "POST",
      data: $('#form').serialize(),
      dataType: "JSON",
      success: function(data)
      {
        window.location.href="<?php echo base_url('admin/C_contest')?>";
      },
      error: function (jqXHR, textStatus, errorThrown)
      {
        alert('Error adding/update data');
      }
    });
  }

  function remove_data(id)
  {
    if(confirm('Apakah kamu yakin ingin menghapus data ini ?'))
    {
        // ajax delete data to database
        $.ajax({
          url : "<?php echo site_url('admin/C_contest/delete_data')?>",
          type: "POST",
          dataType: "JSON",
          data: {'idSetBea': id},
          success: function(data)
          {
               //if success reload ajax table
               window.location.href = "<?php echo site_url('admin/C_contest')?>";
             },
             error: function (jqXHR, textStatus, errorThrown)
             {
              alert('Error adding / update data');
            }
          });

      }
    }

    function add_score() {
      $.ajax({
        url : "<?php echo site_url('admin/C_contest/get_scoring_data')?>",
        type: "GET",
        dataType: "JSON",
        success: function(data)
        {
          score = `
          <div class="form-group">
            <label class="control-label col-md-2">Scoring `+(arr+1)+`</label>
            <div class="col-md-10">
              <input type="hidden" name="idSet[]" value="">
              <select name="score[]" class="form-control">
                <option value="" disabled selected>~ Option</option>`;
                for (var i = 0; i < data.length; i++) {
                  score +='<option value="'+data[i].id+'">'+data[i].nama+'</option>';
                }
                score +=`
                <option value="HAPUS">-HAPUS-</option>
              </select>
            </div>
          </div>
          `;
          $("#scoring").append(score);
          arr+=1;
        },
        error: function (jqXHR, textStatus, errorThrown)
        {
          alert('Error get data');
        }
      });
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