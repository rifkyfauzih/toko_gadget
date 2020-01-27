<?php


$koneksi->query("DELETE FROM pelanggan WHERE id_pelanggan='$_GET[id]'");
echo "<script>alert('Pelanggan Terhapus');</script>";
echo "<script>location='index.php?halaman=pelanggan';</script>";
?>