﻿<?php
$koneksi = new mysqli("localhost","root","","tokogadget");

?>

<!DOCTYPE html>
<html>
<head>
	<title>Daftar Pelanggan</title>
    <link rel="stylesheet" href="admin/assets/css/bootstrap.css">
</head>
<body>

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
        	<div class="col-md-8 col-md-offset-2">
            	<div class="panel panel-default">
                	<div class="panel-heading">
                    <h3 class="panel-title">Daftar Pelanggan</h3>
                    </div>
                    <div class="panel-body">
                    <form method="post" class="form-horizontal">
                    	<div class="form-group">
                        	<label class="control-label col-md-3">Nama</label>
                            <div class="col-md-7">
                            	<input type="text" class="form-control" name="nama" required>
                            </div>
                        </div>
                        <div class="form-group">
                        	<label class="control-label col-md-3">Email</label>
                            <div class="col-md-7">
                            	<input type="email" class="form-control" name="email" required>
                            </div>
                        </div>
                        <div class="form-group">
                        	<label class="control-label col-md-3">Password</label>
                            <div class="col-md-7">
                            	<input type="password" class="form-control" name="password" required>
                            </div>
                        </div>
                        <div class="form-group">
                        	<label class="control-label col-md-3">Nomor Telepon</label>
                            <div class="col-md-7">
                            	<input type="number" class="form-control" name="telepon" required>
                            </div>
                        </div>
                        <div class="form-group">
                        	<label class="control-label col-md-3">Alamat</label>
                            <div class="col-md-7">
                            	<input type="text" class="form-control" name="alamat" required>
                            </div>
                        </div>
                        
                        <div class="form-group">
                        	<div class="col-md-7 col-md-offset-3">
                            	<button class="btn btn-primary" name="daftar">Daftar</button>
                            </div>
                        </div>
                    </form>
                    
                    <?php
					if (isset($_POST["daftar"]))
					{
						$nama = $_POST["nama"];
						$email = $_POST["email"];
						$password = $_POST["password"];
						$telepon = $_POST["telepon"];
						$alamat = $_POST["alamat"];
						
						$ambil = $koneksi->query("SELECT * FROM pelanggan WHERE email_pelanggan='$email' ");
						$yangcocok = $ambil->num_rows;
						if ($yangcocok==1)
						{
							echo "<script>alert ('Pendaftaran gagal, email sudah digunakan');</script>";
							echo "<script>location='daftar.php';</script>";
						}
						else
						{
							$koneksi->query("INSERT INTO pelanggan (email_pelanggan,password_pelanggan,nama_pelanggan,telepon_pelanggan,alamat_pelanggan) VALUES ('$email','$password','$nama','$telepon','$alamat') ");
							
							echo "<script>alert ('Pendaftaran sukses, silahkan login);</script>";
							echo "<script>location='login.php';</script>";
						}

					}
					?>
                    </div>
                </div>
            </div>
        </div>
     </div>
</body>
</html>