<?php
session_start ();
$koneksi = new mysqli("localhost","root","","tokogadget");


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

<section class="riwayat">
	<div class="container">
    	<h3>Riwayat Belanja Pelanggan <?php echo $_SESSION["pelanggan"]["nama_pelanggan"] ?></h3>
         <table class="table table-bordered">
        	<thead>
            	<tr>
                	<th>No</th>
                    <th>Tanggal</th>
                    <th>Status</th>
                    <th>Total</th>
                    <th>Opsi</th>
                </tr>
            </thead>
            <tbody>
            <?php $nomor=1; ?>
            <?php
			$id_pelanggan = $_SESSION["pelanggan"]["id_pelanggan"];
			$ambil = $koneksi->query("SELECT * FROM pembelian WHERE id_pelanggan='$id_pelanggan'");
			while ($pecah = $ambil->fetch_assoc()) {
			
			?>
            	<tr>
                	<td><?php echo $nomor; ?></td>
                    <td><?php echo $pecah["tanggal_pembelian"]; ?></td>
                    <td><?php echo $pecah["status_pembelian"]; ?></td>
                    <td>Rp. <?php echo number_format ($pecah["total_pembelian"]) ?></td>
                    <td>
                    	<a href="nota.php?id=<?php echo $pecah["id_pembelian"] ?>" class="btn btn-info">Nota</a>
                        <a href="pembayaran.php?id=<?php echo $pecah["id_pembelian"] ?>" class="btn btn-succes">Pembayaran</a>
                    </td>
                </tr>
                <?php $nomor++; ?>
             <?php } ?>   

            </tbody>
        </table>
    </div>
        
    	
</section>


</body>
</html>
