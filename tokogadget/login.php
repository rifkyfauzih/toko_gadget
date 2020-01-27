<?php
session_start ();
$koneksi = new mysqli("localhost","root","","tokogadget");

?>
<!DOCTYPE html>
<html>
<head>
	<title>Login Pelanggan</title>
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
	<div class="row">
    	<div class="col-md-4">
        	<div class="panel panel-default">
            	<div class="panel-heading">
                	<h3 class="panel-title">Login Pelanggan</h3>
                </div>
                <div class="panel-body">
                	<form method="post">
                    	<div class="form-group">
                        	<label>Email</label>
                            <input type="email" class="form-control" name="email">
                        </div>
                        <div class="form-group">
                        
                        	<label>Password</label>
                            <input type="password" class="form-control" name="password">
                        </div> 
                        <button class="btn btn-primary" name="simpan">Masuk</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
 </div>
 
 <?php 
 if (isset($_POST["simpan"]))
 {
	 $email = $_POST["email"];
	 $password = $_POST["password"];
	 $ambil = $koneksi->query("SELECT * FROM pelanggan WHERE email_pelanggan='$email' AND password_pelanggan='$password' "); 
	 
	 $akunyangcocok = $ambil->num_rows;
	 
	 if ($akunyangcocok==1)
	 {
		 $akun = $ambil->fetch_assoc();
		$_SESSION["pelanggan"] = $akun;
		
		echo "<script>alert ('Anda sukses login');</script>";
		if (isset($_SESSION["pesanan"]) OR !empty($_SESSION["pesanan"]))
		{
			echo "<script>location='checkout.php';</script>";
		}
		else
		{
			echo "<script>location='riwayat.php';</script>";
			
		}
	 }
	 else
	 {
		 echo "<script>alert ('Anda gagal login, coba periksa akun anda');</script>";
		 echo "<script>location='login.php';</script>";
	 }
 }
 ?>

</body> 
</html>