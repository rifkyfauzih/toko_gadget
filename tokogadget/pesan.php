<?php 
session_start();
$id_menu = $_GET['id'];

if (isset($_SESSION['pesanan'][$id_menu]))
{
	$_SESSION['pesanan'][$id_menu]+=1;
}
else
{
	$_SESSION['pesanan'][$id_menu]=1;
}

echo "<script>alert ('Menu Telah Dipesan');</script>";
echo "<script>location='pesanan.php';</script>";

?>