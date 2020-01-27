<?php
session_start();

echo "<pre>";
print_r ($_SESSION['pesanan']);
echo "</pre>";

$koneksi = new mysqli("localhost","root","","tokogadget");  
?>

<!DOCTYPE html>
<html>
<head>
	<title>Pesanan</title>
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
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
            <?php $nomor=1; ?>
            <?php foreach ($_SESSION["pesanan"] as $id_produk=>$jumlah):  ?>
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
                    <td>
                    	<a href="hapuspesanan.php?id=<?php echo $id_produk ?>" class="btn btn-danger btn-xs">Hapus</a>
                    </td>
                </tr>
                <?php $nomor++; ?>
             <?php endforeach ?>   

            </tbody>
        </table>
        
        <a href="index.php" class="btn btn-default">Lanjutkan Pemesanan</a>
        <a href="checkout.php" class="btn btn-primary">Checkout</a>
    </div>
</section>

</body>
</html>