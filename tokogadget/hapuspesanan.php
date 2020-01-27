<?php 
session_start();
$id_produk = $_GET["id"];
unset ($_SESSION["pesanan"][$id_produk]);
echo "<script>alert ('Pesanan telah dihapus');</script>";
echo "<script>location='index.php';</script>";
?>