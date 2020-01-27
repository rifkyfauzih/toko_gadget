<?php
session_start ();
$koneksi = new mysqli("localhost","root","","tokogadget");
?>
<?php $id_produk = $_GET["id"];
 $ambil = $koneksi->query("SELECT * FROM produk WHERE id_produk='$id_produk'");
 $detail = $ambil->fetch_assoc();  
 ?>
<!DOCTYPE html>
<html>
<head>
	<title>Detail Produk</title>
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


<!-- konten -->
<section class="konten">
	<div class="container">
        <div class="row">
        	<div class="col-md-6">
     			<img src="foto/<?php echo $detail["foto_produk"]; ?>" alt="" class="img-responsive">
            </div>
            <div class="col-md-6" >
            	<h2><?php echo $detail["nama_produk"]; ?></h2>
                <h4><?php echo number_format($detail["harga_produk"]); ?></h4>
                
                <h5>Stok <?php echo $detail['stok_produk'] ?></h5>
                
                <form method="post">
                	<div class="form-group">
                    	<div class="input-group">
                        	<input type="number" min="1" class="form-control" name="jumlah" max="<?php echo $detail['stok_produk'] ?>">
                            <div class="input-group-btn">
                            	<button class="btn btn-primary" name="beli">Beli</button>
                        </div>
                    </div>
                </form>
                
                <?php
				if(isset($_POST["beli"]))
				{
					$jumlah = $_POST["jumlah"];
					$_SESSION["pesanan"][$id_produk] = $jumlah;
					
					echo "<script>alert ('Produk Telah masuk ke keranjang belanja');</script>";
		 		    echo "<script>location='pesanan.php';</script>";
				}
				?>
                
               	<p><?php echo $detail["deskripsi_produk"]; ?></p>
                </div>
            	</div>
            </div>
            
            
        </div>
    </div>   
</section>

</body>
</html>
