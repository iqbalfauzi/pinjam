<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <section class="content-header">
    <h1>
      Setting Pair Criteria <?php echo $namaContest?>
    </h1>
    <ol class="breadcrumb">
      <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
      <li class="active">Setting Pair Criteria</li>
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
          <div class="box-body">
            <div class="form-group">
              <label for="nama" class="control-label col-md-2">Contest Name</label>
              <div class="col-md-10">
                <input name="idSetBea" type="hidden" class="validate" value="<?php echo $idSetBea;?>">
                <input type="text" class="form-control" id="nama" name="nama" placeholder="Contest Name" required="required" value="<?php echo $nama;?>" readonly="readonly">
              </div>
            </div>
            <div class="form-group">
              <label for="kuota" class="control-label col-md-2">Quota</label>
              <div class="col-md-10">
                <input type="number" class="form-control" id="kuota" name="kuota" placeholder="Quota" required="required" value="<?php echo $kuota;?>" readonly="readonly">
              </div>
            </div>
            <div class="form-group">
              <label for="dibuka" class="control-label col-md-2">Register Opened</label>
              <div class="col-md-10">
                <input type="text" class="form-control" id="dibuka" name="dibuka" placeholder="Register Opened" required="required" value="<?php echo $dibuka;?>" readonly="readonly">
              </div>
            </div>
            <div class="form-group">
              <label for="ditutup" class="control-label col-md-2">Register Closed</label>
              <div class="col-md-10">
                <input type="text" class="form-control" id="ditutup" name="ditutup" placeholder="Register Closed" required="required" value="<?php echo $ditutup;?>" readonly="readonly">
              </div>
            </div>
            <div class="form-group">
              <label for="seleksiTutup" class="control-label col-md-2">Selection Closed</label>
              <div class="col-md-10">
                <input type="text" class="form-control" id="seleksiTutup" name="seleksiTutup" placeholder="Selection Closed" required="required" value="<?php echo $seleksiTutup;?>" readonly="readonly">
              </div>
            </div>
          </div>
        </form>
        <!-- /.box-body -->
        <!-- <div class="box-footer">
          <a class="btn btn-warning" href="<?php echo base_url('admin/C_pair')?>" title="Tambah data">Back</a>
          <?php
          if ($idSetBea != "") {
            ?>
            <button onclick="remove_data('<?php echo $idSetBea ?>')" class="btn btn-danger" title="Hapus Pengaturan Beasiswa"><i class="glyphicon glyphicon-trash"></i> Delete data</button>
            <?php
          }
          ?>
          <button onclick="save()" type="button" class="btn btn-success">Save</button>
        </div> -->
      </div>
    </div>
  </div>
</section>


<?php
if ($idSetBea != "") { ?>
<section class="content">
  <div class="row">
   <div class="col-md-12">
    <div class="box box-primary">

      <div class="callout callout-default">
        <h4 style="text-align: center;">Setting Pair Criteria <?php echo $namaContest?></h4>
      </div>
      <div class="box-header with-border">
        <div class="col-xs-12">
         <?php if ($get_by_consistence != "") { ?>
         <div class="alert alert-warning alert-dismissible">
          Lambda = <strong><?php echo number_format($lambda,2)?></strong>; CI = <strong><?php echo number_format($consIndex,2)?></strong>; CR = <strong><?php echo number_format($consRatio*100,2)?>%, (CR dibawah 10% dapat diterima)</strong>
        </div>
        <?php }?>
      </div>
      <div class="col-xs-12">
        <button class="btn btn-primary pull-right" onclick="panduan_setting()" title="Panduan Penilaian Kriteria"><i class="glyphicon glyphicon-zoom-in"></i> Panduan</button>
      </div>
    </div>

    <div class="box-body" style="overflow-x: auto;">

      <form method="post" action="<?php echo base_url('admin/C_pair/ahpUpdate'); ?>">
        <input type="hidden" name="idContest" value="<?php echo $idContest?>">
        <table class="table table-bordered table-hover" cellspacing="0" width="100%">
          <thead>
            <tr class="success">
              <th><i class="mdi-content-clear"></i></th>
              <?php foreach($kriteriaMatrix as $kr){
                echo "<th>".$kr->nama."</th>";
              } ?>
            </tr>
          </thead>
          <tbody id="tbody_pengaturan_nilai">
           <?php
           $baris=0;
           foreach($kriteriaMatrix as $kr){
            $key = array_keys($pK);
            echo "<tr><td class='success'>".$kr->nama."</td>";
            for($j=0;$j<$jumlahKriteria;$j++){
              echo "<td><input type='text' name='krit[$baris][$j]' class='form-control' ";
                  echo(($baris>$j)?"value='".number_format($pK[$kr->idKriteriaSkor][$key[$j]],1,'.',',') ."' disabled":""); // disabled karena pair kiri-bawah
                  echo(($baris==$j)?"value='".number_format($pK[$kr->idKriteriaSkor][$key[$j]],0,'.',',') ."' disabled":""); // disabled karena pair sesamanya
                  echo(($baris<$j)?"value='".number_format($pK[$kr->idKriteriaSkor][$key[$j]],0,'.',',') ."'":"");
                  echo "/></td>";
                }
                echo "</tr>";
                $baris++;
              } ?> 
            </tbody>
            <tfoot>
              <?php
              echo "
              <tr>
                <td colspan='".($jumlahKriteria+1)."'>
                  <a class='btn btn-warning' href='".base_url("admin/C_pair")."'><i class='glyphicon glyphicon-chevron-left'></i> Back</a>
                  <input type='submit' name='submitahp' class='btn btn-success' value='Save Pair Criteria' title='Save Pair Criteria'/>
                </td>
              </tr>";
              ?>
            </tfoot>
          </table>
        </form>
      </div>
    </div>
  </div>
</div>
</section>

<section class="content">
  <div class="row">
   <div class="col-md-12">
    <div class="box box-primary">
      <div class="callout callout-default">
        <h4 style="text-align: center;">Eigen Value</h4>
      </div>
      <div class="box-body" style="overflow-x: auto;">
        <form method="post" action="<?php echo base_url('kasubag/C_KriteriaAHP/ahpUpdate'); ?>">
          <input type="hidden" name="idContest" value="<?php echo $idContest?>">
          <table class="table table-bordered table-hover" cellspacing="0" width="100%">
            <thead>
              <tr class="success">
               <th>No</th>
               <th>Nama Kriteria</th>
               <th>Value Eigen</th>
             </tr>
           </thead>
           <tbody>
            <?php
            $no=1;
            foreach ($eigenVal as $row) : ?>
            <tr>
             <td><?php echo $no++; ?></td>
             <td><?php echo $row->nama ?></td>
             <td><?php echo number_format($row->value_eigen,4)?></td>
           </tr>
         <?php endforeach; ?>
       </tbody>
       <tfoot>
        <tr>
          <th></th>
          <th>Jumlah</th>
          <th><?php echo $jumlah;?></th>
        </tr>
      </tfoot>
    </table>
  </form>
</div>
</div>
</div>
</div>
</section>
<?php } ?>


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

  function delete(id)
  {
    if(confirm('Apakah kamu yakin ingin menghapus data ini ?'))
    {
        // ajax delete data to database
        $.ajax({
          url : "<?php echo site_url('admin/C_pair/hapus')?>/"+id,
          type: "POST",
          dataType: "JSON",
          success: function(data)
          {
               //if success reload ajax table
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
        function panduan_setting()
        {
          $('#modal1').modal('show');
          // $('.modal-title').text('Tabel Panduan Penilaian Kriteria');
        }
      </script>


      <!-- Bootstrap modal -->
      <div class="modal fade modal-default" id="modal1" role="dialog">
        <div class="modal-dialog modal-lg">
          <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
              <h3 class="modal-title"><i class="fa fa-list-alt"></i> <strong> Tabel Panduan Penilaian Kriteria </strong></h3>
            </div>
            <div class="modal-body form">


              <p>Masing-masing kolom diisi dengan angka antara 1 s/d 9, dimana angka tersebut adalah nilai dari perbandingan berpasangan antar kriteria.</p>
              <style>
                table#panduan_tabel>tbody>tr>td:first-child{text-align:center}
                .rd{color:rgb(237,28,36);}
                .bl{color:rgb(0,162,232);}
              </style>

              <div style="overflow-x: auto;">
                <table id="table" class="table table-bordered table-hover" cellspacing="0" width="100%">
                  <thead>
                    <tr class="success">
                     <th>Nilai</th>
                     <th>Keterangan</th>
                   </tr>
                 </thead>
                 <tbody id="detail_skor_mhs">
                   <tr>
                    <td>1</td>
                    <td>Kedua kriteria <strong>sama pentingnya</strong></td>
                  </tr>
                  <tr>
                    <td>3</td>
                    <td>Salah satu kriteria <strong>sedikit lebih penting</strong></td>
                  </tr>
                  <tr>
                    <td>5</td>
                    <td>Salah satu kriteria <strong>jelas lebih penting</strong></td>
                  </tr>
                  <tr>
                    <td>7</td>
                    <td>Salah satu kriteria <strong>sangat jelas lebih penting</strong></td>
                  </tr>
                  <tr>
                    <td>9</td>
                    <td>Salah satu kriteria <strong>paling lebih penting</strong></td>
                  </tr>
                  <tr>
                    <td>2,4,6,8</td>
                    <td>Digunakan apabila ragu-ragu diantara dua nilai yang berdekatan</strong></td>
                  </tr>
                  <tr>
                    <td>Kebalikan (1/Nilai)</td>
                    <td>Apabila satu kriteria mendapat sebuah nilai, maka kriteria pasangannya mendapat kebalikannya (1/nilai)</td>
                  </tr>
                </tbody>
                <tfoot>
                  <tr class="success">
                   <th>Nilai</th>
                   <th>Keterangan</th>
                 </tr>
               </tfoot>
             </table>

             
             <h6><span class="brown-text"><b>Contoh</b></span></h6>
             <div style="text-align:center"><img src="<?= base_url('assets/images/nilai-kr.jpg') ?>" alt="contoh"/></div>
             <p>Anda mengisi nilai perbandingan kriteria antara <span class='rd'><strong>Indeks Prestasi Akademik (IPK)</strong></span> dan <span class='bl'><strong>Penghasilan Ayah</strong></span>. Apabila <span class='rd'><strong>IPK</strong></span> <strong>sedikit lebih penting</strong> dari <span class='bl'><strong>Penghasilan Ayah</strong></span>, maka kolom diisi nilai <strong>3</strong>. Sebaliknya, apabila <span class='bl'><strong>Penghasilan Ayah</strong></span> <strong>sedikit lebih penting</strong> dari <span class='rd'><strong>IPK</strong></span>, maka diisi dengan <strong>1/3</strong></p>
             <p><span class="glyphicon glyphicon-info-sign"></span> Perhatikan untuk mengisi nilai kriteria perbandingan berpasangan dengan urutan pasangan <span class='rd'><strong>Baris</strong></span> lalu <span class='bl'><strong>Kolom</strong></span></p>

           </div>
         </div>
         <div class="modal-footer">
          <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
        </div>
      </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
  </div><!-- /.modal -->
<!-- End Bootstrap modal -->