<?php include 'template/kerangkaAtas.php'; ?>
<?php
if(isset($_GET['pdf']))
{
  navigasi_ke('pemesanan-pdf.php');
}
if(isset($_GET['excel']))
{
  navigasi_ke('pemesanan-excel.php');
}
if(isset($_GET['refresh']))
{
  unset($_SESSION['tombol_filter_pemesanan']);
  navigasi_ke('?daftar');
}
if(isset($_POST['tombol_tambah']))
{
  $tanggal = fch($_POST['tanggal']);
  $nomor = fch($_POST['nomor']);
  $id_pemasok = fch($_POST['id_pemasok']);
  $nilai_tukar = fch($_POST['nilai_tukar']);
  if($nilai_tukar == '')
    navigasi_ke('?tambah&error_nilai_tukar');
  else
  {
    $sql = 
    "SELECT
      a.mata_uang,
      a.ppn
    FROM
      tb_master_pemasok AS a
    WHERE
      a.id = '".$id_pemasok."'";
    $res = mysqli_query($db,$sql) OR die('error 33');
    if(mysqli_num_rows($res) != 0)
    {
      while($res = mysqli_fetch_assoc($res))
      {
        $mata_uang = $row['mata_uang'];
      }
    }
    $sql = 
    "INSERT INTO
      tb_pemesanan
    VALUES
    (
      default,
      '".$tanggal."',
      '".$nomor."',
      '".$id_pemasok."',
      '".$keterangan."',
      0,
      0,
      0,
      0,
      0,
      '".$mata_uang."',
      '".$nilai_tukar."',
      0,
      0,
      '".$id_user."',
      NOW(),
      null
    )";
    mysqli_query($db,$sql) OR die('error 64');
    $id = mysqli_insert_id($db); 
    $sql =
    "INSERT INTO
      tb_log
    VALUES
    (
      default,
      'tb_pemesanan',
      '".$id."',
      'insert',
      '".$id_user."',      
      NOW(),
      null
    )";
    mysqli_query($db,$sql) OR die('error 39');
    navigasi_ke('?daftar&sukses');
  }
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
      Pemesanan Barang
    </h1>
    <ol class="breadcrumb">
      <li><a href="dashboard.php"><i class="fa fa-dashboard"></i> Home</a></li>
      <li><a href="?refresh&daftar">Pemesanan</a></li>
    </ol>
  </section>
  <?php
  if(isset($_GET['daftar']))
  {
    $sql =
    "SELECT
      a.id,
      a.tanggal,
      a.nomor,
      a.id_pemasok,
      a.sub_total,
      a.ppn,
      a.biaya_kirim,
      a.diskon,
      a.total,
      a.mata_uang,
      a.nilai_tukar,
      a.keterangan,
      c.nama,
      b.pemasok
    FROM
      tb_pemesanan AS a
    LEFT JOIN
      tb_master_pemasok AS b ON (b.id = a.id_pemasok)
    LEFT JOIN
      tb_master_user AS c ON (c.id = a.id_user)";
    if(isset($_POST['tombol_filter']) OR isset($_SESSION['tombol_filter_pemesanan']))
    {
      if(isset($_POST['tombol_filter']))
      {
        if($_POST['data_per_halaman'] == '') $_POST['data_per_halaman'] = 0;                  
        $_SESSION['tombol_filter_pemesanan'] = $_POST['tombol_filter'];
        $_SESSION['tgl_awal_pemesanan'] = $_POST['tgl_awal'];
        $_SESSION['tgl_akhir_pemesanan'] = $_POST['tgl_akhir'];
        $_SESSION['no_pemesanan_pemesanan'] = $_POST['nomor'];
        $_SESSION['mata_uang'] = $_POST['mata_uang'];
        $_SESSION['id_pemasok'] = $_POST['id_pemasok'];
        $_SESSION['data_per_halaman_pemesanan'] = $_POST['data_per_halaman'];
        $tgl_awal = $_POST['tgl_awal'];
        $tgl_akhir = $_POST['tgl_akhir'];
        $nomor = $_POST['nomor'];
        $mata_uang = $_POST['mata_uang'];
        $id_pemasok = $_POST['id_pemasok'];
        $data_per_halaman = $_POST['data_per_halaman'];
      }
      else if(isset($_SESSION['tombol_filter_pemesanan']))
      {
        $tombol_filter = $_SESSION['tombol_filter_pemesanan'];
        $tgl_awal = $_SESSION['tgl_awal_pemesanan'];
        $tgl_akhir = $_SESSION['tgl_akhir_pemesanan'];
        $nomor = $_SESSION['no_pemesanan_pemesanan'];
        $mata_uang = $_SESSION['mata_uang'];
        $id_pemasok = $_SESSION['id_pemasok'];
        $data_per_halaman = $_SESSION['data_per_halaman_pemesanan'];
      }   
      if($tgl_awal != '' AND $tgl_akhir != '')
      {
        $sql .= " AND a.tanggal >= '".$tgl_awal."' AND a.tanggal <= '".$tgl_akhir."'";
      }
      else if($tgl_awal == '' AND $tgl_akhir != '')
      {
        $sql .= " AND a.tanggal <= '".$tgl_akhir."'";
      }
      else if($tgl_awal != '' AND $tgl_akhir == '')
      {
        $sql .= " AND a.tanggal >= '".$tgl_awal."'";
      }
      $sql .= " AND a.nomor LIKE '%".$nomor."%'";
      $sql .= " AND a.mata_uang LIKE '%".$mata_uang."%'";
      if($id_pemasok != '')
      {
        $sql .= " AND a.id_pemasok = '".$id_pemasok."'";
      }
    }
    else
    {
      $data_per_halaman = 50;
    }
    if(isset($_GET['sort_by']))
    {
      if($_GET['sort_by'] == 'nomor')
      { 
        $sql .= " ORDER BY a.nomor ".$_GET['order'].",a.tanggal ".$_GET['order']."";
      }
      else if($_GET['sort_by'] == 'tanggal')
      { 
        $sql .= " ORDER BY a.tanggal ".$_GET['order'].",a.nomor ".$_GET['order']."";
      }
      else if($_GET['sort_by'] == 'pemasok')
      { 
        $sql .= " ORDER BY b.pemasok ".$_GET['order'].",a.tanggal ".$_GET['order'].",a.nomor ".$_GET['order']."";
      }
    }
    else
    {
      $sql .= " ORDER BY a.nomor DESC,a.tanggal DESC";
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
    <div class="box">
      <div class="box-header with-border">
        <h3 class="box-title">Daftar Pemesanan Barang</h3>
        <div class="box-tools pull-right">
          <button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="Collapse">
            <i class="fa fa-minus"></i>
          </button>
        </div>
      </div>
      <div class="box-body">
        <div class="row">
          <div class="col-xs-6">
            <a class="btn btn-sm btn-primary" data-toggle="modal" href="#ModalFilter"><i class="fa fa-sm fa-search"></i> Filter</a>
            <a href="?refresh&daftar" class="btn btn-sm btn-primary"><i class="fa fa-sm fa-refresh"></i> Refresh</a>
            <a href="?tambah" class="btn btn-sm btn-primary"><i class="fa fa-sm fa-file"></i> Tambah</a>
          </div>
          <div class="col-xs-6" style="text-align:right;">
            <a href="?pdf" target="_blank" class="btn btn-sm btn-danger"><i class="fa fa-sm fa-file-pdf-o"></i> Cetak PDF</a>
            <a href="?excel" target="_blank" class="btn btn-sm btn-success"> <i class="fa fa-sm fa-file-excel-o"></i> Cetak Excel</a>
          </div>
        </div>
        <br>
        <div class="row">
          <div class="col-xs-12">
            <table class="table">
              <?php
              if($total == 0)
              {
              ?>
              <thead>
                <tr>
                  <td colspan="17">Tidak Ada Data Ditemukan</td>
                </tr>
              </thead>
              <?php
              } 
              else
              {
              ?>
              <thead>
                <tr>
                  <td>Tgl. <a <?php if(isset($_GET['sort_by']) AND $_GET['sort_by']=='tanggal' AND $_GET['order']=='desc') echo 'style="color:red;"'; else echo 'style="color:black;"';?> href="?daftar&sort_by=tanggal&order=desc"><i class="fa fa-sort-up fa-lg"></i></a><a <?php if(isset($_GET['sort_by']) AND $_GET['sort_by']=='tanggal' AND $_GET['order']=='asc') echo 'style="color:red;"'; else echo 'style="color:black;"';?> href="?daftar&sort_by=tanggal&order=asc"><i class="fa fa-sort-down fa-lg"></i></a></td>
                  <td>Nomor <a <?php if(isset($_GET['sort_by']) AND $_GET['sort_by']=='nomor' AND $_GET['order']=='desc') echo 'style="color:red;"'; else echo 'style="color:black;"';?> href="?daftar&sort_by=nomor&order=desc"><i class="fa fa-sort-up fa-lg"></i></a><a <?php if(isset($_GET['sort_by']) AND $_GET['sort_by']=='nomor' AND $_GET['order']=='asc') echo 'style="color:red;"'; else echo 'style="color:black;"';?> href="?daftar&sort_by=nomor&order=asc"><i class="fa fa-sort-down fa-lg"></i></a></td>
                  <td>Supplier <a <?php if(isset($_GET['sort_by']) AND $_GET['sort_by']=='pemasok' AND $_GET['order']=='desc') echo 'style="color:red;"'; else echo 'style="color:black;"';?> href="?daftar&sort_by=pemasok&order=desc"><i class="fa fa-sort-up fa-lg"></i></a><a <?php if(isset($_GET['sort_by']) AND $_GET['sort_by']=='pemasok' AND $_GET['order']=='asc') echo 'style="color:red;"'; else echo 'style="color:black;"';?> href="?daftar&sort_by=pemasok&order=asc"><i class="fa fa-sort-down fa-lg"></i></a></td>
                  <td>PPN (%)</td>
                  <td>M.U</td>
                  <td>Sub Total</td>
                  <td>Nilai PPN</td>
                  <td>Total</td>
                  <td>Kurs</td>
                  <td>Konversi (Rp)</td>
                  <td>Admin</td>
                  <td colspan="3">#</td>
                </tr>
              </thead>
              <tbody>
                <?php     
                $total_konversi = 0;    
                while($row = mysqli_fetch_assoc($res))
                {
                  $tanggal_pemesanan = $row['tanggal'];
                  $today = date_parse($tanggal_pemesanan);
                  $tahun_pemesanan = $today['year'];
                  $total_konversi += $row['total'] * $row['nilai_tukar'];
                ?>
                <tr>
                  <td><?php echo date('d/m/y',strtotime($row['tanggal'])); ?></td>
                  <td><?php echo $row['nomor']; ?></td>
                  <td><?php echo $row['pemasok']; ?></td>
                  <td><?php echo $row['ppn'] * 100; ?></td>
                  <td><?php echo $row['mata_uang']; ?></td>
                  <td><?php echo number_format($row['sub_total'],2); ?></td>
                  <td><?php echo number_format($row['sub_total'] * $row['ppn'],2); ?></td>
                  <td><?php echo number_format($row['total'],2); ?></td>
                  <td><?php echo number_format($row['nilai_tukar'],2); ?></td>
                  <td><?php echo number_format($row['total'] * $row['nilai_tukar'],2); ?></td>
                  <td><?php echo $row['nama']; ?></td>
                  <td><a class="fa fa-print fa-lg" style="cursor: pointer;color:black;text-decoration: none;" href="pengembalian-per-barang-pdf.php?id=<?php echo $row['id']; ?>" target="_blank"></a></td>
                  <td><a class="fa fa-list fa-lg" style="cursor: pointer;color:black;text-decoration: none;" href="?detail&id=<?php echo $row['id']; ?>"></a></td>
                  <?php
                  if($tahun_pemesanan == $tahun_now)
                  {
                  ?>
                  <td><a class="fa fa-trash fa-lg" style="cursor: pointer;color:black;text-decoration: none;" href="?hapus&id=<?php echo $row['id']; ?>"></a></td>
                  <?php
                  }
                  else
                  {
                  ?>
                  <td><a class="fa fa-trash fa-lg" style="cursor: pointer;color:black;text-decoration: none;" href="#"></a></td>
                  <?php
                  } 
                  ?>
                </tr>
                <?php
                }
                ?>
                <tr>
                  <td colspan="9">Grand Total : </td>
                  <td><?php echo number_format($total_konversi,2); ?></td>
                  <td colspan="4"></td>
                </tr>
              </tbody>
              <?php 
              }
              ?>
            </table>
          </div>
        </div>
        <?php
          if($total != 0 AND $pages != 0)
          {
          ?>
        <div class="row">
          <div class="col-xs-12" style="text-align: center;">
            <?php echo paginate_two($reload, $page, $pages,3); ?>
          </div>
        </div>
        <?php 
          }
          ?>
      </div>
      <div class="box-footer"></div>
    </div>
  </section>
  <?php 
  } 

  if(isset($_GET['tambah']))
  {
  ?>
  <section class="content">
    <div class="box">
      <div class="box-header with-border">
        <h3 class="box-title">Tambah Pemesanan Barang</h3>
        <div class="box-tools pull-right">
          <button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="Collapse">
            <i class="fa fa-minus"></i>
          </button>
        </div>
      </div>
      <div class="box-body">
        <form method="POST">
          <div class="row">
            <div class="col-xs-2">
              <div class="form-group">
                <label>Tanggal :</label>
                <div class="input-group date">
                  <div class="input-group-addon">
                    <i class="fa fa-calendar"></i>
                  </div>
                  <input type="text" id="tanggal" name="tanggal" class="form-control datepicker pull-right" onchange="getNilaiTukar(document.getElementById('id_pemasok').value,this.value);" onkeypress="return false;" autocomplete="off" required>
                </div>
              </div>
            </div>
            <div class="col-xs-2">
              <div class="form-group">
                <label>Nomor : </label>
                <input type="text" name="nomor" class="form-control" autocomplete="off" required>
              </div>
            </div>
            <div class="col-xs-6">
              <div class="form-group">
                <label>Pemasok : </label>
                <select id="id_pemasok" name="id_pemasok" class="form-control select2" style="width: 100%;" onchange="getNilaiTukar(this.value,document.getElementById('tanggal').value);" required>
                  <option value="">Pilih..</option>
                  <?php
                $sql =
                "SELECT
                  a.id,
                  a.pemasok,
                  a.mata_uang
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
                  <option value="<?php echo $row['id']; ?>"><?php echo $row['mata_uang']; ?> - <?php echo $row['pemasok']; ?></option>
                  <?php
                  }
                }
                ?>
                </select>
              </div>
            </div>
            <div class="col-xs-2">
              <div class="form-group">
                <label>Nilai Tukar : </label>
                <input readonly type="text" id="nilai_tukar" name="nilai_tukar" class="form-control" autocomplete="off" required>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-xs-2">
              <button type="submit" name="tombol_tambah" class="btn btn-sm btn-success"><i class="fa fa-sm fa-save"></i> Simpan</button>
            </div>
          </div>
        </form>
      </div>
      <div class="box-footer"></div>
    </div>
  </section>
  <?php 
  }
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
        <div class="modal-body">
          <div class="row">
            <div class="col-xs-2">
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
            <div class="col-xs-2">
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
            <div class="col-xs-2">
              <div class="form-group">
                <label>Nomor : </label>
                <input type="text" name="nomor" class="form-control">
              </div>
            </div>
            <div class="col-xs-6">
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
          <button type="submit" name="tombol_filter" class="btn btn-sm btn-success"><i class="fa fa-sm fa-search"></i> Filter</button>
          <button type="button" class="btn btn-sm btn-danger" data-dismiss="modal"><i class="fa fa-sm fa-times"></i> Batal</button>
        </div>
      </div>
      <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
  </div>
</div>
<!-- /.content-wrapper -->
<?php include 'template/kerangkaBawah.php'; ?>