<?php include 'template/kerangkaAtas.php'; ?>
<?php
if(isset($_GET['refresh']))
{
  unset($_SESSION['tombol_filter_'.$id]);
  unset($_SESSION['nama_'.$id]);
  unset($_SESSION['aktif_'.$id]);
  unset($_SESSION['data_per_halaman_'.$id]);
  navigasi_ke('?id='.$id.'&daftar');
}
if(isset($_GET['pdf']))
{
  navigasi_ke('master-navigasi-pdf.php');
}
if(isset($_GET['excel']))
{
  navigasi_ke('master-navigasi-excel.php');
}
if(isset($_POST['tombol_tambah']))
{
  unset($_SESSION['tombol_filter_'.$id_nav_detail]);  
  $pemasok = fch($_POST['pemasok']);
  $alamat = fch($_POST['alamat']);
  $kota = fch($_POST['kota']);
  $telp = fch($_POST['telp']);
  $fax = fch($_POST['fax']);
  $email = fch($_POST['email']);
  $cp = fch($_POST['cp']);
  $catatan = fch($_POST['catatan']);
  $ppn = fch($_POST['ppn']);
  $pph = fch($_POST['pph']);
  $mata_uang = fch($_POST['mata_uang']);
  $nama_bank = fch($_POST['nama_bank']);
  $atas_nama = fch($_POST['atas_nama']);
  $no_rekening = fch($_POST['no_rekening']);
  $aktif = fch($_POST['aktif']);
  $created_at = fch($_POST['created_at']);
  $updated_at = fch($_POST['updated_at']);
  
  $sql =
  "SELECT
    a.id
  FROM
    tb_master_pemasok as a
  WHERE
    a.pemasok = '".$pemasok."'";
  $res = mysqli_query($db,$sql) OR die(alert_php('error 47'));
  if(mysqli_num_rows($res) != 0)
  {
    navigasi_ke('?id_nav_detail='.$id_nav_detail.'&daftar&gagal_tambah='.$pemasok);
  }
  else
  {
    $sql = 
    "INSERT INTO
      tb_master_pemasok
    VALUES
    (
      default,
      '".$pemasok."',
      '".$alamat."',
      '".$kota."',
      '".$telp."',
      '".$fax."',
      '".$email."',
      '".$cp."',
      '".$catatan."',
      '".$ppn."',
      '".$pph."',
      '".$mata_uang."',
      '".$nama_bank."',
      '".$atas_nama."',
      '".$no_rekening."',
      '".$aktif."',
      '".$created_at."',
      '".$updated_at."',
      NOW(),
      NOW()
    )"; 
    mysqli_query($db,$sql) OR die(alert_php('error 68'));  
    $id = mysqli_insert_id($db); 
    $sql =
    "INSERT INTO
      tb_log
    VALUES
    (
      default,
      'tb_master_pemasok',
      '".$id."',
      'insert',
      '".$pemasok."',      
      NOW(),
      NOW()
    )";
    mysqli_query($db,$sql) OR die(alert_php('error 83'));
    navigasi_ke('?id_nav_detail='.$id_nav_detail.'&daftar&id='.$id.'&sukses_tambah');
  }  
}

if(isset($_POST['tombol_ubah']))
{
  $id = fch($_POST['id']);
  $pemasok = fch($_POST['pemasok']);
  $alamat = fch($_POST['alamat']);
  $kota = fch($_POST['kota']);
  $telp = fch($_POST['telp']);
  $fax = fch($_POST['fax']);
  $email = fch($_POST['email']);
  $cp = fch($_POST['cp']);
  $catatan = fch($_POST['catatan']);
  $ppn = fch($_POST['ppn']);
  $pph = fch($_POST['pph']);
  $mata_uang = fch($_POST['mata_uang']);
  $nama_bank = fch($_POST['nama_bank']);
  $atas_nama = fch($_POST['atas_nama']);
  $no_rekening = fch($_POST['no_rekening']);
  $aktif = fch($_POST['aktif']);  
  $created_at = fch($_POST['created_at']);
  $updated_at = fch($_POST['updated_at']);
  
  $sql =
  "SELECT
    *
  FROM
    tb_master_pemasok AS a
  WHERE
    a.pemasok = '".$pemasok."' AND
    a.id <> '".$id."'";
  $res = mysqli_query($db,$sql) OR die(alert_php('160'));
  if(mysqli_num_rows($res) != 0)
  {
    navigasi_ke('?id_nav_detail='.$id_nav_detail.'&page='.$page.'&daftar&id='.$id.'&gagal_ubah='.$pemasok);
  }
  else
  {
    $sql =
    "UPDATE
      tb_master_pemasok AS a
    SET
      a.pemasok = '".$pemasok."',
      a.alamat = '".$alamat."',
      a.kota = '".$kota."',
      a.telp = '".$telp."',
      a.fax = '".$fax."',
      a.email = '".$email."',
      a.cp = '".$cp."',
      a.catatan = '".$catatan."',
      a.ppn = '".$ppn."',
      a.pph = '".$pph."',
      a.mata_uang = '".$mata_uang."',
      a.nama_bank = '".$nama_bank."',
      a.atas_nama = '".$atas_nama."',
      a.no_rekening = '".$no_rekening."',
      a.aktif = '".$aktif."',
      a.created_at = '".$created_at."',
      a.updated_at = NOW()
    WHERE
      a.id = '".$id."'";
    mysqli_query($db,$sql) OR die(alert_php('163'));
    $sql =
    "INSERT INTO
      tb_log
    VALUES
    (
      default,
      'tb_master_pemasok',
      '".$id."',
      'update',
      '".$pemasok."',      
      NOW(),
      NOW()
    )";
    mysqli_query($db,$sql) OR die(alert_php('177'));
    navigasi_ke('?id_nav_detail='.$id_nav_detail.'&page='.$page.'&daftar&id='.$id.'&sukses_ubah');
  }  
}
if(isset($_POST['tombol_hapus']))
{
  $id = fch($_POST['id']);
  $pemasok = fch($_POST['pemasok']);
  $alamat = fch($_POST['alamat']);
  $kota = fch($_POST['kota']);
  $telp = fch($_POST['telp']);
  $fax = fch($_POST['fax']);
  $email = fch($_POST['email']);
  $cp = fch($_POST['cp']);
  $catatan = fch($_POST['catatan']);
  $ppn = fch($_POST['ppn']);
  $pph = fch($_POST['pph']);
  $mata_uang = fch($_POST['mata_uang']);
  $nama_bank = fch($_POST['nama_bank']);
  $atas_nama = fch($_POST['atas_nama']);
  $no_rekening = fch($_POST['no_rekening']);
  $aktif = fch($_POST['aktif']); 
  $created_at = fch($_POST['created_at']);
  $updated_at = fch($_POST['updated_at']);
  
  $sql=
  "SELECT
    *
  FROM
    tb_master_pemasok_detail AS a
  WHERE
    a.id = '".$id."'";
  $res = mysqli_query($db,$sql) OR die(alert_php('error 206'));
  if(mysqli_num_rows($res) != 0)
  {
    while($row = mysqli_fetch_assoc($res))
    {
      $id = $row['id'];
      $sql2 =
      "DELETE FROM
        tb_master_pemasok_detail
      WHERE
        id = '".$row['id']."'";
      mysqli_query($db,$sql2) OR die(alert_php('error 217'));
      $sql2 =
      "INSERT INTO
        tb_log
      VALUES
      (
        default,
        'tb_master_pemasok_detail',
        '".$id_detail."',
        'delete',
        '".$pemasok."',      
        NOW(),
        NOW()
      )";
      mysqli_query($db,$sql2) OR die(alert_php('error 231'));
    }
  }
  $sql =
  "DELETE FROM
    tb_master_pemasok
  WHERE
    id = '".$id."'";
  mysqli_query($db,$sql) OR die(alert_php('error 239'));
  $sql =
  "INSERT INTO
    tb_log
  VALUES
  (
    default,
    'tb_master_pemasok',
    '".$id."',
    'delete',
    '".$pemasok."',      
    NOW(),
    NOW()
  )";
  mysqli_query($db,$sql) OR die(alert_php('error 230'));
  navigasi_ke('?id_nav_detail='.$id_nav_detail.'&daftar&id='.$id.'&sukses_hapus='.$pemasok);
}

?>
<div class="content-wrapper">
  <section class="content-header">
    <h1>
      <a style="color:black;" href="?id_nav_detail=<?php echo $id_nav_detail; ?>&refresh&daftar">Navigasi</a>
    </h1>
    <ol class="breadcrumb">
      <li><a href="dashboard.php"><i class="fa fa-dashboard"></i> Home</a></li>
      <li><a href="navigasi.php?id_nav=<?php echo $id_nav; ?>"><?php echo $nav; ?></a></li>
      <li><a href="?id_nav_detail=<?php echo $id_nav_detail; ?>&refresh&daftar">Pemasok</a></li>
    </ol>
  </section>
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
            <h3 class="box-title">Daftar Pemasok</h3>
            <div class="box-tools">
              <div class="btn-group">
                <button type="button" class="btn btn-sm btn-default btn-flat">File</button>
                <button type="button" class="btn btn-sm btn-default btn-flat dropdown-toggle" data-toggle="dropdown">
                  <span class="caret"></span>
                  <span class="sr-only">Toggle Dropdown</span>
                </button>
                <ul class="dropdown-menu" role="menu">
                  <li><a href="?id=<?php echo $id; ?>&tambah"><i class="fa fa-sm fa-file-o"></i>Tambah</a></li>
                  <li><a data-toggle="modal" href="#ModalFilter"><i class="fa fa-sm fa-search"></i> Filter</a></li>
                  <li><a href="?id=<?php echo $id; ?>&refresh&daftar"><i class="fa fa-sm fa-refresh"></i>Refresh</a></li>
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
              <div style="color:white;">Berhasil Menambah Pemasok Baru</div>
            </div>
            <?php
            }
            if(isset($_GET['gagal_tambah']))
            {              
            ?>
            <div class="alert alert-danger" style="padding:5px;">
              <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
              <div style="color:white;">Gagal Menambah; Pemasok <b><u><?php echo $_GET['gagal_tambah']; ?></u></b> Sudah Ada</div>
            </div>
            <?php
            }
            if(isset($_GET['sukses_ubah']))
            {
            ?>
            <div class="alert alert-success" style="padding:5px;">
              <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
              <div style="color:white;">Berhasil Mengubah Pemasok</div>
            </div>
            <?php
            }
            if(isset($_GET['gagal_ubah']))
            {
            ?>
            <div class="alert alert-danger" style="padding:5px;">
              <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
              <div style="color:white;">Gagal Mengubah; Pemasok <b><u><?php echo $_GET['gagal_ubah']; ?></u></b> Sudah Ada</div>
            </div>
            <?php
            }
            if(isset($_GET['sukses_hapus']))
            {
            ?>
            <div class="alert alert-success" style="padding:5px;">
              <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
              <div style="color:white;">Berhasil Menghapus Pemasok <b><u><?php echo $_GET['sukses_hapus']; ?></u></b></div>
            </div>
            <?php
            }
            ?>
            <div class="table-responsive no-padding">
              <table class="table">
                <?php
                $sql =
                "SELECT
                  a.pemasok ,
                  a.alamat ,
                  a.kota ,
                  a.telp ,
                  a.fax ,
                  a.email ,
                  a.cp ,
                  a.catatan ,
                  a.ppn ,
                  a.pph ,
                  a.mata_uang ,
                  a.nama_bank ,
                  a.atas_nama ,
                  a.no_rekening ,
                  a.aktif ,
                  a.created_at ,
                  a.updated_at 
                FROM
                  tb_master_pemasok AS a";
                if(isset($_POST['tombol_filter']) OR isset($_SESSION['tombol_filter_'.$id]))
                {
                  if(isset($_POST['tombol_filter']))
                  {
                    navigasi_ke('?id='.$id.'&daftar');
                    if($_POST['data_per_halaman'] == '') $_POST['data_per_halaman'] = 0;                  
                    $_SESSION['tombol_filter_'.$id_nav_detail] = $_POST['tombol_filter'];
                    $_SESSION['pemasok_'.$id_nav_detail] = $_POST['pemasok'];
                    $_SESSION['alamat_)'.$id_nav_detail] = $_POST['pemasok'];
                    $_SESSION['kota_'.$id_nav_detail] = $_POST['pemasok'];
                    $_SESSION['telp_'.$id_nav_detail] = $_POST['pemasok'];
                    $_SESSION['fax_'.$id_nav_detail] = $_POST['pemasok'];
                    $_SESSION['email_'.$id_nav_detail] = $_POST['pemasok'];
                    $_SESSION['cp_'.$id_nav_detail] = $_POST['pemasok'];
                    $_SESSION['catatan_'.$id_nav_detail] = $_POST['pemasok'];
                    $_SESSION['ppn_'.$id_nav_detail] = $_POST['pemasok'];
                    $_SESSION['pph_'.$id_nav_detail] = $_POST['pemasok'];
                    $_SESSION['mata_uang_'.$id_nav_detail] = $_POST['pemasok'];
                    $_SESSION['nama_bank_'.$id_nav_detail] = $_POST['pemasok'];
                    $_SESSION['atas_nama_'.$id_nav_detail] = $_POST['pemasok'];
                    $_SESSION['no_rekening_'.$id_nav_detail] = $_POST['pemasok'];
                    $_SESSION['aktif_'.$id_nav_detail] = $_POST['aktif'];
                    $_SESSION['data_per_halaman_'.$id_nav_detail] = $_POST['data_per_halaman'];
                    
                    $pemasok = $_POST['pemasok'];
                    $alamat = $_POST['alamat'];
                    $kota = $_POST['kota'];
                    $telp = $_POST['telp'];
                    $fax = $_POST['fax'];
                    $email = $_POST['email'];
                    $cp = $_POST['cp'];
                    $catatan = $_POST['catatan'];
                    $ppn = $_POST['ppn'];
                    $pph = $_POST['pph'];
                    $mata_uang = $_POST['mata_uang'];
                    $nama_bank = $_POST['nama_bank'];
                    $atas_nama = $_POST['atas_nama'];
                    $no_rekening = $_POST['no_rekening'];
                    $aktif = $_POST['aktif'];
                    $created_at = $_POST['created_at'];
                    $updated_at = $_POST['updated_at'];
                    $data_per_halaman = $_POST['data_per_halaman'];
                  }
                  else if(isset($_SESSION['tombol_filter_'.$id_nav_detail]))
                  {
                    $tombol_filter = $_SESSION['tombol_filter_'.$id_nav_detail]; 
                    $_SESSION['pemasok_'.$id_nav_detail] = $_POST['pemasok'];
                    $_SESSION['alamat_)'.$id_nav_detail] = $_POST['pemasok'];
                    $_SESSION['kota_'.$id_nav_detail] = $_POST['pemasok'];
                    $_SESSION['telp_'.$id_nav_detail] = $_POST['pemasok'];
                    $_SESSION['fax_'.$id_nav_detail] = $_POST['pemasok'];
                    $_SESSION['email_'.$id_nav_detail] = $_POST['pemasok'];
                    $_SESSION['cp_'.$id_nav_detail] = $_POST['pemasok'];
                    $_SESSION['catatan_'.$id_nav_detail] = $_POST['pemasok'];
                    $_SESSION['ppn_'.$id_nav_detail] = $_POST['pemasok'];
                    $_SESSION['pph_'.$id_nav_detail] = $_POST['pemasok'];
                    $_SESSION['mata_uang_'.$id_nav_detail] = $_POST['pemasok'];
                    $_SESSION['nama_bank_'.$id_nav_detail] = $_POST['pemasok'];
                    $_SESSION['atas_nama_'.$id_nav_detail] = $_POST['pemasok'];
                    $_SESSION['no_rekening_'.$id_nav_detail] = $_POST['pemasok'];
                    $data_per_halaman = $_SESSION['data_per_halaman_'.$id_nav_detail];
                  } 
                  $sql .= " WHERE a.pemasok LIKE '%".$pemasok."%'";
                  if($aktif != '')
                  {
                    $sql .= " AND a.aktif = '".$aktif."'";
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
                  if($_GET['sort_by'] == 'pemasok')
                  { 
                    $sql .= " ORDER BY a.pemasok ".$_GET['order']."";
                  }  
                  if($_GET['sort_by'] == 'alamat')
                  { 
                    $sql .= " ORDER BY a.alamat ".$_GET['order']."";
                  }
                  if($_GET['sort_by'] == 'kota')
                  { 
                    $sql .= " ORDER BY a.kota ".$_GET['order']."";
                  }
                  if($_GET['sort_by'] == 'telp')
                  { 
                    $sql .= " ORDER BY a.telp ".$_GET['order']."";
                  }
                  if($_GET['sort_by'] == 'fax')
                  { 
                    $sql .= " ORDER BY a.fax ".$_GET['order']."";
                  }  
                  if($_GET['sort_by'] == 'email')
                  { 
                    $sql .= " ORDER BY a.email ".$_GET['order']."";
                  }
                  if($_GET['sort_by'] == 'cp')
                  { 
                    $sql .= " ORDER BY a.cp ".$_GET['order']."";
                  }
                  if($_GET['sort_by'] == 'catatan')
                  { 
                    $sql .= " ORDER BY a.catatan ".$_GET['order']."";
                  }
                  if($_GET['sort_by'] == 'ppn')
                  { 
                    $sql .= " ORDER BY a.ppn ".$_GET['order']."";
                  }  
                  if($_GET['sort_by'] == 'pph')
                  { 
                    $sql .= " ORDER BY a.pph ".$_GET['order']."";
                  }
                  if($_GET['sort_by'] == 'mata_uang')
                  { 
                    $sql .= " ORDER BY a.mata_uang ".$_GET['order']."";
                  }
                  if($_GET['sort_by'] == 'nama_bank')
                  { 
                    $sql .= " ORDER BY a.nam_bank ".$_GET['order']."";
                  }
                  if($_GET['sort_by'] == 'atas_nama')
                  { 
                    $sql .= " ORDER BY a.atas_nama ".$_GET['order']."";
                  }
                  if($_GET['sort_by'] == 'no_rekening')
                  { 
                    $sql .= " ORDER BY a.no_rekening ".$_GET['order']."";
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
                  $sql .= " ORDER BY a.id DESC";
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
                $reload = $_SERVER['PHP_SELF'] . "?id=".$id."&page=".$page."&daftar".$sort_by;
                if($total == 0)
                {
                ?>
                <thead>
                  <tr>
                    <td colspan="9" style="background-color:<?php echo $warna_blok; ?>">Tidak Ada Data</td>
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
                    <th>Pemasok <a <?php if(isset($_GET['sort_by']) AND $_GET['sort_by']=='pemasok' AND $_GET['order']=='desc') echo 'style="color:red;"'; else echo 'style="color:black;"';?> href="?id_nav_detail=<?php echo $id_nav_detail; ?>&page=<?php echo $page; ?>&daftar&sort_by=nama&order=desc"><i class="fa fa-sort-up fa-lg"></i></a><a <?php if(isset($_GET['sort_by']) AND $_GET['sort_by']=='pemasok' AND $_GET['order']=='asc') echo 'style="color:red;"'; else echo 'style="color:black;"';?> href="?id_nav_detail=<?php echo $id_nav_detail; ?>&page=<?php echo $page; ?>&daftar&sort_by=nama&order=asc"><i class="fa fa-sort-down fa-lg"></i></a></th>
                    <th>Alamat <a <?php if(isset($_GET['sort_by']) AND $_GET['sort_by']=='alamat' AND $_GET['order']=='desc') echo 'style="color:red;"'; else echo 'style="color:black;"';?> href="?id_nav_detail=<?php echo $id_nav_detail; ?>&page=<?php echo $page; ?>&daftar&sort_by=posisi&order=desc"><i class="fa fa-sort-up fa-lg"></i></a><a <?php if(isset($_GET['sort_by']) AND $_GET['sort_by']=='alamat' AND $_GET['order']=='asc') echo 'style="color:red;"'; else echo 'style="color:black;"';?> href="?id_nav_detail=<?php echo $id_nav_detail; ?>&page=<?php echo $page; ?>&daftar&sort_by=posisi&order=asc"><i class="fa fa-sort-down fa-lg"></i></a></th>
                    <th>Kota <a <?php if(isset($_GET['sort_by']) AND $_GET['sort_by']=='kota' AND $_GET['order']=='desc') echo 'style="color:red;"'; else echo 'style="color:black;"';?> href="?id_nav_detail=<?php echo $id_nav_detail; ?>&page=<?php echo $page; ?>&daftar&sort_by=ikon&order=desc"><i class="fa fa-sort-up fa-lg"></i></a><a <?php if(isset($_GET['sort_by']) AND $_GET['sort_by']=='kota' AND $_GET['order']=='asc') echo 'style="color:red;"'; else echo 'style="color:black;"';?> href="?id_nav_detail=<?php echo $id_nav_detail; ?>&page=<?php echo $page; ?>&daftar&sort_by=ikon&order=asc"><i class="fa fa-sort-down fa-lg"></i></a></th>
                    <th>Telp <a <?php if(isset($_GET['sort_by']) AND $_GET['sort_by']=='telp' AND $_GET['order']=='desc') echo 'style="color:red;"'; else echo 'style="color:black;"';?> href="?id_nav_detail=<?php echo $id_nav_detail; ?>&page=<?php echo $page; ?>&daftar&sort_by=aktif&order=desc"><i class="fa fa-sort-up fa-lg"></i></a><a <?php if(isset($_GET['sort_by']) AND $_GET['sort_by']=='telp' AND $_GET['order']=='asc') echo 'style="color:red;"'; else echo 'style="color:black;"';?> href="?id_nav_detail=<?php echo $id_nav_detail; ?>&page=<?php echo $page; ?>&daftar&sort_by=aktif&order=asc"><i class="fa fa-sort-down fa-lg"></i></a></th>
                    <th>Fax <a <?php if(isset($_GET['sort_by']) AND $_GET['sort_by']=='fax' AND $_GET['order']=='desc') echo 'style="color:red;"'; else echo 'style="color:black;"';?> href="?id_nav_detail=<?php echo $id_nav_detail; ?>&page=<?php echo $page; ?>&daftar&sort_by=id&order=desc"><i class="fa fa-sort-up fa-lg"></i></a><a <?php if(isset($_GET['sort_by']) AND $_GET['sort_by']=='fax' AND $_GET['order']=='asc') echo 'style="color:red;"'; else echo 'style="color:black;"';?> href="?id_nav_detail=<?php echo $id_nav_detail; ?>&page=<?php echo $page; ?>&daftar&sort_by=id&order=asc"><i class="fa fa-sort-down fa-lg"></i></a></th>
                    <th>Email <a <?php if(isset($_GET['sort_by']) AND $_GET['sort_by']=='email' AND $_GET['order']=='desc') echo 'style="color:red;"'; else echo 'style="color:black;"';?> href="?id_nav_detail=<?php echo $id_nav_detail; ?>&page=<?php echo $page; ?>&daftar&sort_by=nama&order=desc"><i class="fa fa-sort-up fa-lg"></i></a><a <?php if(isset($_GET['sort_by']) AND $_GET['sort_by']=='email' AND $_GET['order']=='asc') echo 'style="color:red;"'; else echo 'style="color:black;"';?> href="?id_nav_detail=<?php echo $id_nav_detail; ?>&page=<?php echo $page; ?>&daftar&sort_by=nama&order=asc"><i class="fa fa-sort-down fa-lg"></i></a></th>
                    <th>Cp <a <?php if(isset($_GET['sort_by']) AND $_GET['sort_by']=='cp' AND $_GET['order']=='desc') echo 'style="color:red;"'; else echo 'style="color:black;"';?> href="?id_nav_detail=<?php echo $id_nav_detail; ?>&page=<?php echo $page; ?>&daftar&sort_by=posisi&order=desc"><i class="fa fa-sort-up fa-lg"></i></a><a <?php if(isset($_GET['sort_by']) AND $_GET['sort_by']=='cp' AND $_GET['order']=='asc') echo 'style="color:red;"'; else echo 'style="color:black;"';?> href="?id_nav_detail=<?php echo $id_nav_detail; ?>&page=<?php echo $page; ?>&daftar&sort_by=posisi&order=asc"><i class="fa fa-sort-down fa-lg"></i></a></th>
                    <th>Catatan <a <?php if(isset($_GET['sort_by']) AND $_GET['sort_by']=='catatan' AND $_GET['order']=='desc') echo 'style="color:red;"'; else echo 'style="color:black;"';?> href="?id_nav_detail=<?php echo $id_nav_detail; ?>&page=<?php echo $page; ?>&daftar&sort_by=ikon&order=desc"><i class="fa fa-sort-up fa-lg"></i></a><a <?php if(isset($_GET['sort_by']) AND $_GET['sort_by']=='catatan' AND $_GET['order']=='asc') echo 'style="color:red;"'; else echo 'style="color:black;"';?> href="?id_nav_detail=<?php echo $id_nav_detail; ?>&page=<?php echo $page; ?>&daftar&sort_by=ikon&order=asc"><i class="fa fa-sort-down fa-lg"></i></a></th>
                    <th>PPN <a <?php if(isset($_GET['sort_by']) AND $_GET['sort_by']=='ppn' AND $_GET['order']=='desc') echo 'style="color:red;"'; else echo 'style="color:black;"';?> href="?id_nav_detail=<?php echo $id_nav_detail; ?>&page=<?php echo $page; ?>&daftar&sort_by=aktif&order=desc"><i class="fa fa-sort-up fa-lg"></i></a><a <?php if(isset($_GET['sort_by']) AND $_GET['sort_by']=='ppn' AND $_GET['order']=='asc') echo 'style="color:red;"'; else echo 'style="color:black;"';?> href="?id_nav_detail=<?php echo $id_nav_detail; ?>&page=<?php echo $page; ?>&daftar&sort_by=aktif&order=asc"><i class="fa fa-sort-down fa-lg"></i></a></th>
                    <th>PPH <a <?php if(isset($_GET['sort_by']) AND $_GET['sort_by']=='pph' AND $_GET['order']=='desc') echo 'style="color:red;"'; else echo 'style="color:black;"';?> href="?id_nav_detail=<?php echo $id_nav_detail; ?>&page=<?php echo $page; ?>&daftar&sort_by=nama&order=desc"><i class="fa fa-sort-up fa-lg"></i></a><a <?php if(isset($_GET['sort_by']) AND $_GET['sort_by']=='pph' AND $_GET['order']=='asc') echo 'style="color:red;"'; else echo 'style="color:black;"';?> href="?id_nav_detail=<?php echo $id_nav_detail; ?>&page=<?php echo $page; ?>&daftar&sort_by=nama&order=asc"><i class="fa fa-sort-down fa-lg"></i></a></th>
                    <th>Mata Uang <a <?php if(isset($_GET['sort_by']) AND $_GET['sort_by']=='mata_uang' AND $_GET['order']=='desc') echo 'style="color:red;"'; else echo 'style="color:black;"';?> href="?id_nav_detail=<?php echo $id_nav_detail; ?>&page=<?php echo $page; ?>&daftar&sort_by=posisi&order=desc"><i class="fa fa-sort-up fa-lg"></i></a><a <?php if(isset($_GET['sort_by']) AND $_GET['sort_by']=='mata_uang' AND $_GET['order']=='asc') echo 'style="color:red;"'; else echo 'style="color:black;"';?> href="?id_nav_detail=<?php echo $id_nav_detail; ?>&page=<?php echo $page; ?>&daftar&sort_by=posisi&order=asc"><i class="fa fa-sort-down fa-lg"></i></a></th>
                    <th>Nama Bank <a <?php if(isset($_GET['sort_by']) AND $_GET['sort_by']=='nama_bank' AND $_GET['order']=='desc') echo 'style="color:red;"'; else echo 'style="color:black;"';?> href="?id_nav_detail=<?php echo $id_nav_detail; ?>&page=<?php echo $page; ?>&daftar&sort_by=ikon&order=desc"><i class="fa fa-sort-up fa-lg"></i></a><a <?php if(isset($_GET['sort_by']) AND $_GET['sort_by']=='nama_bank' AND $_GET['order']=='asc') echo 'style="color:red;"'; else echo 'style="color:black;"';?> href="?id_nav_detail=<?php echo $id_nav_detail; ?>&page=<?php echo $page; ?>&daftar&sort_by=ikon&order=asc"><i class="fa fa-sort-down fa-lg"></i></a></th>
                    <th>Atas Nama <a <?php if(isset($_GET['sort_by']) AND $_GET['sort_by']=='atas_nama' AND $_GET['order']=='desc') echo 'style="color:red;"'; else echo 'style="color:black;"';?> href="?id_nav_detail=<?php echo $id_nav_detail; ?>&page=<?php echo $page; ?>&daftar&sort_by=aktif&order=desc"><i class="fa fa-sort-up fa-lg"></i></a><a <?php if(isset($_GET['sort_by']) AND $_GET['sort_by']=='atas_nama' AND $_GET['order']=='asc') echo 'style="color:red;"'; else echo 'style="color:black;"';?> href="?id_nav_detail=<?php echo $id_nav_detail; ?>&page=<?php echo $page; ?>&daftar&sort_by=aktif&order=asc"><i class="fa fa-sort-down fa-lg"></i></a></th>
                    <th>No Rekening <a <?php if(isset($_GET['sort_by']) AND $_GET['sort_by']=='no_rekening' AND $_GET['order']=='desc') echo 'style="color:red;"'; else echo 'style="color:black;"';?> href="?id_nav_detail=<?php echo $id_nav_detail; ?>&page=<?php echo $page; ?>&daftar&sort_by=id&order=desc"><i class="fa fa-sort-up fa-lg"></i></a><a <?php if(isset($_GET['sort_by']) AND $_GET['sort_by']=='no_rekening' AND $_GET['order']=='asc') echo 'style="color:red;"'; else echo 'style="color:black;"';?> href="?id_nav_detail=<?php echo $id_nav_detail; ?>&page=<?php echo $page; ?>&daftar&sort_by=id&order=asc"><i class="fa fa-sort-down fa-lg"></i></a></th>
                    <th>Status <a <?php if(isset($_GET['sort_by']) AND $_GET['sort_by']=='aktif' AND $_GET['order']=='desc') echo 'style="color:red;"'; else echo 'style="color:black;"';?> href="?id_nav_detail=<?php echo $id_nav_detail; ?>&page=<?php echo $page; ?>&detail&id=<?php echo $id; ?>&sort_by=aktif&order=desc"><i class="fa fa-sort-up fa-lg"></i></a><a <?php if(isset($_GET['sort_by']) AND $_GET['sort_by']=='aktif' AND $_GET['order']=='asc') echo 'style="color:red;"'; else echo 'style="color:black;"';?> href="?id_nav_detail=<?php echo $id_nav_detail; ?>&page=<?php echo $page; ?>&detail&id=<?php echo $id; ?>&sort_by=aktif&order=asc"><i class="fa fa-sort-down fa-lg"></i></a></th>
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
                    <td><?php echo $row['pemasok']; ?></td>
                    <td><?php echo $row['alamat']; ?></td>
                    <td><?php echo $row['kota']; ?></td>
                    <td><?php echo $row['telp']; ?></td>
                    <td><?php echo $row['fax']; ?></td>
                    <td><?php echo $row['email']; ?></td>
                    <td><?php echo $row['cp']; ?></td>
                    <td><?php echo $row['catatan']; ?></td>
                    <td><?php echo $row['ppn']; ?></td>
                    <td><?php echo $row['pph']; ?></td>
                    <td><?php echo $row['mata_uang']; ?></td>
                    <td><?php echo $row['nama_bank']; ?></td>
                    <td><?php echo $row['atas_nama']; ?></td>
                    <td><?php echo $row['no_rekening']; ?></td>

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
              a.pemasok ,
                  a.alamat ,
                  a.kota ,
                    a.telp ,
              a.fax ,
              a.email ,
              a.cp ,
              a.catatan ,
              a.ppn ,
              a.pph ,
              a.mata_uang ,
              a.nama_bank ,
              a.atas_nama ,
              a.no_rekening ,
              a.aktif ,
              a.created_at ,
              a.updated_at 
            FROM
              tb_log AS a
            LEFT JOIN
              tb_master_user AS b ON (b.id = a.id_user)
            WHERE
              a.tabel = 'tb_master_navigasi'"; 
            $sql.=" ORDER BY a.created_at DESC LIMIT 1";
            $res=mysqli_query($db,$sql) OR die('error 452');
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



//PAGE_TAMBAH
  if(isset($_GET['tambah']))
  {
  ?>
  <section class="content">
    <div class="row">
      <div class="col-md-12">
        <div class="box box-primary">
          <div class="box-header with-border">
            <h3 class="box-title">Tambah Pemasok</h3>
          </div>
          <form role="form" method="POST">
            <div class="box-body">
              <div class="row">
                <div class="col-md-2">
                  <div class="form-group">
                    <label for="pemasok">Pemasok :</label>
                    <input autofocus type="text" name="pemasok" id="pemasok" class="form-control" autocomplete="off" required>
                  </div>
                </div>
                <div class="col-md-2">
                  <div class="form-group">
                    <label for="alamat">Alamat :</label>
                    <input autofocus type="text" name="alamat" id="alamat" class="form-control" autocomplete="off" required>
                  </div>
                </div>
                <div class="col-md-2">
                  <div class="form-group">
                    <label for="kota">Kota :</label>
                    <input autofocus type="text" name="kota" id="kota" class="form-control" autocomplete="off" required>
                  </div>
                </div>
                <div class="col-md-2">
                  <div class="form-group">
                    <label for="telepon">Telepon :</label>
                    <input autofocus type="text" name="telp" id="telp" class="form-control" autocomplete="off" required>
                  </div>
                </div>
                <div class="col-md-2">
                  <div class="form-group">
                    <label for="fax">Fax :</label>
                    <input autofocus type="text" name="fax" id="fax" class="form-control" autocomplete="off" required>
                  </div>
                </div>
                <div class="col-md-2">
                  <div class="form-group">
                    <label for="email">Email :</label>
                    <input autofocus type="email" name="email" id="email" class="form-control" autocomplete="off" required>
                  </div>
                </div>
                <div class="col-md-2">
                  <div class="form-group">
                    <label for="cp">CP :</label>
                    <input autofocus type="text" name="cp" id="cp" class="form-control" autocomplete="off" required>
                  </div>
                </div>
                <div class="col-md-2">
                  <div class="form-group">
                    <label for="catatan">Catatan :</label>
                    <input autofocus type="text" name="catatan" id="catatan" class="form-control" autocomplete="off" required>
                  </div>
                </div>
                <div class="col-md-2">
                  <div class="form-group">
                    <label for="ppn">PPN :</label>
                    <input autofocus type="text" name="ppn" id="ppn" class="form-control" autocomplete="off" required>
                  </div>
                </div>
                <div class="col-md-2">
                  <div class="form-group">
                    <label for="pph">PPH :</label>
                    <input autofocus type="text" name="pph" id="pph" class="form-control" autocomplete="off" required>
                  </div>
                </div>
                <div class="col-md-2">
                  <div class="form-group">
                    <label for="mata_uang">Mata Uang :</label>
                    <input autofocus type="text" name="mata_uang" id="mata_uang" class="form-control" autocomplete="off" required>
                  </div>
                </div>
                <div class="col-md-2">
                  <div class="form-group">
                    <label for="nama_bank">Nama Bank :</label>
                    <input autofocus type="text" name="nama_bank" id="nama_bank" class="form-control" autocomplete="off" required>
                  </div>
                </div>
                <div class="col-md-2">
                  <div class="form-group">
                    <label for="atas_nama">Atas Nama :</label>
                    <input autofocus type="text" name="atas_nama" id="atas_nama" class="form-control" autocomplete="off" required>
                  </div>
                </div>
                <div class="col-md-2">
                  <div class="form-group">
                    <label for="no_rekening">No. Rekening :</label>
                    <input autofocus type="text" name="no_rekening" id="no_rekening" class="form-control" autocomplete="off" required>
                  </div>
                </div>



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
      a.pemasok ,
      a.alamat ,
      a.kota ,
      a.telp ,
      a.fax ,
      a.email ,
      a.cp ,
      a.catatan ,
      a.ppn ,
      a.pph ,
      a.mata_uang ,
      a.nama_bank ,
      a.atas_nama ,
      a.no_rekening ,
      a.aktif ,
      a.created_at ,
      a.updated_at 
      
    FROM
      tb_master_navigasi AS a
    WHERE
      a.id = '".$id."'";
    $res = mysqli_query($db,$sql) OR die('error 957');
    if(mysqli_num_rows($res) != 0)
    {
      while($row = mysqli_fetch_assoc($res))
      {
        $id = fch($_POST['id']);
        $pemasok = fch($_POST['pemasok']);
        $alamat = fch($_POST['alamat']);
        $kota = fch($_POST['kota']);
        $telp = fch($_POST['telp']);
        $fax = fch($_POST['fax']);
        $email = fch($_POST['email']);
        $cp = fch($_POST['cp']);
        $catatan = fch($_POST['catatan']);
        $ppn = fch($_POST['ppn']);
        $pph = fch($_POST['pph']);
        $mata_uang = fch($_POST['mata_uang']);
        $nama_bank = fch($_POST['nama_bank']);
        $atas_nama = fch($_POST['atas_nama']);
        $no_rekening = fch($_POST['no_rekening']);
        $aktif = fch($_POST['aktif']);  
        $created_at = fch($_POST['created_at']);
        $updated_at = fch($_POST['updated_at']);      
      }
    }
  ?>
  <section class="content">
    <div class="row">
      <div class="col-md-12">
        <div class="box box-primary">
          <div class="box-header with-border">
            <h3 class="box-title">Ubah Pemasok</h3>
          </div>
          <form role="form" method="POST">
            <div class="box-body">
              <div class="row">
                <div class="col-md-2">
                  <div class="form-group">
                    <label for="pemasok">Pemasok :</label>
                    <input type="text" name="pemasok" id="pemasok" class="form-control" autocomplete="off" value="<?php echo $pemasok; ?>" required>
                  </div>
                </div>
                <div class="col-md-2">
                  <div class="form-group">
                    <label for="alamat">Alamat :</label>
                    <input type="text" name="alamat" id="alamat" class="form-control" autocomplete="off" value="<?php echo $alamat; ?>" required>
                  </div>
                </div>
                <div class="col-md-2">
                  <div class="form-group">
                    <label for="kota">Kota :</label>
                    <input type="text" name="kota" id="kota" class="form-control" autocomplete="off" value="<?php echo $kota; ?>" required>
                  </div>
                </div>
                <div class="col-md-2">
                  <div class="form-group">
                    <label for="telp">Telepon :</label>
                    <input type="text" name="telp" id="telp" class="form-control" autocomplete="off" value="<?php echo $telp; ?>" required>
                  </div>
                </div>
                <div class="col-md-2">
                  <div class="form-group">
                    <label for="fax">Fax :</label>
                    <input type="text" name="fax" id="fax" class="form-control" autocomplete="off" value="<?php echo $fax; ?>" required>
                  </div>
                </div>
                <div class="col-md-2">
                  <div class="form-group">
                    <label for="email">Email :</label>
                    <input type="email" name="email" id="email" class="form-control" autocomplete="off" value="<?php echo $email; ?>" required>
                  </div>
                </div>
                <div class="col-md-2">
                  <div class="form-group">
                    <label for="cp">CP :</label>
                    <input type="text" name="cp" id="cp" class="form-control" autocomplete="off" value="<?php echo $cp; ?>" required>
                  </div>
                </div>
                <div class="col-md-2">
                  <div class="form-group">
                    <label for="catatan">Catatan :</label>
                    <input type="text" name="catatan" id="catatan" class="form-control" autocomplete="off" value="<?php echo $catatan; ?>" required>
                  </div>
                </div>
                <div class="col-md-2">
                  <div class="form-group">
                    <label for="ppn">PPN :</label>
                    <input type="text" name="ppn" id="ppn" class="form-control" autocomplete="off" value="<?php echo $ppn; ?>" required>
                  </div>
                </div>
                <div class="col-md-2">
                  <div class="form-group">
                    <label for="pph">PPH :</label>
                    <input type="text" name="pph" id="pph" class="form-control" autocomplete="off" value="<?php echo $pph; ?>" required>
                  </div>
                </div>
                <div class="col-md-2">
                  <div class="form-group">
                    <label for="mata_uang">Mata Uang :</label>
                    <input type="text" name="mata_uang" id="mata_uang" class="form-control" autocomplete="off" value="<?php echo $mata_uang; ?>" required>
                  </div>
                </div>
                <div class="col-md-2">
                  <div class="form-group">
                    <label for="nama_bank">Nama Bank :</label>
                    <input type="text" name="nama_bank" id="nama_bank" class="form-control" autocomplete="off" value="<?php echo $nama_bank; ?>" required>
                  </div>
                </div>
                <div class="col-md-2">
                  <div class="form-group">
                    <label for="atas_nama">Atas Nama :</label>
                    <input type="text" name="atas_nama" id="atas_nama" class="form-control" autocomplete="off" value="<?php echo $atas_nama; ?>" required>
                  </div>
                </div>
                <div class="col-md-2">
                  <div class="form-group">
                    <label for="no_rekening">No. Rekening :</label>
                    <input type="text" name="no_rekening" id="no_rekening" class="form-control" autocomplete="off" value="<?php echo $no_rekening; ?>" required>
                  </div>
                </div>
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
      a.pemasok
    FROM
      tb_master_pemasok AS a
    WHERE
      a.id = '".$id."'";
    $res = mysqli_query($db,$sql) OR die(alert_php('1094'));
    if(mysqli_num_rows($res) != 0)
    {
      while($row = mysqli_fetch_assoc($res))
      {
        $pemasok = $row['pemasok'];     
      }
    }
  ?>
  <section class="content">
    <div class="row">
      <div class="col-md-12">
        <div class="box box-primary">
          <div class="box-header with-border">
            <h3 class="box-title">Hapus Pemasok</h3>
          </div>
          <form role="form" method="POST">
            <div class="box-body">
              <div class="row">
                <div class="col-md-12">
                  <label>Anda Yakin Ingin Menghapus Pemasok : <b><u><?php echo $pemasok; ?></u></b> ?</label>
                </div>
              </div>
              <br>
              <div class="row">
                <div class="col-md-2">
                  <input type="hidden" name="id" value="<?php echo $id; ?>">
                  <input type="hidden" name="nama" value="<?php echo $pemasok; ?>">
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
    <div class="modal-dialog modal-md">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span></button>
          <h4 class="modal-title">Filter Data</h4>
        </div>
        <form method="POST">
          <div class="modal-body">
            <div class="row">
              <div class="col-md-4">
                <div class="form-group">
                  <label>Pemasok: </label>
                  <input type="text" name="pemasok" autocomplete="off" class="form-control" value="<?php if(isset($_SESSION['pemasok_'.$id_nav_detail])) echo $_SESSION['nama_'.$id_nav_detail]; ?>">
                </div>
              </div>
              <div class="col-md-4">
                <div class="form-group">
                  <label>Status : </label>
                  <select name="aktif" class="form-control select2" style="width: 100%;">
                    <option value="" <?php if(isset($_SESSION['aktif_'.$id_nav_detail]) AND $_SESSION['aktif_'.$id_nav_detail] == '') echo 'selected';?>>Semua</option>
                    <option value="1" <?php if(isset($_SESSION['aktif_'.$id_nav_detail]) AND $_SESSION['aktif_'.$id_nav_detail] == 1) echo 'selected';?>>Aktif</option>
                    <option value="0" <?php if(isset($_SESSION['aktif_'.$id_nav_detail]) AND $_SESSION['aktif_'.$id_nav_detail] == '0') echo 'selected';?>>Non Aktif</option>
                  </select>
                </div>
              </div>
              <div class="col-md-4">
                <div class="form-group">
                  <label>Data/Halaman : </label>
                  <select name="data_per_halaman" class="form-control select2" style="width: 100%;">
                    <option value="" <?php if(isset($_SESSION['data_per_halaman_'.$id_nav_detail]) AND $_SESSION['data_per_halaman_'.$id_nav_detail]=='') echo 'selected';?>>Semua</option>
                    <option value="15" <?php if(!isset($_SESSION['data_per_halaman_'.$id_nav_detail]) OR (isset($_SESSION['data_per_halaman_'.$id_nav_detail]) AND $_SESSION['data_per_halaman_'.$id_nav_detail] == '15')) echo 'selected';?>>15</option>
                    <option value="25" <?php if(isset($_SESSION['data_per_halaman_'.$id_nav_detail]) AND $_SESSION['data_per_halaman_'.$id_nav_detail]=='25') echo 'selected';?>>25</option>
                    <option value="50" <?php if(isset($_SESSION['data_per_halaman_'.$id_nav_detail]) AND $_SESSION['data_per_halaman_'.$id_nav_detail]=='50') echo 'selected';?>>50</option>
                    <option value="100" <?php if(isset($_SESSION['data_per_halaman_'.$id_nav_detail]) AND $_SESSION['data_per_halaman_'.$id_nav_detail]=='100') echo 'selected';?>>100</option>
                    <option value="250" <?php if(isset($_SESSION['data_per_halaman_'.$id_nav_detail]) AND $_SESSION['data_per_halaman_'.$id_nav_detail]=='250') echo 'selected';?>>250</option>
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