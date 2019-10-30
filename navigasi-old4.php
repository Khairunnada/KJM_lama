  <?php include 'template/kerangkaAtas.php'; ?>
  <?php
  if(isset($_GET['id_nav']))
  {
    $id_nav = fch($_GET['id_nav']);
    $sql = 
    "SELECT
      a.nama
    FROM
      tb_master_navigasi AS a
    WHERE
      a.id = '".$id_nav."'";
    $res = mysqli_query($db,$sql) OR die('error 13');
    if(mysqli_num_rows($res) != 0)
    {
      while($row = mysqli_fetch_assoc($res))
      {
        $nama = ucwords(strtolower($row['nama']));
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
      <h1><?php echo $nama; ?></h1>
      <ol class="breadcrumb">
        <li><a href="dashboard.php"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="?kode=<?php echo $kode; ?>"><?php echo $nama; ?></a></li>
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
            <div class="col-xs-3">
              <ul class="nav flex-column">
                <?php
                $sql =
                "SELECT
                  a.file,
                  a.ikon,
                  a.nomor,
                  a.nama
                FROM
                  tb_master_navigasi_detail AS a
                JOIN
                (
                  SELECT
                    a.id_navigasi_detail
                  FROM
                    tb_master_user_detail AS a
                  WHERE
                    a.id = '".$id_user."'
                ) ta
                ON ta.id_navigasi_detail = a.id_detail 
                WHERE
                  a.id = '".$id_nav."'";
                $sql .= " ORDER BY a.posisi";
                $res = mysqli_query($db,$sql) OR die('error 71');
                if(mysqli_num_rows($res) != 0)
                {
                  while($row = mysqli_fetch_assoc($res))
                  {
                  ?>
                <li class="nav-item">
                  <a class="hovered" href="<?php echo $row['file']; ?>" style="color:black;" target="_blank">
                    <i class="fa <?php echo $row['ikon']; ?>" aria-hidden="true"></i>
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