﻿<?php
session_start ();
$koneksi = new mysqli("localhost","root","","tokogadget");

if(!isset($_SESSION['pelanggan']))
{
	echo "<script> alert ('Anda Harus Login');</script>";
	echo "<script> location='login.php';</script>";
	header ('location=login.php');
	exit ();
}

?>
<!DOCTYPE html>
<html>
<head>
	<title>Checkout</title>
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


<section class="konten">
	<div class="container">
    	<h1>Pesanan</h1>
        <hr>
        <table class="table table-bordered">
        	<thead>
            	<tr>
                	<th>No</th>
                    <th>Menu</th>
                    <th>Harga</th>
                    <th>Jumlah</th>
                    <th>Subharga</th>
                </tr>
            </thead>
            <tbody>
            <?php $nomor=1; ?>
            <?php $totalpesanan=0; ?>
            <?php foreach ($_SESSION["pesanan"] as $id_produk=>$jumlah): ?>
            <?php 
			$ambil = $koneksi->query("SELECT * FROM produk WHERE id_produk='$id_produk'");
			$pecah = $ambil->fetch_assoc();
			$subharga = $pecah["harga_produk"]*$jumlah;
			
			?>
            	<tr>
                	<td><?php echo $nomor; ?></td>
                    <td><?php echo $pecah["nama_produk"]; ?></td>
                    <td>Rp. <?php echo number_format ($pecah["harga_produk"]); ?></td>
                    <td><?php echo $jumlah; ?></td>
                    <td>Rp. <?php echo number_format ($subharga); ?></td>
                </tr>
                <?php $nomor++; ?>
                <?php $totalpesanan+=$subharga; ?>
                
                <?php endforeach ?>

            </tbody>
            <tfoot>
            	<tr>
                	<th colspan="4"> Total Pesanan </th>
                    <th> Rp. <?php echo number_format ($totalpesanan) ?> </th>
                </tr>
            </tfoot>
        </table>
        
        <form method="post">
        <div class="row">
        	<div class="col-md-4">
            <div class="form-group"> 
        	<input type="text" readonly value="<?php echo $_SESSION["pelanggan"]['nama_pelanggan']?>" class="form-control">
        </div>
            </div>
            <div class="col-md-4">
            <div class="form-group"> 
        	<input type="text" readonly value="<?php echo $_SESSION["pelanggan"]['telepon_pelanggan'] ?>" class="form-control">
        </div>
            </div>
            <div class="col-md-4">
            	<select class="form-control" name="id_ongkir">
                <option value="">Pilih Ongkos Kirim</option>
                <?php
				$ambil = $koneksi->query("SELECT * FROM ongkir");
				While ($perongkir = $ambil->fetch_assoc()) {
				?>
                <option value="<?php echo $perongkir['id_ongkir']?>">
                <?php echo $perongkir['nama_kota']?> -
                Rp. <?php echo number_format ($perongkir['tarif'])?>
                <?php } ?>
                </option>
                </select>
                </div>
            
        </div>
        <div class="form-group">
        	<label>Alamat Lengkap Pengiriman</label>
            <textarea class="form-control" name="alamat_pengiriman" placeholder="Masukkan alamat lengkap pengiriman"></textarea>
         </div>
        <button class="btn btn-primary" name="checkout">Checkout</button>
        </form>
        
        <?php
		if (isset($_POST["checkout"]))
		{
			$id_pelanggan = $_SESSION["pelanggan"]["id_pelanggan"];
			$id_ongkir = $_POST["id_ongkir"];
			$tanggal_pembelian = date ("Y-m-d");
			$alamat_pengiriman = $_POST['alamat_pengiriman'];
			
			$ambil = $koneksi->query("SELECT * FROM ongkir WHERE id_ongkir='$id_ongkir'");
			$arrayongkir = $ambil->fetch_assoc();
			$nama_kota = $arrayongkir['nama_kota'];
			$tarif = $arrayongkir['tarif'];
			
			$total_pembelian = $totalpesanan + $tarif;
			
			$koneksi->query("INSERT INTO pembelian (id_pelanggan, id_ongkir, tanggal_pembelian, total_pembelian, nama_kota, tarif, alamat_pengiriman) VALUES ('$id_pelanggan','$id_ongkir', '$tanggal_pembelian','$total_pembelian','$nama_kota','$tarif','$alamat_pengiriman')");
			
			$id_pembelian_barusan = $koneksi->insert_id;
			
			foreach ($_SESSION["pesanan"] as $id_produk => $jumlah)
			{
				$ambil= $koneksi->query("SELECT * FROM produk WHERE id_produk =$id_produk");
				$perproduk = $ambil->fetch_assoc();
			
				$nama=$perproduk['nama_produk'];
				$harga=$perproduk['harga_produk'];
				$subharga=$perproduk['harga_produk']*$jumlah;
				
				
				$koneksi->query("INSERT INTO pembelian_produk (id_pembelian,id_produk,nama,harga,subharga,jumlah_beli) VALUES ('$id_pembelian_barusan','$id_produk','$nama','$harga','$subharga','$jumlah') ");
				
				$koneksi->query("UPDATE produk SET stok_produk=stok_produk -$jumlah WHERE id_produk='$id_produk'");
			}
			
			unset($_SESSION["pesanan"]);
			
			echo "<script>alert ('Pembelian Sukses');</script>";
			echo "<script>location='nota.php?id=$id_pembelian_barusan';</script>";
		}
		?>
    </div>
</section>

</body> 
</html>