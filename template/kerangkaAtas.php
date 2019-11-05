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
  $sql =
  "SELECT
    b.id,
    a.nama as nav_detail,
    b.nama as nav
  FROM
    tb_master_navigasi_detail AS a
  JOIN
    tb_master_navigasi AS b ON (b.id = a.id)
  WHERE
    a.id_detail = '".$id_nav_detail."'";
  $res = mysqli_query($db,$sql) OR die('error 18');
  if(mysqli_num_rows($res) != 0)
  {
    while($row = mysqli_fetch_assoc($res))
    {
      $id_nav = $row['id'];
      $nav = $row['nav'];
      $nav_detail = $row['nav_detail'];
    }    
  }
  if(cek_page_avail($id_user,$id_nav_detail) == 0)
  {
    navigasi_ke('index.php');
  }
}
if(isset($_GET['page']))
{
  $page = fch($_GET['page']);
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