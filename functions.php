<?php

$background_genap = 'background:#E0FFFF;';
$background_ganjil = 'background:#FFFFFF;';

function insertLog($tabel,$id,$aksi)
{
  $db = $GLOBALS["db"];
  $id_user = $GLOBALS["id_user"];
  $sql =
  "INSERT INTO
    tb_log
  VALUES
  (
    default,
    '".$tabel."',
    '".$id."',
    '".$aksi."',
    '".$id_user."',      
    NOW(),
    NOW()
  )";
  mysqli_query($db,$sql) OR die(alert_php('error 22'));
}

function showLog($nama_table)
{
  $db = $GLOBALS["db"];
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
    a.tabel = '".$nama_table."'"; 
  $sql.=" ORDER BY a.created_at DESC,a.id DESC LIMIT 1";
  $res=mysqli_query($db,$sql) OR die('error 23');
  if(mysqli_num_rows($res)!=0)
  {
    while($row=mysqli_fetch_assoc($res))
    {
      return '<small>Aksi Terakhir : '.strtoupper($row['aksi']).' ID='.strtoupper($row['id_tabel']).', pada tanggal '.date("d M Y", strtotime($row['created_at'])).', pukul '.date("H:i:s", strtotime($row['created_at'])).' , oleh '.ucwords($row['nama']).' </small>';
    }
  }
}

function cek_page_avail($id_user,$id_nav_detail)
{
  $db = $GLOBALS["db"];
  $sql =
  "SELECT
    *
  FROM
    tb_master_user_detail AS a
  WHERE
    a.id = '".$id_user."' AND
    a.id_navigasi_detail = '".$id_nav_detail."'";
  $res = mysqli_query($db,$sql) OR die('error 19');
  if(mysqli_num_rows($res) != 0)
    return 1;
  else
    return 0;
}

function fch($string)
{
  $db = $GLOBALS["db"]; 
	$variabel =  mysqli_real_escape_string($db,$string);
	return $variabel;
}

function get_kode_akun($id_akun)
{
  $db_accounting = $GLOBALS["db_accounting"];  

  $sql=
  "SELECT
    *
  FROM
    list_kode_akun AS a
  WHERE
    a.id_akun='".$id_akun."'";
  $res=mysqli_query($db_accounting,$sql) or die('error 17');
  while($row=mysqli_fetch_assoc($res))
  {
    return $row['kode_akun'];
  }
}

function hitung_saldo_awal_kartu_stok($id_perusahaan,$id_gudang,$kode_barang,$tanggal)
{
  $db_accounting = $GLOBALS["db_accounting"];  

  $sql=
  "SELECT
    ifnull(sum(kuantitas_masuk)-sum(kuantitas_keluar),0) as saldo_awal
  FROM
    tb_transaksi_persediaan AS a
  WHERE
    a.id_perusahaan='".$id_perusahaan."' AND
    a.kode_barang='".$kode_barang."' AND
    a.tgl_transaksi<'".$tanggal."'";  
  if($id_gudang!='all')
  {
    $sql.=" AND a.id_gudang='".$id_gudang."'";
  }
  $res=mysqli_query($db_accounting,$sql) or die('error 19');
  if(mysqli_num_rows($res)!=0)
  {
    while($row=mysqli_fetch_assoc($res))
    {
      return $row['saldo_awal'];
    }
  }
}

function hitung_saldo_awal_kartu_stok_test($id_perusahaan,$id_gudang,$kode_barang,$tanggal)
{
  $db_accounting = $GLOBALS["db_accounting"];  

  $sql=
  "SELECT
    ifnull(sum(kuantitas_masuk)-sum(kuantitas_keluar),0) as saldo_awal
  FROM
    tb_transaksi_persediaan_test AS a
  WHERE
    a.id_perusahaan='".$id_perusahaan."' AND
    a.kode_barang='".$kode_barang."' AND
    a.tgl_transaksi<'".$tanggal."'";  
  if($id_gudang!='all')
  {
    $sql.=" AND a.id_gudang='".$id_gudang."'";
  }
  $res=mysqli_query($db_accounting,$sql) or die('error 19');
  if(mysqli_num_rows($res)!=0)
  {
    while($row=mysqli_fetch_assoc($res))
    {
      return $row['saldo_awal'];
    }
  }
}

function get_harga($id_perusahaan,$kode_barang,$tgl_transaksi)
{
  $db_accounting = $GLOBALS["db_accounting"];  

  $sql=
  "SELECT
    a.harga_rata_rata
  FROM
    tb_harga_rata_rata AS a
  WHERE
    a.id_perusahaan='".$id_perusahaan."' AND
    a.kode_barang='".$kode_barang."' AND
    a.tanggal<='".$tgl_transaksi."'";
  $sql.=" ORDER BY a.tanggal desc,a.id desc LIMIT 1";
  $res=mysqli_query($db_accounting,$sql) or die('error 19');
  if(mysqli_num_rows($res)!=0)
  {
    while($row=mysqli_fetch_assoc($res))
    {
      return $row['harga_rata_rata'];
    }
  }
}

function get_harga_test($id_perusahaan,$kode_barang,$tgl_transaksi)
{
  $db_accounting = $GLOBALS["db_accounting"];  

  $sql=
  "SELECT
    a.harga_rata_rata
  FROM
    tb_harga_rata_rata_test AS a
  WHERE
    a.id_perusahaan='".$id_perusahaan."' AND
    a.kode_barang='".$kode_barang."' AND
    a.tanggal<='".$tgl_transaksi."'";
  $sql.=" ORDER BY a.tanggal desc,a.id desc LIMIT 1";
  $res=mysqli_query($db_accounting,$sql) or die('error 19');
  if(mysqli_num_rows($res)!=0)
  {
    while($row=mysqli_fetch_assoc($res))
    {
      return $row['harga_rata_rata'];
    }
  }
}

function get_harga_pengeluaran($id_perusahaan,$kode_barang,$tgl_transaksi)
{
  $db_accounting = $GLOBALS["db_accounting"];  

  $sql=
  "SELECT
    a.harga_rata_rata
  FROM
    tb_harga_rata_rata AS a
  WHERE
    a.id_perusahaan='".$id_perusahaan."' AND
    a.kode_barang='".$kode_barang."' AND
    a.tanggal<='".$tgl_transaksi."' AND
    a.harga_rata_rata<>0";
  $sql.=" ORDER BY a.tanggal desc,a.id desc LIMIT 1";
  $res=mysqli_query($db_accounting,$sql) or die('error 19');
  if(mysqli_num_rows($res)!=0)
  {
    while($row=mysqli_fetch_assoc($res))
    {
      return $row['harga_rata_rata'];
    }
  }
}

function get_harga_pengeluaran_test($id_perusahaan,$kode_barang,$tgl_transaksi)
{
  $db_accounting = $GLOBALS["db_accounting"];  

  $sql=
  "SELECT
    a.harga_rata_rata
  FROM
    tb_harga_rata_rata_test AS a
  WHERE
    a.id_perusahaan='".$id_perusahaan."' AND
    a.kode_barang='".$kode_barang."' AND
    a.tanggal<='".$tgl_transaksi."' AND
    a.harga_rata_rata<>0";
  $sql.=" ORDER BY a.tanggal desc,a.id desc LIMIT 1";
  $res=mysqli_query($db_accounting,$sql) or die('error 19');
  if(mysqli_num_rows($res)!=0)
  {
    while($row=mysqli_fetch_assoc($res))
    {
      return $row['harga_rata_rata'];
    }
  }
}

function hitung_average_price($id_perusahaan,$kode_barang,$tgl_pembelian,$kuantiti_beli,$harga_beli,$nilai_tukar)
{
  //perhitungan harga rata rata
  $saldo_before=0;
  $db_accounting = $GLOBALS["db_accounting"];
  $sql3=
  "SELECT
    ifnull(sum(a.kuantitas_masuk)-sum(a.kuantitas_keluar),0) AS saldo_before
  FROM
    tb_transaksi_persediaan AS a
  WHERE
    a.id_perusahaan='".$id_perusahaan."' AND
    a.kode_barang='".$kode_barang."' AND
    a.tgl_transaksi <= '".$tgl_pembelian."' AND
    a.kode_akun IN (1401,'PBK','NOVAL','NONVALUASI')";
  $sql3.=" ORDER BY a.tgl_transaksi,conv(concat(
    substring(a.id_transaksi, 16, 3)
  , substring(a.id_transaksi, 10, 4)
  , substring(a.id_transaksi, 1, 8)
  ), 16, 10) asc";
  $res3=mysqli_query($db_accounting,$sql3) or die('error 97');
  while($row3=mysqli_fetch_assoc($res3))
  {
    $saldo_before=$row3['saldo_before'];    
  } 

  $sql3=
  "SELECT
    a.harga_rata_rata
  FROM
    tb_harga_rata_rata AS a
  WHERE
    a.id_perusahaan='".$id_perusahaan."' AND            
    a.kode_barang='".$kode_barang."'";
  $sql3.=" ORDER BY a.tanggal desc,a.id desc LIMIT 1";
  $res3=mysqli_query($db_accounting,$sql3) or die('error 113');
  if(mysqli_num_rows($res3)!=0)
  {
    while($row3=mysqli_fetch_assoc($res3))
    {
      $harga_rata_rata_before=$row3['harga_rata_rata'];
    }
  }
  else
  {
    $harga_rata_rata_before=0;
  }  

  if($saldo_before+$kuantiti_beli==0)
  {
    $harga_rata_rata=0;
  }
  else
  {
    $harga_rata_rata=(($saldo_before*$harga_rata_rata_before)+($kuantiti_beli*$harga_beli*$nilai_tukar))/($saldo_before+$kuantiti_beli);
  }  
  
  if($id_perusahaan==1 AND $kode_barang=='PPK1002')
  {
    $harga_rata_rata=0;
  }

  if($id_perusahaan==1 AND $kode_barang=='PPK1125')
  {
    echo 'Kode Barang : '.$kode_barang.' - Tgl Beli : '.$tgl_pembelian.' - Saldo Before xxx: '.$saldo_before.' - Harga Rata2 Before : '.$harga_rata_rata_before. ' - Kuantiti Beli : '.$kuantiti_beli.' - Harga Beli : '.$harga_beli.' - Nilai Tukar : '.$nilai_tukar.' - Harga Rata2 : '.$harga_rata_rata;
    
  }

  $sql3=
  "INSERT INTO
    tb_harga_rata_rata
  VALUES
  (
    null,
    '".$id_perusahaan."',
    '".$tgl_pembelian."',
    '".$kode_barang."',
    '".$harga_beli*$nilai_tukar."',
    '".$harga_rata_rata."',
    0,
    0
  )";
  mysqli_query($db_accounting,$sql3) or die('error 309');

  $sql3=
  "UPDATE
    tb_master_barang as a
  SET
    a.harga_rata_rata='".$harga_rata_rata."'
  WHERE
    a.kode_barang='".$kode_barang."' AND
    a.id_perusahaan='".$id_perusahaan."'";
  //mysqli_query($db_sistem_stok,$sql3) or die('error 551');
  
  return $harga_rata_rata;
}

function hitung_average_price_old($id_perusahaan,$kode_barang,$tgl_pembelian,$kuantiti_beli,$harga_beli,$nilai_tukar)
{
  //perhitungan harga rata rata
  $saldo_before=0;
  $db_accounting = $GLOBALS["db_accounting"];
  $sql3=
  "SELECT
    ifnull(sum(a.kuantitas_masuk)-sum(a.kuantitas_keluar),0) AS saldo_before
  FROM
    tb_transaksi_persediaan AS a
  WHERE
    a.id_perusahaan='".$id_perusahaan."' AND
    a.kode_barang='".$kode_barang."' AND
    a.tgl_transaksi <= '".$tgl_pembelian."' AND
    a.kode_akun IN (1401,'PBK','NOVAL','NONVALUASI')";
  $sql3.=" ORDER BY a.tgl_transaksi,conv(concat(
    substring(a.id_transaksi, 16, 3)
  , substring(a.id_transaksi, 10, 4)
  , substring(a.id_transaksi, 1, 8)
  ), 16, 10) asc";
  $res3=mysqli_query($db_accounting,$sql3) or die('error 97');
  while($row3=mysqli_fetch_assoc($res3))
  {
    $saldo_before=$row3['saldo_before'];
    //if($kode_barang=='BK1074')
    {
      
    }

    if($kode_barang=='BK1074')
    {
      echo $sql3."\n";
      echo 'saldo adalah '.$row3['saldo_before']."\n";
      //die();
      
    }


    
  }

 

  $sql3=
  "SELECT
    a.harga_rata_rata
  FROM
    tb_harga_rata_rata AS a
  WHERE
    a.id_perusahaan='".$id_perusahaan."' AND            
    a.kode_barang='".$kode_barang."'";
  $sql3.=" ORDER BY a.tanggal desc,a.id desc LIMIT 1";
  $res3=mysqli_query($db_accounting,$sql3) or die('error 113');
  if(mysqli_num_rows($res3)!=0)
  {
    while($row3=mysqli_fetch_assoc($res3))
    {
      $harga_rata_rata_before=$row3['harga_rata_rata'];
    }
  }
  else
  {
    $harga_rata_rata_before=0;
  }  

  if($saldo_before+$kuantiti_beli==0)
  {
    echo 'Kode Barang : '.$kode_barang.' - Tgl Beli : '.$tgl_pembelian.' - Saldo Before : '.$saldo_before.' - Harga Rata2 Before : '.$harga_rata_rata_before. ' - Kuantiti Beli : '.$kuantiti_beli.' - Harga Beli : '.$harga_beli.' - Nilai Tukar : '.$nilai_tukar;
    $harga_rata_rata=0;
  }
  else
  {
    //echo 'Kode Barang : '.$kode_barang.' - Tgl Beli : '.$tgl_pembelian.' - Saldo Before : '.$saldo_before.' - Harga Rata2 Before : '.$harga_rata_rata_before. ' - Kuantiti Beli : '.$kuantiti_beli.' - Harga Beli : '.$harga_beli.' - Nilai Tukar : '.$nilai_tukar;
    $harga_rata_rata=(($saldo_before*$harga_rata_rata_before)+($kuantiti_beli*$harga_beli*$nilai_tukar))/($saldo_before+$kuantiti_beli);
  }

  if($kode_barang=='BG1365')
  {
    echo 'Kode Barang : '.$kode_barang.' - Tgl Beli : '.$tgl_pembelian.' - Saldo Before xxx: '.$saldo_before.' - Harga Rata2 Before : '.$harga_rata_rata_before. ' - Kuantiti Beli : '.$kuantiti_beli.' - Harga Beli : '.$harga_beli.' - Nilai Tukar : '.$nilai_tukar.' - Harga Rata2 : '.$harga_rata_rata;
    
  }
   
  if($id_perusahaan==1 AND $kode_barang=='PPK1002')
  {
    $harga_rata_rata=0;
  }
  
  $sql3=
  "INSERT INTO
    tb_harga_rata_rata
  VALUES
  (
    null,
    '".$id_perusahaan."',
    '".$tgl_pembelian."',
    '".$kode_barang."',
    '".$harga_beli*$nilai_tukar."',
    '".$harga_rata_rata."',
    0,
    0
  )";
  mysqli_query($db_accounting,$sql3) or die('error 110');
  
  return $harga_rata_rata;
}

function hitung_average_price_penyesuaian($id_perusahaan,$kode_barang,$tgl_pembelian,$kuantiti_beli,$harga_beli,$nilai_tukar)
{
  //perhitungan harga rata rata
  $saldo_before=0;
  $db_accounting = $GLOBALS["db_accounting"];
  $db_sistem_stok = $GLOBALS["db_sistem_stok"];
  $sql3=
  "SELECT
    ifnull(sum(a.kuantitas_masuk)-sum(a.kuantitas_keluar),0) AS saldo_before
  FROM
    tb_transaksi_persediaan AS a
  WHERE
    a.id_perusahaan='".$id_perusahaan."' AND
    a.kode_barang='".$kode_barang."' AND
    a.tgl_transaksi <= '".$tgl_pembelian."' AND
    a.kode_akun IN (1401,'PBK','NOVAL','NONVALUASI')";
  $sql3.=" ORDER BY a.tgl_transaksi,conv(concat(
    substring(a.id_transaksi, 16, 3)
  , substring(a.id_transaksi, 10, 4)
  , substring(a.id_transaksi, 1, 8)
  ), 16, 10) asc";
  $res3=mysqli_query($db_accounting,$sql3) or die('error 97');
  while($row3=mysqli_fetch_assoc($res3))
  {
    $saldo_before=$row3['saldo_before'];    
  } 
  
  $sql3=
  "SELECT
    a.harga_rata_rata
  FROM
    tb_harga_rata_rata AS a
  WHERE
    a.id_perusahaan='".$id_perusahaan."' AND            
    a.kode_barang='".$kode_barang."'";
  $sql3.=" ORDER BY a.tanggal desc,a.id desc LIMIT 1";
  $res3=mysqli_query($db_accounting,$sql3) or die('error 113');
  if(mysqli_num_rows($res3)!=0)
  {
    while($row3=mysqli_fetch_assoc($res3))
    {
      $harga_rata_rata_before=$row3['harga_rata_rata'];
    }
  }
  else
  {
    $harga_rata_rata_before=0;
  }  

  if($saldo_before+$kuantiti_beli==0)
  {
    $harga_rata_rata=0;
  }
  else
  {
    $harga_rata_rata=(($saldo_before*$harga_rata_rata_before)+($kuantiti_beli*$harga_beli*$nilai_tukar))/($saldo_before+$kuantiti_beli);
  }  
  
  if($id_perusahaan==1 AND $kode_barang=='PPK1002')
  {
    $harga_rata_rata=0;
  }

  if($id_perusahaan==1 AND $kode_barang=='PPK1125')
  {
    echo 'Kode Barang : '.$kode_barang.' - Tgl Beli : '.$tgl_pembelian.' - Saldo Before xxx: '.$saldo_before.' - Harga Rata2 Before : '.$harga_rata_rata_before. ' - Kuantiti Beli : '.$kuantiti_beli.' - Harga Beli : '.$harga_beli.' - Nilai Tukar : '.$nilai_tukar.' - Harga Rata2 : '.$harga_rata_rata;
    
  }

  if($saldo_before==0)
  {
    $harga_rata_rata=0;
  }

  $sql3=
  "INSERT INTO
    tb_harga_rata_rata
  VALUES
  (
    null,
    '".$id_perusahaan."',
    '".$tgl_pembelian."',
    '".$kode_barang."',
    '".$harga_beli*$nilai_tukar."',
    '".$harga_rata_rata."',
    0,
    0
  )";
  mysqli_query($db_accounting,$sql3) or die('error 309');

  $sql3=
  "UPDATE
    tb_master_barang as a
  SET
    a.harga_rata_rata='".$harga_rata_rata."'
  WHERE
    a.kode_barang='".$kode_barang."' AND
    a.id_perusahaan='".$id_perusahaan."'";
  //mysqli_query($db_sistem_stok,$sql3) or die('error 551');
  
  return $harga_rata_rata;
}

function hitung_average_price_test($id_perusahaan,$kode_barang,$tgl_pembelian,$kuantiti_beli,$harga_beli,$nilai_tukar)
{
  //perhitungan harga rata rata
  $saldo_before=0;
  $db_accounting = $GLOBALS["db_accounting"];
  $db_sistem_stok = $GLOBALS["db_sistem_stok"];
  $sql3=
  "SELECT
    ifnull(sum(a.kuantitas_masuk)-sum(a.kuantitas_keluar),0) AS saldo_before
  FROM
    tb_transaksi_persediaan_test AS a
  WHERE
    a.id_perusahaan='".$id_perusahaan."' AND
    a.kode_barang='".$kode_barang."' AND
    a.tgl_transaksi <= '".$tgl_pembelian."' AND
    a.kode_akun IN (1401,'PBK','NOVAL','NONVALUASI')";
  $sql3.=" ORDER BY a.tgl_transaksi,conv(concat(
    substring(a.id_transaksi, 16, 3)
  , substring(a.id_transaksi, 10, 4)
  , substring(a.id_transaksi, 1, 8)
  ), 16, 10) asc";
  $res3=mysqli_query($db_accounting,$sql3) or die('error 97');
  while($row3=mysqli_fetch_assoc($res3))
  {
    $saldo_before=$row3['saldo_before'];    
  } 

  $sql3=
  "SELECT
    a.harga_rata_rata
  FROM
    tb_harga_rata_rata_test AS a
  WHERE
    a.id_perusahaan='".$id_perusahaan."' AND            
    a.kode_barang='".$kode_barang."'";
  $sql3.=" ORDER BY a.tanggal desc,a.id desc LIMIT 1";
  $res3=mysqli_query($db_accounting,$sql3) or die('error 113');
  if(mysqli_num_rows($res3)!=0)
  {
    while($row3=mysqli_fetch_assoc($res3))
    {
      $harga_rata_rata_before=$row3['harga_rata_rata'];
    }
  }
  else
  {
    $harga_rata_rata_before=0;
  }  

  if($saldo_before+$kuantiti_beli==0)
  {
    $harga_rata_rata=0;
  }
  else
  {
    $harga_rata_rata=(($saldo_before*$harga_rata_rata_before)+($kuantiti_beli*$harga_beli*$nilai_tukar))/($saldo_before+$kuantiti_beli);
  }  
  
  if($id_perusahaan==1 AND $kode_barang=='PPK1002')
  {
    $harga_rata_rata=0;
  }

  if($id_perusahaan==1 AND $kode_barang=='PPK1125')
  {
    echo 'Kode Barang : '.$kode_barang.' - Tgl Beli : '.$tgl_pembelian.' - Saldo Before xxx: '.$saldo_before.' - Harga Rata2 Before : '.$harga_rata_rata_before. ' - Kuantiti Beli : '.$kuantiti_beli.' - Harga Beli : '.$harga_beli.' - Nilai Tukar : '.$nilai_tukar.' - Harga Rata2 : '.$harga_rata_rata;
    
  }

  $sql3=
  "INSERT INTO
    tb_harga_rata_rata_test
  VALUES
  (
    null,
    '".$id_perusahaan."',
    '".$tgl_pembelian."',
    '".$kode_barang."',
    '".$harga_beli*$nilai_tukar."',
    '".$harga_rata_rata."',
    0,
    0
  )";
  mysqli_query($db_accounting,$sql3) or die('error 309');

  $sql3=
  "UPDATE
    tb_master_barang as a
  SET
    a.harga_rata_rata='".$harga_rata_rata."'
  WHERE
    a.kode_barang='".$kode_barang."' AND
    a.id_perusahaan='".$id_perusahaan."'";
  //mysqli_query($db_sistem_stok,$sql3) or die('error 551');
  
  return $harga_rata_rata;
}

function hitung_average_price_penyesuaian_test($id_perusahaan,$kode_barang,$tgl_pembelian,$kuantiti_beli,$harga_beli,$nilai_tukar)
{
  //perhitungan harga rata rata
  $saldo_before=0;
  $db_accounting = $GLOBALS["db_accounting"];
  $sql3=
  "SELECT
    ifnull(sum(a.kuantitas_masuk)-sum(a.kuantitas_keluar),0) AS saldo_before
  FROM
    tb_transaksi_persediaan_test AS a
  WHERE
    a.id_perusahaan='".$id_perusahaan."' AND
    a.kode_barang='".$kode_barang."' AND
    a.tgl_transaksi <= '".$tgl_pembelian."' AND
    a.kode_akun IN (1401,'PBK','NOVAL','NONVALUASI')";
  $sql3.=" ORDER BY a.tgl_transaksi,conv(concat(
    substring(a.id_transaksi, 16, 3)
  , substring(a.id_transaksi, 10, 4)
  , substring(a.id_transaksi, 1, 8)
  ), 16, 10) asc";
  $res3=mysqli_query($db_accounting,$sql3) or die('error 97');
  while($row3=mysqli_fetch_assoc($res3))
  {
    $saldo_before=$row3['saldo_before'];    
  } 
  
  $sql3=
  "SELECT
    a.harga_rata_rata
  FROM
    tb_harga_rata_rata_test AS a
  WHERE
    a.id_perusahaan='".$id_perusahaan."' AND            
    a.kode_barang='".$kode_barang."'";
  $sql3.=" ORDER BY a.tanggal desc,a.id desc LIMIT 1";
  $res3=mysqli_query($db_accounting,$sql3) or die('error 113');
  if(mysqli_num_rows($res3)!=0)
  {
    while($row3=mysqli_fetch_assoc($res3))
    {
      $harga_rata_rata_before=$row3['harga_rata_rata'];
    }
  }
  else
  {
    $harga_rata_rata_before=0;
  }  

  if($saldo_before+$kuantiti_beli==0)
  {
    $harga_rata_rata=0;
  }
  else
  {
    $harga_rata_rata=(($saldo_before*$harga_rata_rata_before)+($kuantiti_beli*$harga_beli*$nilai_tukar))/($saldo_before+$kuantiti_beli);
  }  
  
  if($id_perusahaan==1 AND $kode_barang=='PPK1002')
  {
    $harga_rata_rata=0;
  }

  if($id_perusahaan==1 AND $kode_barang=='PPK1125')
  {
    echo 'Kode Barang : '.$kode_barang.' - Tgl Beli : '.$tgl_pembelian.' - Saldo Before xxx: '.$saldo_before.' - Harga Rata2 Before : '.$harga_rata_rata_before. ' - Kuantiti Beli : '.$kuantiti_beli.' - Harga Beli : '.$harga_beli.' - Nilai Tukar : '.$nilai_tukar.' - Harga Rata2 : '.$harga_rata_rata;
    
  }

  if($saldo_before==0)
  {
    $harga_rata_rata=0;
  }

  $sql3=
  "INSERT INTO
    tb_harga_rata_rata_test
  VALUES
  (
    null,
    '".$id_perusahaan."',
    '".$tgl_pembelian."',
    '".$kode_barang."',
    '".$harga_beli*$nilai_tukar."',
    '".$harga_rata_rata."',
    0,
    0
  )";
  mysqli_query($db_accounting,$sql3) or die('error 309');

  $sql3=
  "UPDATE
    tb_master_barang as a
  SET
    a.harga_rata_rata='".$harga_rata_rata."'
  WHERE
    a.kode_barang='".$kode_barang."' AND
    a.id_perusahaan='".$id_perusahaan."'";
  //mysqli_query($db_sistem_stok,$sql3) or die('error 551');
  
  return $harga_rata_rata;
}

function hitung_average_price_test_old2($id_perusahaan,$kode_barang,$tgl_pembelian,$kuantiti_beli,$harga_beli,$nilai_tukar)
{
  //perhitungan harga rata rata
  $saldo_before=0;
  $db_accounting = $GLOBALS["db_accounting"];
  $sql3=
  "SELECT
    ifnull(sum(a.kuantitas_masuk)-sum(a.kuantitas_keluar),0) AS saldo_before
  FROM
    tb_transaksi_persediaan_test AS a
  WHERE
    a.id_perusahaan='".$id_perusahaan."' AND
    a.kode_barang='".$kode_barang."' AND
    a.tgl_transaksi <= '".$tgl_pembelian."' AND
    a.kode_akun IN (1401,'PBK','NOVAL','NONVALUASI')";
  $sql3.=" ORDER BY a.tgl_transaksi,conv(concat(
    substring(a.id_transaksi, 16, 3)
  , substring(a.id_transaksi, 10, 4)
  , substring(a.id_transaksi, 1, 8)
  ), 16, 10) asc";
  $res3=mysqli_query($db_accounting,$sql3) or die('error 97');
  while($row3=mysqli_fetch_assoc($res3))
  {
    $saldo_before=$row3['saldo_before'];
    //if($kode_barang=='BK1074')
    {
      
    }

    if($kode_barang=='BK1074')
    {
      echo $sql3."\n";
      echo 'saldo adalah '.$row3['saldo_before']."\n";
      //die();
      
    }


    
  }

 

  $sql3=
  "SELECT
    a.harga_rata_rata
  FROM
    tb_harga_rata_rata_test AS a
  WHERE
    a.id_perusahaan='".$id_perusahaan."' AND            
    a.kode_barang='".$kode_barang."' AND
    a.harga_rata_rata<>0";
  $sql3.=" ORDER BY a.tanggal desc,a.id desc LIMIT 1";
  $res3=mysqli_query($db_accounting,$sql3) or die('error 113');
  if(mysqli_num_rows($res3)!=0)
  {
    while($row3=mysqli_fetch_assoc($res3))
    {
      $harga_rata_rata_before=$row3['harga_rata_rata'];
    }
  }
  else
  {
    $harga_rata_rata_before=0;
  }  

  if($saldo_before+$kuantiti_beli==0)
  {
    echo 'Kode Barang : '.$kode_barang.' - Tgl Beli : '.$tgl_pembelian.' - Saldo Before : '.$saldo_before.' - Harga Rata2 Before : '.$harga_rata_rata_before. ' - Kuantiti Beli : '.$kuantiti_beli.' - Harga Beli : '.$harga_beli.' - Nilai Tukar : '.$nilai_tukar;
    $harga_rata_rata=0;
  }
  else
  {
    //echo 'Kode Barang : '.$kode_barang.' - Tgl Beli : '.$tgl_pembelian.' - Saldo Before : '.$saldo_before.' - Harga Rata2 Before : '.$harga_rata_rata_before. ' - Kuantiti Beli : '.$kuantiti_beli.' - Harga Beli : '.$harga_beli.' - Nilai Tukar : '.$nilai_tukar;
    $harga_rata_rata=(($saldo_before*$harga_rata_rata_before)+($kuantiti_beli*$harga_beli*$nilai_tukar))/($saldo_before+$kuantiti_beli);
  }

  if($kode_barang=='BG1365')
  {
    echo 'Kode Barang : '.$kode_barang.' - Tgl Beli : '.$tgl_pembelian.' - Saldo Before xxx: '.$saldo_before.' - Harga Rata2 Before : '.$harga_rata_rata_before. ' - Kuantiti Beli : '.$kuantiti_beli.' - Harga Beli : '.$harga_beli.' - Nilai Tukar : '.$nilai_tukar.' - Harga Rata2 : '.$harga_rata_rata;
    
  }
   

  $sql3=
  "INSERT INTO
    tb_harga_rata_rata_test
  VALUES
  (
    null,
    '".$id_perusahaan."',
    '".$tgl_pembelian."',
    '".$kode_barang."',
    '".$harga_beli*$nilai_tukar."',
    '".$harga_rata_rata."',
    0,
    0
  )";
  mysqli_query($db_accounting,$sql3) or die('error 309');
  
  return $harga_rata_rata;
}

function hitung_average_price_test_old($id_perusahaan,$kode_barang,$tgl_pembelian,$kuantiti_beli,$harga_beli,$nilai_tukar)
{
  //perhitungan harga rata rata
  $db_accounting = $GLOBALS["db_accounting"];
  $sql3=
  "SELECT
    ifnull(sum(a.kuantitas_masuk)-sum(a.kuantitas_keluar),0) AS saldo_before
  FROM
    tb_transaksi_persediaan_test AS a
  WHERE
    a.id_perusahaan='".$id_perusahaan."' AND
    a.kode_barang='".$kode_barang."' AND
    a.tgl_transaksi<='".$tgl_pembelian."' AND
    a.kode_akun IN (1401,'PBK','NOVAL')";
  $sql3.=" ORDER BY a.tgl_transaksi,conv(concat(
    substring(a.id_transaksi, 16, 3)
  , substring(a.id_transaksi, 10, 4)
  , substring(a.id_transaksi, 1, 8)
  ), 16, 10) asc";
  $res3=mysqli_query($db_accounting,$sql3) or die('error 97');
  while($row3=mysqli_fetch_assoc($res3))
  {
    $saldo_before=$row3['saldo_before'];
  }

  $sql3=
  "SELECT
    a.harga_rata_rata
  FROM
    tb_harga_rata_rata_test AS a
  WHERE
    a.id_perusahaan='".$id_perusahaan."' AND            
    a.kode_barang='".$kode_barang."'";
  $sql3.=" ORDER BY a.tanggal desc,a.id desc LIMIT 1";
  $res3=mysqli_query($db_accounting,$sql3) or die('error 113');
  if(mysqli_num_rows($res3)!=0)
  {
    while($row3=mysqli_fetch_assoc($res3))
    {
      $harga_rata_rata_before=$row3['harga_rata_rata'];
    }
  }
  else
  {
    $harga_rata_rata_before=0;
  }  

  if($saldo_before+$kuantiti_beli==0)
  {
    echo 'Kode Barang : '.$kode_barang.' - Tgl Beli : '.$tgl_pembelian.' - Saldo Before : '.$saldo_before.' - Harga Rata2 Before : '.$harga_rata_rata_before. ' - Kuantiti Beli : '.$kuantiti_beli.' - Harga Beli : '.$harga_beli.' - Nilai Tukar : '.$nilai_tukar;
    $harga_rata_rata=0;
  }
  else
  {
    //echo 'Kode Barang : '.$kode_barang.' - Tgl Beli : '.$tgl_pembelian.' - Saldo Before : '.$saldo_before.' - Harga Rata2 Before : '.$harga_rata_rata_before. ' - Kuantiti Beli : '.$kuantiti_beli.' - Harga Beli : '.$harga_beli.' - Nilai Tukar : '.$nilai_tukar;
    $harga_rata_rata=(($saldo_before*$harga_rata_rata_before)+($kuantiti_beli*$harga_beli*$nilai_tukar))/($saldo_before+$kuantiti_beli);
  }

  if($kode_barang=='INV1452')
  {
    echo 'Kode Barang : '.$kode_barang.' - Tgl Beli : '.$tgl_pembelian.' - Saldo Before : '.$saldo_before.' - Harga Rata2 Before : '.$harga_rata_rata_before. ' - Kuantiti Beli : '.$kuantiti_beli.' - Harga Beli : '.$harga_beli.' - Nilai Tukar : '.$nilai_tukar.' - Harga Rata2 : '.$harga_rata_rata;
    
  }
   

  $sql3=
  "INSERT INTO
    tb_harga_rata_rata_test
  VALUES
  (
    null,
    '".$id_perusahaan."',
    '".$tgl_pembelian."',
    '".$kode_barang."',
    '".$harga_beli*$nilai_tukar."',
    '".$harga_rata_rata."',
    0,
    0
  )";
  mysqli_query($db_accounting,$sql3) or die('error 110');
  
  return $harga_rata_rata;
}

function format_angka($angka)
{
  if($angka>=0)
  {
    return number_format($angka,2);    
  }
  else
  {
    return '<font color="red">('.number_format(abs($angka),2).')</font>';
  }
}

function saldo_awal_hutang_pemasok($id_supplier,$kode_perusahaan,$tanggal)
{
    $db_internal_system = $GLOBALS["db_internal_system"];
    $db_accounting = $GLOBALS["db_accounting"];

    /*if($tanggal=='2017-12-31')
    {
      $tanggal='2018-01-01';
    }*/
    $sql=
    "SELECT
      sum(a.total_pembelian) as jumlah_total_pembelian
    FROM
      tb_purchasing_pembelian as a
    WHERE
      a.tgl_pembelian<'".$tanggal."' AND
      a.perusahaan='".$kode_perusahaan."' AND
      a.id_supplier_pembelian='".$id_supplier."'";
    $res=mysqli_query($db_internal_system,$sql) or die('error 309');
    while($row=mysqli_fetch_assoc($res))
    {
      $jumlah_total_pembelian=$row['jumlah_total_pembelian'];
    }   

    if($id_supplier==475)
    {
      //echo $sql;
    }
    
    $sql=
    "SELECT
      sum(b.jumlah_pembayaran) as jumlah_total_pelunasan
    FROM
      pembayaran_hutang_supplier as a
    LEFT JOIN
      detail_pembayaran_hutang_supplier as b ON (b.id_pembayaran=a.id_pembayaran)
    JOIN
      detail_mutasi_kas_dan_bank as c on (c.id_detail_mutasi=a.id_detail_mutasi)
    WHERE
      c.tanggal<'".$tanggal."' AND
      a.id_supplier='".$id_supplier."' AND
      c.is_valid=1";
    $res=mysqli_query($db_accounting,$sql) or die('error 325'); 
    while($row=mysqli_fetch_assoc($res))
    {
      $jumlah_total_pelunasan=$row['jumlah_total_pelunasan'];
    }

    $sql=
    "SELECT
      sum(a.total_pengembalian) AS jumlah_total_pengembalian
    FROM
      tb_purchasing_pengembalian AS a
    WHERE
      a.tgl_pengembalian<'".$tanggal."' AND
      a.perusahaan='".$kode_perusahaan."' AND
      a.id_supplier_pengembalian='".$id_supplier."'";
    $res=mysqli_query($db_internal_system,$sql) or die('error 340');
    while($row=mysqli_fetch_assoc($res))
    {
      $jumlah_total_pengembalian=$row['jumlah_total_pengembalian'];
    }

    $sql=
    "SELECT
      b.debet_or_credit,
      b.nominal as total_bukti_jurnal
    FROM
      detail_jurnal_transaksi_link as a
    JOIN
      detail_jurnal_transaksi as b on (b.id_detail_jurnal=a.id_detail_jurnal)
    JOIN
      jurnal_transaksi as c on (c.id_jurnal=b.id_jurnal)
    LEFT JOIN
      list_kode_akun as d ON (d.id_akun=b.id_akun)
    WHERE
      c.tanggal<'".$tanggal."' AND
      a.id_link='".$id_supplier."' AND
      a.id_tipe_link=1"; 
    $res=mysqli_query($db_accounting,$sql) or die('error 959'); 
    $jumlah_total_bukti_jurnal=0;                           
    while($row=mysqli_fetch_assoc($res))
    {
      if($row['debet_or_credit']=='dr')
      {
        $jumlah_total_bukti_jurnal-=$row['total_bukti_jurnal'];
      }
      else
      {
        $jumlah_total_bukti_jurnal+=$row['total_bukti_jurnal'];
      }  
    } 
    return $jumlah_total_pembelian-$jumlah_total_pelunasan-$jumlah_total_pengembalian+$jumlah_total_bukti_jurnal;    
}

function saldo_awal_piutang_pelanggan($id_pelanggan,$id_perusahaan,$tanggal)
{
    $db_isistem = $GLOBALS["db_isistem"];
    $db_accounting = $GLOBALS["db_accounting"];
    $sql=
    "SELECT
      sum(a.total_faktur) as jumlah_total_penjualan
    FROM
      tb_faktur_penjualan as a
    WHERE
      a.tgl_faktur<'".$tanggal."' AND
      a.id_perusahaan='".$id_perusahaan."' AND
      a.id_pelanggan='".$id_pelanggan."'";
    $res=mysqli_query($db_isistem,$sql) or die('error 404');
    while($row=mysqli_fetch_assoc($res))
    {
      $jumlah_total_penjualan=$row['jumlah_total_penjualan'];
    }      
    
    $sql=
    "SELECT
      sum(a.nominal_faktur) as jumlah_total_pelunasan
    FROM
      tb_pelunasan_piutang_penjualan as a
    WHERE
      a.tanggal<'".$tanggal."' AND
      a.id_pelanggan='".$id_pelanggan."'";
    $res=mysqli_query($db_accounting,$sql) or die('error 418'); 
    while($row=mysqli_fetch_assoc($res))
    {
      $jumlah_total_pelunasan=$row['jumlah_total_pelunasan'];
    }

    if($id_perusahaan==2 and $id_pelanggan==3)
    {
      $sql=
      "SELECT
        sum(a.total_invoice) as jumlah_total_penjualan
      FROM
        jual_beli_bahan_baku AS a
      WHERE
        a.tanggal_invoice<'".$tanggal."'";
      $res=mysqli_query($db_accounting,$sql) or die('error 686');
      while($row=mysqli_fetch_assoc($res))
      {
        $jumlah_total_penjualan_panen=$row['jumlah_total_penjualan'];
      }
      $jumlah_total_penjualan+=$jumlah_total_penjualan_panen;
      
      $sql=
      "SELECT
        sum(a.jumlah_pembayaran) as jumlah_total_pelunasan
      FROM
        detail_pelunasan_piutang_jual_beli_bahan_baku AS a
      JOIN
        detail_mutasi_kas_dan_bank AS b ON (b.id_detail_mutasi=a.id_detail_mutasi)
      WHERE
        a.tanggal_invoice<'".$tanggal."' AND
        b.is_valid=1";
      $res=mysqli_query($db_accounting,$sql) or die('error 688'); 
      while($row=mysqli_fetch_assoc($res))
      {
        $jumlah_total_pelunasan_panen=$row['jumlah_total_pelunasan'];
      }       
      $jumlah_total_pelunasan+=$jumlah_total_pelunasan_panen;
    }

    /*
    $sql=
    "SELECT
      sum(a.total_pengembalian) AS jumlah_total_pengembalian
    FROM
      tb_purchasing_pengembalian AS a
    WHERE
      a.tgl_pengembalian<'".$tanggal."' AND
      a.perusahaan='".$kode_perusahaan."' AND
      a.id_supplier_pengembalian='".$id_supplier."'";
    $res=mysqli_query($db_internal_system,$sql) or die('error 340');
    while($row=mysqli_fetch_assoc($res))
    {
      $jumlah_total_pengembalian=$row['jumlah_total_pengembalian'];
    }

    $sql=
    "SELECT
      b.debet_or_credit,
      sum(b.nominal) as total_bukti_jurnal
    FROM
      detail_jurnal_transaksi_link as a
    JOIN
      detail_jurnal_transaksi as b on (b.id_detail_jurnal=a.id_detail_jurnal)
    JOIN
      jurnal_transaksi as c on (c.id_jurnal=b.id_jurnal)
    WHERE
      c.tanggal<'".$tanggal."' AND
      a.id_link='".$id_supplier."'"; 
    $res=mysqli_query($db_accounting,$sql) or die('error 343');                            
    while($row=mysqli_fetch_assoc($res))
    {
      $jumlah_total_bukti_jurnal=$row['total_bukti_jurnal'];
      $debet_or_credit=$row['debet_or_credit'];
    }*/
    
    if($debet_or_credit=='dr')
    {
      return $jumlah_total_penjualan-$jumlah_total_pelunasan-$jumlah_total_pengembalian-$jumlah_total_bukti_jurnal;
    }
    else if($debet_or_credit=='cr')
    {
      return $jumlah_total_penjualan-$jumlah_total_pelunasan-$jumlah_total_pengembalian+$jumlah_total_bukti_jurnal;
    }
    else if($debet_or_credit=='')
    {
      return $jumlah_total_penjualan-$jumlah_total_pelunasan-$jumlah_total_pengembalian+$jumlah_total_bukti_jurnal;
    }
    
}

function saldo_awal_piutang_pelanggan_petani($id_pelanggan,$id_perusahaan,$tanggal)
{
    $db_isistem = $GLOBALS["db_isistem"];
    $db_accounting = $GLOBALS["db_accounting"];
    $sql=
    "SELECT
      sum(a.total_faktur) as jumlah_total_penjualan
    FROM
      tb_faktur_penjualan as a
    WHERE
      a.tgl_faktur<'".$tanggal."' AND
      a.id_perusahaan='".$id_perusahaan."' AND
      a.id_pelanggan='".$id_pelanggan."'";
    $res=mysqli_query($db_isistem,$sql) or die('error 404');
    while($row=mysqli_fetch_assoc($res))
    {
      $jumlah_total_penjualan=$row['jumlah_total_penjualan'];
    }      
    
    $sql=
    "SELECT
      ifnull(sum(a.total_pelunasan),0) as jumlah_total_pelunasan
    FROM
      tb_pelunasan_bibit as a
    WHERE
      a.tgl_pelunasan<'".$tanggal."' AND
      a.id_pelanggan='".$id_pelanggan."'";
    $res=mysqli_query($db_accounting,$sql) or die('error 418'); 
    while($row=mysqli_fetch_assoc($res))
    {
      $jumlah_total_pelunasan=$row['jumlah_total_pelunasan'];
    }
    
    if($debet_or_credit=='dr')
    {
      return $jumlah_total_penjualan-$jumlah_total_pelunasan-$jumlah_total_pengembalian-$jumlah_total_bukti_jurnal;
    }
    else if($debet_or_credit=='cr')
    {
      return $jumlah_total_penjualan-$jumlah_total_pelunasan-$jumlah_total_pengembalian+$jumlah_total_bukti_jurnal;
    }
    else if($debet_or_credit=='')
    {
      return $jumlah_total_penjualan-$jumlah_total_pelunasan-$jumlah_total_pengembalian+$jumlah_total_bukti_jurnal;
    }
    
}

function total_pembelian_pemasok($id_supplier,$id_perusahaan,$tgl_awal,$tgl_akhir)
{
  $db_internal_system = $GLOBALS["db_internal_system"];
  $db_accounting = $GLOBALS["db_accounting"];
  $sql=
  "SELECT
    sum(a.total_pembelian) as total_pembelian
  FROM
    tb_purchasing_pembelian as a
  WHERE
    a.tgl_pembelian>='".$tgl_awal."' AND
    a.tgl_pembelian<='".$tgl_akhir."' AND
    a.id_perusahaan='".$id_perusahaan."' AND
    a.id_supplier_pembelian='".$id_supplier."'";
  $res=mysqli_query($db_internal_system,$sql) or die('error 224');
  while($row=mysqli_fetch_assoc($res))
  {
    $jumlah_total_pembelian=$row['total_pembelian'];
  }        

  $jumlah_total_pembelian_panen=0; 
  if($id_perusahaan==1 and $id_supplier==28)
  {
    
    $sql=
    "SELECT
      sum(a.total_invoice) as jumlah_total_pembelian
    FROM
      jual_beli_bahan_baku AS a
    WHERE
      a.tanggal_invoice>='".$tgl_awal."' AND
      a.tanggal_invoice<='".$tgl_akhir."'";
    $res=mysqli_query($db_accounting,$sql) or die('error 1073');
    while($row=mysqli_fetch_assoc($res))
    {
      $jumlah_total_pembelian_panen=$row['jumlah_total_pembelian'];
    }
  }  
  return $jumlah_total_pembelian+=$jumlah_total_pembelian_panen;
}

function total_penjualan_pelanggan($id_pelanggan,$id_perusahaan,$tgl_awal,$tgl_akhir)
{
  $db_isistem = $GLOBALS["db_isistem"];
  $db_accounting = $GLOBALS["db_accounting"];
  $sql=
  "SELECT
    sum(a.total_faktur) as jumlah_total_penjualan
  FROM
    tb_faktur_penjualan as a
  WHERE
    a.tgl_faktur>='".$tgl_awal."' AND
    a.tgl_faktur<='".$tgl_akhir."' AND
    a.id_perusahaan='".$id_perusahaan."' AND
    a.id_pelanggan='".$id_pelanggan."'";
  $res=mysqli_query($db_isistem,$sql) or die('error 508');
  while($row=mysqli_fetch_assoc($res))
  {
    $jumlah_total_penjualan=$row['jumlah_total_penjualan'];
  }        

  $jumlah_total_penjualan_panen=0;  
  if($id_perusahaan==2 and $id_pelanggan==3)
  {
    $sql=
    "SELECT
      sum(a.total_invoice) as jumlah_total_penjualan
    FROM
      jual_beli_bahan_baku AS a
    WHERE
      a.tanggal_invoice>='".$tgl_awal."' AND
      a.tanggal_invoice<='".$tgl_akhir."'";
    $res=mysqli_query($db_accounting,$sql) or die('error 1113');
    while($row=mysqli_fetch_assoc($res))
    {
      $jumlah_total_penjualan_panen=$row['jumlah_total_penjualan'];
    }
  }  
  return $jumlah_total_penjualan+=$jumlah_total_penjualan_panen;
}

function total_penjualan_pelanggan_petani($id_pelanggan,$id_perusahaan,$tgl_awal,$tgl_akhir)
{
  $db_isistem = $GLOBALS["db_isistem"];
  $sql=
  "SELECT
    sum(a.total_faktur) as jumlah_total_penjualan
  FROM
    tb_faktur_penjualan as a
  WHERE
    a.tgl_faktur>='".$tgl_awal."' AND
    a.tgl_faktur<='".$tgl_akhir."' AND
    a.id_perusahaan='".$id_perusahaan."' AND
    a.id_pelanggan='".$id_pelanggan."'";
  $res=mysqli_query($db_isistem,$sql) or die('error 508');
  while($row=mysqli_fetch_assoc($res))
  {
    $jumlah_total_penjualan=$row['jumlah_total_penjualan'];
  }     
  return $jumlah_total_penjualan;
}

function total_pelunasan_pemasok($id_supplier,$id_perusahaan,$tgl_awal,$tgl_akhir)
{
    $db_accounting = $GLOBALS["db_accounting"];
    $sql=
    "SELECT
      sum(a.jumlah) as total_pelunasan
    FROM
      pembayaran_hutang_supplier as a
    JOIN
      detail_mutasi_kas_dan_bank as b on (b.id_detail_mutasi=a.id_detail_mutasi)
    WHERE
      b.tanggal>='".$tgl_awal."' AND
      b.tanggal<='".$tgl_akhir."' AND
      a.id_supplier='".$id_supplier."' AND
      b.is_valid=1";
    $res=mysqli_query($db_accounting,$sql) or die('error 80');            
    while($row=mysqli_fetch_assoc($res))
    {
      $jumlah_total_pelunasan=$row['total_pelunasan'];
    }     
    
    $jumlah_total_pelunasan_panen=0;
    if($id_perusahaan==1 and $id_supplier==28)
    {     
      $sql=
      "SELECT
        sum(a.jumlah_pembayaran) as jumlah_total_pelunasan
      FROM
        detail_pelunasan_hutang_jual_beli_bahan_baku AS a
      JOIN
        detail_mutasi_kas_dan_bank AS b ON (b.id_detail_mutasi=a.id_detail_mutasi)
      WHERE
        b.tanggal>='".$tgl_awal."' AND
        b.tanggal<='".$tgl_akhir."' AND
        b.is_valid=1";
      $res=mysqli_query($db_accounting,$sql) or die('error 1155'); 
      while($row=mysqli_fetch_assoc($res))
      {
        $jumlah_total_pelunasan_panen=$row['jumlah_total_pelunasan'];
      } 
    }
    return $jumlah_total_pelunasan+=$jumlah_total_pelunasan_panen;
}

function total_pelunasan_pelanggan($id_pelanggan,$id_perusahaan,$tgl_awal,$tgl_akhir)
{
    $db_accounting = $GLOBALS["db_accounting"];
    $sql=
    "SELECT
      ifnull(sum(b.jumlah_pembayaran),0) as jumlah_total_pelunasan
    FROM
      tb_pelunasan_piutang_penjualan as a
    JOIN
      tb_pelunasan_piutang_penjualan_detail_faktur AS b ON (b.uuid_pelunasan=a.uuid_pelunasan)
    JOIN
      detail_mutasi_kas_dan_bank AS c ON (c.id_detail_mutasi=a.id_detail_mutasi)
    JOIN
      isistem.tb_master_pelanggan AS d ON (d.id=a.id_pelanggan)
    JOIN
      isistem.tb_master_mata_uang AS e ON (e.id=d.id_mata_uang)
    WHERE
      d.id_perusahaan='".$id_perusahaan."' AND
      c.tanggal>='".$tgl_awal."' AND
      c.tanggal<='".$tgl_akhir."' AND
      a.id_pelanggan='".$id_pelanggan."'";
    $res=mysqli_query($db_accounting,$sql) or die('error 821'); 
    while($row=mysqli_fetch_assoc($res))
    {
      $jumlah_total_pelunasan=$row['jumlah_total_pelunasan'];
    }

    $jumlah_total_pelunasan_panen=0;
    if($id_perusahaan==2 and $id_pelanggan==3)
    {     
      $sql=
      "SELECT
        sum(a.jumlah_pembayaran) as jumlah_total_pelunasan
      FROM
        detail_pelunasan_piutang_jual_beli_bahan_baku AS a
      JOIN
        detail_mutasi_kas_dan_bank AS b ON (b.id_detail_mutasi=a.id_detail_mutasi)
      WHERE
        b.tanggal>='".$tgl_awal."' AND
        b.tanggal<='".$tgl_akhir."' AND
        b.is_valid=1"; 
      $res=mysqli_query($db_accounting,$sql) or die('error 849'); 
      while($row=mysqli_fetch_assoc($res))
      {
        $jumlah_total_pelunasan_panen=$row['jumlah_total_pelunasan'];
      } 
    }
    return $jumlah_total_pelunasan+=$jumlah_total_pelunasan_panen;
}

function total_pelunasan_pelanggan_petani($id_pelanggan,$id_perusahaan,$tgl_awal,$tgl_akhir)
{
    $db_accounting = $GLOBALS["db_accounting"];
    $sql=
    "SELECT
      ifnull(sum(a.total_pelunasan),0) as jumlah_total_pelunasan
    FROM
      tb_pelunasan_bibit as a
    WHERE
      a.tgl_pelunasan>='".$tgl_awal."' AND
      a.tgl_pelunasan<='".$tgl_akhir."' AND
      a.id_pelanggan='".$id_pelanggan."'";
    $res=mysqli_query($db_accounting,$sql) or die('error 821'); 
    while($row=mysqli_fetch_assoc($res))
    {
      $jumlah_total_pelunasan=$row['jumlah_total_pelunasan'];
    }
    return $jumlah_total_pelunasan;
}

function total_retur_pemasok($id_supplier,$kode_perusahaan,$tgl_awal,$tgl_akhir)
{
  $db_internal_system = $GLOBALS["db_internal_system"];
  $sql=
  "SELECT
    sum(a.total_pengembalian) as total_retur
  FROM
    tb_purchasing_pengembalian as a
  WHERE
    a.tgl_pengembalian>='".$tgl_awal."' AND
    a.tgl_pengembalian<='".$tgl_akhir."' AND
    a.perusahaan='".$kode_perusahaan."' AND
    a.id_supplier_pengembalian='".$id_supplier."'";
  $res=mysqli_query($db_internal_system,$sql) or die('error 224');
  while($row=mysqli_fetch_assoc($res))
  {
    return $row['total_retur'];
  }        
}

function total_bukti_jurnal_pemasok($id_supplier,$kode_perusahaan,$tgl_awal,$tgl_akhir)
{
  $db_accounting = $GLOBALS["db_accounting"];
  $sql=
  "SELECT
    b.debet_or_credit,
    b.nominal as total_bukti_jurnal
  FROM
    detail_jurnal_transaksi_link as a
  JOIN
    detail_jurnal_transaksi as b on (b.id_detail_jurnal=a.id_detail_jurnal)
  JOIN
    jurnal_transaksi as c on (c.id_jurnal=b.id_jurnal)
  LEFT JOIN
    list_kode_akun as d ON (d.id_akun=b.id_akun)
  WHERE
    c.tanggal>='".$tgl_awal."' AND
    c.tanggal<='".$tgl_akhir."' AND
    a.id_link='".$id_supplier."' AND    
    a.id_tipe_link=1"; 
  $res=mysqli_query($db_accounting,$sql) or die('error 411'); 
  $total_bukti_jurnal=0;                           
  while($row=mysqli_fetch_assoc($res))
  {    
    if($row['debet_or_credit']=='dr')
    {
      $total_bukti_jurnal-=$row['total_bukti_jurnal'];
    }
    elseif($row['debet_or_credit']=='cr')
    {
      $total_bukti_jurnal+=$row['total_bukti_jurnal'];
    }    
  }  
  return $total_bukti_jurnal;
}

function total_bukti_jurnal_pelanggan($id_pelanggan,$id_perusahaan,$tgl_awal,$tgl_akhir)
{
  $db_accounting = $GLOBALS["db_accounting"];
  $sql=
  "SELECT
    b.debet_or_credit,
    b.nominal as total_bukti_jurnal
  FROM
    detail_jurnal_transaksi_link as a
  JOIN
    detail_jurnal_transaksi as b on (b.id_detail_jurnal=a.id_detail_jurnal)
  JOIN
    jurnal_transaksi as c on (c.id_jurnal=b.id_jurnal)
  WHERE
    c.tanggal>='".$tgl_awal."' AND
    c.tanggal<='".$tgl_akhir."' AND
    a.id_link='".$id_supplier."' AND
    a.id_tipe_link=1"; 
  $res=mysqli_query($db_accounting,$sql) or die('error 1420'); 
  $total_bukti_jurnal=0;                           
  while($row=mysqli_fetch_assoc($res))
  {
    if($row['debet_or_credit']=='dr')
    {
      $total_bukti_jurnal-=$row['total_bukti_jurnal'];
    }
    else
    {
      $total_bukti_jurnal+=$row['total_bukti_jurnal'];
    }
  }      
  return $total_bukti_jurnal;  
}

function get_nama_perusahaan($id_perusahaan)
{
    $db_isistem = $GLOBALS["db_isistem"];
    $sql =
        "SELECT
          a.nama
        FROM
	        tb_master_perusahaan as a
	      WHERE
	        a.id='" . $id_perusahaan . "'";
    $res = mysqli_query($db_isistem, $sql) or die('error 16');
    $count = mysqli_num_rows($res);
    if ($count != 0) {
        while ($row = mysqli_fetch_assoc($res)) {
            return $row['nama'];
        }
    }
}

function get_kode_perusahaan($id_perusahaan)
{
    $db_isistem = $GLOBALS["db_isistem"];
    $sql =
        "SELECT
          a.kode
        FROM
	        tb_master_perusahaan as a
	      WHERE
	        a.id='" . $id_perusahaan . "'";
    $res = mysqli_query($db_isistem, $sql) or die('error 35');
    $count = mysqli_num_rows($res);
    if ($count != 0) {
        while ($row = mysqli_fetch_assoc($res)) {
            return $row['kode'];
        }
    }
}

function selisih_hari($hari_awal, $hari_akhir)
{
    $start_date = new DateTime($hari_awal);
    $end_date = new DateTime($hari_akhir);
    $interval = $start_date->diff($end_date);
    return $interval->days;
}

function leadingZeros($num, $numDigits)
{
    return sprintf("%0" . $numDigits . "d", $num);
}

function get_barang($kode_barang)
{
    $db_sistem_stok = $GLOBALS["db_sistem_stok"];
    $id_perusahaan = $GLOBALS["id_perusahaan"];

    $sql =
        "SELECT barang FROM
	tb_master_barang
	WHERE
	kode_barang='" . $kode_barang . "' AND
	id_perusahaan='" . $id_perusahaan . "'";

    $res = mysqli_query($db_sistem_stok, $sql) or die('error 18');

    $count = mysqli_num_rows($res);

    if ($count == 0) {
        return 'N/A';
    } else {
        while ($row = mysqli_fetch_assoc($res)) {
            return $row['barang'];
        }
    }
}

function get_satuan($kode_barang)
{
    $db_sistem_stok = $GLOBALS["db_sistem_stok"];
    $id_perusahaan = $GLOBALS["id_perusahaan"];

    $sql =
        "SELECT satuan FROM
	tb_master_barang
	WHERE
	kode_barang='" . $kode_barang . "' AND
	id_perusahaan='" . $id_perusahaan . "'";

    $res = mysqli_query($db_sistem_stok, $sql) or die('error 48');

    $count = mysqli_num_rows($res);

    if ($count == 0) {
        return 'N/A';
    } else {
        while ($row = mysqli_fetch_assoc($res)) {
            return $row['satuan'];
        }
    }
}

function get_transisi($id_transisi)
{
    $db_sistem_stok = $GLOBALS["db_sistem_stok"];

    $sql =
        "SELECT transisi FROM
	tb_master_transisi
	WHERE
	id_transisi='" . $id_transisi . "'";

    $res = mysqli_query($db_sistem_stok, $sql) or die('error 60');

    $count = mysqli_num_rows($res);

    if ($count == 0) {
        return 'N/A';
    } else {
        while ($row = mysqli_fetch_assoc($res)) {
            return $row['transisi'];
        }
    }
}

function cek_kunci($tanggal)
{
    $bulan_aktif = $GLOBALS["bulan_aktif"];
    $tahun_aktif = $GLOBALS["tahun_aktif"];

    $today = date_parse($tanggal);
    $bulan_now = $today['month'];
    $tahun_now = $today['year'];

    if ($bulan_now == $bulan_aktif and $tahun_now == $tahun_aktif) {
        return 1;
    } else {
        return 0;
    }

}

function get_saldo($kode_barang)
{
    $db_sistem_stok = $GLOBALS["db_sistem_stok"];
    $id_perusahaan = $GLOBALS["id_perusahaan"];
    $id_gudang = $GLOBALS["id_gudang"];

    $sql =
        "SELECT ifnull(sum(kuantitas_masuk)-sum(kuantitas_keluar),0) as saldo FROM
	tb_transaksi_barang
	WHERE
	id_perusahaan='" . $id_perusahaan . "' and
	id_gudang='" . $id_gudang . "' and
	kode_barang='" . $kode_barang . "'";
    $res = mysqli_query($db_sistem_stok, $sql) or die('error 12');
    $count = mysqli_num_rows($res);
    if ($count == 0) {
        $saldo = 0;
    } else {
        while ($row = mysqli_fetch_assoc($res)) {
            $saldo = $row['saldo'];
        }
    }

    return $saldo;
}

function get_saldo_transisi($kode_barang, $id_transisi)
{
    $db_sistem_stok = $GLOBALS["db_sistem_stok"];
    $id_perusahaan = $GLOBALS["id_perusahaan"];
    $id_gudang = $GLOBALS["id_gudang"];

    $sql =
        "SELECT ifnull(sum(kuantitas_masuk)-sum(kuantitas_keluar),0) as saldo FROM
	tb_transaksi_barang_transisi
	WHERE
	id_perusahaan='" . $id_perusahaan . "' and
	id_gudang='" . $id_gudang . "' and
	id_transisi='" . $id_transisi . "' and
	kode_barang='" . $kode_barang . "'";
    $res = mysqli_query($db_sistem_stok, $sql) or die('error 12');
    $count = mysqli_num_rows($res);
    if ($count == 0) {
        $saldo = 0;
    } else {
        while ($row = mysqli_fetch_assoc($res)) {
            $saldo = $row['saldo'];
        }
    }
    return $saldo;
}

function get_saldo_transisi_per_tanggal($kode_barang, $id_transisi, $tgl_transaksi)
{
    $db_sistem_stok = $GLOBALS["db_sistem_stok"];
    $id_perusahaan = $GLOBALS["id_perusahaan"];
    $id_gudang = $GLOBALS["id_gudang"];

    $sql =
        "SELECT ifnull(sum(kuantitas_masuk)-sum(kuantitas_keluar),0) as saldo FROM
	tb_transaksi_barang_transisi
	WHERE
	id_perusahaan='" . $id_perusahaan . "' and
	id_gudang='" . $id_gudang . "' and
	id_transisi='" . $id_transisi . "' and
	kode_barang='" . $kode_barang . "' and
	tgl_transaksi<='" . $tgl_transaksi . "'";
    $res = mysqli_query($db_sistem_stok, $sql) or die('error 12');
    $count = mysqli_num_rows($res);
    if ($count == 0) {
        $saldo = 0;
    } else {
        while ($row = mysqli_fetch_assoc($res)) {
            $saldo = $row['saldo'];
        }
    }

    return $saldo;
}

function hitung_harga_rata_rata($kode_barang)
{
    $db_sistem_stok = $GLOBALS["db_sistem_stok"];

    $sql =
        "SELECT harga_rata_rata FROM tb_master_barang
  	WHERE
  	id_perusahaan='" . $id_perusahaan . "' AND
  	kode_barang='" . $kode_barang . "'";
    $res = mysqli_query($db_sistem_stok, $sql) or die('error 496');
    $count = mysqli_num_rows($res);
    if ($count == 0) {
        $harga_rata_rata = 0;
    } else {
        while ($row = mysqli_fetch_assoc($res)) {
            $harga_rata_rata = $row['harga_rata_rata'];
        }
    }

    $sql =
        "SELECT (sum(kuantitas_masuk)-sum(kuantitas_keluar)) as saldo  FROM tb_transaksi_barang
  	WHERE
  	id_perusahaan='" . $id_perusahaan . "' AND
  	id_gudang='" . $id_gudang . "' AND
  	kode_barang='" . $kode_barang . "'";
    $res = mysqli_query($db_sistem_stok, $sql);
    while ($row = mysqli_fetch_assoc($res)) {
        $saldo = $row['saldo'];
    }

    $value_pembelian = ($kuantiti_pembelian * $harga_pembelian);
    $value_before = $saldo * $harga_rata_rata;

    $x = $kuantiti_pembelian + $saldo;
    if ($x == 0) {
        $harga_rata_rata = 0;
    } else {
        $harga_rata_rata = ($value_pembelian + $value_before) / ($kuantiti_pembelian + $saldo);
    }
}

function cek_id_akun($interface, $id_perusahaan)
{
    $db_sistem_stok = $GLOBALS["db_sistem_stok"];

    $sql =
        "SELECT id_akun_debit,id_akun_kredit FROM
	tb_master_posting_no_akun
	WHERE
	id_perusahaan='" . $id_perusahaan . "' AND
	interface='" . $interface . "'";

    $res = mysqli_query($db_sistem_stok, $sql) or die('error 28');

    $count = mysqli_num_rows($res);

    if ($count == 0) {
        $id_akun_debit = 0;
        $id_akun_kredit = 0;
    } else {
        while ($row = mysqli_fetch_assoc($res)) {
            $id_akun_debit = $row['id_akun_debit'];
            $id_akun_kredit = $row['id_akun_kredit'];
        }
    }

    return array($id_akun_debit, $id_akun_kredit);
}

function formatNoBPB($gudang, $bulan_bpb1, $tahun_bpb1)
{
    $db_stok = $GLOBALS["db_stok"];

    $sql = "select kode_gudang from tb_master_gudang where gudang='$gudang'";
    $res = mysqli_query($db_stok, $sql);
    while ($row = mysqli_fetch_array($res)) {
        $kode_gudang = $row['kode_gudang'];
    }

    $format_no_bpb = '/' . $kode_gudang . '/BPB/' . $bulan_bpb1 . '/' . $tahun_bpb1;

    return $format_no_bpb;
}
function parseBulan($tanggal)
{
    $today = date_parse($tanggal);
    return $today['month'];
}

function parseTahun($tanggal)
{
    $today = date_parse($tanggal);
    return $today['year'];
}

function bulanRomawi($bulan)
{
    switch ($bulan) {
        case 1:$bulan_romawi = 'I';
            break;
        case 2:$bulan_romawi = 'II';
            break;
        case 3:$bulan_romawi = 'III';
            break;
        case 4:$bulan_romawi = 'IV';
            break;
        case 5:$bulan_romawi = 'V';
            break;
        case 6:$bulan_romawi = 'VI';
            break;
        case 7:$bulan_romawi = 'VII';
            break;
        case 8:$bulan_romawi = 'VIII';
            break;
        case 9:$bulan_romawi = 'IX';
            break;
        case 10:$bulan_romawi = 'X';
            break;
        case 11:$bulan_romawi = 'XI';
            break;
        default:$bulan_romawi = 'XII';
            break;
    }

    return $bulan_romawi;
}

function bulanHuruf($bulan)
{
    switch ($bulan) {
        case 1:$bulan_huruf = 'januari';
            break;
        case 2:$bulan_huruf = 'februari';
            break;
        case 3:$bulan_huruf = 'maret';
            break;
        case 4:$bulan_huruf = 'april';
            break;
        case 5:$bulan_huruf = 'mei';
            break;
        case 6:$bulan_huruf = 'juni';
            break;
        case 7:$bulan_huruf = 'juli';
            break;
        case 8:$bulan_huruf = 'agustus';
            break;
        case 9:$bulan_huruf = 'september';
            break;
        case 10:$bulan_huruf = 'oktober';
            break;
        case 11:$bulan_huruf = 'november';
            break;
        default:$bulan_huruf = 'desember';
            break;
    }

    return $bulan_huruf;
}

function navigasi_ke($alamat)
{
    ?>
<script type="text/javascript">
document.location = "<?php echo $alamat ?>";
</script>
<?php
}

function alert_php($var)
{

    ?>
<script type="text/javascript">
alert('<?=$var?>');
</script>
<?php
}

function cek_detail($id_permintaan)
{
    $db_stok = $GLOBALS["db_stok"];

    $sql = "select a.id_permintaan from tb_purchasing_permintaan as a,tb_purchasing_permintaan_detail as b where a.id_permintaan=b.id_permintaan and a.id_permintaan='" . $id_permintaan . "' and b.is_sudah_ap in (1,2)";
    $res = mysqli_query($db_stok, $sql);
    $count = mysqli_num_rows($res);

    return $count;
}

function format_number_ku($number)
{
    if (is_bulat($number) == 1) {
        return number_format($number);
    } else {
        return number_format($number, 2);
    }

}

function cek_status($id_permintaan)
{
    $db_stok = $GLOBALS["db_stok"];

    $sql = "select a.id_permintaan from tb_purchasing_permintaan as a,tb_purchasing_permintaan_detail as b where a.id_permintaan=b.id_permintaan and a.id_permintaan='" . $id_permintaan . "' and b.is_sudah_ap<>3 and b.is_sudah_po<>2 ";
    $res = mysqli_query($db_stok, $sql);
    $jumlah_detail = mysqli_num_rows($res);

    $sql = "select a.id_permintaan from tb_purchasing_permintaan as a,tb_purchasing_permintaan_detail as b where a.id_permintaan=b.id_permintaan and a.id_permintaan='" . $id_permintaan . "' and b.is_sudah_ap=1";
    $res = mysqli_query($db_stok, $sql);
    $jumlah_detail_ap = mysqli_num_rows($res);

    $sql = "select a.id_permintaan from tb_purchasing_permintaan as a,tb_purchasing_permintaan_detail as b where a.id_permintaan=b.id_permintaan and a.id_permintaan='" . $id_permintaan . "' and b.is_sudah_po=1";
    $res = mysqli_query($db_stok, $sql);
    $jumlah_detail_po = mysqli_num_rows($res);

    //echo $jumlah_detail_ap.' - '.$jumlah_detail_po.' - '.$jumlah_detail_tb.' - '.$jumlah_detail_pb.' - '.$jumlah_detail;
    if ($jumlah_detail_ap == $jumlah_detail and $jumlah_detail_po == $jumlah_detail) {
        $sql = "update tb_purchasing_permintaan set status='PO Selesai' where id_permintaan='" . $id_permintaan . "'";
        mysqli_query($db_stok, $sql);
    } elseif ($jumlah_detail_ap < $jumlah_detail or $jumlah_detail_po < $jumlah_detail) {
        $sql = "update tb_purchasing_permintaan set status='Sedang Diproses' where id_permintaan='" . $id_permintaan . "'";
        mysqli_query($db_stok, $sql);
    }
    if ($jumlah_detail_ap == 0 and $jumlah_detail_po == 0) {
        $sql = "update tb_purchasing_permintaan set status='Sudah Dikirim Ke Pembelian' where id_permintaan='" . $id_permintaan . "'";
        mysqli_query($db_stok, $sql);
    }

    //return $count;
}

function is_bulat($number)
{
    $pos = explode(".", $number);

    $jumData = count($pos); //untuk menghitung jumlah elemen array
    for ($i = 0; $i < $jumData; $i++) {

        if ($i == 1) {
            $a = trim($pos[$i]);
        }

    }
    if (!isset($a)) {
        $a = '';
    }

    if ($a == '000' or $a == '00' or $a == '0' or $a == '') {
        return 1;
    } else {
        return 0;
    }

}

function cek_detail_spb($id_pengiriman)
{
    $db_stok = $GLOBALS["db_stok"];

    $sql = "select a.id_pengiriman from tb_purchasing_pengiriman as a,tb_purchasing_pengiriman_detail as b where a.id_pengiriman=b.id_pengiriman and a.id_pengiriman='$id_pengiriman'";
    $res = mysqli_query($db_stok, $sql);
    $count = mysqli_num_rows($res);

    return $count;
}

function qty_masuk_stok_utama($bulan, $tahun, $perusahaan, $gudang, $kode_stok)
{
    $db_stok = $GLOBALS["db_stok"];

    $sql =
        "select sum(a.kuantiti_masuk_transaksi) as total_qty_masuk from
	tb_purchasing_transaksi as a
	where
	month(a.tgl_transaksi)='" . $bulan . "' and
	year(a.tgl_transaksi)='" . $tahun . "' and
	a.perusahaan='" . $perusahaan . "' and
	a.gudang='" . $gudang . "' and
	a.kode_stok_transaksi='" . $kode_stok . "'
	group by a.kode_stok_transaksi";
    $res = mysqli_query($db_stok, $sql) or die('error 195');
    $count = mysqli_num_rows($res);
    if ($count == 0) {
        $total_qty_masuk = 0;
    } else {
        while ($row = mysqli_fetch_assoc($res)) {
            $total_qty_masuk = $row['total_qty_masuk'];
        }
    }

    return $total_qty_masuk;
}

function qty_keluar_stok_utama($bulan, $tahun, $perusahaan, $gudang, $kode_stok)
{
    $db_stok = $GLOBALS["db_stok"];

    $sql =
        "select sum(a.kuantiti_keluar_transaksi) as total_qty_keluar from
	tb_purchasing_transaksi as a
	where
	month(a.tgl_transaksi)='" . $bulan . "' and
	year(a.tgl_transaksi)='" . $tahun . "' and
	a.perusahaan='" . $perusahaan . "' and
	a.gudang='" . $gudang . "' and
	a.kode_stok_transaksi='" . $kode_stok . "'
	group by a.kode_stok_transaksi";
    $res = mysqli_query($db_stok, $sql) or die('error 195');
    $count = mysqli_num_rows($res);
    if ($count == 0) {
        $total_qty_keluar = 0;
    } else {
        while ($row = mysqli_fetch_assoc($res)) {
            $total_qty_keluar = $row['total_qty_keluar'];
        }
    }

    return $total_qty_keluar;
}

function qty_masuk_stok_utama_before($bulan, $tahun, $perusahaan, $gudang, $kode_stok)
{
    $db_stok = $GLOBALS["db_stok"];
    $tanggal = $tahun . '-' . $bulan . '-01';

    $sql =
        "select sum(a.kuantiti_masuk_transaksi) as total_qty_masuk_before from
	tb_purchasing_transaksi as a
	where
	a.tgl_transaksi<'" . $tanggal . "' and
	a.perusahaan='" . $perusahaan . "' and
	a.gudang='" . $gudang . "' and
	a.kode_stok_transaksi='" . $kode_stok . "'
	group by a.kode_stok_transaksi";
    $res = mysqli_query($db_stok, $sql) or die('error 195');
    $count = mysqli_num_rows($res);
    if ($count == 0) {
        $total_qty_masuk_before = 0;
    } else {
        while ($row = mysqli_fetch_assoc($res)) {
            $total_qty_masuk_before = $row['total_qty_masuk_before'];
        }
    }

    return $total_qty_masuk_before;
}

function qty_keluar_stok_utama_before($bulan, $tahun, $perusahaan, $gudang, $kode_stok)
{
    $db_stok = $GLOBALS["db_stok"];
    $tanggal = $tahun . '-' . $bulan . '-01';

    $sql =
        "select sum(a.kuantiti_keluar_transaksi) as total_qty_keluar_before from
	tb_purchasing_transaksi as a
	where
	a.tgl_transaksi<'" . $tanggal . "' and
	a.perusahaan='" . $perusahaan . "' and
	a.gudang='" . $gudang . "' and
	a.kode_stok_transaksi='" . $kode_stok . "'
	group by a.kode_stok_transaksi";
    $res = mysqli_query($db_stok, $sql) or die('error 195');
    $count = mysqli_num_rows($res);
    if ($count == 0) {
        $total_qty_keluar_before = 0;
    } else {
        while ($row = mysqli_fetch_assoc($res)) {
            $total_qty_keluar_before = $row['total_qty_keluar_before'];
        }
    }

    return $total_qty_keluar_before;
}

function qty_keluar_stok_utama_hingga($tanggal_sekarang, $initial_date, $perusahaan, $gudang, $kode_stok)
{
    $db_stok = $GLOBALS["db_stok"];

    $sql =
        "select sum(a.kuantiti_keluar_transaksi) as total_qty_keluar_hingga from
	tb_purchasing_transaksi as a
	where
	a.tgl_transaksi>='" . $initial_date . "' and
	a.tgl_transaksi<='" . $tanggal_sekarang . "' and
	a.perusahaan='" . $perusahaan . "' and
	a.gudang='" . $gudang . "' and
	a.kode_stok_transaksi='" . $kode_stok . "'
	group by a.kode_stok_transaksi";
    $res = mysqli_query($db_stok, $sql) or die('error 195');
    $count = mysqli_num_rows($res);
    if ($count == 0) {
        $total_qty_keluar_hingga = 0;
    } else {
        while ($row = mysqli_fetch_assoc($res)) {
            $total_qty_keluar_hingga = $row['total_qty_keluar_hingga'];
        }
    }

    return $total_qty_keluar_hingga;
}

function tanggal_pemasukan_terakhir($perusahaan, $gudang, $kode_stok)
{
    $db_stok = $GLOBALS["db_stok"];

    $sql =
        "select max(a.tgl_transaksi) as tanggal_pemasukan_terakhir from
	tb_purchasing_transaksi as a
	where
	a.perusahaan='" . $perusahaan . "' and
	a.gudang='" . $gudang . "' and
	a.kode_stok_transaksi='" . $kode_stok . "' and
	a.kuantiti_masuk_transaksi>0";
    $res = mysqli_query($db_stok, $sql) or die('error 195');
    $count = mysqli_num_rows($res);
    if ($count == 0) {
        $tanggal_pemasukan_terakhir = 'N/A';
    } else {
        while ($row = mysqli_fetch_assoc($res)) {
            $tanggal_pemasukan_terakhir = $row['tanggal_pemasukan_terakhir'];
        }
    }

    return $tanggal_pemasukan_terakhir;
}

function tanggal_pengeluaran_terakhir($perusahaan, $gudang, $kode_stok)
{
    $db_stok = $GLOBALS["db_stok"];

    $sql =
        "select max(a.tgl_transaksi) as tanggal_pengeluaran_terakhir from
	tb_purchasing_transaksi as a
	where
	a.perusahaan='" . $perusahaan . "' and
	a.gudang='" . $gudang . "' and
	a.kode_stok_transaksi='" . $kode_stok . "' and
	a.kuantiti_keluar_transaksi > 0";
    $res = mysqli_query($db_stok, $sql) or die('error 195');
    $count = mysqli_num_rows($res);
    if ($count == 0) {
        $tanggal_pengeluaran_terakhir = '0000-00-00';
    } else {
        while ($row = mysqli_fetch_assoc($res)) {
            $tanggal_pengeluaran_terakhir = $row['tanggal_pengeluaran_terakhir'];
        }
    }

    return $tanggal_pengeluaran_terakhir;
}

function get_id_akun($no_akun, $id_perusahaan)
{
    $db_accounting = $GLOBALS["db_accounting"];

    $sql = "
	SELECT
		a.id_akun
	FROM
		list_kode_akun as a
	WHERE
		a.id_perusahaan='" . $id_perusahaan . "' and
		a.kode_akun='" . $no_akun . "'";

    $res = mysqli_query($db_accounting, $sql) or die('error 712');

    while ($row = mysqli_fetch_assoc($res)) {
        $id_akun = $row['id_akun'];
    }

    return $id_akun;

}

function list_transisi($no_akun, $id_perusahaan)
{
    $db_sistem_stok = $GLOBALS["db_sistem_stok"];
    $id_gudang = $GLOBALS["id_gudang"];
    $sql =
        "SELECT
    a.id_transisi,
    a.transisi
  FROM
    tb_master_transisi as a
  WHERE
    a.id_gudang='" . $id_gudang . "' and
    a.aktif=1";
    $sql .= " ORDER BY a.transisi";
    $res = mysqli_query($db_sistem_stok, $sql) or die('error 272');
    $count = mysqli_num_rows($res);
    if ($count > 0) {
        while ($row = mysqli_fetch_assoc($res)) {
            ?>
<option value="<?php echo $row['id_transisi']; ?>">
  <?php echo $row['transisi']; ?>
</option>
<?php
}
    }
}

function get_terbilang($x)
{
  $array_bilangan = array("", "satu", "dua", "tiga", "empat", "lima", "enam", "tujuh", "delapan", "sembilan", "sepuluh", "sebelas");
  if ($x < 12)
  return " " . $array_bilangan[$x];
  elseif ($x < 20)
  return get_terbilang($x - 10) . "belas";
  elseif ($x < 100)
  return get_terbilang($x / 10) . " puluh" . get_terbilang($x % 10);
  elseif ($x < 200)
  return " seratus" . get_terbilang($x - 100);
  elseif ($x < 1000)
  return get_terbilang($x / 100) . " ratus" . get_terbilang($x % 100);
  elseif ($x < 2000)
  return " seribu" . get_terbilang($x - 1000);
  elseif ($x < 1000000)
  return get_terbilang($x / 1000) . " ribu" . get_terbilang($x % 1000);
  elseif ($x < 1000000000)
  return get_terbilang($x / 1000000) . " juta" . get_terbilang($x % 1000000);
}

/*************************************************************************
php easy :: pagination scripts set - Version Two
==========================================================================
Author:      php easy code, www.phpeasycode.com
Web Site:    http://www.phpeasycode.com
Contact:     webmaster@phpeasycode.com
*************************************************************************/
function paginate_two($reload, $page, $tpages, $adjacents) 
{	
	$firstlabel = "&laquo;&nbsp;";
	$prevlabel  = "&lsaquo;&nbsp;";
	$nextlabel  = "&nbsp;&rsaquo;";
	$lastlabel  = "&nbsp;&raquo;";
	
	$out = "<nav><ul class=\"pagination\">\n";
	
	// first
	if($page>($adjacents+1)) {
		$out.= "<li><a href=\"" . $reload . "\">" . $firstlabel . "</a></li>\n";
	}
	else {
		$out.= "<li class=\"disabled\"><a href=\"#\">" . $firstlabel . "</a></li>\n";
	}
	
	// previous
	if($page==1) {
		$out.= "<li class=\"disabled\"><a href=\"#\">" . $prevlabel . "</a></li>\n";
	}
	elseif($page==2) {
		$out.= "<li><a href=\"" . $reload . "\">" . $prevlabel . "</a></li>\n";
	}
	else {
		$out.= "<li><a href=\"" . $reload . "&amp;page=" . ($page-1) . "\">" . $prevlabel . "</a></li>\n";
	}
	
	// 1 2 3 4 etc
	$pmin = ($page>$adjacents) ? ($page-$adjacents) : 1;
	$pmax = ($page<($tpages-$adjacents)) ? ($page+$adjacents) : $tpages;
	for($i=$pmin; $i<=$pmax; $i++) {
		if($i==$page) {
			$out.= "<li class=\"active\"><a href=\"#\">" . $i . "</a></li>\n";
		}
		elseif($i==1) {
			$out.= "<li><a href=\"" . $reload . "\">" . $i . "</a></li>\n";
		}
		else {
			$out.= "<li><a href=\"" . $reload . "&amp;page=" . $i . "\">" . $i . "</a></li>\n";
		}
	}
	
	// next
	if($page<$tpages) {
		$out.= "<li><a href=\"" . $reload . "&amp;page=" .($page+1) . "\">" . $nextlabel . "</a></li>\n";
	}
	else {
		$out.= "<li class=\"disabled\"><a href=\"#\">" . $nextlabel . "</a></li>\n";
	}
	
	// last
	if($page<($tpages-$adjacents)) {
		$out.= "<li><a href=\"" . $reload . "&amp;page=" . $tpages . "\">" . $lastlabel . "</a></li>\n";
	}
	else {
		$out.= "<li class=\"disabled\"><a href=\"#\">" . $lastlabel . "</a></li>\n";
	}
	
	$out.= "</ul></nav>";
	
	return $out;
}


?>