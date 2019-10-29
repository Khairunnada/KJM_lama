<?php
include "config.php";
include "functions.php";
if(!isset($_SESSION['id_user_'.$kode_perusahaan])) 
{
  navigasi_ke('login.php');
} 
else
{
  navigasi_ke('dashboard.php');
}