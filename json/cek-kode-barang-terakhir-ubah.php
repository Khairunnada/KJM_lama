<?php
include "../config.php";
$prefix = $_GET['prefix'];
$current_prefix = $_GET['current_prefix'];
$counter2 = $_GET['counter'];
if($prefix != $current_prefix)
{
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
    $counter = preg_replace('/[[:alpha:]]/', '', $kode)+1;
  }
  else
  {
    $counter = 1;  
  }   
  echo str_pad($counter, 4, '0', STR_PAD_LEFT);
  mysqli_close($db);
}
else
{
  echo $counter2;
} 
?>