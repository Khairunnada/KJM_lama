<?php
  include "config.php";
  include "functions.php";
  if(!isset($_SESSION['id_user_'.$kode_perusahaan]))
  {
    navigasi_ke('index.php');
  }
?>
<!doctype html>
<html class="fixed sidebar-left-collapsed">

<head>
  <?php include 'template/head.php'; ?>
</head>

<body>
  <section class="body">
    <?php include 'template/header.php'; ?>
    <div class="inner-wrapper">
      <?php include 'template/sidebar.php'; ?>
      <section role="main" class="content-body">
        <header class="page-header">
          <h2>Dashboard</h2>
          <div class="right-wrapper pull-right">
            <ol class="breadcrumbs">
              <li>
                <a href="index.php">
                  <i class="fa fa-home"></i>
                </a>
              </li>
              <li><span>Home</span></li>
              <li><span>Dashboard</span></li>
            </ol>
          </div>
        </header>
        <!-- start: page -->
        <h2>Selamat Datang dan Selamat Bekerja</h2>
        <!-- end: page -->
      </section>
    </div>
  </section>
  <?php include 'template/scripts.php'; ?>
</body>

</html>