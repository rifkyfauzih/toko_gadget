﻿<?php
session_start ();
$koneksi = new mysqli("localhost","root","","tokogadget");

$idpem = $_GET["id"];
$ambil = $koneksi->query("SELECT * FROM pembelian WHERE id_pembelian = '$idpem'");
$detpem = $ambil->fetch_assoc();

$id_pelanggan_beli = $detpem["id_pelanggan"];
$id_pelanggan_login = $_SESSION["pelanggan"]["id_pelanggan"];

if ($id_pelanggan_login !== $id_pelanggan_beli)
{
		 echo "<script>alert ('jangan nakal');</script>";
		 echo "<script>location='riwayat.php';</script>";
	 }
?>
<!DOCTYPE html>
<html>
<head>
	<title>Toko Gadget</title>
    <link rel="stylesheet" href="admin/assets/css/bootstrap.css">
</head>
<body>


<!-- navbar -->
<nav class="navbar navbar-default">
<div class="container">
	<ul class="nav navbar-nav">
    	<li><a href="index.php">Home</a></li>
        <li><a href="pesanan.php">Keranjang</a></li>
        	<?php if(isset($_SESSION["pelanggan"])): ?>
            	<li><a href="riwayat.php">Riwayat Belanja</a></li>
            	<li><a href="logout.php">Logout</a></li>
            <?php else: ?>
            	<li><a href="login.php">Login</a></li>
            <?php endif?>
        <li><a href="daftar.php">Daftar Pelanggan</a></li>
        <li><a href="checkout.php">Checkout</a></li>
    </ul>
    <form action="pencarian.php" method="get" class="navbar-form navbar-right">
    	<input type="text" class="form-control" name="keyword">
        <button class="btn btn-primary">Cari</button>
    </form>
    </div>
</nav>

<div class="container">
	<h2>Konfirmasi Pembayaran</h2>
    <p>Kirim bukti pembayaran disini</p>
    <div class="alert alert-info">Total tagihan anda <strong>Rp. <?php echo number_format($detpem["total_pembelian"]) ?></strong>
    </div>
    <form method="post" enctype="multipart/form-data">
    	<div class="form-group">
        	<label>Nama Penyetor</label>
            <input type="text" class="form-control" name="nama">
        </div>
        <div class="form-group">
        	<label>Bank</label>
            <input type="text" class="form-control" name="bank">
        </div>
        <div class="form-group">
        	<label>Jumlah</label>
            <input type="number" class="form-control" name="jumlah" min="1">
        </div>
        <div class="form-group">
        	<label>Foto Bukti</label>
            <input type="file" class="form-control" name="bukti">
            <p class="text-danger">Foto bukti harus JPG maksimal 2mb</p>
        </div>
        <button class="btn btn-primary" name="kirim">Kirim</button>
        
    </form>
</div>
	
<?php 
if (isset($_POST["kirim"]))
{
	$namabukti = $_FILES['bukti']['name'];
	$lokasibukti = $_FILES['bukti']['tmp_name'];
	$namafiks = date ("YmdHis").$namabukti;
	move_uploaded_file($lokasibukti, "/foto/$namafiks");
	
	$nama = $_POST["nama"];
	$bank = $_POST["bank"];
	$jumlah = $_POST["jumlah"];
	$tanggal = date ("Y-m-d");
	
	$koneksi->query("INSERT INTO pembayaran (id_pembelian,nama,bank,jumlah,tanggal,bukti) VALUES ('$idpem', '$nama','$bank', '$jumlah', '$tanggal', '$namafiks')");
	
	$koneksi->query("UPDATE pembelian SET status_pembelian='sudah kirim pembayaran' WHERE id_pembelian='$idpem'");
	
		 echo "<script>alert ('Terima kasih sudah membayar');</script>";
		 echo "<script>location='riwayat.php';</script>";
}
?>

</body>
</html> 
