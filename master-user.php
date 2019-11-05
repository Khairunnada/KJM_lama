<?php include 'template/kerangkaAtas.php'; ?>
<?php
if(isset($_GET['refresh']))
{
  unset($_SESSION['tombol_filter_'.$id_nav_detail]);
  unset($_SESSION['id_'.$id_nav_detail]);
  unset($_SESSION['nama_'.$id_nav_detail]);
  unset($_SESSION['username_'.$id_nav_detail]);
  unset($_SESSION['id_lokasi_'.$id_nav_detail]);
  unset($_SESSION['id_departemen_'.$id_nav_detail]);
  unset($_SESSION['id_jabatan_'.$id_nav_detail]);
  unset($_SESSION['aktif_'.$id_nav_detail]);
  unset($_SESSION['created_at_'.$id_nav_detail]);
  unset($_SESSION['updated_at_'.$id_nav_detail]);
  navigasi_ke('?id_nav_detail='.$id_nav_detail.'&daftar');
}
if(isset($_GET['pdf']))
{
  navigasi_ke('master-user-pdf.php');
}
if(isset($_GET['excel']))
{
  navigasi_ke('master-user-excel.php');
}
if(isset($_POST['tombol_tambah']))
{
  $nama = fch($_POST['nama']);
  $username = fch($_POST['username']);
  $password = fch($_POST['password']);
  $id_lokasi = fch($_POST['id_lokasi']);
  $id_departemen = fch($_POST['id_departemen']);
  $id_jabatan = fch($_POST['id_jabatan']);
  $aktif = fch($_POST['aktif']);
  $sql = 
  "INSERT INTO
    tb_master_user
  VALUES
  (
    default,
    '".$nama."',
    '".$username."',
    sha1(md5('".$password ."')),
    '".$id_lokasi."',
    '".$id_departemen."',
    '".$id_jabatan."',
    '".$aktif."',
    '".$id_user."',
    NOW(),
    NOW()
  )";
  mysqli_query($db,$sql) OR die('error 51');
  $id = mysqli_insert_id($db); 
  $sql =
  "INSERT INTO
    tb_log
  VALUES
  (
    default,
    'tb_master_user',
    '".$id."',
    'insert',
    '".$id_user."',      
    NOW(),
    NOW()
  )";
  mysqli_query($db,$sql) OR die('error 66');
  navigasi_ke('?id_nav_detail='.$id_nav_detail.'&daftar&id='.$id.'&sukses_tambah');
}
if(isset($_POST['tombol_ubah']))
{
  $id = fch($_POST['id']);
  $nama = fch($_POST['nama']);
  $username = fch($_POST['username']);
  $id_lokasi = fch($_POST['id_lokasi']);
  $id_departemen = fch($_POST['id_departemen']);
  $id_jabatan = fch($_POST['id_jabatan']);
  $aktif = fch($_POST['aktif']);
  $sql =
  "UPDATE
    tb_master_user AS a
  SET
    a.nama = '".$nama."',
    a.username = '".$username."',
    a.id_lokasi = '".$id_lokasi."',
    a.id_departemen = '".$id_departemen."',
    a.id_jabatan = '".$id_jabatan."',
    a.aktif = '".$aktif."',
    a.updated_at = NOW()
  WHERE
    a.id = '".$id."'";
  mysqli_query($db,$sql) OR die('error 90');
  $sql =
  "INSERT INTO
    tb_log
  VALUES
  (
    default,
    'tb_master_user',
    '".$id."',
    'update',
    '".$id_user."',      
    NOW(),
    NOW()
  )";
  mysqli_query($db,$sql) OR die('error 104');
  navigasi_ke('?id_nav_detail='.$id_nav_detail.'&daftar&id='.$id.'&sukses_ubah');
}
if(isset($_POST['tombol_hapus']))
{
  $id = fch($_POST['id']);
  $sql=
  "SELECT
    *
  FROM
    tb_master_user_detail AS a
  WHERE
    a.id = '".$id."'";
  $res = mysqli_query($db,$sql) OR die(alert_php('error 118'));
  if(mysqli_num_rows($res) != 0)
  {
    while($row = mysqli_fetch_assoc($res))
    {
      $id_detail = $row['id_detail'];
      $sql2 =
      "DELETE FROM
        tb_master_user_detail
      WHERE
        id_detail = '".$row['id_detail']."'";
      mysqli_query($db,$sql2) OR die(alert_php('error 129'));
      $sql2 =
      "INSERT INTO
        tb_log
      VALUES
      (
        default,
        'tb_master_user_detail',
        '".$id_detail."',
        'delete',
        '".$id_user."',      
        NOW(),
        NOW()
      )";
      mysqli_query($db,$sql2) OR die(alert_php('error 230'));
    }
  }
  $sql =
  "DELETE FROM
    tb_master_user
  WHERE
    id = '".$id."'";
  mysqli_query($db,$sql) OR die(alert_php('error 151'));
  $sql =
  "INSERT INTO
    tb_log
  VALUES
  (
    default,
    'tb_master_user',
    '".$id."',
    'delete',
    '".$id_user."',      
    NOW(),
    NOW()
  )";
  mysqli_query($db,$sql) OR die(alert_php('error 165'));
  navigasi_ke('?id_nav_detail='.$id_nav_detail.'&daftar&id='.$id.'&sukses_hapus');
}
if(isset($_POST['tombol_update']))
{
  $id = fch($_POST['id']);  
  $sql =
  "DELETE FROM
    tb_master_user_detail
  WHERE
    id = '".$id."'";
  mysqli_query($db,$sql) OR die('error 140');
  if(isset($_POST['navigasi_detail']) AND count($_POST['navigasi_detail']) != 0)
  {
    $navigasi_detail = $_POST['navigasi_detail'];
    foreach ($navigasi_detail as $id_navigasi_detail)
    { 
      $sql =
      "SELECT
        a.id
      FROM
        tb_master_navigasi_detail AS a
      WHERE
        a.id_detail = '".$id_navigasi_detail."'";
      $res = mysqli_query($db,$sql) OR die('error 153');
      if(mysqli_num_rows($res) != 0)
      {
        while($row = mysqli_fetch_assoc($res))
        {
          $id_navigasi = $row['id'];
        }
      }  
      $sql =
      "INSERT INTO
        tb_master_user_detail
      VALUES
      (
        default,
        '".$id."',
        '".$id_navigasi."',
        '".$id_navigasi_detail."',
        1,
        NOW(),
        NOW()
      )";
      mysqli_query($db,$sql) OR die('error 174');
      $id_detail = mysqli_insert_id($db);
      $sql =
      "INSERT INTO
        tb_log
      VALUES
      (
        default,
        'tb_master_user_detail',
        '".$id_detail."',
        'insert',
        '".$id_user."',      
        NOW(),
        NOW()
      )";
      mysqli_query($db,$sql) OR die('error 189');
    }
  }  
  navigasi_ke('?id_nav_detail='.$id_nav_detail.'&detail&id='.$id.'&sukses_update');
}
?>
<div class="content-wrapper">
  <?php include 'template/content_header.php';?>
  <?php
//PAGE_DAFTAR
  if(isset($_GET['daftar']))
  {    
  ?>
  <section class="content">
    <div class="row">
      <div class="col-md-12">
        <div class="box box-primary">
          <div class="box-header with-border">
            <h3 class="box-title">Daftar User</h3>
            <div class="box-tools">
              <div class="btn-group">
                <button type="button" class="btn btn-sm btn-default btn-flat">File</button>
                <button type="button" class="btn btn-sm btn-default btn-flat dropdown-toggle" data-toggle="dropdown">
                  <span class="caret"></span>
                  <span class="sr-only">Toggle Dropdown</span>
                </button>
                <ul class="dropdown-menu" role="menu">
                  <li><a href="?id_nav_detail=<?php echo $id_nav_detail; ?>&tambah"><i class="fa fa-sm fa-file-o"></i>Tambah</a></li>
                  <li><a data-toggle="modal" href="#ModalFilter"><i class="fa fa-sm fa-search"></i> Filter</a></li>
                  <li><a href="?id_nav_detail=<?php echo $id_nav_detail; ?>&refresh&daftar"><i class="fa fa-sm fa-refresh"></i>Refresh</a></li>
                </ul>
              </div>
              <div class="btn-group">
                <button type="button" class="btn btn-sm btn-default btn-flat">Cetak</button>
                <button type="button" class="btn btn-sm btn-default btn-flat dropdown-toggle" data-toggle="dropdown">
                  <span class="caret"></span>
                  <span class="sr-only">Toggle Dropdown</span>
                </button>
                <ul class="dropdown-menu" role="menu">
                  <li><a href="?id_nav_detail=<?php echo $id_nav_detail; ?>&pdf" target="_blank"><i class="fa fa-sm fa-file-pdf-o"></i>PDF</a></li>
                  <li><a href="?id_nav_detail=<?php echo $id_nav_detail; ?>&excel" target="_blank"><i class="fa fa-sm fa-file-excel-o"></i>Excel</a></li>
                </ul>
              </div>
            </div>
          </div>
          <div class="box-body">
            <?php
            if(isset($_GET['sukses_tambah']))
            {
            ?>
            <div class="alert alert-success" style="padding:5px;">
              <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
              <div style="color:black;">Berhasil Menambah User Baru</div>
            </div>
            <?php
            }
            if(isset($_GET['sukses_ubah']))
            {
            ?>
            <div class="alert alert-success" style="padding:5px;">
              <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
              <div style="color:black;">Berhasil Mengubah User</div>
            </div>
            <?php
            }
            if(isset($_GET['sukses_hapus']))
            {
            ?>
            <div class="alert alert-success" style="padding:5px;">
              <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
              <div style="color:black;">Berhasil Menghapus User</div>
            </div>
            <?php
            }
            ?>
            <div class="table-responsive no-padding">
              <table class="table">
                <?php
                $sql =
                "SELECT
                  a.id,
                  a.nama,
                  a.username,
                  a.password,
                  b.lokasi,
                  c.departemen,
                  d.jabatan,
                  a.aktif,
                  a.created_at,
                  a.updated_at
                FROM
                  tb_master_user AS a
                LEFT JOIN
                  tb_master_lokasi AS b ON (b.id = a.id_lokasi)
                LEFT JOIN
                  tb_master_departemen AS c ON (c.id = a.id_departemen)
                LEFT JOIN
                  tb_master_jabatan AS d ON (d.id = a.id_jabatan)";
                if(isset($_POST['tombol_filter']) OR isset($_SESSION['tombol_filter_'.$id_nav_detail]))
                {
                  if(isset($_POST['tombol_filter']))
                  {
                    navigasi_ke('?id_nav_detail='.$id_nav_detail.'&daftar');
                    if($_POST['data_per_halaman'] == '') $_POST['data_per_halaman'] = 0;                  
                    $_SESSION['tombol_filter_'.$id_nav_detail] = $_POST['tombol_filter'];
                    $_SESSION['id_'.$id_nav_detail] = $_POST['id'];
                    $_SESSION['nama_'.$id_nav_detail] = $_POST['nama'];
                    $_SESSION['username_'.$id_nav_detail] = $_POST['username'];
                    $_SESSION['id_lokasi_'.$id_nav_detail] = $_POST['id_lokasi'];
                    $_SESSION['id_departemen_'.$id_nav_detail] = $_POST['id_departemen'];
                    $_SESSION['id_jabatan_'.$id_nav_detail] = $_POST['id_jabatan'];
                    $_SESSION['aktif_'.$id_nav_detail] = $_POST['aktif'];
                    $_SESSION['created_at_'.$id_nav_detail] = $_POST['created_at'];
                    $_SESSION['updated_at_'.$id_nav_detail] = $_POST['updated_at'];
                    $_SESSION['data_per_halaman_'.$id_nav_detail] = $_POST['data_per_halaman'];
                    $id = $_POST['id'];
                    $nama = $_POST['nama'];        
                    $username = $_POST['username'];
                    $id_lokasi = $_POST['id_lokasi'];
                    $id_departemen = $_POST['id_departemen'];
                    $id_jabatan = $_POST['id_jabatan'];
                    $aktif = $_POST['aktif'];
                    $created_at = $_POST['created_at'];
                    $updated_at = $_POST['updated_at'];
                    $data_per_halaman = $_POST['data_per_halaman'];
                  }
                  else if(isset($_SESSION['tombol_filter_'.$id_nav_detail]))
                  {
                    $tombol_filter = $_SESSION['tombol_filter_'.$id_nav_detail]; 
                    $id = $_SESSION['id_'.$id_nav_detail]; 
                    $nama = $_SESSION['nama_'.$id_nav_detail];   
                    $username = $_SESSION['username_'.$id_nav_detail];  
                    $id_lokasi = $_SESSION['id_lokasi_'.$id_nav_detail]; 
                    $id_departemen = $_SESSION['id_departemen_'.$id_nav_detail]; 
                    $id_jabatan = $_SESSION['id_jabatan_'.$id_nav_detail];  
                    $aktif = $_SESSION['aktif_'.$id_nav_detail];
                    $created_at = $_SESSION['created_at_'.$id_nav_detail];
                    $updated_at = $_SESSION['updated_at_'.$id_nav_detail];
                    $data_per_halaman = $_SESSION['data_per_halaman_'.$id_nav_detail];
                  } 
                  $sql .= " WHERE a.nama LIKE '%".$nama."%'";
                  $sql .= " AND a.username LIKE '%".$username."%'";
                  if($id_lokasi != '')
                  {
                    $sql .= " AND a.id_lokasi = '".$id_lokasi."'";
                  }
                  if($id_departemen != '')
                  {
                    $sql .= " AND a.id_departemen = '".$id_departemen."'";
                  }
                  if($id_jabatan != '')
                  {
                    $sql .= " AND a.id_jabatan = '".$id_jabatan."'";
                  }
                }
                else
                {
                  $data_per_halaman = 15;
                }
                if(isset($_GET['sort_by']))
                {
                  if($_GET['sort_by'] == 'id')
                  { 
                    $sql .= " ORDER BY a.id ".$_GET['order']."";
                  }
                  if($_GET['sort_by'] == 'nama')
                  { 
                    $sql .= " ORDER BY a.nama ".$_GET['order']."";
                  }  
                  if($_GET['sort_by'] == 'username')
                  { 
                    $sql .= " ORDER BY a.username ".$_GET['order']."";
                  } 
                  if($_GET['sort_by'] == 'lokasi')
                  { 
                    $sql .= " ORDER BY b.lokasi ".$_GET['order']."";
                  }  
                  if($_GET['sort_by'] == 'departemen')
                  { 
                    $sql .= " ORDER BY c.departemen ".$_GET['order']."";
                  }
                  if($_GET['sort_by'] == 'jabatan')
                  { 
                    $sql .= " ORDER BY d.jabatan ".$_GET['order']."";
                  }
                  if($_GET['sort_by'] == 'aktif')
                  { 
                    $sql .= " ORDER BY a.aktif ".$_GET['order']."";
                  }
                  if($_GET['sort_by'] == 'created_at')
                  { 
                    $sql .= " ORDER BY a.created_at ".$_GET['order']."";
                  }
                  if($_GET['sort_by'] == 'updated_at')
                  { 
                    $sql .= " ORDER BY a.updated_at ".$_GET['order']."";
                  }
                }
                else
                {
                  $sql .= " ORDER BY a.nama";
                }             
                $page = isset($_GET["page"]) ? (int)$_GET["page"] : 1;
                $mulai = ($page > 1) ? ($page * $data_per_halaman) - $data_per_halaman : 0;
                $result = mysqli_query($db,$sql) OR die('error 401');
                $total = mysqli_num_rows($result);              
                if($data_per_halaman!=0)
                {
                  $pages = ceil($total / $data_per_halaman);
                  $sql .= " LIMIT ".$mulai.",".$data_per_halaman."";
                }
                else
                {
                  $pages = 0;
                }
                $res = mysqli_query($db,$sql) OR die('error 412');
                $nomor = $mulai + 1;
                $sort_by = '';
                if(isset($_GET['sort_by']) AND isset($_GET['order']))
                {
                  $sort_by='&sort_by='.$_GET['sort_by'].'&order='.$_GET['order'];
                }
                $reload = $_SERVER['PHP_SELF'] . "?id_nav_detail=".$id_nav_detail."&daftar".$sort_by;
                if($total == 0)
                {
                ?>
                <thead>
                  <tr>
                    <td colspan="12">Tidak Ada Data Ditemukan</td>
                  </tr>
                </thead>
                <?php
                } 
                else
                {
                ?>
                <thead>
                  <tr>
                    <th>No.</th>
                    <th>ID <a <?php if(isset($_GET['sort_by']) AND $_GET['sort_by']=='id' AND $_GET['order']=='desc') echo 'style="color:red;"'; else echo 'style="color:black;"';?> href="?id_nav_detail=<?php echo $id_nav_detail; ?>&page=<?php echo $page; ?>&daftar&sort_by=id&order=desc"><i class="fa fa-sort-up fa-lg"></i></a><a <?php if(isset($_GET['sort_by']) AND $_GET['sort_by']=='id' AND $_GET['order']=='asc') echo 'style="color:red;"'; else echo 'style="color:black;"';?> href="?id_nav_detail=<?php echo $id_nav_detail; ?>&page=<?php echo $page; ?>&daftar&sort_by=id&order=asc"><i class="fa fa-sort-down fa-lg"></i></a></th>
                    <th>Nama <a <?php if(isset($_GET['sort_by']) AND $_GET['sort_by']=='nama' AND $_GET['order']=='desc') echo 'style="color:red;"'; else echo 'style="color:black;"';?> href="?id_nav_detail=<?php echo $id_nav_detail; ?>&page=<?php echo $page; ?>&daftar&sort_by=nama&order=desc"><i class="fa fa-sort-up fa-lg"></i></a><a <?php if(isset($_GET['sort_by']) AND $_GET['sort_by']=='nama' AND $_GET['order']=='asc') echo 'style="color:red;"'; else echo 'style="color:black;"';?> href="?id_nav_detail=<?php echo $id_nav_detail; ?>&page=<?php echo $page; ?>&daftar&sort_by=nama&order=asc"><i class="fa fa-sort-down fa-lg"></i></a></th>
                    <th>Username <a <?php if(isset($_GET['sort_by']) AND $_GET['sort_by']=='username' AND $_GET['order']=='desc') echo 'style="color:red;"'; else echo 'style="color:black;"';?> href="?id_nav_detail=<?php echo $id_nav_detail; ?>&page=<?php echo $page; ?>&daftar&sort_by=username&order=desc"><i class="fa fa-sort-up fa-lg"></i></a><a <?php if(isset($_GET['sort_by']) AND $_GET['sort_by']=='username' AND $_GET['order']=='asc') echo 'style="color:red;"'; else echo 'style="color:black;"';?> href="?id_nav_detail=<?php echo $id_nav_detail; ?>&page=<?php echo $page; ?>&daftar&sort_by=username&order=asc"><i class="fa fa-sort-down fa-lg"></i></a></th>
                    <th>Password</th>
                    <th>Lokasi <a <?php if(isset($_GET['sort_by']) AND $_GET['sort_by']=='lokasi' AND $_GET['order']=='desc') echo 'style="color:red;"'; else echo 'style="color:black;"';?> href="?id_nav_detail=<?php echo $id_nav_detail; ?>&page=<?php echo $page; ?>&daftar&sort_by=lokasi&order=desc"><i class="fa fa-sort-up fa-lg"></i></a><a <?php if(isset($_GET['sort_by']) AND $_GET['sort_by']=='lokasi' AND $_GET['order']=='asc') echo 'style="color:red;"'; else echo 'style="color:black;"';?> href="?id_nav_detail=<?php echo $id_nav_detail; ?>&page=<?php echo $page; ?>&daftar&sort_by=lokasi&order=asc"><i class="fa fa-sort-down fa-lg"></i></a></th>
                    <th>Departemen <a <?php if(isset($_GET['sort_by']) AND $_GET['sort_by']=='departemen' AND $_GET['order']=='desc') echo 'style="color:red;"'; else echo 'style="color:black;"';?> href="?id_nav_detail=<?php echo $id_nav_detail; ?>&page=<?php echo $page; ?>&daftar&sort_by=departemen&order=desc"><i class="fa fa-sort-up fa-lg"></i></a><a <?php if(isset($_GET['sort_by']) AND $_GET['sort_by']=='departemen' AND $_GET['order']=='asc') echo 'style="color:red;"'; else echo 'style="color:black;"';?> href="?id_nav_detail=<?php echo $id_nav_detail; ?>&page=<?php echo $page; ?>&daftar&sort_by=departemen&order=asc"><i class="fa fa-sort-down fa-lg"></i></a></th>
                    <th>Jabatan <a <?php if(isset($_GET['sort_by']) AND $_GET['sort_by']=='jabatan' AND $_GET['order']=='desc') echo 'style="color:red;"'; else echo 'style="color:black;"';?> href="?id_nav_detail=<?php echo $id_nav_detail; ?>&page=<?php echo $page; ?>&daftar&sort_by=jabatan&order=desc"><i class="fa fa-sort-up fa-lg"></i></a><a <?php if(isset($_GET['sort_by']) AND $_GET['sort_by']=='jabatan' AND $_GET['order']=='asc') echo 'style="color:red;"'; else echo 'style="color:black;"';?> href="?id_nav_detail=<?php echo $id_nav_detail; ?>&page=<?php echo $page; ?>&daftar&sort_by=jabatan&order=asc"><i class="fa fa-sort-down fa-lg"></i></a></th>
                    <th>Status <a <?php if(isset($_GET['sort_by']) AND $_GET['sort_by']=='aktif' AND $_GET['order']=='desc') echo 'style="color:red;"'; else echo 'style="color:black;"';?> href="?id_nav_detail=<?php echo $id_nav_detail; ?>&page=<?php echo $page; ?>&daftar&sort_by=aktif&order=desc"><i class="fa fa-sort-up fa-lg"></i></a><a <?php if(isset($_GET['sort_by']) AND $_GET['sort_by']=='aktif' AND $_GET['order']=='asc') echo 'style="color:red;"'; else echo 'style="color:black;"';?> href="?id_nav_detail=<?php echo $id_nav_detail; ?>&page=<?php echo $page; ?>&daftar&sort_by=aktif&order=asc"><i class="fa fa-sort-down fa-lg"></i></a></th>
                    <th>Created At <a <?php if(isset($_GET['sort_by']) AND $_GET['sort_by']=='created_at' AND $_GET['order']=='desc') echo 'style="color:red;"'; else echo 'style="color:black;"';?> href="?id_nav_detail=<?php echo $id_nav_detail; ?>&page=<?php echo $page; ?>&daftar&sort_by=created_at&order=desc"><i class="fa fa-sort-up fa-lg"></i></a><a <?php if(isset($_GET['sort_by']) AND $_GET['sort_by']=='created_at' AND $_GET['order']=='asc') echo 'style="color:red;"'; else echo 'style="color:black;"';?> href="?id_nav_detail=<?php echo $id_nav_detail; ?>&page=<?php echo $page; ?>&daftar&sort_by=created_at&order=asc"><i class="fa fa-sort-down fa-lg"></i></a></th>
                    <th>Updated At <a <?php if(isset($_GET['sort_by']) AND $_GET['sort_by']=='updated_at' AND $_GET['order']=='desc') echo 'style="color:red;"'; else echo 'style="color:black;"';?> href="?id_nav_detail=<?php echo $id_nav_detail; ?>&page=<?php echo $page; ?>&daftar&sort_by=updated_at&order=desc"><i class="fa fa-sort-up fa-lg"></i></a><a <?php if(isset($_GET['sort_by']) AND $_GET['sort_by']=='updated_at' AND $_GET['order']=='asc') echo 'style="color:red;"'; else echo 'style="color:black;"';?> href="?id_nav_detail=<?php echo $id_nav_detail; ?>&page=<?php echo $page; ?>&daftar&sort_by=updated_at&order=asc"><i class="fa fa-sort-down fa-lg"></i></a></th>
                    <th colspan="3">Aksi</th>
                  </tr>
                </thead>
                <tbody>
                  <?php      
                  while($row = mysqli_fetch_assoc($res))
                  {
                    if($row['aktif'] == 1)
                    {
                      $status='Aktif';
                      $label='success';
                    }
                    else 
                    {
                      $status='Non Aktif';
                      $label='danger';
                    }
                    ?>
                  <tr style="<?php if(isset($_GET['id']) AND $row['id']==$_GET['id']) echo 'background-color:'.$warna_blok; else if ($nomor % 2 == 0) { echo $background_ganjil; } else { echo $background_genap; }?>" class="tr-hover">
                    <td><?php echo $nomor++; ?></td>
                    <td><?php echo $row['id']; ?></td>
                    <td><?php echo $row['nama']; ?></td>
                    <td><?php echo $row['username']; ?></td>
                    <td><?php echo $row['password']; ?></td>
                    <td><?php echo $row['lokasi']; ?></td>
                    <td><?php echo $row['departemen']; ?></td>
                    <td><?php echo $row['jabatan']; ?></td>
                    <td><span class=" label label-<?php echo $label; ?>"><?php echo $status; ?></span></td>
                    <td><?php echo date('d-M-Y H:i:s',strtotime($row['created_at'])); ?></td>
                    <td><?php echo date('d-M-Y H:i:s',strtotime($row['updated_at'])); ?></td>
                    <td><a class="fa fa-lg fa-folder-open" style="cursor: pointer;color:orange;text-decoration: none;" href="?id_nav_detail=<?php echo $id_nav_detail; ?>&page=<?php echo $page; ?>&detail&id=<?php echo $row['id']; ?>"></a></td>
                    <td><a class="fa fa-lg fa-pencil" style="cursor: pointer;color:darkblue;text-decoration: none;" href="?id_nav_detail=<?php echo $id_nav_detail; ?>&page=<?php echo $page; ?>&ubah&id=<?php echo $row['id']; ?>"></a></td>
                    <td><a class="fa fa-lg fa-trash-o " style="cursor: pointer;color:red;text-decoration: none;" href="?id_nav_detail=<?php echo $id_nav_detail; ?>&page=<?php echo $page; ?>&hapus&id=<?php echo $row['id']; ?>"></a></td>
                  </tr>
                  <?php
                  }
                  ?>
                </tbody>
                <?php 
                }
                ?>
              </table>
            </div>
            <div class="box-tools" style="text-align:center;">
              <?php
              if($total != 0 AND $pages != 0)
              {
                echo paginate_two($reload, $page, $pages,3);
              }
              ?>
            </div>
          </div>
          <div class="box-footer">
            <?php
            $sql=
            "SELECT
              a.tabel,
              a.aksi,
              a.id_tabel,              
              b.nama,
              a.created_at
            FROM
              tb_log AS a
            LEFT JOIN
              tb_master_user AS b ON (b.id = a.id_user)
            WHERE
              a.tabel = 'tb_master_user'"; 
            $sql.=" ORDER BY a.created_at DESC LIMIT 1";
            $res=mysqli_query($db,$sql) OR die('error 514');
            if(mysqli_num_rows($res)!=0)
            {
              while($row=mysqli_fetch_assoc($res))
              {
              ?>
            <small>Aksi Terakhir : <?php echo strtoupper($row['aksi']); ?> ID=<?php echo strtoupper($row['id_tabel']); ?> , pada tanggal <?php echo date("d M Y", strtotime($row['created_at'])); ?> , pukul <?php echo date("H:i:s", strtotime($row['created_at'])); ?> , oleh <?php echo ucwords($row['nama']); ?></small>
            <?php 
              }
            }
            ?>
          </div>
        </div>
      </div>
    </div>
  </section>
  <?php 
  } 
//PAGE_DAFTAR

//PAGE_DETAIL
  if(isset($_GET['detail']))
  {    
    $id = fch($_GET['id']);
    $sql = 
    "SELECT
      a.nama,
      b.lokasi,
      c.departemen,
      d.jabatan
    FROM
      tb_master_user AS a
    LEFT JOIN
      tb_master_lokasi AS b ON (b.id = a.id_lokasi)
    LEFT JOIN
      tb_master_departemen AS c ON (c.id = a.id_departemen)
    LEFT JOIN
      tb_master_jabatan AS d ON (d.id = a.id_jabatan)
    WHERE
      a.id = '".$id."'";
    $res = mysqli_query($db,$sql) OR die('error 554');
    if(mysqli_num_rows($res) != 0)
    {
      while($row = mysqli_fetch_assoc($res))
      {
        $nama = $row['nama'];
        $lokasi = $row['lokasi'];
        $departemen = $row['departemen'];
        $jabatan = $row['jabatan'];
      }
    }    
  ?>
  <section class="content">
    <div class="row">
      <div class="col-md-6">
        <div class="box box-primary">
          <div class="box-header with-border">
            <h3 class="box-title">Informasi User</h3>
          </div>
          <div class="box-body">
            <div class="row">
              <div class="col-md-3">
                <div class="form-group">
                  <label for="nama">Nama :</label>
                  <br>
                  <?php echo $nama; ?>
                </div>
              </div>
              <div class="col-md-3">
                <div class="form-group">
                  <label for="nama">Lokasi :</label>
                  <br>
                  <?php echo $lokasi; ?>
                </div>
              </div>
              <div class="col-md-3">
                <div class="form-group">
                  <label for="nama">Departemen :</label>
                  <br>
                  <?php echo $departemen; ?>
                </div>
              </div>
              <div class="col-md-3">
                <div class="form-group">
                  <label for="nama">Jabatan :</label>
                  <br>
                  <?php echo $jabatan; ?>
                </div>
              </div>
            </div>
          </div>
          <div class="box-footer"></div>
        </div>
      </div>
      <div class="col-md-6">
        <div class="box box-primary">
          <div class="box-header with-border">
            <h3 class="box-title">Pengaturan Navigasi</h3>
          </div>
          <form method="POST">
            <div class="box-body">
              <?php
              if(isset($_GET['sukses_update']))
              {
              ?>
              <div class="alert alert-success" style="padding:5px;">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                <div style="color:black;">Berhasil Mengubah Navigasi User</div>
              </div>
              <?php
              }
              ?>
              <div class="table-responsive no-padding">
                <table class="table">
                  <thead>
                    <tr>
                      <th>Navigasi</th>
                      <th>Status</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php
                    $sql =
                    "SELECT
                      a.id,
                      a.nama
                    FROM
                      tb_master_navigasi AS a";
                    $res = mysqli_query($db,$sql) OR die('error 642');
                    if(mysqli_num_rows($res) != 0)
                    {
                      while($row = mysqli_fetch_assoc($res))
                      {
                      ?>
                    <tr>
                      <td><i class="fa fa-sm fa-tags"></i> <?php echo $row['nama']; ?></td>
                    </tr>
                    <?php
                        $sql2 =
                        "SELECT
                          a.id_detail,
                          a.nama
                        FROM
                          tb_master_navigasi_detail AS a
                        WHERE
                          a.id = '".$row['id']."'";
                        $res2 = mysqli_query($db,$sql2) OR die('error 660');
                        if(mysqli_num_rows($res2) != 0)
                        {
                          while($row2 = mysqli_fetch_assoc($res2))
                          {
                            $sql3 =
                            "SELECT
                              a.id_detail
                            FROM
                              tb_master_user_detail AS a
                            WHERE
                              a.id = '".$id."' AND
                              a.id_navigasi_detail = '".$row2['id_detail']."'";
                            $res3 = mysqli_query($db,$sql3) OR die('error 673');
                            if(mysqli_num_rows($res3) != 0)
                              $checked = 1;
                            else  
                              $checked = 0;
                          ?>
                    <tr>
                      <td style="padding-left:1cm;"><i class="fa fa-sm fa-tag"></i> <?php echo $row2['nama']; ?></td>
                      <td><input name="navigasi_detail[]" type="checkbox" <?php if($checked == 1) echo 'checked';?> value="<?php echo $row2['id_detail']; ?>" class="flat-red"></td>
                    </tr>
                    <?php
                          }
                        }
                      }
                    }
                    ?>
                  </tbody>
                </table>
              </div>
            </div>
            <div class="box-footer">
              <input type="hidden" name="id" value="<?php echo $id; ?>">
              <button type="submit" name="tombol_update" class="btn btn-flat btn-sm btn-success"><i class="fa fa-sm fa-save"></i> Simpan</button>
              <a href="?id_nav_detail=<?php echo $id_nav_detail; ?>&page=<?php echo $page; ?>&daftar&id=<?php echo $id; ?>" class="btn btn-flat btn-sm btn-danger"><i class="fa fa-sm fa-reply"></i> Kembali</a>
            </div>
          </form>
        </div>
      </div>
    </div>
  </section>
  <?php 
  } 
//PAGE_DETAIL

//PAGE_TAMBAH
  if(isset($_GET['tambah']))
  {
  ?>
  <section class="content">
    <div class="row">
      <div class="col-md-12">
        <div class="box box-primary">
          <div class="box-header with-border">
            <h3 class="box-title">Tambah User</h3>
          </div>
          <form role="form" method="POST">
            <div class="box-body">
              <div class="row">
                <div class="col-md-2">
                  <div class="form-group">
                    <label for="nama">Nama :</label>
                    <input autofocus type="text" name="nama" id="nama" class="form-control" autocomplete="off" required>
                  </div>
                </div>
                <div class="col-md-2">
                  <div class="form-group">
                    <label for="username">Username :</label>
                    <input type="text" name="username" id="username" class="form-control" autocomplete="off" required>
                  </div>
                </div>
                <div class="col-md-2">
                  <div class="form-group">
                    <label for="password">Password :</label>
                    <input type="text" name="password" id="password" class="form-control" autocomplete="off" required>
                  </div>
                </div>
                <div class="col-md-2">
                  <div class="form-group">
                    <label for="id_lokasi">Lokasi :</label>
                    <select id="id_lokasi" name="id_lokasi" class="form-control select2" style="width: 100%;" required>
                      <option value="">Pilih..</option>
                      <?php
                      $sql = 
                      "SELECT
                        a.id,
                        a.lokasi
                      FROM
                        tb_master_lokasi AS a
                      WHERE
                        a.aktif = 1";
                      $res = mysqli_query($db,$sql) OR die('error 754');
                      if(mysqli_num_rows($res))
                      {
                        while($row = mysqli_fetch_assoc($res))
                        {
                        ?>
                      <option value="<?php echo $row['id']; ?>"><?php echo $row['lokasi']; ?></option>
                      <?php
                        }
                      }
                      ?>
                    </select>
                  </div>
                </div>
                <div class="col-md-2">
                  <div class="form-group">
                    <label for="id_departemen">Departemen :</label>
                    <select id="id_departemen" name="id_departemen" class="form-control select2" style="width: 100%;" required>
                      <option value="">Pilih..</option>
                      <?php
                      $sql = 
                      "SELECT
                        a.id,
                        a.departemen
                      FROM
                        tb_master_departemen AS a
                      WHERE
                        a.aktif = 1";
                      $res = mysqli_query($db,$sql) OR die('error 782');
                      if(mysqli_num_rows($res))
                      {
                        while($row = mysqli_fetch_assoc($res))
                        {
                        ?>
                      <option value="<?php echo $row['id']; ?>"><?php echo $row['departemen']; ?></option>
                      <?php
                        }
                      }
                      ?>
                    </select>
                  </div>
                </div>
                <div class="col-md-2">
                  <div class="form-group">
                    <label for="id_jabatan">Jabatan :</label>
                    <select id="id_jabatan" name="id_jabatan" class="form-control select2" style="width: 100%;" required>
                      <option value="">Pilih..</option>
                      <?php
                      $sql = 
                      "SELECT
                        a.id,
                        a.jabatan
                      FROM
                        tb_master_jabatan AS a
                      WHERE
                        a.aktif = 1";
                      $res = mysqli_query($db,$sql) OR die('error 810');
                      if(mysqli_num_rows($res))
                      {
                        while($row = mysqli_fetch_assoc($res))
                        {
                        ?>
                      <option value="<?php echo $row['id']; ?>"><?php echo $row['jabatan']; ?></option>
                      <?php
                        }
                      }
                      ?>
                    </select>
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-md-2">
                  <div class="form-group">
                    <label for="aktif">Status :</label>
                    <select id="aktif" name="aktif" class="form-control select2" style="width: 100%;" required>
                      <option value="">Pilih..</option>
                      <option value="1">Aktif</option>
                      <option value="0">Non Aktif</option>
                    </select>
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-md-2">
                  <button type="submit" name="tombol_tambah" class="btn btn-sm btn-flat btn-success"><i class="fa fa-sm fa-save"></i> Simpan</button>
                  <a href="?id_nav_detail=<?php echo $id_nav_detail; ?>&daftar"><button type="button" class="btn btn-sm btn-flat btn-danger "><i class="fa fa-sm fa-times"></i> Batal</button></a>
                </div>
              </div>
            </div>
            <div class="box-footer"></div>
          </form>
        </div>
      </div>
    </div>
  </section>
  <?php 
  }
//PAGE_TAMBAH

//PAGE_UBAH
  if(isset($_GET['ubah']))
  {
    $id = fch($_GET['id']);
    $sql =
    "SELECT
      a.nama,
      a.username,
      a.password,
      a.id_lokasi,
      a.id_departemen,
      a.id_jabatan,
      a.aktif
    FROM
      tb_master_user AS a
    WHERE
      a.id = '".$id."'";
    $res = mysqli_query($db,$sql) OR die('error 871');
    if(mysqli_num_rows($res) != 0)
    {
      while($row = mysqli_fetch_assoc($res))
      {
        $nama = $row['nama'];
        $username = $row['username'];
        $password = $row['password'];
        $id_lokasi = $row['id_lokasi'];
        $id_departemen = $row['id_departemen'];
        $id_jabatan = $row['id_jabatan'];
        $aktif = $row['aktif'];        
      }
    }
  ?>
  <section class="content">
    <div class="row">
      <div class="col-md-12">
        <div class="box box-primary">
          <div class="box-header with-border">
            <h3 class="box-title">Ubah User</h3>
          </div>
          <form role="form" method="POST">
            <div class="box-body">
              <div class="row">
                <div class="col-md-2">
                  <div class="form-group">
                    <label for="nama">Nama :</label>
                    <input type="text" name="nama" id="nama" class="form-control" autocomplete="off" value="<?php echo $nama; ?>" required>
                  </div>
                </div>
                <div class="col-md-2">
                  <div class="form-group">
                    <label for="username">Username :</label>
                    <input type="text" name="username" id="username" class="form-control" autocomplete="off" value="<?php echo $username; ?>" required>
                  </div>
                </div>
                <div class="col-md-2">
                  <div class="form-group">
                    <label for="password">Password :</label>
                    <input readonly type="text" name="password" id="password" class="form-control" autocomplete="off" value="<?php echo $password; ?>" required>
                  </div>
                </div>
                <div class="col-md-2">
                  <div class="form-group">
                    <label for="id_lokasi">Lokasi :</label>
                    <select id="id_lokasi" name="id_lokasi" class="form-control select2" style="width: 100%;" required>
                      <?php
                      $sql = 
                      "SELECT
                        a.id,
                        a.lokasi
                      FROM
                        tb_master_lokasi AS a
                      WHERE
                        a.aktif = 1";
                      $res = mysqli_query($db,$sql) OR die('error 927');
                      if(mysqli_num_rows($res))
                      {
                        while($row = mysqli_fetch_assoc($res))
                        {
                        ?>
                      <option value="<?php echo $row['id']; ?>" <?php if($row['id'] == $id_lokasi) echo 'selected'; ?><><?php echo $row['lokasi']; ?></option>
                      <?php
                        }
                      }
                      ?>
                    </select>
                  </div>
                </div>
                <div class="col-md-2">
                  <div class="form-group">
                    <label for="id_departemen">Departemen :</label>
                    <select id="id_departemen" name="id_departemen" class="form-control select2" style="width: 100%;" required>
                      <?php
                      $sql = 
                      "SELECT
                        a.id,
                        a.departemen
                      FROM
                        tb_master_departemen AS a
                      WHERE
                        a.aktif = 1";
                      $res = mysqli_query($db,$sql) OR die('error 954');
                      if(mysqli_num_rows($res))
                      {
                        while($row = mysqli_fetch_assoc($res))
                        {
                        ?>
                      <option value="<?php echo $row['id']; ?>" <?php if($row['id'] == $id_departemen) echo 'selected'; ?>><?php echo $row['departemen']; ?></option>
                      <?php
                        }
                      }
                      ?>
                    </select>
                  </div>
                </div>
                <div class="col-md-2">
                  <div class="form-group">
                    <label for="id_jabatan">Jabatan :</label>
                    <select id="id_jabatan" name="id_jabatan" class="form-control select2" style="width: 100%;" required>
                      <?php
                      $sql = 
                      "SELECT
                        a.id,
                        a.jabatan
                      FROM
                        tb_master_jabatan AS a
                      WHERE
                        a.aktif = 1";
                      $res = mysqli_query($db,$sql) OR die('error 981');
                      if(mysqli_num_rows($res))
                      {
                        while($row = mysqli_fetch_assoc($res))
                        {
                        ?>
                      <option value="<?php echo $row['id']; ?>" <?php if($row['id'] == $id_jabatan) echo 'selected'; ?>><?php echo $row['jabatan']; ?></option>
                      <?php
                        }
                      }
                      ?>
                    </select>
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-md-2">
                  <div class="form-group">
                    <label for="aktif">Status :</label>
                    <select id="aktif" name="aktif" class="form-control select2" style="width: 100%;" required>
                      <option value="1" <?php if($aktif == 1) echo 'selected'; ?>>Aktif</option>
                      <option value="0" <?php if($aktif == 0) echo 'selected'; ?>>Non Aktif</option>
                    </select>
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-md-2">
                  <input type="hidden" name="id" value="<?php echo $id; ?>">
                  <button type="submit" name="tombol_ubah" class="btn btn-sm btn-flat btn-success"><i class="fa fa-sm fa-save"></i> Simpan</button>
                  <a href="?id_nav_detail=<?php echo $id_nav_detail; ?>&page=<?php echo $page; ?>&daftar&id=<?php echo $id; ?>"><button type="button" class="btn btn-sm btn-flat btn-danger "><i class="fa fa-sm fa-times"></i> Batal</button></a>
                </div>
              </div>
            </div>
            <div class="box-footer"></div>
          </form>
        </div>
      </div>
    </div>
  </section>
  <?php 
  }
//PAGE_UBAH

//PAGE_HAPUS
  if(isset($_GET['hapus']))
  {
    $id = fch($_GET['id']);
    $sql =
    "SELECT
      a.nama,
      a.username,
      a.password,
      a.id_lokasi,
      a.id_departemen,
      a.id_jabatan,
      a.aktif
    FROM
      tb_master_user AS a
    WHERE
      a.id = '".$id."'";
    $res = mysqli_query($db,$sql) OR die('error 439');
    if(mysqli_num_rows($res) != 0)
    {
      while($row = mysqli_fetch_assoc($res))
      {
        $nama = $row['nama'];
        $username = $row['username'];
        $password = $row['password'];
        $id_lokasi = $row['id_lokasi'];
        $id_departemen = $row['id_departemen'];
        $id_jabatan = $row['id_jabatan'];
        $aktif = $row['aktif'];        
      }
    }
  ?>
  <section class="content">
    <div class="row">
      <div class="col-md-12">
        <div class="box box-primary">
          <div class="box-header with-border">
            <h3 class="box-title">Hapus User</h3>
          </div>
          <form role="form" method="POST">
            <div class="box-body">
              <div class="row">
                <div class="col-md-12">
                  <label>Anda Yakin Ingin Menghapus User : <b><?php echo $nama; ?></b> ?</label>
                </div>
              </div>
              <div class="row">
                <div class="col-md-2">
                  <input type="hidden" name="id" value="<?php echo $id; ?>">
                  <button type="submit" name="tombol_hapus" class="btn btn-sm btn-flat btn-success"><i class="fa fa-sm fa-check"></i> Ya</button>
                  <a href="?id_nav_detail=<?php echo $id_nav_detail; ?>&page=<?php echo $page; ?>&daftar&id=<?php echo $id; ?>"><button type="button" class="btn btn-sm btn-flat btn-danger "><i class="fa fa-sm fa-times"></i> Batal</button></a>
                </div>
              </div>
            </div>
            <div class="box-footer"></div>
          </form>
        </div>
      </div>
    </div>
  </section>
  <?php 
  }
//PAGE_HAPUS
  ?>
  <!-- modal -->
  <div class="modal fade" id="ModalFilter">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span></button>
          <h4 class="modal-title">Filter Data</h4>
        </div>
        <form method="POST">
          <div class="modal-body">
            <div class="row">
              <div class="col-md-3">
                <div class="form-group">
                  <label>Nama : </label>
                  <input type="text" name="nama" class="form-control">
                </div>
              </div>
              <div class="col-md-3">
                <div class="form-group">
                  <label>Username : </label>
                  <input type="text" name="username" class="form-control">
                </div>
              </div>
              <div class="col-md-3">
                <div class="form-group">
                  <label>Lokasi : </label>
                  <select name="id_lokasi" class="form-control select2" style="width: 100%;">
                    <option value="">Semua</option>
                    <?php
                    $sql =
                    "SELECT
                      a.id,
                      a.lokasi
                    FROM
                      tb_master_lokasi AS a
                    WHERE
                      a.aktif = 1";
                    $sql .= " ORDER BY a.lokasi";
                    $res = mysqli_query($db,$sql) OR die('error 806');
                    if(mysqli_num_rows($res) != 0)
                    {
                      while($row = mysqli_fetch_assoc($res))
                      {
                      ?>
                    <option value="<?php echo $row['id']; ?>"><?php echo $row['lokasi']; ?></option>
                    <?php
                      }
                    }
                    ?>
                  </select>
                </div>
              </div>
              <div class="col-md-3">
                <div class="form-group">
                  <label>Departemen : </label>
                  <select name="id_departemen" class="form-control select2" style="width: 100%;">
                    <option value="">Semua</option>
                    <?php
                    $sql =
                    "SELECT
                      a.id,
                      a.departemen
                    FROM
                      tb_master_departemen AS a
                    WHERE
                      a.aktif = 1";
                    $sql .= " ORDER BY a.departemen";
                    $res = mysqli_query($db,$sql) OR die('error 835');
                    if(mysqli_num_rows($res) != 0)
                    {
                      while($row = mysqli_fetch_assoc($res))
                      {
                      ?>
                    <option value="<?php echo $row['id']; ?>"><?php echo $row['departemen']; ?></option>
                    <?php
                      }
                    }
                    ?>
                  </select>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-3">
                <div class="form-group">
                  <label>Jabatan : </label>
                  <select name="id_jabatan" class="form-control select2" style="width: 100%;">
                    <option value="">Semua</option>
                    <?php
                    $sql =
                    "SELECT
                      a.id,
                      a.jabatan
                    FROM
                      tb_master_jabatan AS a
                    WHERE
                      a.aktif = 1";
                    $sql .= " ORDER BY a.jabatan";
                    $res = mysqli_query($db,$sql) OR die('error 866');
                    if(mysqli_num_rows($res) != 0)
                    {
                      while($row = mysqli_fetch_assoc($res))
                      {
                      ?>
                    <option value="<?php echo $row['id']; ?>"><?php echo $row['jabatan']; ?></option>
                    <?php
                      }
                    }
                    ?>
                  </select>
                </div>
              </div>
              <div class="col-md-2">
                <div class="form-group">
                  <label>Data/Halaman : </label>
                  <select name="data_per_halaman" class="form-control select2" style="width: 100%;">
                    <option value="" <?php if(isset($_SESSION['data_per_halaman_pengembalian']) AND $_SESSION['data_per_halaman_pengembalian']=='') echo 'selected';?>>Semua</option>
                    <option value="15" <?php if(!isset($_SESSION['data_per_halaman_pengembalian']) OR (isset($_SESSION['data_per_halaman_pengembalian']) AND $_SESSION['data_per_halaman_pengembalian']=='15')) echo 'selected';?>>15</option>
                    <option value="25" <?php if(isset($_SESSION['data_per_halaman_pengembalian']) AND $_SESSION['data_per_halaman_pengembalian']=='25') echo 'selected';?>>25</option>
                    <option value="50" <?php if(isset($_SESSION['data_per_halaman_pengembalian']) AND $_SESSION['data_per_halaman_pengembalian']=='50') echo 'selected';?>>50</option>
                    <option value="100" <?php if(isset($_SESSION['data_per_halaman_pengembalian']) AND $_SESSION['data_per_halaman_pengembalian']=='100') echo 'selected';?>>100</option>
                    <option value="250" <?php if(isset($_SESSION['data_per_halaman_pengembalian']) AND $_SESSION['data_per_halaman_pengembalian']=='250') echo 'selected';?>>250</option>
                  </select>
                </div>
              </div>
            </div>
          </div>
          <div class="modal-footer">
            <button type="submit" name="tombol_filter" class="btn btn-sm btn-flat btn-success"><i class="fa fa-sm fa-search"></i> Filter</button>
            <button type="button" class="btn btn-sm btn-flat btn-danger" data-dismiss="modal"><i class="fa fa-sm fa-times"></i> Batal</button>
          </div>
        </form>
      </div>
    </div>
  </div>
  <!-- modal -->
</div>
<!-- /.content-wrapper -->
<?php include 'template/kerangkaBawah.php'; ?>