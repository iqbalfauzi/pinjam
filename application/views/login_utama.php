<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <title>LOGIN</title>
  <base href="<?php echo base_url() ?>" />
  <!-- Tell the browser to be responsive to screen width -->
  <link rel="shortcut icon" href="assets/images/logo.png" type="image/x-icon" />

  <link rel="stylesheet" href="assets/bootstrap/css/bootstrap.min.css">
  <link rel="stylesheet" href="assets/dist/css/AdminLTE.min.css">
  <link rel="stylesheet" href="assets/dist/css/skins/_all-skins.min.css">
  <link rel="stylesheet" href="assets/bootstrap/css/animate.css">
  <link rel="stylesheet" href="assets/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css">
</head>

<style type="text/css">
  body{
    background: url('assets/images/bg_siswa.jpg');
    font-family: courier;
  }
</style>
<div class="login-box">
  <div class="login-logo">
    <img src="assets/images/logo.png" width="120px"><br/>

  </div><!-- /.login-logo -->
  <div class="login-box-body">
    <p class="login-box-msg"><b>LOGIN</b></p>
    <?php echo $this->session->flashdata('pesan');?>
    <?php echo form_open('C_FunctLogin/prosesLogin') ?>
    <div class="form-group has-feedback animated bounceInLeft" style="animation-delay: 0.5s;">
      <input type="text" class="form-control" name="username" placeholder="Username">

    </div>
    <div class="form-group has-feedback animated bounceInLeft" style="animation-delay: 0.5s;">
      <input type="password" class="form-control" name="password" placeholder="Password">

    </div>
    <div class="form-group has-feedback animated bounceInLeft" style="animation-delay: 0.5s;">
      <select class="form-control" name="idLevel" required="required">
        <option value="" disabled selected>~ Pilih Level ~</option>
        <option value="1">Admin</option>
        <option value="2">Mahasiswa</option>
      </select>
    </div>

    <div class="row animated bounceInDown" style="animation-delay: 1s;">
     <div class="col-xs-8">
      <button type="submit" name="login" class="btn btn-primary btn-block btn-flat">Sign In</button>

    </div><!-- /.col -->
    <div class="col-xs-4">
      <a href="index.php" class="btn btn-danger btn-block btn-right">Back</a>
    </div><!-- /.col -->
  </div>
</form>




</div><!-- /.login-box-body -->
</div><!-- /.login-box -->
<style type="text/css">
  footer{
    text-align: center;
    color: white;
  }
</style>
<footer>
  <b>COPYRIGHT &copy; 2019 DECISION SUPPORT SYSTEM SELECTION OF PIONIR ATHLETE UIN MALANG USING AHP-TOPSIS METHOD </a></b>
</footer> >