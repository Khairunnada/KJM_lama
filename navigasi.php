  <?php include 'template/kerangkaAtas.php'; ?>
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
    else
    {
      navigasi_ke('index.php');
    }
  }
  else
  {
    navigasi_ke('index.php');
  }
  ?>
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1><?php echo $grup; ?></h1>
      <ol class="breadcrumb">
        <li><a href="dashboard.php"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="?kode=<?php echo $kode; ?>"><?php echo $grup; ?></a></li>
        <li class="active">Navigasi</li>
      </ol>
    </section>
    <!-- Main content -->
    <section class="content">
      <!-- Default box -->
      <div class="box">
        <div class="box-header <?php echo $boxheader_border; ?>">
          <h3 class="box-title">Navigasi</h3>
          <div class="box-tools pull-right">
            <button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="Collapse">
              <i class="fa fa-minus"></i>
            </button>
          </div>
        </div>
        <div class="box-body">
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
        <!-- /.box-body -->
        <div class="box-footer"></div>
        <!-- /.box-footer-->
      </div>
      <!-- /.box -->
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
  <?php include 'template/kerangkaBawah.php'; ?>