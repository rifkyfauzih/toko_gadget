<?php
session_start ();
$koneksi = new mysqli("localhost","root","","tokogadget");

?>
<?php 
$keyword = $_GET["keyword"];

$semuadata=array();
$ambil = $koneksi->query("SELECT * FROM produk WHERE nama_produk LIKE '%$keyword%' OR deskripsi_produk LIKE '%$keyword%' ");
while ($pecah = $ambil->fetch_assoc())
{
	$semuadata[]=$pecah;
}
?>
<!DOCTYPE html>
<html>
<head>
	<title>Hasil Pencarian</title>
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
<section>
<div class="container">
	<h3>Hasil Pencarian <?php echo $keyword?></h3>
    
    <?php if(empty($semuadata)) : ?>
    	<div class="alert alert-danger">Produk <?php echo $keyword?> tidak ditemukan</div>
    <?php endif ?>
    <div class="row">
    	
    	<?php foreach ($semuadata  as $key => $value ): ?> 
          


            <div class="col-md-3" >
            	<div class="thumbnail" >
                <img  src="foto/<?php echo $value['foto_produk'];?>" alt="" class="img-responsive">
                <div class="caption" >
                <h3><?php echo $value['nama_produk'];?></h3>
                <h5>Rp. <?php echo number_format ($value['harga_produk']);?></h5>
                <a href="pesan.php?id=<?php echo $value['id_produk']; ?> " class="btn btn-primary">Beli</a>
                <a href="detail.php?id=<?php echo $value['id_produk']; ?>" class="btn btn-default">Detail</a>
                </div>
            	</div>
            </div>
            
   
            
            
        </div>
        
        <?php endforeach ?>
        
    </div>
</div>
</section>


</body> 
</html>