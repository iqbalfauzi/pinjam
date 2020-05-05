<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Data Mahasiswa Lolos Seleksi</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <!-- Bootstrap 3.3.6 -->
  <link rel="stylesheet" href="<?php echo base_url('assets/bootstrap/css/bootstrap.min.css'); ?>">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.5.0/css/font-awesome.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ionicons/2.0.1/css/ionicons.min.css">

  <script type="text/javascript" src="<?php echo base_url('assets/plugins/jQuery/jQuery-2.1.4.min.js')?>"></script>
  <!-- Theme style -->
</head>
<body onload="window.print();setTimeout(window.close, 0);">
  <div class="wrapper">
    <!-- Main content -->
    <section class="invoice">
      <!-- title row -->
      <div class="row">
        <div class="col-xs-12">
          <h2 class="page-header">
            <img width="35px" height="35px" src="<?php echo base_url('assets/images/logo.png'); ?>">&nbsp;Data Mahasiswa Lolos Seleksi
            <small class="pull-right">Tanggal : <?php echo date('Y-m-d'); ?></small>
          </h2>
        </div>
        <!-- /.col -->
      </div>
      <!-- info row -->
      <div class="row invoice-info">
        <div class="col-sm-4 invoice-col">
          Data Data Mahasiswa Lolos Seleksi PIONIR UIN Malang
          <address>
            <strong>Kemahasiswan UIN Maulana Malik Ibrahim Malang</strong><br>
            Jalan  Gajayana Nomor 50 Kecamatan Lowokwaru Malang<br>
          </address>
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->

      <!-- Table row -->
      <div class="row">
        <div class="col-xs-12 table-responsive">
          <table id="table1" class="table table-striped table-bordered">
            <thead>
              <tr>
                <th>NIM</th>
                <th>NAMA</th>
                <th>Fakultas</th>
                <th>Jurusan</th>
                <th>Contest</th>
              </tr>
            </thead>
            <tbody>
              <?php foreach ($databea as $data): ?>

              <tr style="text-align: left;">

              <td><?php echo $data->nim?></td>
              <td><?php echo $data->nama?></td>
              <td><?php echo $data->namaJur?></td>
              <td><?php echo $data->namaFk?></td>
              <td><?php echo $data->nama_contest?></td>
              </tr>
              <?php endforeach; ?>
            </tbody>
          </table>
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->
    </section>
    <!-- /.content -->
  </div>
  <!-- ./wrapper -->
</body>
</html>
