<?php

	session_start();
	
	$soluongmoi = $_POST['soluongmoi'];
	$ctsp = $_POST['ctsp'];
	$_SESSION['cart'][$ctsp]['soluong'] = $soluongmoi;

	echo $_SESSION['cart'][$ctsp]['soluong'];
?>