<?php include 'template/kerangkaAtas.php'; ?>
<?php
if(isset($_GET['refresh']))
{
  unset($_SESSION['tombol_filter_'.$id_nav_detail]);
  unset($_SESSION['kode_'.$id_nav_detail]);
  unset($_SESSION['barang_'.$id_nav_detail]);
  unset($_SESSION['satuan_'.$id_nav_detail]);
  unset($_SESSION['aktif_'.$id_nav_detail]);
  unset($_SESSION['data_per_halaman_'.$id_nav_detail]);
  navigasi_ke('?id_nav_detail='.$id_nav_detail.'&daftar');
}
if(isset($_GET['pdf']))
{
  navigasi_ke('master-barang-pdf.php');
}
if(isset($_GET['excel']))
{
  navigasi_ke('master-barang-excel.php');
}
if(isset($_POST['tombol_tambah']))
{
  unset($_SESSION['tombol_filter_'.$id_nav_detail]);  
  $prefix = fch($_POST['prefix']);
  $counter = fch($_POST['counter']);
  $barang = fch($_POST['barang']);
  $satuan = fch($_POST['satuan']);
  $id_level_1 = fch($_POST['id_level_1']);
  $id_level_2 = fch($_POST['id_level_2']);
  $pembagi = fch($_POST['pembagi']);
  $minimum_stok = fch($_POST['minimum_stok']);
  $lead_time = fch($_POST['lead_time']);
  $reorder_qty = fch($_POST['reorder_qty']);
  $id_golongan = fch($_POST['id_golongan']);
  $id_akun_pembukuan = fch($_POST['id_akun_pembukuan']);
  $id_tipe_aktiva = fch($_POST['id_tipe_aktiva']);
  $id_kelompok_aktiva = fch($_POST['id_kelompok_aktiva']);
  $id_akun_akumulasi_penyusutan_aktiva = fch($_POST['id_akun_akumulasi_penyusutan_aktiva']);
  $id_akun_beban_penyusutan_aktiva = fch($_POST['id_akun_beban_penyusutan_aktiva']);
  $catatan = fch($_POST['catatan']);
  $aktif = fch($_POST['aktif']);  
  $faktor = 1;
  $kode = $prefix.$counter;
  $sql =
  "SELECT
    a.id
  FROM
    tb_master_barang as a
  WHERE
    a.kode = '".$kode."'";
  $res = mysqli_query($db,$sql) OR die(alert_php('error 43'));
  if(mysqli_num_rows($res) != 0)
  {
    navigasi_ke('?id_nav_detail='.$id_nav_detail.'&daftar&gagal_tambah='.$kode);
  }
  else
  {
    $sql = 
    "SELECT
      a.id
    FROM
      tb_master_barang_prefix AS a
    WHERE
      a.prefix = '".$prefix."'";
    $res = mysqli_query($db,$sql) OR die(alert_php('error 57'));
    if(mysqli_num_rows($res) != 0)
    {
      while($row = mysqli_fetch_assoc($res))
      {
        $id_grup = $row['id'];
      }
    }
    $sql = 
    "INSERT INTO
      tb_master_barang
    VALUES
    (
      default,
      '".$kode."',
      '".$barang."',
      '".$satuan."',
      '',
      '".$id_grup."',
      '',
      '".$id_level_1."',
      '',
      '".$id_level_2."',
      '',
      '".$id_golongan."',
      '',
      '".$faktor."',
      '".$minimum_stok."',
      '".$lead_time."',
      '".$reorder_qty."',
      '".$pembagi."',
      0,
      '".$id_akun_pembukuan."',
      '',
      0,
      '".$id_tipe_aktiva."',
      '".$id_kelompok_aktiva."',
      '".$id_akun_akumulasi_penyusutan_aktiva."',
      '',
      '".$id_akun_beban_penyusutan_aktiva."',
      '',
      '".$catatan."',
      '".$aktif."',
      '".$id_user."',
      NOW(),
      NOW()
    )"; 
    mysqli_query($db,$sql) OR die(alert_php('error 110'));  
    $id = mysqli_insert_id($db); 
    $sql =
    "INSERT INTO
      tb_log
    VALUES
    (
      default,
      'tb_master_barang',
      '".$id."',
      'insert',
      '".$id_user."',      
      NOW(),
      NOW()
    )";
    mysqli_query($db,$sql) OR die(alert_php('error 125'));
    navigasi_ke('?id_nav_detail='.$id_nav_detail.'&daftar&id='.$id.'&sukses_tambah='.$kode.' - '.$barang);
  }
}
if(isset($_POST['tombol_tambah_detail']))
{
  $id = fch($_POST['id']);
  $nama = fch($_POST['nama']);
  $kode = fch($_POST['kode']);
  $nomor = fch($_POST['nomor']);
  $file = fch($_POST['file']);
  $postfix = fch($_POST['postfix']);
  $ikon = fch($_POST['ikon']);
  $aktif = fch($_POST['aktif']);    
  $sql =
  "SELECT
    a.id_detail
  FROM
    tb_master_navigasi_detail as a
  WHERE
    a.nama = '".$nama."'";
  $res = mysqli_query($db,$sql) OR die(alert_php('error 103'));
  if(mysqli_num_rows($res) != 0)
  {
    navigasi_ke('?id_nav_detail='.$id_nav_detail.'&page='.$page.'&detail&id='.$id.'&gagal_tambah='.$nama);
  }
  else
  {
    $sql =
    "SELECT
      a.posisi
    FROM
      tb_master_navigasi_detail AS a";
    $sql .= " ORDER BY a.posisi DESC LIMIT 1";
    $res = mysqli_query($db,$sql) OR die(alert_php('error 116'));
    if(mysqli_num_rows($res) != 0)
    {
      while($row = mysqli_fetch_assoc($res))
      {
        $posisi = $row['posisi'] + 1;
      }
    }
    $sql = 
    "INSERT INTO
      tb_master_navigasi_detail
    VALUES
    (
      default,
      '".$id."',
      '".$kode."',
      '".$nomor."',
      '".$nama."',
      '".$file."',
      '".$postfix."',
      '".$posisi."',
      '".$ikon."',
      '".$aktif."',
      '".$id_user."',
      NOW(),
      NOW()
    )"; 
    mysqli_query($db,$sql) OR die(alert_php('error 143'));
    $id_detail = mysqli_insert_id($db); 
    $sql =
    "INSERT INTO
      tb_log
    VALUES
    (
      default,
      'tb_master_navigasi_detail',
      '".$id_detail."',
      'insert',
      '".$id_user."',      
      NOW(),
      NOW()
    )";
    mysqli_query($db,$sql) OR die(alert_php('error 158'));
    navigasi_ke('?id_nav_detail='.$id_nav_detail.'&page='.$page.'&detail&id='.$id.'&sukses_tambah='.$nama);
  }  
}
if(isset($_POST['tombol_ubah_detail']))
{
  $id = fch($_POST['id']);
  $id_detail = fch($_POST['id_detail']);
  $nama = fch($_POST['nama']);
  $kode = fch($_POST['kode']);
  $nomor = fch($_POST['nomor']);
  $file = fch($_POST['file']);
  $postfix = fch($_POST['postfix']);
  $ikon = fch($_POST['ikon']);
  $aktif = fch($_POST['aktif']);    
  $sql =
  "SELECT
    a.id_detail
  FROM
    tb_master_navigasi_detail as a
  WHERE
    a.nama = '".$nama."' AND
    a.id_detail <> '".$id_detail."'";
  $res = mysqli_query($db,$sql) OR die(alert_php('error 181'));
  if(mysqli_num_rows($res) != 0)
  {
    navigasi_ke('?id_nav_detail='.$id_nav_detail.'&page='.$page.'&detail&id='.$id.'&id_detail='.$id_detail.'&gagal_ubah='.$nama);
  }
  else
  {
    $sql =
    "SELECT
      a.posisi
    FROM
      tb_master_navigasi_detail AS a";
    $sql .= " ORDER BY a.posisi DESC LIMIT 1";
    $res = mysqli_query($db,$sql) OR die(alert_php('error 116'));
    if(mysqli_num_rows($res) != 0)
    {
      while($row = mysqli_fetch_assoc($res))
      {
        $posisi = $row['posisi'] + 1;
      }
    }
    $sql =
    "UPDATE
      tb_master_navigasi_detail AS a
    SET
      a.kode = '".$kode."',
      a.nomor = '".$nomor."',
      a.nama = '".$nama."',
      a.file = '".$file."',
      a.postfix = '".$postfix."',
      a.ikon = '".$ikon."',
      a.aktif = '".$aktif."',
      a.updated_at = NOW()
    WHERE
      a.id_detail = '".$id_detail."'";    
    mysqli_query($db,$sql) OR die(alert_php('error 216'));
    $sql =
    "INSERT INTO
      tb_log
    VALUES
    (
      default,
      'tb_master_navigasi_detail',
      '".$id_detail."',
      'update',
      '".$id_user."',      
      NOW(),
      NOW()
    )";
    mysqli_query($db,$sql) OR die(alert_php('error 230'));
    navigasi_ke('?id_nav_detail='.$id_nav_detail.'&page='.$page.'&detail&id='.$id.'&id_detail='.$id_detail.'&sukses_ubah='.$nama);
  }  
}
if(isset($_POST['tombol_hapus_detail']))
{
  $id = fch($_POST['id']);
  $id_detail = fch($_POST['id_detail']);
  $nama = fch($_POST['nama']);  
  $sql =
  "DELETE FROM
    tb_master_navigasi_detail
  WHERE
    id_detail = '".$id_detail."'";
  mysqli_query($db,$sql) OR die(alert_php('error 244'));
  $sql =
  "INSERT INTO
    tb_log
  VALUES
  (
    default,
    'tb_master_navigasi_detail',
    '".$id_detail."',
    'delete',
    '".$id_user."',      
    NOW(),
    NOW()
  )";
  mysqli_query($db,$sql) OR die(alert_php('error 258'));
  navigasi_ke('?id_nav_detail='.$id_nav_detail.'&page='.$page.'&detail&id='.$id.'&id_detail='.$id_detail.'&sukses_hapus='.$nama);
}
if(isset($_POST['tombol_ubah']))
{
  $id = fch($_POST['id']);
  $nama = fch($_POST['nama']);
  $ikon = fch($_POST['ikon']);
  $aktif = fch($_POST['aktif']);
  $sql =
  "SELECT
    *
  FROM
    tb_master_barang AS a
  WHERE
    a.nama = '".$nama."' AND
    a.id <> '".$id."'";
  $res = mysqli_query($db,$sql) OR die(alert_php('160'));
  if(mysqli_num_rows($res) != 0)
  {
    navigasi_ke('?id_nav_detail='.$id_nav_detail.'&page='.$page.'&daftar&id='.$id.'&gagal_ubah='.$nama);
  }
  else
  {
    $sql =
    "UPDATE
      tb_master_barang AS a
    SET
      a.nama = '".$nama."',
      a.ikon = '".$ikon."',
      a.aktif = '".$aktif."',
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
      'tb_master_barang',
      '".$id."',
      'update',
      '".$id_user."',      
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
  $nama = fch($_POST['nama']);
  $sql=
  "SELECT
    *
  FROM
    tb_master_navigasi_detail AS a
  WHERE
    a.id = '".$id."'";
  $res = mysqli_query($db,$sql) OR die(alert_php('error 206'));
  if(mysqli_num_rows($res) != 0)
  {
    while($row = mysqli_fetch_assoc($res))
    {
      $id_detail = $row['id_detail'];
      $sql2 =
      "DELETE FROM
        tb_master_navigasi_detail
      WHERE
        id_detail = '".$row['id_detail']."'";
      mysqli_query($db,$sql2) OR die(alert_php('error 217'));
      $sql2 =
      "INSERT INTO
        tb_log
      VALUES
      (
        default,
        'tb_master_navigasi_detail',
        '".$id_detail."',
        'delete',
        '".$id_user."',      
        NOW(),
        NOW()
      )";
      mysqli_query($db,$sql2) OR die(alert_php('error 231'));
    }
  }
  $sql =
  "DELETE FROM
    tb_master_barang
  WHERE
    id = '".$id."'";
  mysqli_query($db,$sql) OR die(alert_php('error 239'));
  $sql =
  "INSERT INTO
    tb_log
  VALUES
  (
    default,
    'tb_master_barang',
    '".$id."',
    'delete',
    '".$id_user."',      
    NOW(),
    NOW()
  )";
  mysqli_query($db,$sql) OR die(alert_php('error 230'));
  navigasi_ke('?id_nav_detail='.$id_nav_detail.'&daftar&id='.$id.'&sukses_hapus='.$nama);
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
<script>
function cekKodeTerakhir(prefix) {
  if (window.XMLHttpRequest) {
    // code for IE7+, Firefox, Chrome, Opera, Safari
    xmlhttp = new XMLHttpRequest();
  } else {
    // code for IE6, IE5
    xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
  }
  xmlhttp.onreadystatechange = function() {
    if (this.readyState == 4 && this.status == 200) {
      //document.getElementById("counter").removeAttribute("readonly");
      document.getElementById("counter").value = this.responseText;
    }
  };
  xmlhttp.open("GET", "json/cek-kode-barang-terakhir.php?prefix=" + prefix, true);
  xmlhttp.send();
}
</script>
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
            <h3 class="box-title">Daftar Barang</h3>
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
              <div style="color:white;">Berhasil Menambah; Barang <b><u><?php echo $_GET['sukses_tambah']; ?></u></b></div>
            </div>
            <?php
            }
            if(isset($_GET['gagal_tambah']))
            {              
            ?>
            <div class="alert alert-danger" style="padding:5px;">
              <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
              <div style="color:white;">Gagal Menambah; Barang <b><u><?php echo $_GET['gagal_tambah']; ?></u></b> Sudah Ada</div>
            </div>
            <?php
            }
            if(isset($_GET['sukses_ubah']))
            {
            ?>
            <div class="alert alert-success" style="padding:5px;">
              <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
              <div style="color:white;">Berhasil Mengubah Barang</div>
            </div>
            <?php
            }
            if(isset($_GET['gagal_ubah']))
            {
            ?>
            <div class="alert alert-danger" style="padding:5px;">
              <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
              <div style="color:white;">Gagal Mengubah; Barang <b><u><?php echo $_GET['gagal_ubah']; ?></u></b> Sudah Ada</div>
            </div>
            <?php
            }
            if(isset($_GET['sukses_hapus']))
            {
            ?>
            <div class="alert alert-success" style="padding:5px;">
              <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
              <div style="color:white;">Berhasil Menghapus Barang <b><u><?php echo $_GET['sukses_hapus']; ?></u></b></div>
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
                  a.kode,
                  a.barang,
                  a.satuan,
                  a.aktif,
                  a.created_at,
                  a.updated_at
                FROM
                  tb_master_barang AS a";
                if(isset($_POST['tombol_filter']) OR isset($_SESSION['tombol_filter_'.$id_nav_detail]))
                {
                  if(isset($_POST['tombol_filter']))
                  {
                    navigasi_ke('?id_nav_detail='.$id_nav_detail.'&daftar');
                    if($_POST['data_per_halaman'] == '') $_POST['data_per_halaman'] = 0;                  
                    $_SESSION['tombol_filter_'.$id_nav_detail] = $_POST['tombol_filter'];
                    $_SESSION['kode_'.$id_nav_detail] = $_POST['kode'];
                    $_SESSION['barang_'.$id_nav_detail] = $_POST['barang'];
                    $_SESSION['satuan_'.$id_nav_detail] = $_POST['satuan'];
                    $_SESSION['aktif_'.$id_nav_detail] = $_POST['aktif'];
                    $_SESSION['data_per_halaman_'.$id_nav_detail] = $_POST['data_per_halaman'];
                    $kode = $_POST['kode'];
                    $barang = $_POST['barang'];
                    $satuan = $_POST['satuan'];
                    $aktif = $_POST['aktif'];
                    $data_per_halaman = $_POST['data_per_halaman'];
                  }
                  else if(isset($_SESSION['tombol_filter_'.$id_nav_detail]))
                  {
                    $tombol_filter = $_SESSION['tombol_filter_'.$id_nav_detail]; 
                    $kode = $_SESSION['kode_'.$id_nav_detail];
                    $barang = $_SESSION['barang_'.$id_nav_detail];
                    $satuan = $_SESSION['satuan_'.$id_nav_detail];
                    $aktif = $_SESSION['aktif_'.$id_nav_detail];
                    $data_per_halaman = $_SESSION['data_per_halaman_'.$id_nav_detail];
                  } 
                  $sql .= " WHERE a.kode LIKE '%".$kode."%'";
                  $sql .= " AND a.barang LIKE '%".$barang."%'";
                  if($satuan != '')
                  {
                    $sql .= " AND a.satuan = '".$satuan."'";
                  }
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
                  if($_GET['sort_by'] == 'kode')
                  { 
                    $sql .= " ORDER BY a.kode ".$_GET['order']."";
                  }  
                  if($_GET['sort_by'] == 'barang')
                  { 
                    $sql .= " ORDER BY a.barang ".$_GET['order']."";
                  }
                  if($_GET['sort_by'] == 'satuan')
                  { 
                    $sql .= " ORDER BY a.satuan ".$_GET['order']."";
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
                  $sql .= " ORDER BY a.kode";
                }             
                $page = isset($_GET["page"]) ? (int)$_GET["page"] : 1;
                $mulai = ($page > 1) ? ($page * $data_per_halaman) - $data_per_halaman : 0;
                $result = mysqli_query($db,$sql) OR die(alert_php('error 612'));
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
                $reload = $_SERVER['PHP_SELF'] . "?id_nav_detail=".$id_nav_detail."&page=".$page."&daftar".$sort_by;
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
                    <th>Kode <a <?php if(isset($_GET['sort_by']) AND $_GET['sort_by']=='kode' AND $_GET['order']=='desc') echo 'style="color:red;"'; else echo 'style="color:black;"';?> href="?id_nav_detail=<?php echo $id_nav_detail; ?>&page=<?php echo $page; ?>&daftar&sort_by=kode&order=desc"><i class="fa fa-sort-up fa-lg"></i></a><a <?php if(isset($_GET['sort_by']) AND $_GET['sort_by']=='kode' AND $_GET['order']=='asc') echo 'style="color:red;"'; else echo 'style="color:black;"';?> href="?id_nav_detail=<?php echo $id_nav_detail; ?>&page=<?php echo $page; ?>&daftar&sort_by=kode&order=asc"><i class="fa fa-sort-down fa-lg"></i></a></th>
                    <th>Barang <a <?php if(isset($_GET['sort_by']) AND $_GET['sort_by']=='barang' AND $_GET['order']=='desc') echo 'style="color:red;"'; else echo 'style="color:black;"';?> href="?id_nav_detail=<?php echo $id_nav_detail; ?>&page=<?php echo $page; ?>&daftar&sort_by=barang&order=desc"><i class="fa fa-sort-up fa-lg"></i></a><a <?php if(isset($_GET['sort_by']) AND $_GET['sort_by']=='barang' AND $_GET['order']=='asc') echo 'style="color:red;"'; else echo 'style="color:black;"';?> href="?id_nav_detail=<?php echo $id_nav_detail; ?>&page=<?php echo $page; ?>&daftar&sort_by=barang&order=asc"><i class="fa fa-sort-down fa-lg"></i></a></th>
                    <th>Satuan <a <?php if(isset($_GET['sort_by']) AND $_GET['sort_by']=='satuan' AND $_GET['order']=='desc') echo 'style="color:red;"'; else echo 'style="color:black;"';?> href="?id_nav_detail=<?php echo $id_nav_detail; ?>&page=<?php echo $page; ?>&daftar&sort_by=satuan&order=desc"><i class="fa fa-sort-up fa-lg"></i></a><a <?php if(isset($_GET['sort_by']) AND $_GET['sort_by']=='satuan' AND $_GET['order']=='asc') echo 'style="color:red;"'; else echo 'style="color:black;"';?> href="?id_nav_detail=<?php echo $id_nav_detail; ?>&page=<?php echo $page; ?>&daftar&sort_by=satuan&order=asc"><i class="fa fa-sort-down fa-lg"></i></a></th>
                    <th>Status <a <?php if(isset($_GET['sort_by']) AND $_GET['sort_by']=='aktif' AND $_GET['order']=='desc') echo 'style="color:red;"'; else echo 'style="color:black;"';?> href="?id_nav_detail=<?php echo $id_nav_detail; ?>&page=<?php echo $page; ?>&daftar&sort_by=aktif&order=desc"><i class="fa fa-sort-up fa-lg"></i></a><a <?php if(isset($_GET['sort_by']) AND $_GET['sort_by']=='aktif' AND $_GET['order']=='asc') echo 'style="color:red;"'; else echo 'style="color:black;"';?> href="?id_nav_detail=<?php echo $id_nav_detail; ?>&page=<?php echo $page; ?>&daftar&sort_by=aktif&order=asc"><i class="fa fa-sort-down fa-lg"></i></a></th>
                    <th>Created At <a <?php if(isset($_GET['sort_by']) AND $_GET['sort_by']=='created_at' AND $_GET['order']=='desc') echo 'style="color:red;"'; else echo 'style="color:black;"';?> href="?id_nav_detail=<?php echo $id_nav_detail; ?>&page=<?php echo $page; ?>&daftar&sort_by=created_at&order=desc"><i class="fa fa-sort-up fa-lg"></i></a><a <?php if(isset($_GET['sort_by']) AND $_GET['sort_by']=='created_at' AND $_GET['order']=='asc') echo 'style="color:red;"'; else echo 'style="color:black;"';?> href="?id_nav_detail=<?php echo $id_nav_detail; ?>&page=<?php echo $page; ?>&daftar&sort_by=created_at&order=asc"><i class="fa fa-sort-down fa-lg"></i></a></th>
                    <th>Updated At <a <?php if(isset($_GET['sort_by']) AND $_GET['sort_by']=='updated_at' AND $_GET['order']=='desc') echo 'style="color:red;"'; else echo 'style="color:black;"';?> href="?id_nav_detail=<?php echo $id_nav_detail; ?>&page=<?php echo $page; ?>&daftar&sort_by=updated_at&order=desc"><i class="fa fa-sort-up fa-lg"></i></a><a <?php if(isset($_GET['sort_by']) AND $_GET['sort_by']=='updated_at' AND $_GET['order']=='asc') echo 'style="color:red;"'; else echo 'style="color:black;"';?> href="?id_nav_detail=<?php echo $id_nav_detail; ?>&page=<?php echo $page; ?>&daftar&sort_by=updated_at&order=asc"><i class="fa fa-sort-down fa-lg"></i></a></th>
                    <th colspan="1">Aksi</th>
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
                    <td style="width:1.5cm;"><?php echo $nomor++; ?></td>
                    <td style="width:1.5cm;"><?php echo $row['id']; ?></td>
                    <td style="width:2cm;"><?php echo $row['kode']; ?></td>
                    <td><?php echo $row['barang']; ?></td>
                    <td style="width:2.5cm;"><?php echo $row['satuan']; ?></td>
                    <td style="width:2.5cm;"><span class=" label label-<?php echo $label; ?>"><?php echo $status; ?></span></td>
                    <td style="width:4.5cm;"><?php echo date('d-M-Y H:i:s',strtotime($row['created_at'])); ?></td>
                    <td style="width:4.5cm;"><?php echo date('d-M-Y H:i:s',strtotime($row['updated_at'])); ?></td>
                    <td style="width:0.5cm;"><a class="fa fa-lg fa-pencil" style="cursor: pointer;color:darkblue;text-decoration: none;" href="?id_nav_detail=<?php echo $id_nav_detail; ?>&page=<?php echo $page; ?>&ubah&id=<?php echo $row['id']; ?>"></a></td>
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
              a.tabel = 'tb_master_barang'"; 
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

//PAGE_DETAIL
  if(isset($_GET['detail']))
  {    
    $id = fch($_GET['id']);
    
    $sql = 
    "SELECT
      *
    FROM
      tb_master_barang AS a
    WHERE
      a.id = '".$id."'";
    $res = mysqli_query($db,$sql) OR die('error 651');
    if(mysqli_num_rows($res) != 0)
    {
      while($row = mysqli_fetch_assoc($res))
      {
        $nama = $row['nama'];
      }
    }
    if(isset($_GET['tambah_detail']))
    {
    ?>
  <section class="content">
    <div class="row">
      <div class="col-md-12">
        <div class="box box-primary">
          <div class="box-header with-border">
            <h3 class="box-title">Tambah Detail Barang</h3>
          </div>
          <div class="box-body">
            <form role="form" method="POST">
              <div class="row">
                <div class="col-md-2">
                  <div class="form-group">
                    <label for="nama">Nama :</label>
                    <input autofocus type="text" name="nama" id="nama" class="form-control" autocomplete="off" required>
                  </div>
                </div>
                <div class="col-md-2">
                  <div class="form-group">
                    <label for="kode">Kode :</label>
                    <input type="text" name="kode" id="kode" class="form-control" autocomplete="off">
                  </div>
                </div>
                <div class="col-md-2">
                  <div class="form-group">
                    <label for="nomor">Nomor :</label>
                    <input type="text" name="nomor" id="nomor" class="form-control" autocomplete="off">
                  </div>
                </div>
                <div class="col-md-2">
                  <div class="form-group">
                    <label for="file">File :</label>
                    <input type="text" name="file" id="file" class="form-control" autocomplete="off" required>
                  </div>
                </div>
                <div class="col-md-2">
                  <div class="form-group">
                    <label for="postfix">Postfix :</label>
                    <input type="text" name="postfix" id="postfix" class="form-control" autocomplete="off">
                  </div>
                </div>
                <div class="col-md-2">
                  <div class="form-group">
                    <label for="ikon">Ikon :</label>
                    <select id="ikon" name="ikon" class="form-control select2-icon" style="width: 100%;" required>
                      <option value="">Pilih..</option>
                      <?php
                      $sql =
                      "SELECT
                        a.nama
                      FROM
                        tb_master_ikon AS a";
                      $sql .= " ORDER BY a.nama ";
                      $res = mysqli_query($db,$sql) OR die('error 695');
                      if(mysqli_num_rows($res) != 0)
                      {
                        while($row = mysqli_fetch_assoc($res))
                        {
                        ?>
                      <option value="<?php echo $row['nama']; ?>" data-icon="<?php echo $row['nama']; ?>">&nbsp;<?php echo $row['nama']; ?></option>
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
                  <input type="hidden" name="id" value="<?php echo $id; ?>">
                  <button type="submit" name="tombol_tambah_detail" class="btn btn-sm btn-flat btn-success"><i class="fa fa-sm fa-save"></i> Simpan</button>
                  <a href="?id_nav_detail=<?php echo $id_nav_detail; ?>&page=<?php echo $page; ?>&detail&id=<?php echo $id; ?>" class="btn btn-sm btn-flat btn-danger"><i class="fa fa-sm fa-times"></i> Batal</a>
                </div>
              </div>
            </form>
          </div>
          <div class="box-footer"></div>
        </div>
      </div>
    </div>
  </section>
  <?php
    }
    else if(isset($_GET['ubah_detail']))
    {
      $id_detail = fch($_GET['id_detail']);
      $sql = 
      "SELECT
        *
      FROM
        tb_master_navigasi_detail AS a
      WHERE
        a.id_detail = '".$id_detail."'";
      $res = mysqli_query($db,$sql) OR die('error 667');
      if(mysqli_num_rows($res) != 0)
      {
        while($row = mysqli_fetch_assoc($res))
        {
          $nama_navigasi_detail = $row['nama'];
          $kode = $row['kode'];
          $nomor = $row['nomor'];
          $file = $row['file'];
          $postfix = $row['postfix'];
          $posisi = $row['posisi'];
          $ikon = $row['ikon'];
          $aktif = $row['aktif'];
        }
      }
    ?>
  <section class="content">
    <div class="row">
      <div class="col-md-12">
        <div class="box box-primary">
          <div class="box-header with-border">
            <h3 class="box-title">Ubah Detail Barang | <?php echo $nama; ?></h3>
          </div>
          <div class="box-body">
            <form role="form" method="POST">
              <div class="row">
                <div class="col-md-2">
                  <div class="form-group">
                    <label for="nama">Nama :</label>
                    <input type="text" name="nama" id="nama" class="form-control" autocomplete="off" value="<?php echo $nama_navigasi_detail; ?>" required>
                  </div>
                </div>
                <div class="col-md-2">
                  <div class="form-group">
                    <label for="kode">Kode :</label>
                    <input type="text" name="kode" id="kode" class="form-control" autocomplete="off" value="<?php echo $kode; ?>">
                  </div>
                </div>
                <div class="col-md-2">
                  <div class="form-group">
                    <label for="nomor">Nomor :</label>
                    <input type="text" name="nomor" id="nomor" class="form-control" autocomplete="off" value="<?php echo $nomor; ?>">
                  </div>
                </div>
                <div class="col-md-2">
                  <div class="form-group">
                    <label for="file">File :</label>
                    <input type="text" name="file" id="file" class="form-control" autocomplete="off" value="<?php echo $file; ?>" required>
                  </div>
                </div>
                <div class="col-md-2">
                  <div class="form-group">
                    <label for="postfix">Postfix :</label>
                    <input type="text" name="postfix" id="postfix" class="form-control" autocomplete="off" value="<?php echo $postfix; ?>">
                  </div>
                </div>
                <div class="col-md-2">
                  <div class="form-group">
                    <label for="ikon">Ikon :</label>
                    <select id="ikon" name="ikon" class="form-control select2-icon" style="width: 100%;" required>
                      <?php
                      $sql =
                      "SELECT
                        a.nama
                      FROM
                        tb_master_ikon AS a";
                      $sql .= " ORDER BY a.nama ";
                      $res = mysqli_query($db,$sql) OR die('error 695');
                      if(mysqli_num_rows($res) != 0)
                      {
                        while($row = mysqli_fetch_assoc($res))
                        {
                        ?>
                      <option value="<?php echo $row['nama']; ?>" data-icon="<?php echo $row['nama']; ?>" <?php if($row['nama'] == $ikon) echo 'selected'; ?>>&nbsp;<?php echo $row['nama']; ?></option>
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
                  <input type="hidden" name="id_detail" value="<?php echo $id_detail; ?>">
                  <button type="submit" name="tombol_ubah_detail" class="btn btn-sm btn-flat btn-success"><i class="fa fa-sm fa-save"></i> Simpan</button>
                  <a href="?id_nav_detail=<?php echo $id_nav_detail; ?>&page=<?php echo $page; ?>&detail&id=<?php echo $id; ?>&id_detail=<?php echo $id_detail; ?>" class="btn btn-sm btn-flat btn-danger"><i class="fa fa-sm fa-times"></i> Batal</a>
                </div>
              </div>
            </form>
          </div>
          <div class="box-footer"></div>
        </div>
      </div>
    </div>
  </section>
  <?php
    }
    else if(isset($_GET['hapus_detail']))
    {
      $id_detail = fch($_GET['id_detail']);
      $sql = 
      "SELECT
        *
      FROM
        tb_master_navigasi_detail AS a
      WHERE
        a.id_detail = '".$id_detail."'";
      $res = mysqli_query($db,$sql) OR die('error 667');
      if(mysqli_num_rows($res) != 0)
      {
        while($row = mysqli_fetch_assoc($res))
        {
          $nama_navigasi_detail = $row['nama'];
        }
      }
    ?>
  <section class="content">
    <div class="row">
      <div class="col-md-12">
        <div class="box box-primary">
          <div class="box-header with-border">
            <h3 class="box-title">Hapus Detail Barang | <?php echo $nama; ?></h3>
          </div>
          <form role="form" method="POST">
            <div class="box-body">
              <div class="row">
                <div class="col-md-12">
                  <label>Anda Yakin Ingin Menghapus Detail Barang : <b><u><?php echo $nama_navigasi_detail; ?></u></b> ?</label>
                </div>
              </div>
              <br>
              <div class="row">
                <div class="col-md-2">
                  <input type="hidden" name="id" value="<?php echo $id; ?>">
                  <input type="hidden" name="id_detail" value="<?php echo $id_detail; ?>">
                  <input type="hidden" name="nama" value="<?php echo $nama_navigasi_detail; ?>">
                  <button type="submit" name="tombol_hapus_detail" class="btn btn-sm btn-flat btn-success"><i class="fa fa-sm fa-check"></i> Ya</button>
                  <a href="?id_nav_detail=<?php echo $id_nav_detail; ?>&page=<?php echo $page; ?>&detail&id=<?php echo $id; ?>&id_detail=<?php echo $id_detail; ?>"><button type="button" class="btn btn-sm btn-flat btn-danger "><i class="fa fa-sm fa-times"></i> Batal</button></a>
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
    else
    {
    ?>
  <section class="content">
    <div class="row">
      <div class="col-md-12">
        <div class="box box-primary">
          <div class="box-header with-border">
            <h3 class="box-title">Detail Barang | <?php echo $nama; ?></h3>
            <div class="box-tools">
              <div class="box-tools">
                <div class="btn-group">
                  <button type="button" class="btn btn-sm btn-default btn-flat">File</button>
                  <button type="button" class="btn btn-sm btn-default btn-flat dropdown-toggle" data-toggle="dropdown">
                    <span class="caret"></span>
                    <span class="sr-only">Toggle Dropdown</span>
                  </button>
                  <ul class="dropdown-menu" role="menu">
                    <li><a href="?id_nav_detail=<?php echo $id_nav_detail; ?>&page=<?php echo $page; ?>&detail&id=<?php echo $id; ?>&tambah_detail"><i class="fa fa-sm fa-file-o"></i>Tambah</a></li>
                    <li><a href="?id_nav_detail=<?php echo $id_nav_detail; ?>&page=<?php echo $page; ?>&detail&id=<?php echo $id; ?>"><i class="fa fa-sm fa-refresh"></i>Refresh</a></li>
                    <li><a href="?id_nav_detail=<?php echo $id_nav_detail; ?>&page=<?php echo $page; ?>&daftar&id=<?php echo $id; ?>"><i class="fa fa-sm fa-reply"></i>Kembali</a></li>
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
          </div>
          <div class="box-body">
            <?php
            if(isset($_GET['sukses_tambah']))
            {
            ?>
            <div class="alert alert-success" style="padding:5px;">
              <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
              <div style="color:white;">Berhasil Menambah; Detail Barang <b><u><?php echo $_GET['sukses_tambah']; ?></u></b></div>
            </div>
            <?php
            }
            if(isset($_GET['gagal_tambah']))
            {              
            ?>
            <div class="alert alert-danger" style="padding:5px;">
              <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
              <div style="color:white;">Gagal Menambah; Detail Barang <b><u><?php echo $_GET['gagal_tambah']; ?></u></b> Sudah Ada</div>
            </div>
            <?php
            }
            if(isset($_GET['sukses_ubah']))
            {
            ?>
            <div class="alert alert-success" style="padding:5px;">
              <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
              <div style="color:white;">Berhasil Mengubah; Detail Barang <b><u><?php echo $_GET['sukses_ubah']; ?></u></b></div>
            </div>
            <?php
            }
            if(isset($_GET['gagal_ubah']))
            {
            ?>
            <div class="alert alert-danger" style="padding:5px;">
              <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
              <div style="color:white;">Gagal Mengubah; Detail Barang <b><u><?php echo $_GET['gagal_ubah']; ?></u></b> Sudah Ada</div>
            </div>
            <?php
            }
            if(isset($_GET['sukses_hapus']))
            {
            ?>
            <div class="alert alert-success" style="padding:5px;">
              <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
              <div style="color:white;">Berhasil Menghapus; Detail Barang <b><u><?php echo $_GET['sukses_hapus']; ?></u></b></div>
            </div>
            <?php
            }
            ?>
            <div class="table-responsive no-padding">
              <table class="table">
                <?php
                $sql =
                "SELECT
                  a.id_detail,
                  a.id,
                  a.kode,
                  a.nomor,
                  a.nama,
                  a.file,
                  a.postfix,
                  a.posisi,
                  a.ikon,
                  a.aktif,
                  a.created_at,
                  a.updated_at
                FROM
                  tb_master_navigasi_detail AS a
                WHERE
                  a.id = '".$id."'";
                if(isset($_GET['sort_by']))
                {
                  if($_GET['sort_by'] == 'id_detail')
                  { 
                    $sql .= " ORDER BY a.id_detail ".$_GET['order']."";
                  }
                  if($_GET['sort_by'] == 'nama')
                  { 
                    $sql .= " ORDER BY a.nama ".$_GET['order']."";
                  } 
                  if($_GET['sort_by'] == 'kode')
                  { 
                    $sql .= " ORDER BY a.kode ".$_GET['order']."";
                  } 
                  if($_GET['sort_by'] == 'nomor')
                  { 
                    $sql .= " ORDER BY a.nomor ".$_GET['order']."";
                  } 
                  if($_GET['sort_by'] == 'file')
                  { 
                    $sql .= " ORDER BY a.file ".$_GET['order']."";
                  }
                  if($_GET['sort_by'] == 'postfix')
                  { 
                    $sql .= " ORDER BY a.postfix ".$_GET['order']."";
                  } 
                  if($_GET['sort_by'] == 'posisi')
                  { 
                    $sql .= " ORDER BY a.posisi ".$_GET['order']."";
                  }
                  if($_GET['sort_by'] == 'ikon')
                  { 
                    $sql .= " ORDER BY a.ikon ".$_GET['order']."";
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
                  $sql .= " ORDER BY a.id_detail DESC";
                }   
                $res = mysqli_query($db,$sql) OR die('error 682');                    
                if(mysqli_num_rows($res) == 0)
                {
                ?>
                <thead>
                  <tr>
                    <td colspan="13" style="background-color:<?php echo $warna_blok; ?>">Tidak Ada Data Ditemukan</td>
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
                    <th>ID <a <?php if(isset($_GET['sort_by']) AND $_GET['sort_by']=='id_detail' AND $_GET['order']=='desc') echo 'style="color:red;"'; else echo 'style="color:black;"';?> href="?id_nav_detail=<?php echo $id_nav_detail; ?>&page=<?php echo $page; ?>&detail&id=<?php echo $id; ?>&sort_by=id_detail&order=desc"><i class="fa fa-sort-up fa-lg"></i></a><a <?php if(isset($_GET['sort_by']) AND $_GET['sort_by']=='id_detail' AND $_GET['order']=='asc') echo 'style="color:red;"'; else echo 'style="color:black;"';?> href="?id_nav_detail=<?php echo $id_nav_detail; ?>&page=<?php echo $page; ?>&detail&id=<?php echo $id; ?>&sort_by=id_detail&order=asc"><i class="fa fa-sort-down fa-lg"></i></a></th>
                    <th>Nama <a <?php if(isset($_GET['sort_by']) AND $_GET['sort_by']=='nama' AND $_GET['order']=='desc') echo 'style="color:red;"'; else echo 'style="color:black;"';?> href="?id_nav_detail=<?php echo $id_nav_detail; ?>&page=<?php echo $page; ?>&detail&id=<?php echo $id; ?>&sort_by=nama&order=desc"><i class="fa fa-sort-up fa-lg"></i></a><a <?php if(isset($_GET['sort_by']) AND $_GET['sort_by']=='nama' AND $_GET['order']=='asc') echo 'style="color:red;"'; else echo 'style="color:black;"';?> href="?id_nav_detail=<?php echo $id_nav_detail; ?>&page=<?php echo $page; ?>&detail&id=<?php echo $id; ?>&sort_by=nama&order=asc"><i class="fa fa-sort-down fa-lg"></i></a></th>
                    <th>Kode <a <?php if(isset($_GET['sort_by']) AND $_GET['sort_by']=='kode' AND $_GET['order']=='desc') echo 'style="color:red;"'; else echo 'style="color:black;"';?> href="?id_nav_detail=<?php echo $id_nav_detail; ?>&page=<?php echo $page; ?>&detail&id=<?php echo $id; ?>&sort_by=kode&order=desc"><i class="fa fa-sort-up fa-lg"></i></a><a <?php if(isset($_GET['sort_by']) AND $_GET['sort_by']=='kode' AND $_GET['order']=='asc') echo 'style="color:red;"'; else echo 'style="color:black;"';?> href="?id_nav_detail=<?php echo $id_nav_detail; ?>&page=<?php echo $page; ?>&detail&id=<?php echo $id; ?>&sort_by=kode&order=asc"><i class="fa fa-sort-down fa-lg"></i></a></th>
                    <th>Nomor <a <?php if(isset($_GET['sort_by']) AND $_GET['sort_by']=='nomor' AND $_GET['order']=='desc') echo 'style="color:red;"'; else echo 'style="color:black;"';?> href="?id_nav_detail=<?php echo $id_nav_detail; ?>&page=<?php echo $page; ?>&detail&id=<?php echo $id; ?>&sort_by=nomor&order=desc"><i class="fa fa-sort-up fa-lg"></i></a><a <?php if(isset($_GET['sort_by']) AND $_GET['sort_by']=='nomor' AND $_GET['order']=='asc') echo 'style="color:red;"'; else echo 'style="color:black;"';?> href="?id_nav_detail=<?php echo $id_nav_detail; ?>&page=<?php echo $page; ?>&detail&id=<?php echo $id; ?>&sort_by=nomor&order=asc"><i class="fa fa-sort-down fa-lg"></i></a></th>
                    <th>File <a <?php if(isset($_GET['sort_by']) AND $_GET['sort_by']=='file' AND $_GET['order']=='desc') echo 'style="color:red;"'; else echo 'style="color:black;"';?> href="?id_nav_detail=<?php echo $id_nav_detail; ?>&page=<?php echo $page; ?>&detail&id=<?php echo $id; ?>&sort_by=file&order=desc"><i class="fa fa-sort-up fa-lg"></i></a><a <?php if(isset($_GET['sort_by']) AND $_GET['sort_by']=='file' AND $_GET['order']=='asc') echo 'style="color:red;"'; else echo 'style="color:black;"';?> href="?id_nav_detail=<?php echo $id_nav_detail; ?>&page=<?php echo $page; ?>&detail&id=<?php echo $id; ?>&sort_by=file&order=asc"><i class="fa fa-sort-down fa-lg"></i></a></th>
                    <th>Postfix <a <?php if(isset($_GET['sort_by']) AND $_GET['sort_by']=='postfix' AND $_GET['order']=='desc') echo 'style="color:red;"'; else echo 'style="color:black;"';?> href="?id_nav_detail=<?php echo $id_nav_detail; ?>&page=<?php echo $page; ?>&detail&id=<?php echo $id; ?>&sort_by=postfix&order=desc"><i class="fa fa-sort-up fa-lg"></i></a><a <?php if(isset($_GET['sort_by']) AND $_GET['sort_by']=='postfix' AND $_GET['order']=='asc') echo 'style="color:red;"'; else echo 'style="color:black;"';?> href="?id_nav_detail=<?php echo $id_nav_detail; ?>&page=<?php echo $page; ?>&detail&id=<?php echo $id; ?>&sort_by=postfix&order=asc"><i class="fa fa-sort-down fa-lg"></i></a></th>
                    <th>Posisi <a <?php if(isset($_GET['sort_by']) AND $_GET['sort_by']=='posisi' AND $_GET['order']=='desc') echo 'style="color:red;"'; else echo 'style="color:black;"';?> href="?id_nav_detail=<?php echo $id_nav_detail; ?>&page=<?php echo $page; ?>&detail&id=<?php echo $id; ?>&sort_by=posisi&order=desc"><i class="fa fa-sort-up fa-lg"></i></a><a <?php if(isset($_GET['sort_by']) AND $_GET['sort_by']=='posisi' AND $_GET['order']=='asc') echo 'style="color:red;"'; else echo 'style="color:black;"';?> href="?id_nav_detail=<?php echo $id_nav_detail; ?>&page=<?php echo $page; ?>&detail&id=<?php echo $id; ?>&sort_by=posisi&order=asc"><i class="fa fa-sort-down fa-lg"></i></a></th>
                    <th>Ikon <a <?php if(isset($_GET['sort_by']) AND $_GET['sort_by']=='ikon' AND $_GET['order']=='desc') echo 'style="color:red;"'; else echo 'style="color:black;"';?> href="?id_nav_detail=<?php echo $id_nav_detail; ?>&page=<?php echo $page; ?>&detail&id=<?php echo $id; ?>&sort_by=ikon&order=desc"><i class="fa fa-sort-up fa-lg"></i></a><a <?php if(isset($_GET['sort_by']) AND $_GET['sort_by']=='ikon' AND $_GET['order']=='asc') echo 'style="color:red;"'; else echo 'style="color:black;"';?> href="?id_nav_detail=<?php echo $id_nav_detail; ?>&page=<?php echo $page; ?>&detail&id=<?php echo $id; ?>&sort_by=ikon&order=asc"><i class="fa fa-sort-down fa-lg"></i></a></th>
                    <th>Status <a <?php if(isset($_GET['sort_by']) AND $_GET['sort_by']=='aktif' AND $_GET['order']=='desc') echo 'style="color:red;"'; else echo 'style="color:black;"';?> href="?id_nav_detail=<?php echo $id_nav_detail; ?>&page=<?php echo $page; ?>&detail&id=<?php echo $id; ?>&sort_by=aktif&order=desc"><i class="fa fa-sort-up fa-lg"></i></a><a <?php if(isset($_GET['sort_by']) AND $_GET['sort_by']=='aktif' AND $_GET['order']=='asc') echo 'style="color:red;"'; else echo 'style="color:black;"';?> href="?id_nav_detail=<?php echo $id_nav_detail; ?>&page=<?php echo $page; ?>&detail&id=<?php echo $id; ?>&sort_by=aktif&order=asc"><i class="fa fa-sort-down fa-lg"></i></a></th>
                    <th>Created At <a <?php if(isset($_GET['sort_by']) AND $_GET['sort_by']=='created_at' AND $_GET['order']=='desc') echo 'style="color:red;"'; else echo 'style="color:black;"';?> href="?id_nav_detail=<?php echo $id_nav_detail; ?>&page=<?php echo $page; ?>&detail&id=<?php echo $id; ?>&sort_by=created_at&order=desc"><i class="fa fa-sort-up fa-lg"></i></a><a <?php if(isset($_GET['sort_by']) AND $_GET['sort_by']=='created_at' AND $_GET['order']=='asc') echo 'style="color:red;"'; else echo 'style="color:black;"';?> href="?id_nav_detail=<?php echo $id_nav_detail; ?>&page=<?php echo $page; ?>&detail&id=<?php echo $id; ?>&sort_by=created_at&order=asc"><i class="fa fa-sort-down fa-lg"></i></a></th>
                    <th>Updated At <a <?php if(isset($_GET['sort_by']) AND $_GET['sort_by']=='updated_at' AND $_GET['order']=='desc') echo 'style="color:red;"'; else echo 'style="color:black;"';?> href="?id_nav_detail=<?php echo $id_nav_detail; ?>&page=<?php echo $page; ?>&detail&id=<?php echo $id; ?>&sort_by=updated_at&order=desc"><i class="fa fa-sort-up fa-lg"></i></a><a <?php if(isset($_GET['sort_by']) AND $_GET['sort_by']=='updated_at' AND $_GET['order']=='asc') echo 'style="color:red;"'; else echo 'style="color:black;"';?> href="?id_nav_detail=<?php echo $id_nav_detail; ?>&page=<?php echo $page; ?>&detail&id=<?php echo $id; ?>&sort_by=updated_at&order=asc"><i class="fa fa-sort-down fa-lg"></i></a></th>
                    <th colspan="2">Aksi</th>
                  </tr>
                </thead>
                <tbody>
                  <?php   
                  $nomor = 1;   
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
                  <tr style="<?php if(isset($_GET['id_detail']) AND $row['id_detail']==$_GET['id_detail']) echo 'background-color:'.$warna_blok; else if ($nomor % 2 == 0) { echo $background_ganjil; } else { echo $background_genap; }?>" class="tr-hover">
                    <td><?php echo $nomor++; ?></td>
                    <td><?php echo $row['id_detail']; ?></td>
                    <td><?php echo $row['nama']; ?></td>
                    <td><?php echo $row['kode']; ?></td>
                    <td><?php echo $row['nomor']; ?></td>
                    <td><?php echo $row['file']; ?></td>
                    <td><?php echo $row['postfix']; ?></td>
                    <td><?php echo $row['posisi']; ?></td>
                    <td><i class="fa fa-sm <?php echo $row['ikon']; ?>"></i> <?php echo $row['ikon']; ?></td>
                    <td><span class=" label label-<?php echo $label; ?>"><?php echo $status; ?></span></td>
                    <td><?php echo date('d-M-Y H:i:s',strtotime($row['created_at'])); ?></td>
                    <td><?php echo date('d-M-Y H:i:s',strtotime($row['updated_at'])); ?></td>
                    <td><a class="fa fa-lg fa-pencil" style="cursor: pointer;color:darkblue;text-decoration: none;" href="?id_nav_detail=<?php echo $id_nav_detail; ?>&page=<?php echo $page; ?>&detail&id=<?php echo $row['id']; ?>&ubah_detail&id_detail=<?php echo $row['id_detail']; ?>"></a></td>
                    <td><a class="fa fa-lg fa-trash-o " style="cursor: pointer;color:red;text-decoration: none;" href="?id_nav_detail=<?php echo $id_nav_detail; ?>&page=<?php echo $page; ?>&detail&id=<?php echo $row['id']; ?>&hapus_detail&id_detail=<?php echo $row['id_detail']; ?>"></a></td>
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
              a.tabel = 'tb_master_navigasi_detail'"; 
            $sql.=" ORDER BY a.created_at DESC LIMIT 1";
            $res=mysqli_query($db,$sql) OR die('error 1275');
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
            <h3 class="box-title">Tambah Barang</h3>
          </div>
          <form role="form" method="POST">
            <div class="box-body">
              <div class="row">
                <div class="col-md-1">
                  <div class="form-group">
                    <label for="prefix">Prefix :</label>
                    <select id="prefix" name="prefix" class="form-control select2" style="width: 100%;" onchange="cekKodeTerakhir(this.value);" required>
                      <option value="">Pilih..</option>
                      <?php
                      $sql =
                      "SELECT
                        a.prefix
                      FROM
                        tb_master_barang_prefix AS a
                      WHERE
                        a.aktif = 1";
                      $sql .= " ORDER BY a.prefix ";
                      $res = mysqli_query($db,$sql) OR die(alert_php('error 1348'));
                      if(mysqli_num_rows($res) != 0)
                      {
                        while($row = mysqli_fetch_assoc($res))
                        {
                        ?>
                      <option value="<?php echo $row['prefix']; ?>"><?php echo $row['prefix']; ?></option>
                      <?php
                        }
                      } 
                      ?>
                    </select>
                  </div>
                </div>
                <div class="col-md-1">
                  <div class="form-group">
                    <label for="counter">Counter :</label>
                    <input readonly type="text" name="counter" id="counter" class="form-control" autocomplete="off" required>
                  </div>
                </div>
                <div class="col-md-9">
                  <div class="form-group">
                    <label for="barang">Barang :</label>
                    <input type="text" name="barang" id="barang" class="form-control" autocomplete="off" required>
                  </div>
                </div>
                <div class="col-md-1">
                  <div class="form-group">
                    <label for="satuan">Satuan :</label>
                    <select id="satuan" name="satuan" class="form-control select2" style="width: 100%;" required>
                      <option value="">Pilih..</option>
                      <?php
                      $sql =
                      "SELECT
                        a.satuan
                      FROM
                        tb_master_barang_satuan AS a
                      WHERE
                       a.aktif = 1";
                      $sql .= " ORDER BY a.satuan ";
                      $res = mysqli_query($db,$sql) OR die(alert_php('error 1389'));
                      if(mysqli_num_rows($res) != 0)
                      {
                        while($row = mysqli_fetch_assoc($res))
                        {
                        ?>
                      <option value="<?php echo $row['satuan']; ?>"><?php echo $row['satuan']; ?></option>
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
                    <label for="id_level_1">Level 1 :</label>
                    <select id="id_level_1" name="id_level_1" class="form-control select2" style="width: 100%;" required>
                      <option value="">Pilih..</option>
                      <?php
                      $sql =
                      "SELECT
                        a.id,
                        a.level_1
                      FROM
                        tb_master_barang_level_1 AS a
                      WHERE
                        a.aktif = 1";
                      $sql .= " ORDER BY a.level_1 "; 
                      $res = mysqli_query($db,$sql) OR die(alert_php('error 1472'));
                      if(mysqli_num_rows($res) != 0)
                      {
                        while($row = mysqli_fetch_assoc($res))
                        {
                        ?>
                      <option value="<?php echo $row['id']; ?>"><?php echo $row['level_1']; ?></option>
                      <?php
                        }
                      } 
                      ?>
                    </select>
                  </div>
                </div>
                <div class="col-md-2">
                  <div class="form-group">
                    <label for="id_level_2">Level 2 :</label>
                    <select id="id_level_2" name="id_level_2" class="form-control select2" style="width: 100%;" required>
                      <option value="">Pilih..</option>
                      <?php
                      $sql =
                      "SELECT
                        a.id,
                        a.level_2
                      FROM
                        tb_master_barang_level_2 AS a
                      WHERE
                        a.aktif = 1";
                      $sql .= " ORDER BY a.level_2 "; 
                      $res = mysqli_query($db,$sql) OR die(alert_php('error 1475'));
                      if(mysqli_num_rows($res) != 0)
                      {
                        while($row = mysqli_fetch_assoc($res))
                        {
                        ?>
                      <option value="<?php echo $row['id']; ?>"><?php echo $row['level_2']; ?></option>
                      <?php
                        }
                      } 
                      ?>
                    </select>
                  </div>
                </div>
                <div class="col-md-1">
                  <div class="form-group">
                    <label for="pembagi">Pembagi :</label>
                    <input type="text" name="pembagi" id="pembagi" class="form-control" autocomplete="off" value="1" required>
                  </div>
                </div>
                <div class="col-md-1">
                  <div class="form-group">
                    <label for="minimum_stok">Min Stok :</label>
                    <input type="text" name="minimum_stok" id="minimum_stok" class="form-control" autocomplete="off" value="4" required>
                  </div>
                </div>
                <div class="col-md-1">
                  <div class="form-group">
                    <label for="lead_time">Lead Time :</label>
                    <input type="text" name="lead_time" id="lead_time" class="form-control" autocomplete="off" value="2" required>
                  </div>
                </div>
                <div class="col-md-1">
                  <div class="form-group">
                    <label for="reorder_qty">Reorder Qty :</label>
                    <input type="text" name="reorder_qty" id="reorder_qty" class="form-control" autocomplete="off" value="4" required>
                  </div>
                </div>
                <div class="col-md-2">
                  <div class="form-group">
                    <label for="id_golongan">Golongan :</label>
                    <select id="id_golongan" name="id_golongan" class="form-control select2" style="width: 100%;" required>
                      <option value="">Pilih..</option>
                      <?php
                      $sql =
                      "SELECT
                        a.id,
                        a.golongan
                      FROM
                        tb_master_barang_golongan AS a
                      WHERE
                        a.aktif = 1";
                      $sql .= " ORDER BY a.golongan "; 
                      $res = mysqli_query($db,$sql) OR die(alert_php('error 1531'));
                      if(mysqli_num_rows($res) != 0)
                      {
                        while($row = mysqli_fetch_assoc($res))
                        {
                        ?>
                      <option value="<?php echo $row['id']; ?>"><?php echo $row['golongan']; ?></option>
                      <?php
                        }
                      } 
                      ?>
                    </select>
                  </div>
                </div>
                <div class="col-md-2">
                  <div class="form-group">
                    <label for="id_akun_pembukuan">Akun Pembukuan :</label>
                    <select id="id_akun_pembukuan" name="id_akun_pembukuan" class="form-control select2" style="width: 100%;" required>
                      <option value="">Pilih..</option>
                      <?php
                      $sql =
                      "SELECT
                        a.id,
                        a.kode,
                        a.akun
                      FROM
                        tb_master_akun_pembukuan AS a
                      WHERE
                        a.induk_or_detail = 'd' AND
                        a.aktif = 1";
                      $sql .= " ORDER BY a.kode ";
                      $res = mysqli_query($db,$sql) OR die(alert_php('error 1564'));
                      if(mysqli_num_rows($res) != 0)
                      {
                        while($row = mysqli_fetch_assoc($res))
                        {
                        ?>
                      <option value="<?php echo $row['id']; ?>"><?php echo $row['kode']; ?> - <?php echo $row['akun']; ?></option>
                      <?php
                        }
                      } 
                      ?>
                    </select>
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-md-11">
                  <div class="form-group">
                    <label for="catatan">Catatan :</label>
                    <input type="text" name="catatan" id="catatan" class="form-control" autocomplete="off" value="-" required>
                  </div>
                </div>
                <div class="col-md-1">
                  <div class="form-group">
                    <label for="aktif">Status :</label>
                    <select id="aktif" name="aktif" class="form-control select2" style="width: 100%;" required>
                      <option value="">Pilih..</option>
                      <option value="1" selected>Aktif</option>
                      <option value="0">Non Aktif</option>
                    </select>
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-md-3">
                  <div class="form-group">
                    <label for="id_tipe_aktiva">Tipe Aktiva :</label>
                    <select id="id_tipe_aktiva" name="id_tipe_aktiva" class="form-control select2" style="width: 100%;" required>
                      <option value="">Pilih..</option>
                      <?php
                      $sql =
                      "SELECT
                        a.id,
                        a.tipe,
                        a.kode
                      FROM
                        tb_master_aktiva_tipe AS a
                      WHERE
                        a.aktif = 1";
                      $sql .= " ORDER BY a.tipe ";
                      $res = mysqli_query($db,$sql) OR die(alert_php('error 1504'));
                      if(mysqli_num_rows($res) != 0)
                      {
                        while($row = mysqli_fetch_assoc($res))
                        {
                        ?>
                      <option value="<?php echo $row['id']; ?>"><?php echo $row['tipe']; ?> (<?php echo $row['kode']; ?>)</option>
                      <?php
                        }
                      } 
                      ?>
                    </select>
                  </div>
                </div>
                <div class="col-md-3">
                  <div class="form-group">
                    <label for="id_kelompok_aktiva">Kelompok Aktiva :</label>
                    <select id="id_kelompok_aktiva" name="id_kelompok_aktiva" class="form-control select2" style="width: 100%;" required>
                      <option value="">Pilih..</option>
                      <?php
                      $sql =
                      "SELECT
                        a.id,
                        a.kelompok,
                        a.kode
                      FROM
                        tb_master_aktiva_kelompok AS a
                      WHERE
                        a.aktif = 1";
                      $sql .= " ORDER BY a.kelompok ";
                      $res = mysqli_query($db,$sql) OR die(alert_php('error 1534'));
                      if(mysqli_num_rows($res) != 0)
                      {
                        while($row = mysqli_fetch_assoc($res))
                        {
                        ?>
                      <option value="<?php echo $row['id']; ?>"><?php echo $row['kelompok']; ?> (<?php echo $row['kode']; ?>)</option>
                      <?php
                        }
                      } 
                      ?>
                    </select>
                  </div>
                </div>
                <div class="col-md-3">
                  <div class="form-group">
                    <label for="id_akun_akumulasi_penyusutan_aktiva">Akun Akumulasi Penyusutan Aktiva :</label>
                    <select id="id_akun_akumulasi_penyusutan_aktiva" name="id_akun_akumulasi_penyusutan_aktiva" class="form-control select2" style="width: 100%;" required>
                      <option value="">Pilih..</option>
                      <?php
                      $sql =
                      "SELECT
                        a.id,
                        a.kode,
                        a.akun
                      FROM
                        tb_master_akun_pembukuan AS a
                      WHERE
                        a.id_tipe = 6 AND
                        a.induk_or_detail = 'd' AND
                        a.aktif = 1";
                      $sql .= " ORDER BY a.kode ";
                      $res = mysqli_query($db,$sql) OR die(alert_php('error 1473'));
                      if(mysqli_num_rows($res) != 0)
                      {
                        while($row = mysqli_fetch_assoc($res))
                        {
                        ?>
                      <option value="<?php echo $row['id']; ?>"><?php echo $row['kode']; ?> - <?php echo $row['akun']; ?></option>
                      <?php
                        }
                      } 
                      ?>
                    </select>
                  </div>
                </div>
                <div class="col-md-3">
                  <div class="form-group">
                    <label for="id_akun_beban_penyusutan_aktiva">Akun Beban Penyusutan Aktiva :</label>
                    <select id="id_akun_beban_penyusutan_aktiva" name="id_akun_beban_penyusutan_aktiva" class="form-control select2" style="width: 100%;" required>
                      <option value="">Pilih..</option>
                      <?php
                      $sql =
                      "SELECT
                        a.id,
                        a.kode,
                        a.akun
                      FROM
                        tb_master_akun_pembukuan AS a
                      WHERE
                        a.akun LIKE '%beban penyusutan%' AND 
                        a.induk_or_detail = 'd' AND
                        a.aktif = 1";
                      $sql .= " ORDER BY a.kode ";
                      $res = mysqli_query($db,$sql) OR die(alert_php('error 1539'));
                      if(mysqli_num_rows($res) != 0)
                      {
                        while($row = mysqli_fetch_assoc($res))
                        {
                        ?>
                      <option value="<?php echo $row['id']; ?>"><?php echo $row['kode']; ?> - <?php echo $row['akun']; ?></option>
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
      a.kode,
      a.barang,
      a.satuan,
      a.id_grup,
      a.id_level_1,
      a.id_level_2,
      a.id_golongan,
      a.minimum_stok,
      a.lead_time,
      a.reorder_qty,
      a.pembagi,
      a.id_akun_pembukuan,
      a.id_tipe_aktiva,
      a.id_kelompok_aktiva,
      a.id_akun_akumulasi_penyusutan,
      a.id_akun_beban_penyusutan,
      a.catatan,      
      a.aktif
    FROM
      tb_master_barang AS a
    WHERE
      a.id = '".$id."'";
    $res = mysqli_query($db,$sql) OR die(alert_php('error 1761'));
    if(mysqli_num_rows($res) != 0)
    {
      while($row = mysqli_fetch_assoc($res))
      {
        $kode = $row['kode'];
        $barang = $row['barang'];
        $satuan = $row['satuan'];   
        $id_grup = $row['id_grup'];
        $id_level_1 = $row['id_level_1'];
        $id_level_2 = $row['id_level_2'];
        $id_golongan = $row['id_golongan'];
        $minimum_stok = $row['minimum_stok'];
        $lead_time = $row['lead_time'];
        $reorder_qty = $row['reorder_qty'];
        $pembagi = $row['pembagi'];
        $id_akun_pembukuan = $row['id_akun_pembukuan'];
        $id_tipe_aktiva = $row['id_tipe_aktiva'];
        $id_kelompok_aktiva = $row['id_kelompok_aktiva'];
        $id_akun_akumulasi_penyusutan = $row['id_akun_akumulasi_penyusutan'];
        $id_akun_beban_penyusutan = $row['id_akun_beban_penyusutan'];
        $catatan = $row['catatan'];
        $aktif = $row['aktif'];             
      }
    }
  ?>
  <section class="content">
    <div class="row">
      <div class="col-md-12">
        <div class="box box-primary">
          <div class="box-header with-border">
            <h3 class="box-title">Ubah Barang</h3>
          </div>
          <form role="form" method="POST">
            <div class="box-body">
              <div class="row">
                <div class="col-md-1">
                  <div class="form-group">
                    <label for="prefix">Prefix :</label>
                    <select id="prefix" name="prefix" class="form-control select2" style="width: 100%;" onchange="cekKodeTerakhir(this.value);" required>
                      <option value="">Pilih..</option>
                      <?php
                      $sql =
                      "SELECT
                        a.prefix
                      FROM
                        tb_master_barang_prefix AS a
                      WHERE
                        a.aktif = 1";
                      $sql .= " ORDER BY a.prefix ";
                      $res = mysqli_query($db,$sql) OR die(alert_php('error 1348'));
                      if(mysqli_num_rows($res) != 0)
                      {
                        while($row = mysqli_fetch_assoc($res))
                        {
                        ?>
                      <option value="<?php echo $row['prefix']; ?>"><?php echo $row['prefix']; ?></option>
                      <?php
                        }
                      } 
                      ?>
                    </select>
                  </div>
                </div>
                <div class="col-md-1">
                  <div class="form-group">
                    <label for="counter">Counter :</label>
                    <input readonly type="text" name="counter" id="counter" class="form-control" autocomplete="off" required>
                  </div>
                </div>
                <div class="col-md-9">
                  <div class="form-group">
                    <label for="barang">Barang :</label>
                    <input type="text" name="barang" id="barang" class="form-control" autocomplete="off" required>
                  </div>
                </div>
                <div class="col-md-1">
                  <div class="form-group">
                    <label for="satuan">Satuan :</label>
                    <select id="satuan" name="satuan" class="form-control select2" style="width: 100%;" required>
                      <option value="">Pilih..</option>
                      <?php
                      $sql =
                      "SELECT
                        a.satuan
                      FROM
                        tb_master_barang_satuan AS a
                      WHERE
                       a.aktif = 1";
                      $sql .= " ORDER BY a.satuan ";
                      $res = mysqli_query($db,$sql) OR die(alert_php('error 1389'));
                      if(mysqli_num_rows($res) != 0)
                      {
                        while($row = mysqli_fetch_assoc($res))
                        {
                        ?>
                      <option value="<?php echo $row['satuan']; ?>"><?php echo $row['satuan']; ?></option>
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
                    <label for="id_level_1">Level 1 :</label>
                    <select id="id_level_1" name="id_level_1" class="form-control select2" style="width: 100%;" required>
                      <option value="">Pilih..</option>
                      <?php
                      $sql =
                      "SELECT
                        a.id,
                        a.level_1
                      FROM
                        tb_master_barang_level_1 AS a
                      WHERE
                        a.aktif = 1";
                      $sql .= " ORDER BY a.level_1 "; 
                      $res = mysqli_query($db,$sql) OR die(alert_php('error 1472'));
                      if(mysqli_num_rows($res) != 0)
                      {
                        while($row = mysqli_fetch_assoc($res))
                        {
                        ?>
                      <option value="<?php echo $row['id']; ?>"><?php echo $row['level_1']; ?></option>
                      <?php
                        }
                      } 
                      ?>
                    </select>
                  </div>
                </div>
                <div class="col-md-2">
                  <div class="form-group">
                    <label for="id_level_2">Level 2 :</label>
                    <select id="id_level_2" name="id_level_2" class="form-control select2" style="width: 100%;" required>
                      <option value="">Pilih..</option>
                      <?php
                      $sql =
                      "SELECT
                        a.id,
                        a.level_2
                      FROM
                        tb_master_barang_level_2 AS a
                      WHERE
                        a.aktif = 1";
                      $sql .= " ORDER BY a.level_2 "; 
                      $res = mysqli_query($db,$sql) OR die(alert_php('error 1475'));
                      if(mysqli_num_rows($res) != 0)
                      {
                        while($row = mysqli_fetch_assoc($res))
                        {
                        ?>
                      <option value="<?php echo $row['id']; ?>"><?php echo $row['level_2']; ?></option>
                      <?php
                        }
                      } 
                      ?>
                    </select>
                  </div>
                </div>
                <div class="col-md-1">
                  <div class="form-group">
                    <label for="pembagi">Pembagi :</label>
                    <input type="text" name="pembagi" id="pembagi" class="form-control" autocomplete="off" value="1" required>
                  </div>
                </div>
                <div class="col-md-1">
                  <div class="form-group">
                    <label for="minimum_stok">Min Stok :</label>
                    <input type="text" name="minimum_stok" id="minimum_stok" class="form-control" autocomplete="off" value="4" required>
                  </div>
                </div>
                <div class="col-md-1">
                  <div class="form-group">
                    <label for="lead_time">Lead Time :</label>
                    <input type="text" name="lead_time" id="lead_time" class="form-control" autocomplete="off" value="2" required>
                  </div>
                </div>
                <div class="col-md-1">
                  <div class="form-group">
                    <label for="reorder_qty">Reorder Qty :</label>
                    <input type="text" name="reorder_qty" id="reorder_qty" class="form-control" autocomplete="off" value="4" required>
                  </div>
                </div>
                <div class="col-md-2">
                  <div class="form-group">
                    <label for="id_golongan">Golongan :</label>
                    <select id="id_golongan" name="id_golongan" class="form-control select2" style="width: 100%;" required>
                      <option value="">Pilih..</option>
                      <?php
                      $sql =
                      "SELECT
                        a.id,
                        a.golongan
                      FROM
                        tb_master_barang_golongan AS a
                      WHERE
                        a.aktif = 1";
                      $sql .= " ORDER BY a.golongan "; 
                      $res = mysqli_query($db,$sql) OR die(alert_php('error 1531'));
                      if(mysqli_num_rows($res) != 0)
                      {
                        while($row = mysqli_fetch_assoc($res))
                        {
                        ?>
                      <option value="<?php echo $row['id']; ?>"><?php echo $row['golongan']; ?></option>
                      <?php
                        }
                      } 
                      ?>
                    </select>
                  </div>
                </div>
                <div class="col-md-2">
                  <div class="form-group">
                    <label for="id_akun_pembukuan">Akun Pembukuan :</label>
                    <select id="id_akun_pembukuan" name="id_akun_pembukuan" class="form-control select2" style="width: 100%;" required>
                      <option value="">Pilih..</option>
                      <?php
                      $sql =
                      "SELECT
                        a.id,
                        a.kode,
                        a.akun
                      FROM
                        tb_master_akun_pembukuan AS a
                      WHERE
                        a.induk_or_detail = 'd' AND
                        a.aktif = 1";
                      $sql .= " ORDER BY a.kode ";
                      $res = mysqli_query($db,$sql) OR die(alert_php('error 1564'));
                      if(mysqli_num_rows($res) != 0)
                      {
                        while($row = mysqli_fetch_assoc($res))
                        {
                        ?>
                      <option value="<?php echo $row['id']; ?>"><?php echo $row['kode']; ?> - <?php echo $row['akun']; ?></option>
                      <?php
                        }
                      } 
                      ?>
                    </select>
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-md-11">
                  <div class="form-group">
                    <label for="catatan">Catatan :</label>
                    <input type="text" name="catatan" id="catatan" class="form-control" autocomplete="off" value="-" required>
                  </div>
                </div>
                <div class="col-md-1">
                  <div class="form-group">
                    <label for="aktif">Status :</label>
                    <select id="aktif" name="aktif" class="form-control select2" style="width: 100%;" required>
                      <option value="">Pilih..</option>
                      <option value="1" selected>Aktif</option>
                      <option value="0">Non Aktif</option>
                    </select>
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-md-3">
                  <div class="form-group">
                    <label for="id_tipe_aktiva">Tipe Aktiva :</label>
                    <select id="id_tipe_aktiva" name="id_tipe_aktiva" class="form-control select2" style="width: 100%;" required>
                      <option value="">Pilih..</option>
                      <?php
                      $sql =
                      "SELECT
                        a.id,
                        a.tipe,
                        a.kode
                      FROM
                        tb_master_aktiva_tipe AS a
                      WHERE
                        a.aktif = 1";
                      $sql .= " ORDER BY a.tipe ";
                      $res = mysqli_query($db,$sql) OR die(alert_php('error 1504'));
                      if(mysqli_num_rows($res) != 0)
                      {
                        while($row = mysqli_fetch_assoc($res))
                        {
                        ?>
                      <option value="<?php echo $row['id']; ?>"><?php echo $row['tipe']; ?> (<?php echo $row['kode']; ?>)</option>
                      <?php
                        }
                      } 
                      ?>
                    </select>
                  </div>
                </div>
                <div class="col-md-3">
                  <div class="form-group">
                    <label for="id_kelompok_aktiva">Kelompok Aktiva :</label>
                    <select id="id_kelompok_aktiva" name="id_kelompok_aktiva" class="form-control select2" style="width: 100%;" required>
                      <option value="">Pilih..</option>
                      <?php
                      $sql =
                      "SELECT
                        a.id,
                        a.kelompok,
                        a.kode
                      FROM
                        tb_master_aktiva_kelompok AS a
                      WHERE
                        a.aktif = 1";
                      $sql .= " ORDER BY a.kelompok ";
                      $res = mysqli_query($db,$sql) OR die(alert_php('error 1534'));
                      if(mysqli_num_rows($res) != 0)
                      {
                        while($row = mysqli_fetch_assoc($res))
                        {
                        ?>
                      <option value="<?php echo $row['id']; ?>"><?php echo $row['kelompok']; ?> (<?php echo $row['kode']; ?>)</option>
                      <?php
                        }
                      } 
                      ?>
                    </select>
                  </div>
                </div>
                <div class="col-md-3">
                  <div class="form-group">
                    <label for="id_akun_akumulasi_penyusutan_aktiva">Akun Akumulasi Penyusutan Aktiva :</label>
                    <select id="id_akun_akumulasi_penyusutan_aktiva" name="id_akun_akumulasi_penyusutan_aktiva" class="form-control select2" style="width: 100%;" required>
                      <option value="">Pilih..</option>
                      <?php
                      $sql =
                      "SELECT
                        a.id,
                        a.kode,
                        a.akun
                      FROM
                        tb_master_akun_pembukuan AS a
                      WHERE
                        a.id_tipe = 6 AND
                        a.induk_or_detail = 'd' AND
                        a.aktif = 1";
                      $sql .= " ORDER BY a.kode ";
                      $res = mysqli_query($db,$sql) OR die(alert_php('error 1473'));
                      if(mysqli_num_rows($res) != 0)
                      {
                        while($row = mysqli_fetch_assoc($res))
                        {
                        ?>
                      <option value="<?php echo $row['id']; ?>"><?php echo $row['kode']; ?> - <?php echo $row['akun']; ?></option>
                      <?php
                        }
                      } 
                      ?>
                    </select>
                  </div>
                </div>
                <div class="col-md-3">
                  <div class="form-group">
                    <label for="id_akun_beban_penyusutan_aktiva">Akun Beban Penyusutan Aktiva :</label>
                    <select id="id_akun_beban_penyusutan_aktiva" name="id_akun_beban_penyusutan_aktiva" class="form-control select2" style="width: 100%;" required>
                      <option value="">Pilih..</option>
                      <?php
                      $sql =
                      "SELECT
                        a.id,
                        a.kode,
                        a.akun
                      FROM
                        tb_master_akun_pembukuan AS a
                      WHERE
                        a.akun LIKE '%beban penyusutan%' AND 
                        a.induk_or_detail = 'd' AND
                        a.aktif = 1";
                      $sql .= " ORDER BY a.kode ";
                      $res = mysqli_query($db,$sql) OR die(alert_php('error 1539'));
                      if(mysqli_num_rows($res) != 0)
                      {
                        while($row = mysqli_fetch_assoc($res))
                        {
                        ?>
                      <option value="<?php echo $row['id']; ?>"><?php echo $row['kode']; ?> - <?php echo $row['akun']; ?></option>
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
//PAGE_UBAH

//PAGE_HAPUS
  if(isset($_GET['hapus']))
  {
    $id = fch($_GET['id']);
    $sql =
    "SELECT
      a.nama
    FROM
      tb_master_barang AS a
    WHERE
      a.id = '".$id."'";
    $res = mysqli_query($db,$sql) OR die(alert_php('1094'));
    if(mysqli_num_rows($res) != 0)
    {
      while($row = mysqli_fetch_assoc($res))
      {
        $nama = $row['nama'];     
      }
    }
  ?>
  <section class="content">
    <div class="row">
      <div class="col-md-12">
        <div class="box box-primary">
          <div class="box-header with-border">
            <h3 class="box-title">Hapus Barang</h3>
          </div>
          <form role="form" method="POST">
            <div class="box-body">
              <div class="row">
                <div class="col-md-12">
                  <label>Anda Yakin Ingin Menghapus Barang : <b><u><?php echo $nama; ?></u></b> ?</label>
                </div>
              </div>
              <br>
              <div class="row">
                <div class="col-md-2">
                  <input type="hidden" name="id" value="<?php echo $id; ?>">
                  <input type="hidden" name="nama" value="<?php echo $nama; ?>">
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
              <div class="col-md-2">
                <div class="form-group">
                  <label>Kode : </label>
                  <input type="text" name="kode" autocomplete="off" class="form-control" value="<?php if(isset($_SESSION['kode_'.$id_nav_detail])) echo $_SESSION['kode_'.$id_nav_detail]; ?>">
                </div>
              </div>
              <div class="col-md-4">
                <div class="form-group">
                  <label>Barang : </label>
                  <input type="text" name="barang" autocomplete="off" class="form-control" value="<?php if(isset($_SESSION['barang_'.$id_nav_detail])) echo $_SESSION['barang_'.$id_nav_detail]; ?>">
                </div>
              </div>
              <div class="col-md-2">
                <div class="form-group">
                  <label>Satuan : </label>
                  <select name="satuan" class="form-control select2" style="width: 100%;">
                    <option value="">Semua</option>
                    <?php
                    $sql =
                    "SELECT
                      a.satuan
                    FROM
                      tb_master_barang_satuan AS a
                    WHERE
                      a.aktif = 1";
                    $sql .= " ORDER BY a.satuan";
                    $res = mysqli_query($db,$sql) OR die(alert_php('error 1930'));
                    if(mysqli_num_rows($res) != 0)
                    {
                      while($row = mysqli_fetch_assoc($res))
                      {
                      ?>
                    <option value="<?php echo $row['satuan']; ?>" <?php if(isset($_SESSION['satuan_'.$id_nav_detail]) AND $row['satuan'] == $_SESSION['satuan_'.$id_nav_detail]) echo 'selected'; ?>><?php echo $row['satuan']; ?></option>
                    <?php
                      }
                    }
                    ?>
                  </select>
                </div>
              </div>
              <div class="col-md-2">
                <div class="form-group">
                  <label>Status : </label>
                  <select name="aktif" class="form-control select2" style="width: 100%;">
                    <option value="" <?php if(isset($_SESSION['aktif_'.$id_nav_detail]) AND $_SESSION['aktif_'.$id_nav_detail] == '') echo 'selected';?>>Semua</option>
                    <option value="1" <?php if(isset($_SESSION['aktif_'.$id_nav_detail]) AND $_SESSION['aktif_'.$id_nav_detail] == 1) echo 'selected';?>>Aktif</option>
                    <option value="0" <?php if(isset($_SESSION['aktif_'.$id_nav_detail]) AND $_SESSION['aktif_'.$id_nav_detail] == '0') echo 'selected';?>>Non Aktif</option>
                  </select>
                </div>
              </div>
              <div class="col-md-2">
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