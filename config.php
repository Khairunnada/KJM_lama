<?php
session_start();
include '../gb_config.php';
//error_reporting(E_ALL & ~E_NOTICE);
$kode_perusahaan = 'KJM';
$perusahaan = 'PT. Karo Jaya Makmur';
$db = mysqli_connect($gb_server,$gb_username,$gb_password,$kode_perusahaan);
date_default_timezone_set("Asia/Jakarta");
$tgl_sekarang = date('Y-m-d');
$today = date_parse($tgl_sekarang);
$bulan_now = $today['month'];
$tahun_now = $today['year'];
$db_isistem = mysqli_connect("localhost", "root", "", "isistem");
$db_internal_system = mysqli_connect("localhost", "root", "", "internal_system");
$db_accounting = mysqli_connect("localhost", "root", "", "accounting");
$db_sistem_stok = mysqli_connect("localhost", "root", "", "sistem_stok");
$db_kas = mysqli_connect("localhost", "root", "", "kas");
$db_repository = mysqli_connect("localhost", "root", "", "repository");
//$db_bahan = mysqli_connect("localhost", "root", "", "bahan");
if(isset($_SESSION['id_user_'.$kode_perusahaan])) 
{
  $id_user = $_SESSION['id_user_'.$kode_perusahaan];
  $nama_user = $_SESSION['nama_user_'.$kode_perusahaan];
  $username = $_SESSION['username_'.$kode_perusahaan];
}
$skin = 'skin-black';
$sidebar_style = 'sidebar-collapse';//sidebar-collapse
$boxheader_border = 'with-border';
$login_session_duration = 1800; // 30 minute