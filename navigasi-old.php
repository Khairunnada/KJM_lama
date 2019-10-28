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
      <?php
      if(isset($_GET['kode']))
      {
        $kode = $_GET['kode'];
        $sql = 
        "SELECT
          a.grup
        FROM
          tb_master_navigasi AS a
        WHERE
          a.kode = '".$kode."'";
        $res = mysqli_query($db,$sql) OR die('error 32');
        if(mysqli_num_rows($res) != 0)
        {
          while($row = mysqli_fetch_assoc($res))
          {
            $grup = ucwords(strtolower($row['grup']));
          }
        }        
      ?>
      <section role="main" class="content-body">
        <header class="page-header">
          <h2><a href="?kode=<?php echo $kode; ?>" style="cursor:pointer;text-decoration:none;color:white;"><?php echo $grup; ?></h2>
          <div class="right-wrapper pull-right">
            <ol class="breadcrumbs">
              <li>
                <a href="index.php">
                  <i class="fa fa-home"></i>
                </a>
              </li>
              <li><span><?php echo $grup; ?></span></li>
              <li><span>Navigasi</span></li>
            </ol>
          </div>
        </header>
        <!-- start: page -->
        <div class="row">
          <div class="col-xs-12">
            <section class="panel">
              <header class="panel-heading">
                <h2 class="panel-title">Navigasi</h2>
              </header>
              <div class="panel-body">
                <div class="row">
                  <div class="col-sm-6">
                    <ul class="nav flex-column">
                      <?php
                      $sql =
                      "SELECT
                        b.nomor,
                        b.nama,
                        b.file
                      FROM
                        tb_master_user_detail as a   
                      JOIN  
                        tb_master_navigasi as b on (b.id = a.id_navigasi and b.kode = '".$kode."')
                      WHERE
                      a.id = '".$_SESSION['id_user_'.$kode_perusahaan]."'";
                      $sql .= " ORDER BY b.nomor";
                      $res = mysqli_query($db,$sql) or die('error 62');
                      if(mysqli_num_rows($res) != 0)
                      {
                      while($row = mysqli_fetch_assoc($res))
                      {
                      ?>
                      <li class="nav-item">
                        <a class="hovered" href="<?php echo $row['file']; ?>" style="color:black;" target="_blank">
                          <i class="fa fa-certificate" aria-hidden="true"></i>
                          <span><?php echo $row['nomor']; ?> - <?php echo $row['nama']; ?></span>
                        </a>
                      </li>
                      <?php 
                        }
                      }                      
                      ?>
                    </ul>
                  </div>
                </div>
              </div>
            </section>
          </div>
        </div>
        <!-- end: page -->
      </section>
      <?php  
      }
      ?>
    </div>
  </section>
  <?php include 'template/scripts.php'; ?>
</body>

</html>