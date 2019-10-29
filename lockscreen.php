<?php
include "config.php";
include "functions.php";
$cek_login = -1;
if(isset($_POST['tombol_login'])) 
{
  $password = $_POST['password'];
  $sql =
  "SELECT
    *
  FROM
    tb_master_user as a
  WHERE
    a.username = '".$username."' and
    a.password = sha1(md5('".$password ."')) and
    a.aktif = 1";
  $res = mysqli_query($db,$sql) or die('error 17');
  if(mysqli_num_rows($res) == 0)
  {
    $cek_login = 0;
  }
  else
  {
    while($row = mysqli_fetch_assoc($res)) 
    {
      $_SESSION['id_user_'.$kode_perusahaan] = $row['id'];
      $_SESSION['nama_user_'.$kode_perusahaan] = $row['nama']; 
      $_SESSION['username_'.$kode_perusahaan] = $row['username'];
      $_SESSION['logged_time'] = time();           
      navigasi_ke('index.php');
    }
  }
}
?>
<!DOCTYPE html>
<html>

<head>
  <?php include 'template/head_lockscreen.php';?>
</head>

<body class="hold-transition lockscreen">
  <!-- Automatic element centering -->
  <div class="lockscreen-wrapper">
    <div class="lockscreen-logo">
      <a href="index.php"><b><?php echo $perusahaan; ?></b></a>
    </div>
    <!-- User name -->
    <div class="lockscreen-name" style="font-size:15pt !important;"><?php echo $nama_user; ?></div>
    <!-- START LOCK SCREEN ITEM -->
    <div class="lockscreen-item">
      <!-- lockscreen credentials (contains the form) -->
      <form action="" method="POST">
        <!-- class="lockscreen-credentials" -->
        <div class="input-group">
          <input autofocus type="password" name="password" class="form-control" placeholder="password" required>
          <div class="input-group-btn">
            <button type="submit" name="tombol_login" class="btn"><i class="fa fa-arrow-right text-muted"></i></button>
          </div>
        </div>
      </form>
      <!-- /.lockscreen credentials -->
    </div>
    <!-- /.lockscreen-item -->
    <div class="help-block text-center">
      Silakan masukkan password anda untuk melanjutkan sesi
    </div>
    <div class="text-center">
      <a href="logout.php">Atau masuk sebagai akun lain</a>
    </div>
    <div class="lockscreen-footer text-center">
      Copyright &copy; 2014-2016 <b><a href="https://adminlte.io" class="text-black">Almsaeed Studio</a></b><br>
      All rights reserved
    </div>
  </div>
  <!-- /.center -->
  <?php include 'template/script_lockscreen.php';?>
</body>

</html>