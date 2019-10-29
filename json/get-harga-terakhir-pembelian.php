<?php
include "../include/config.php";
$kode_barang = $_GET['kode_barang'];
$id_supplier = $_GET['id_supplier'];
$sql =
"SELECT
  *
FROM
  tb_purchasing_pembelian AS a
LEFT JOIN
  tb_purchasing_pembelian_detail AS b ON (b.id_pembelian = a.id_pembelian)
WHERE
  a.id_supplier_pembelian = '".$id_supplier."' AND
  b.kode_stok_pembelian = '".$kode_barang."'";
$sql .= " ORDER BY a.tgl_pembelian DESC,a.id_pembelian DESC";
$sql .= " LIMIT 1";
$res = mysqli_query($db_internal_system,$sql) or die('error 11');
if(mysqli_num_rows($res) != 0)
{
  while($row = mysqli_fetch_assoc($res))
  {	
    $harga_pembelian = $row['harga_pembelian'];
  }
}
echo $harga_pembelian;
mysqli_close($db_internal_system);

?>