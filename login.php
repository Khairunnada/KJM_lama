<?php
include "config.php";
include "functions.php";
$cek_login = -1;
if(isset($_POST['tombol_login'])) 
{
  $username = $_POST['username'];
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
  <?php include 'template/head_login.php'; ?>
</head>

<body class="hold-transition login-page">
  <div class="login-box">
    <div class="login-logo">
      <a href="index.php"><b><?php echo $perusahaan; ?></b></a>
    </div>
    <!-- /.login-logo -->
    <div class="login-box-body">
      <p class="login-box-msg">Silakan memulai sesi anda</p>
      <form action="" method="post">
        <div class="form-group has-feedback">
          <input autofocus type="text" name="username" class="form-control" placeholder="Username">
          <span class="glyphicon glyphicon-user form-control-feedback"></span>
        </div>
        <div class="form-group has-feedback">
          <input type="password" name="password" class="form-control" placeholder="Password">
          <span class="glyphicon glyphicon-lock form-control-feedback"></span>
        </div>
        <?php 
        if($cek_login == 0)
        {
        ?>
        <div class="row">
          <div class="col-xs-12">
            <div class="alert alert-danger">
              <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
              Username atau Password Salah!
            </div>
          </div>
        </div>
        <?php 
        }
        ?>
        <div class="row">
          <!-- /.col -->
          <div class="col-xs-12">
            <button type="submit" name="tombol_login" class="btn btn-primary btn-block btn-flat">Masuk</button>
          </div>
          <!-- /.col -->
        </div>
      </form>
    </div>
    <!-- /.login-box-body -->
  </div>
  <!-- /.login-box -->
  <?php include 'template/script_login.php'; ?>
</body>

</html>