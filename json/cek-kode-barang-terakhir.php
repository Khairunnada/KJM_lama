<?php
include "../config.php";
$prefix = $_GET['prefix'];
$sql = 
"SELECT
  *
FROM
  tb_master_barang AS a
WHERE
  replace(a.kode, right(a.kode,4), '') = '".$prefix."'";
$sql .= " ORDER BY a.kode";
$res = mysqli_query($db,$sql) OR die(alert_php('error 12'));
if(mysqli_num_rows($res) != 0)
{
  while($row = mysqli_fetch_array($res))
  {
    $kode = $row['kode'];
  }
}
echo preg_replace('/[[:alpha:]]/', '', $kode)+1;
mysqli_close($db);

?>