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
  unset($_SESSION['nama_master_user']);
  unset($_SESSION['username_master_user']);
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
  navigasi_ke('?daftar&id='.$id.'&sukses_tambah');
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
    a.aktif = '".$aktif."'
  WHERE
    a.id = '".$id."'";
  mysqli_query($db,$sql) OR die('error 74');
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
    null
  )";
  mysqli_query($db,$sql) OR die('error 95');
  navigasi_ke('?daftar&id='.$id.'&sukses_ubah');
}
if(isset($_POST['tombol_hapus']))
{
  $id = fch($_POST['id']);
  $sql =
  "DELETE FROM
    tb_master_user
  WHERE
    id = '".$id."'";
  mysqli_query($db,$sql) OR die('error 106');
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
    null
  )";
  mysqli_query($db,$sql) OR die('error 120');
  navigasi_ke('?daftar&id='.$id.'&sukses_hapus');
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
<div class="content-wrapper">
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
                  <li><a href="?pdf" target="_blank"><i class="fa fa-sm fa-file-pdf-o"></i>PDF</a></li>
                  <li><a href="?excel" target="_blank"><i class="fa fa-sm fa-file-excel-o"></i>Excel</a></li>
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
                if(isset($_POST['tombol_filter']) OR isset($_SESSION['tombol_filter_master_user']))
                {
                  if(isset($_POST['tombol_filter']))
                  {
                    navigasi_ke('?daftar');
                    if($_POST['data_per_halaman'] == '') $_POST['data_per_halaman'] = 0;                  
                    $_SESSION['tombol_filter_master_user'] = $_POST['tombol_filter'];
                    $_SESSION['nama_master_user'] = $_POST['nama'];
                    $_SESSION['username_master_user'] = $_POST['username'];
                    $_SESSION['id_lokasi_master_user'] = $_POST['id_lokasi'];
                    $_SESSION['id_departemen_master_user'] = $_POST['id_departemen'];
                    $_SESSION['id_jabatan_master_user'] = $_POST['id_jabatan'];
                    $_SESSION['data_per_halaman_master_user'] = $_POST['data_per_halaman'];
                    $nama = $_POST['nama'];        
                    $username = $_POST['username'];
                    $id_lokasi = $_POST['id_lokasi'];
                    $id_departemen = $_POST['id_departemen'];
                    $id_jabatan = $_POST['id_jabatan'];
                    $data_per_halaman = $_POST['data_per_halaman'];
                  }
                  else if(isset($_SESSION['tombol_filter_master_user']))
                  {
                    $tombol_filter = $_SESSION['tombol_filter_master_user']; 
                    $nama = $_SESSION['nama_master_user'];   
                    $username = $_SESSION['username_master_user'];  
                    $id_lokasi = $_SESSION['id_lokasi_master_user']; 
                    $id_departemen = $_SESSION['id_departemen_master_user']; 
                    $id_jabatan = $_SESSION['id_jabatan_master_user'];  
                    $data_per_halaman = $_SESSION['data_per_halaman_master_user'];
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
                $nomor = $mulai + 1;
                $sort_by = '';
                if(isset($_GET['sort_by']) AND isset($_GET['order']))
                {
                  $sort_by='&sort_by='.$_GET['sort_by'].'&order='.$_GET['order'];
                }
                $reload = $_SERVER['PHP_SELF'] . "?daftar".$sort_by;
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
                    <th>ID</th>
                    <th>Nama <a <?php if(isset($_GET['sort_by']) AND $_GET['sort_by']=='nama' AND $_GET['order']=='desc') echo 'style="color:red;"'; else echo 'style="color:black;"';?> href="?daftar&sort_by=nama&order=desc"><i class="fa fa-sort-up fa-lg"></i></a><a <?php if(isset($_GET['sort_by']) AND $_GET['sort_by']=='nama' AND $_GET['order']=='asc') echo 'style="color:red;"'; else echo 'style="color:black;"';?> href="?daftar&sort_by=nama&order=asc"><i class="fa fa-sort-down fa-lg"></i></a></th>
                    <th>Username</th>
                    <th>Password</th>
                    <th>Lokasi</th>
                    <th>Departemen</th>
                    <th>Jabatan</th>
                    <th>Status</th>
                    <th>Created At</th>
                    <th>Updated At</th>
                    <th colspan="3"></th>
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
                  <tr style="<?php if(isset($_GET['id']) AND $row['id']==$_GET['id']) echo 'background-color:darkorange'; else if ($nomor % 2 == 0) { echo $background_ganjil; } else { echo $background_genap; }?>" class="tr-hover">
                    <td><?php echo $nomor++; ?></td>
                    <td><?php echo $row['id']; ?></td>
                    <td><?php echo $row['nama']; ?></td>
                    <td><?php echo $row['username']; ?></td>
                    <td><?php echo $row['password']; ?></td>
                    <td><?php echo $row['lokasi']; ?></td>
                    <td><?php echo $row['departemen']; ?></td>
                    <td><?php echo $row['jabatan']; ?></td>
                    <td><span class=" label label-<?php echo $label; ?>"><?php echo $status; ?></span></td>
                    <td><?php echo date('d-M-Y h:i:s',strtotime($row['created_at'])); ?></td>
                    <td><?php echo date('d-M-Y h:i:s',strtotime($row['updated_at'])); ?></td>
                    <td><a class="fa fa-lg fa-folder-open-o" style="cursor: pointer;color:black;text-decoration: none;" href="?detail&id=<?php echo $row['id']; ?>"></a></td>
                    <td><a class="fa fa-lg fa-edit" style="cursor: pointer;color:black;text-decoration: none;" href="?ubah&id=<?php echo $row['id']; ?>"></a></td>
                    <td><a class="fa fa-lg fa-trash-o " style="cursor: pointer;color:black;text-decoration: none;" href="?hapus&id=<?php echo $row['id']; ?>"></a></td>
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
            $res=mysqli_query($db,$sql) OR die('error 329');
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
    $res = mysqli_query($db,$sql) OR die('error 451');
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
          <div class="box-body">
            <div class="table-responsive no-padding">
              <table class="table">
                <thead>
                  <tr>
                    <th>Navigasi</th>
                    <th>Sub Navigasi</th>
                  </tr>
                </thead>
                <?php
                $arr_navigasi_utama = array();
                $sql =
                "SELECT
                  a.id,
                  a.nama
                FROM
                  tb_master_navigasi AS a
                LEFT JOIN
                  tb_master_navigasi_detail AS b ON (b.id = a.id)";
                $sql .= " GROUP BY a.nama";
                $sql .= " ORDER BY a.posisi";
                $res = mysqli_query($db,$sql) OR die('error 540');
                while($row = mysqli_fetch_assoc($res))
                {
                  $arr_navigasi_utama[$row['id']] = $row['nama'];
                }

                $arr_navigasi_sub = array();
                $sql =
                "SELECT
                  a.id,
                  b.nama
                FROM
                  tb_master_navigasi AS a
                LEFT JOIN
                  tb_master_navigasi_detail AS b ON (b.id = a.id)";
                $sql .= " ORDER BY b.posisi";
                $res = mysqli_query($db,$sql) OR die('error 556');
                while($row = mysqli_fetch_assoc($res))
                {
                  $arr_navigasi_sub[$row['id']][] = $row['nama'];                  
                }
                
                foreach($arr_navigasi_utama as $key => $value)
                {
                ?>
                <tr>
                  <td colspan="2"><input type="checkbox" class="flat-red"> <?php echo $value; ?></td>
                </tr>
                <?php
                  foreach($arr_navigasi_sub[$key] as $key1 => $value1)
                  {
                  ?>
                <tr>
                  <td style="width:3cm;"></td>
                  <td><input type="checkbox" class="flat-red"> <?php echo $value1; ?></td>
                </tr>
                <?php
                  }
                }
                ?>
              </table>
            </div>
          </div>
          <div class="box-footer">
            <button type="submit" name="tombol_update" class="btn btn-flat btn-sm btn-success">Update</button>
          </div>
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
                      $res = mysqli_query($db,$sql) OR die('error 327');
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
                      $res = mysqli_query($db,$sql) OR die('error 356');
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
                      $res = mysqli_query($db,$sql) OR die('error 384');
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
                  <a href="?daftar"><button type="button" class="btn btn-sm btn-flat btn-danger "><i class="fa fa-sm fa-times"></i> Batal</button></a>
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
                      $res = mysqli_query($db,$sql) OR die('error 327');
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
                      $res = mysqli_query($db,$sql) OR die('error 356');
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
                      $res = mysqli_query($db,$sql) OR die('error 384');
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
                  <a href="?daftar&id=<?php echo $id; ?>"><button type="button" class="btn btn-sm btn-flat btn-danger "><i class="fa fa-sm fa-times"></i> Batal</button></a>
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
                  <a href="?daftar&id=<?php echo $id; ?>"><button type="button" class="btn btn-sm btn-flat btn-danger "><i class="fa fa-sm fa-times"></i> Batal</button></a>
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