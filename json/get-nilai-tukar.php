<?php
include "../config.php";
include "../functions.php";
$id_pemasok = fch($_GET['id_pemasok']);
$tanggal = fch($_GET['tanggal']);
if($tanggal == '')
  $tanggal = date('Y-m-d');
$sql =
"SELECT
  a.mata_uang
FROM
  tb_master_pemasok AS a
WHERE
  a.id = '".$id_pemasok."'";
$res = mysqli_query($db,$sql) OR die('error 15');
if(mysqli_num_rows($res) != 0)
{
  while($row = mysqli_fetch_assoc($res))
  {
    $mata_uang = $row['mata_uang'];
  }
}
else
{
  $mata_uang='';
}

if($mata_uang == 'IDR' OR $mata_uang == '')
  $nilai_kurs = 1;
else
{
  $sql =
  "SELECT
    a.nilai_kurs
  FROM
    tb_master_kurs_pajak_detail AS a
  WHERE
    a.mata_uang = '".$mata_uang."' AND
    a.tanggal = '".$tanggal."'";
  $res = mysqli_query($db,$sql) or die('error 31');
  if(mysqli_num_rows($res) != 0)
  {
    while($row = mysqli_fetch_assoc($res))
    {    
      $nilai_kurs = $row['nilai_kurs'];
    }
  }
  else
  {
    $nilai_kurs='';
  }
}
echo $nilai_kurs;
mysqli_close($db);

?>