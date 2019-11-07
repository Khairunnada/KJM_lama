<?php include 'template/kerangkaAtas.php'; ?>
<?php
if(isset($_GET['refresh']))
{
  unset($_SESSION['tombol_filter_'.$id_nav_detail]);
  unset($_SESSION['lokasi'.$id_nav_detail]);
  unset($_SESSION['aktif_'.$id_nav_detail]);
  unset($_SESSION['data_per_halaman_'.$id_nav_detail]);
  navigasi_ke('?id_nav_detail='.$id_nav_detail.'&daftar');
}
if(isset($_GET['pdf']))
{
  navigasi_ke('master-lokasi-pdf.php');
}
if(isset($_GET['excel']))
{
  navigasi_ke('master-lokasi-excel.php');
}
if(isset($_POST['tombol_tambah']))
{
  unset($_SESSION['tombol_filter_'.$id_nav_detail]);  
  $lokasi = fch($_POST['lokasi']);
  $aktif = fch($_POST['aktif']);  
  $sql =
  "SELECT
    a.id
  FROM
    tb_master_lokasi as a
  WHERE
    a.lokasi = '".$lokasi."'";
  $res = mysqli_query($db,$sql) OR die(alert_php('error 33'));
  if(mysqli_num_rows($res) != 0)
  {
    navigasi_ke('?id_nav_detail='.$id_nav_detail.'&daftar&gagal_tambah='.$lokasi);
  }
  else
  {
    $sql = 
    "INSERT INTO
      tb_master_lokasi
    VALUES
    (
      default,
      '".$lokasi."',
      '".$aktif."',
      0,
      '".$id_user."',
      NOW(),
      NOW()
    )"; 
    mysqli_query($db,$sql) OR die(alert_php('error 53'));  
    $id = mysqli_insert_id($db);
    insertLog($tabel,$id,$aksi); 
    /*$sql =
    "INSERT INTO
      tb_log
    VALUES
    (
      default,
      'tb_master_lokasi',
      '".$id."',
      'insert',
      '".$id_user."',      
      NOW(),
      NOW()
    )";
    mysqli_query($db,$sql) OR die(alert_php('error 68'));*/
    //navigasi_ke('?id_nav_detail='.$id_nav_detail.'&daftar&sukses_tambah='.$lokasi);
  }
}
if(isset($_POST['tombol_ubah']))
{
  $id = fch($_POST['id']);
  $lokasi = fch($_POST['lokasi']);
  $aktif = fch($_POST['aktif']);  
  $sql =
  "SELECT
    a.id
  FROM
    tb_master_lokasi as a
  WHERE    
    a.lokasi = '".$lokasi."' AND
    a.id <> '".$id."' AND
    a.hapus = 0";
  $res = mysqli_query($db,$sql) OR die(alert_php('error 86'));
  if(mysqli_num_rows($res) != 0)
  {
    navigasi_ke('?id_nav_detail='.$id_nav_detail.'&page='.$page.'&daftar&id='.$id.'&gagal_ubah='.$lokasi);
  }
  else
  {
    $sql =
    "UPDATE
      tb_master_lokasi AS a
    SET
      a.hapus = 1,
      a.updated_at = NOW()
    WHERE
      id = '".$id."'";  
    mysqli_query($db,$sql) OR die(alert_php('error 101'));
    $sql =
    "INSERT INTO
      tb_log
    VALUES
    (
      default,
      'tb_master_lokasi',
      '".$id."',
      'update',
      '".$id_user."',      
      NOW(),
      NOW()
    )";
    mysqli_query($db,$sql) OR die(alert_php('error 115'));
    $sql = 
    "INSERT INTO
      tb_master_lokasi
    VALUES
    (
      default,
      '".$lokasi."',
      '".$aktif."',
      0,
      '".$id_user."',
      NOW(),
      NOW()
    )"; 
    mysqli_query($db,$sql) OR die(alert_php('error 129'));  
    $id = mysqli_insert_id($db); 
    $sql =
    "INSERT INTO
      tb_log
    VALUES
    (
      default,
      'tb_master_lokasi',
      '".$id."',
      'update',
      '".$id_user."',      
      NOW(),
      NOW()
    )";
    mysqli_query($db,$sql) OR die(alert_php('error 144'));
    navigasi_ke('?id_nav_detail='.$id_nav_detail.'&page='.$page.'&daftar&id='.$id.'&sukses_ubah='.$lokasi);
  }
}
if(isset($_POST['tombol_hapus']))
{
  $id = fch($_POST['id']);
  $lokasi = fch($_POST['lokasi']);
  $sql =
  "UPDATE
    tb_master_lokasi AS a
  SET
    a.hapus = 1,
    a.updated_at = NOW()
  WHERE
    id = '".$id."'";
  mysqli_query($db,$sql) OR die(alert_php('error 160'));
  $sql =
  "INSERT INTO
    tb_log
  VALUES
  (
    default,
    'tb_master_lokasi',
    '".$id."',
    'delete',
    '".$id_user."',      
    NOW(),
    NOW()
  )";
  mysqli_query($db,$sql) OR die(alert_php('error 174'));
  navigasi_ke('?id_nav_detail='.$id_nav_detail.'&daftar&id='.$id.'&sukses_hapus='.$lokasi);
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
            <h3 class="box-title">Daftar Lokasi</h3>
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
              <div style="color:white;">Berhasil Menambah; <b><u><?php echo $_GET['sukses_tambah']; ?></u></b></div>
            </div>
            <?php
            }
            if(isset($_GET['gagal_tambah']))
            {              
            ?>
            <div class="alert alert-danger" style="padding:5px;">
              <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
              <div style="color:white;">Gagal Menambah; <b><u><?php echo $_GET['gagal_tambah']; ?></u></b> Sudah Ada</div>
            </div>
            <?php
            }
            if(isset($_GET['sukses_ubah']))
            {
            ?>
            <div class="alert alert-success" style="padding:5px;">
              <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
              <div style="color:white;">Berhasil Mengubah; <b><u><?php echo $_GET['sukses_ubah']; ?></u></b></div>
            </div>
            <?php
            }
            if(isset($_GET['gagal_ubah']))
            {
            ?>
            <div class="alert alert-danger" style="padding:5px;">
              <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
              <div style="color:white;">Gagal Mengubah; Sudah Ada Data Dengan Lokasi Yang Sama</div>
            </div>
            <?php
            }
            if(isset($_GET['sukses_hapus']))
            {
            ?>
            <div class="alert alert-success" style="padding:5px;">
              <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
              <div style="color:white;">Berhasil Menghapus; <b><u><?php echo $_GET['sukses_hapus']; ?></u></b></div>
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
                  a.lokasi,
                  a.aktif,
                  a.created_at,
                  a.updated_at
                FROM
                  tb_master_lokasi AS a
                WHERE
                  a.aktif = 1 AND
                  a.hapus = 0";
                if(isset($_POST['tombol_filter']) OR isset($_SESSION['tombol_filter_'.$id_nav_detail]))
                {
                  if(isset($_POST['tombol_filter']))
                  {
                    navigasi_ke('?id_nav_detail='.$id_nav_detail.'&daftar');
                    if($_POST['data_per_halaman'] == '') $_POST['data_per_halaman'] = 0;                  
                    $_SESSION['tombol_filter_'.$id_nav_detail] = $_POST['tombol_filter'];
                    $_SESSION['lokasi_'.$id_nav_detail] = $_POST['lokasi'];
                    $_SESSION['aktif_'.$id_nav_detail] = $_POST['aktif'];
                    $_SESSION['data_per_halaman_'.$id_nav_detail] = $_POST['data_per_halaman'];
                    $lokasi = $_POST['lokasi'];
                    $aktif = $_POST['aktif'];
                    $data_per_halaman = $_POST['data_per_halaman'];
                  }
                  else if(isset($_SESSION['tombol_filter_'.$id_nav_detail]))
                  {
                    $tombol_filter = $_SESSION['tombol_filter_'.$id_nav_detail]; 
                    $lokasi = $_SESSION['lokasi_'.$id_nav_detail];
                    $aktif = $_SESSION['aktif_'.$id_nav_detail];
                    $data_per_halaman = $_SESSION['data_per_halaman_'.$id_nav_detail];
                  } 
                  $sql .= " AND a.lokasi LIKE '%".$lokasi."%'";
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
                  if($_GET['sort_by'] == 'lokasi')
                  { 
                    $sql .= " ORDER BY a.lokasi ".$_GET['order']."";
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
                  $sql .= " ORDER BY a.lokasi";
                }             
                $page = isset($_GET["page"]) ? (int)$_GET["page"] : 1;
                $mulai = ($page > 1) ? ($page * $data_per_halaman) - $data_per_halaman : 0;
                $result = mysqli_query($db,$sql) OR die(alert_php('error 487'));
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
                $res = mysqli_query($db,$sql) OR die('error 498');
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
                    <th>Lokasi <a <?php if(isset($_GET['sort_by']) AND $_GET['sort_by']=='lokasi' AND $_GET['order']=='desc') echo 'style="color:red;"'; else echo 'style="color:black;"';?> href="?id_nav_detail=<?php echo $id_nav_detail; ?>&page=<?php echo $page; ?>&daftar&sort_by=lokasi&order=desc"><i class="fa fa-sort-up fa-lg"></i></a><a <?php if(isset($_GET['sort_by']) AND $_GET['sort_by']=='lokasi' AND $_GET['order']=='asc') echo 'style="color:red;"'; else echo 'style="color:black;"';?> href="?id_nav_detail=<?php echo $id_nav_detail; ?>&page=<?php echo $page; ?>&daftar&sort_by=lokasi&order=asc"><i class="fa fa-sort-down fa-lg"></i></a></th>
                    <th>Status <a <?php if(isset($_GET['sort_by']) AND $_GET['sort_by']=='aktif' AND $_GET['order']=='desc') echo 'style="color:red;"'; else echo 'style="color:black;"';?> href="?id_nav_detail=<?php echo $id_nav_detail; ?>&page=<?php echo $page; ?>&daftar&sort_by=aktif&order=desc"><i class="fa fa-sort-up fa-lg"></i></a><a <?php if(isset($_GET['sort_by']) AND $_GET['sort_by']=='aktif' AND $_GET['order']=='asc') echo 'style="color:red;"'; else echo 'style="color:black;"';?> href="?id_nav_detail=<?php echo $id_nav_detail; ?>&page=<?php echo $page; ?>&daftar&sort_by=aktif&order=asc"><i class="fa fa-sort-down fa-lg"></i></a></th>
                    <th>Created At <a <?php if(isset($_GET['sort_by']) AND $_GET['sort_by']=='created_at' AND $_GET['order']=='desc') echo 'style="color:red;"'; else echo 'style="color:black;"';?> href="?id_nav_detail=<?php echo $id_nav_detail; ?>&page=<?php echo $page; ?>&daftar&sort_by=created_at&order=desc"><i class="fa fa-sort-up fa-lg"></i></a><a <?php if(isset($_GET['sort_by']) AND $_GET['sort_by']=='created_at' AND $_GET['order']=='asc') echo 'style="color:red;"'; else echo 'style="color:black;"';?> href="?id_nav_detail=<?php echo $id_nav_detail; ?>&page=<?php echo $page; ?>&daftar&sort_by=created_at&order=asc"><i class="fa fa-sort-down fa-lg"></i></a></th>
                    <th>Updated At <a <?php if(isset($_GET['sort_by']) AND $_GET['sort_by']=='updated_at' AND $_GET['order']=='desc') echo 'style="color:red;"'; else echo 'style="color:black;"';?> href="?id_nav_detail=<?php echo $id_nav_detail; ?>&page=<?php echo $page; ?>&daftar&sort_by=updated_at&order=desc"><i class="fa fa-sort-up fa-lg"></i></a><a <?php if(isset($_GET['sort_by']) AND $_GET['sort_by']=='updated_at' AND $_GET['order']=='asc') echo 'style="color:red;"'; else echo 'style="color:black;"';?> href="?id_nav_detail=<?php echo $id_nav_detail; ?>&page=<?php echo $page; ?>&daftar&sort_by=updated_at&order=asc"><i class="fa fa-sort-down fa-lg"></i></a></th>
                    <th colspan="2">Aksi</th>
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
                    <td><?php echo $row['lokasi']; ?></td>
                    <td style="width:2.5cm;"><span class=" label label-<?php echo $label; ?>"><?php echo $status; ?></span></td>
                    <td style="width:4.5cm;"><?php echo date('d-M-Y H:i:s',strtotime($row['created_at'])); ?></td>
                    <td style="width:4.5cm;"><?php echo date('d-M-Y H:i:s',strtotime($row['updated_at'])); ?></td>
                    <td style="width:0.5cm;"><a class="fa fa-lg fa-pencil" style="cursor: pointer;color:darkblue;text-decoration: none;" href="?id_nav_detail=<?php echo $id_nav_detail; ?>&page=<?php echo $page; ?>&ubah&id=<?php echo $row['id']; ?>"></a></td>
                    <td style="width:0.5cm;"><a class="fa fa-lg fa-trash" style="cursor: pointer;color:red;text-decoration: none;" href="?id_nav_detail=<?php echo $id_nav_detail; ?>&page=<?php echo $page; ?>&hapus&id=<?php echo $row['id']; ?>"></a></td>
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
            <?php echo showLog('tb_master_lokasi'); ?>
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
            <h3 class="box-title">Tambah Lokasi</h3>
          </div>
          <form role="form" method="POST">
            <div class="box-body">
              <div class="row">
                <div class="col-md-11">
                  <div class="form-group">
                    <label for="lokasi">Lokasi :</label>
                    <input autofocus type="text" name="lokasi" id="lokasi" class="form-control" autocomplete="off" required>
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
      a.lokasi,    
      a.aktif
    FROM
      tb_master_lokasi AS a
    WHERE
      a.id = '".$id."'";
    $res = mysqli_query($db,$sql) OR die(alert_php('error 577'));
    if(mysqli_num_rows($res) != 0)
    {
      while($row = mysqli_fetch_assoc($res))
      {
        $lokasi = $row['lokasi'];
        $aktif = $row['aktif'];          
      }
    }
  ?>
  <section class="content">
    <div class="row">
      <div class="col-md-12">
        <div class="box box-primary">
          <div class="box-header with-border">
            <h3 class="box-title">Ubah Lokasi</h3>
          </div>
          <form role="form" method="POST">
            <div class="box-body">
              <div class="row">
                <div class="col-md-11">
                  <div class="form-group">
                    <label for="lokasi">Lokasi :</label>
                    <input type="text" name="lokasi" id="lokasi" class="form-control" autocomplete="off" value="<?php echo $lokasi; ?>" required>
                  </div>
                </div>
                <div class="col-md-1">
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
      a.lokasi
    FROM
      tb_master_lokasi AS a
    WHERE
      a.id = '".$id."'";
    $res = mysqli_query($db,$sql) OR die(alert_php('error 588'));
    if(mysqli_num_rows($res) != 0)
    {
      while($row = mysqli_fetch_assoc($res))
      {
        $lokasi = $row['lokasi']; 
      }
    }
  ?>
  <section class="content">
    <div class="row">
      <div class="col-md-12">
        <div class="box box-primary">
          <div class="box-header with-border">
            <h3 class="box-title">Hapus Lokasi</h3>
          </div>
          <form role="form" method="POST">
            <div class="box-body">
              <div class="row">
                <div class="col-md-12">
                  <label>Anda Yakin Ingin Menghapus : <b><u><?php echo $lokasi; ?></u></b> ?</label>
                </div>
              </div>
              <br>
              <div class="row">
                <div class="col-md-2">
                  <input type="hidden" name="id" value="<?php echo $id; ?>">
                  <input type="hidden" name="lokasi" value="<?php echo $lokasi; ?>">
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
              <div class="col-md-8">
                <div class="form-group">
                  <label>Lokasi : </label>
                  <input type="text" name="lokasi" autocomplete="off" class="form-control" value="<?php if(isset($_SESSION['lokasi_'.$id_nav_detail])) echo $_SESSION['lokasi_'.$id_nav_detail]; ?>">
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