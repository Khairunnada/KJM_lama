<?php
error_reporting(0);
include "config.php";
include "functions.php";
unset($_SESSION['id_user_'.$kode_perusahaan]);
unset($_SESSION['nama_user_'.$kode_perusahaan]);
navigasi_ke('index.php');