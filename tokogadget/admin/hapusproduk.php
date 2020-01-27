<?php

$ambil = $koneksi->query("SELECT * FROM produk WHERE id_produk='$_GET[id]'");
$pecah = $ambil->fetch_assoc();
$fotoproduk = $pecah['foto_produk'];
if (file_exists("../foto/$fotoproduk")) 
{
	unlink ("../foto/$fotoproduk");
}
$koneksi->query("DELETE FROM produk WHERE id_produk='$_GET[id]'");
echo "<script>alert('Produk Terhapus');</script>";
echo "<script>location='index.php?halaman=produk';</script>";
?>