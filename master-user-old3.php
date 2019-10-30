<?php include 'template/kerangkaAtas.php'; ?>
<?php
if(isset($_GET['pdf']))
{
  navigasi_ke('master-user-pdf.php');
}
if(isset($_GET['excel']))
{
  navigasi_ke('master-user-excel.php');
}
if(isset($_GET['refresh']))
{
  unset($_SESSION['tombol_filter_master_user']);
  navigasi_ke('?daftar');
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
    null
  )";
  mysqli_query($db,$sql) OR die('error 42');
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
    null
  )";
  mysqli_query($db,$sql) OR die('error 57');
  navigasi_ke('?daftar&id='.$id.'&sukses');
}
?>
<script>
function getNilaiTukar(id_pemasok, tanggal) {
  if (window.XMLHttpRequest) {
    // code for IE7+, Firefox, Chrome, Opera, Safari
    xmlhttp = new XMLHttpRequest();
  } else {
    // code for IE6, IE5
    xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
  }
  xmlhttp.onreadystatechange = function() {
    if (this.readyState == 4 && this.status == 200) {
      var x = document.getElementById("nilai_tukar");
      x.value = this.responseText;
    }
  };
  xmlhttp.open("GET", "json/get-nilai-tukar.php?id_pemasok=" + id_pemasok + "&tanggal=" + tanggal, true);
  xmlhttp.send();
}
</script>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <h1>
      User
    </h1>
    <ol class="breadcrumb">
      <li><a href="dashboard.php"><i class="fa fa-dashboard"></i> Home</a></li>
      <li><a href="?refresh&daftar">User</a></li>
    </ol>
  </section>
  <?php
//PAGE_DAFTAR
  if(isset($_GET['daftar']))
  {
    $sql =
    "SELECT
      *
    FROM
      tb_master_user AS a";
    if(isset($_POST['tombol_filter']) OR isset($_SESSION['tombol_filter_master_user']))
    {
      if(isset($_POST['tombol_filter']))
      {
        if($_POST['data_per_halaman'] == '') $_POST['data_per_halaman'] = 0;                  
        $_SESSION['tombol_filter_master_user'] = $_POST['tombol_filter'];
        $_SESSION['data_per_halaman_master_user'] = $_POST['data_per_halaman'];
        $tgl_awal = $_POST['tgl_awal'];        
        $data_per_halaman = $_POST['data_per_halaman'];
      }
      else if(isset($_SESSION['tombol_filter_master_user']))
      {
        $tombol_filter = $_SESSION['tombol_filter_master_user'];        
        $data_per_halaman = $_SESSION['data_per_halaman_master_user'];
      } 
      $sql .= " AND a.nama LIKE '%".$nomor."%'";
      $sql .= " AND a.user_name LIKE '%".$mata_uang."%'";
    }
    else
    {
      $data_per_halaman = 50;
    }
    if(isset($_GET['sort_by']))
    {
      if($_GET['sort_by'] == 'nama')
      { 
        $sql .= " ORDER BY a.nama ".$_GET['order']."";
      }     
    }
    else
    {
      $sql .= " ORDER BY a.nama";
    }             
    $page = isset($_GET["page"]) ? (int)$_GET["page"] : 1;
    $mulai = ($page > 1) ? ($page * $data_per_halaman) - $data_per_halaman : 0;  
    $result = mysqli_query($db,$sql) OR die('error 615');
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
    $res = mysqli_query($db,$sql) OR die('error 626');
    $no = $mulai + 1;
    $sort_by = '';
    if(isset($_GET['sort_by']) AND isset($_GET['order']))
    {
      $sort_by='&sort_by='.$_GET['sort_by'].'&order='.$_GET['order'];
    }
    $reload = $_SERVER['PHP_SELF'] . "?daftar".$sort_by;
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
                  <li><a href="?tambah"><i class="fa fa-sm fa-file-o"></i>Tambah</a></li>
                  <li><a data-toggle="modal" href="#ModalFilter"><i class="fa fa-sm fa-search"></i> Filter</a></li>
                  <li><a href="?refresh&daftar"><i class="fa fa-sm fa-refresh"></i>Refresh</a></li>
                </ul>
              </div>
              <div class="btn-group">
                <button type="button" class="btn btn-sm btn-default btn-flat">Cetak</button>
                <button type="button" class="btn btn-sm btn-default btn-flat dropdown-toggle" data-toggle="dropdown">
                  <span class="caret"></span>
                  <span class="sr-only">Toggle Dropdown</span>
                </button>
                <ul class="dropdown-menu" role="menu">
                  <li><a href="?pdf"><i class="fa fa-sm fa-file-pdf-o"></i>PDF</a></li>
                  <li><a href="?excel"><i class="fa fa-sm fa-file-excel-o"></i>Excel</a></li>
                </ul>
              </div>
            </div>
          </div>
          <div class="box-body">
            <?php
            if(isset($_GET['sukses']))
            {
            ?>
            <div class="alert alert-success" style="padding:5px;">
              <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
              <div style="color:black;font-weight:bold;">Berhasil Menambah User Baru</div>
            </div>
            <?php
            }
            ?>
            <div class="table-responsive no-padding">
              <table class="table">
                <?php
                if($total == 0)
                {
                ?>
                <thead>
                  <tr>
                    <td colspan="9">Tidak Ada Data Ditemukan</td>
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
                    <th>ID</th>
                    <th>Nama <a <?php if(isset($_GET['sort_by']) AND $_GET['sort_by']=='nama' AND $_GET['order']=='desc') echo 'style="color:red;"'; else echo 'style="color:black;"';?> href="?daftar&sort_by=nama&order=desc"><i class="fa fa-sort-up fa-lg"></i></a><a <?php if(isset($_GET['sort_by']) AND $_GET['sort_by']=='nama' AND $_GET['order']=='asc') echo 'style="color:red;"'; else echo 'style="color:black;"';?> href="?daftar&sort_by=nama&order=asc"><i class="fa fa-sort-down fa-lg"></i></a></th>
                    <th>Username</th>
                    <th>Password</th>
                    <th>Status</th>
                    <th>Created At</th>
                    <th>Updated At</th>
                    <th colspan="3"></th>
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
                  <tr style="<?php if(isset($_GET['id']) AND $row['id']==$_GET['id']) echo 'background-color:darkorange';?>">
                    <td><?php echo $nomor++; ?></td>
                    <td><?php echo $row['id']; ?></td>
                    <td><?php echo $row['nama']; ?></td>
                    <td><?php echo $row['username']; ?></td>
                    <td><?php echo $row['password']; ?></td>
                    <td><span class=" label label-<?php echo $label; ?>"><?php echo $status; ?></span></td>
                    <td><?php echo date('d-M-Y h:i:s',strtotime($row['created_at'])); ?></td>
                    <td><?php echo date('d-M-Y h:i:s',strtotime($row['updated_at'])); ?></td>
                    <td><a class="fa fa-lg fa-folder-open" style="cursor: pointer;color:black;text-decoration: none;" href="?detail&id=<?php echo $row['id']; ?>"></a></td>
                    <td><a class="fa fa-lg fa-pencil" style="cursor: pointer;color:black;text-decoration: none;" href="?ubah&id=<?php echo $row['id']; ?>"></a></td>
                    <td><a class="fa fa-lg fa-trash " style="cursor: pointer;color:black;text-decoration: none;" href="?hapus&id=<?php echo $row['id']; ?>"></a></td>
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
          <div class="box-footer"></div>
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
            <h3 class="box-title">Tambah User</h3>
          </div>
          <form role="form" method="POST">
            <div class="box-body">
              <div class="form-group">
                <label for="nama">Nama :</label>
                <input autofocus type="text" name="nama" id="nama" class="form-control" autocomplete="off" required>
              </div>
              <div class="form-group">
                <label for="username">Username :</label>
                <input type="text" name="username" id="username" class="form-control" autocomplete="off" required>
              </div>
              <div class="form-group">
                <label for="password">Password :</label>
                <input type="text" name="password" id="password" class="form-control" autocomplete="off" required>
              </div>
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
                  $res = mysqli_query($db,$sql) OR die('error 327');
                  if(mysqli_num_rows($res))
                  {
                    while($row = mysqli_fetch_assoc($res))
                    {
                    ?>
                  <option value="<?php $row['id']; ?>"><?php echo $row['lokasi']; ?></option>
                  <?php
                    }
                  }
                  ?>
                </select>
              </div>
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
                  $res = mysqli_query($db,$sql) OR die('error 356');
                  if(mysqli_num_rows($res))
                  {
                    while($row = mysqli_fetch_assoc($res))
                    {
                    ?>
                  <option value="<?php $row['id']; ?>"><?php echo $row['departemen']; ?></option>
                  <?php
                    }
                  }
                  ?>
                </select>
              </div>
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
                  $res = mysqli_query($db,$sql) OR die('error 384');
                  if(mysqli_num_rows($res))
                  {
                    while($row = mysqli_fetch_assoc($res))
                    {
                    ?>
                  <option value="<?php $row['id']; ?>"><?php echo $row['jabatan']; ?></option>
                  <?php
                    }
                  }
                  ?>
                </select>
              </div>
              <div class="form-group">
                <label for="aktif">Status :</label>
                <select id="aktif" name="aktif" class="form-control select2" style="width: 100%;" required>
                  <option value="">Pilih..</option>
                  <option value="1">Aktif</option>
                  <option value="0">Non Aktif</option>
                </select>
              </div>
            </div>
            <div class="box-footer">
              <button type="submit" name="tombol_tambah" class="btn btn-sm btn-flat btn-default"><i class="fa fa-sm fa-save"></i> Simpan</button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </section>
  <?php 
  }
//PAGE_TAMBAH
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
                  <label>Dari :</label>
                  <div class="input-group date">
                    <div class="input-group-addon">
                      <i class="fa fa-calendar"></i>
                    </div>
                    <input type="text" name="tgl_awal" class="form-control datepicker pull-right" autocomplete="off">
                  </div>
                </div>
              </div>
              <div class="col-md-2">
                <div class="form-group">
                  <label>Sampai :</label>
                  <div class="input-group date">
                    <div class="input-group-addon">
                      <i class="fa fa-calendar"></i>
                    </div>
                    <input type="text" name="tgl_akhir" class="form-control datepicker pull-right" autocomplete="off">
                  </div>
                </div>
              </div>
              <div class="col-md-2">
                <div class="form-group">
                  <label>Nomor : </label>
                  <input type="text" name="nomor" class="form-control">
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group">
                  <label>Pemasok : </label>
                  <select class="form-control select2" style="width: 100%;">
                    <option value="">Semua</option>
                    <?php
                    $sql =
                    "SELECT
                      a.id,
                      a.pemasok
                    FROM
                      tb_master_pemasok AS a
                    WHERE
                      a.aktif = 1";
                    $sql .= " ORDER BY a.pemasok";
                    $res = mysqli_query($db,$sql) OR die('error 98');
                    if(mysqli_num_rows($res) != 0)
                    {
                      while($row = mysqli_fetch_assoc($res))
                      {
                      ?>
                    <option value="<?php echo $row['id']; ?>"><?php echo $row['pemasok']; ?></option>
                    <?php
                      }
                    }
                    ?>
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