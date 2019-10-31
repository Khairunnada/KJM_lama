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
  <div class="content-wrapper">
    <section class="content-header">
      <h1><?php echo $nama; ?></h1>
      <ol class="breadcrumb">
        <li><a href="dashboard.php"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="?kode=<?php echo $kode; ?>"><?php echo $nama; ?></a></li>
        <li class="active">Navigasi</li>
      </ol>
    </section>
    <section class="content">
      <div class="row">
        <div class="col-md-12">
          <div class="box box-primary">
            <div class="box-header with-border">
              <h3 class="box-title">Navigasi</h3>
            </div>
            <form role="form" method="POST">
              <div class="box-body">
                <ul class="nav flex-column">
                  <?php
                $sql =
                "SELECT
                  a.id_detail,
                  a.file,
                  a.ikon,
                  a.nomor,
                  a.nama,
                  a.postfix
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
                    <a class="hovered" href="<?php echo $row['file']; ?>?id_nav_detail=<?php echo $row['id_detail']; ?><?php echo $row['postfix']; ?>" style="color:black;">
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
              <div class="box-footer"></div>
            </form>
          </div>
        </div>
      </div>
    </section>
  </div>
  <?php include 'template/kerangkaBawah.php'; ?>