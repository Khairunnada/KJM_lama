<?php
include "config.php";
include "functions.php";
if (!isset($_SESSION['id_user_'.$kode_perusahaan])) 
{
  navigasi_ke('index.php');
}  
if(isset($_GET['id_nav_detail']))
{
  $id_nav_detail = fch($_GET['id_nav_detail']);
  if(cek_page_avail($id_user,$id_nav_detail) == 0)
  {
    navigasi_ke('index.php');
  }
}

/*if($_SESSION['logged_time'])
{
  if(((time() - $_SESSION['logged_time']) > $login_session_duration))
  { 
    navigasi_ke('lockscreen.php');
    // session will be exired after 1 minutes
  }
}*/
?>
<!DOCTYPE html>
<html>

<head>
  <?php include 'template/head.php'; ?>
</head>

<body class="hold-transition sidebar-mini <?php echo $skin; ?> <?php echo $sidebar_style; ?>">
  <!-- sidebar-collapse -->
  <!-- Site wrapper -->
  <div class="wrapper">
    <?php include 'template/header.php';?>
    <!-- =============================================== -->
    <!-- Left side column. contains the sidebar -->
    <?php include 'template/sidebar.php';?>
    <!-- =============================================== -->