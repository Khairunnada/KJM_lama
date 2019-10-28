<?php
include "config.php";
include "functions.php";
if (!isset($_SESSION['id_user_'.$kode_perusahaan])) 
{
  navigasi_ke('index.php');
}
if(isset($_GET['refresh']))
{
  unset($_SESSION['tombol_filter_pengaktivaan']);
  unset($_SESSION['tgl_awal_pengaktivaan']);
  unset($_SESSION['tgl_akhir_pengaktivaan']);
  unset($_SESSION['kode_aktiva_pengaktivaan']);
  unset($_SESSION['nama_aktiva_pengaktivaan']);
  unset($_SESSION['data_per_halaman_pengaktivaan']);
  navigasi_ke('?daftar');
}
?>
<!DOCTYPE html>
<html>

<head>
  <?php include 'template/head.php'; ?>
</head>

<body class="hold-transition skin-blue sidebar-mini sidebar-collapse">
  <!-- sidebar-collapse -->
  <!-- Site wrapper -->
  <div class="wrapper">
    <?php include 'template/header.php';?>
    <!-- =============================================== -->
    <!-- Left side column. contains the sidebar -->
    <?php include 'template/sidebar.php';?>
    <!-- =============================================== -->
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
      <!-- Content Header (Page header) -->
      <section class="content-header">
        <h1>
          Blank page
          <small>it all starts here</small>
        </h1>
        <ol class="breadcrumb">
          <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
          <li><a href="#">Examples</a></li>
          <li class="active">Blank page</li>
        </ol>
      </section>
      <!-- Main content -->
      <section class="content">
        <!-- Default box -->
        <div class="box">
          <div class="box-header with-border">
            <h3 class="box-title">Title</h3>

            <div class="box-tools pull-right">
              <button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="Collapse">
                <i class="fa fa-minus"></i></button>
              <button type="button" class="btn btn-box-tool" data-widget="remove" data-toggle="tooltip" title="Remove">
                <i class="fa fa-times"></i></button>
            </div>
          </div>
          <div class="box-body">
            Start creating your amazing application!
          </div>
          <!-- /.box-body -->
          <div class="box-footer">
            Footer
          </div>
          <!-- /.box-footer-->
        </div>
        <!-- /.box -->
      </section>
      <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->
    <?php include 'template/footer.php';?>
  </div>
  <!-- ./wrapper -->
  <?php include 'template/script.php';?>
</body>

</html>