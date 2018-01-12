<?php

	$ac = isset($_GET['ac']) ? $_GET['ac'] : "";
	
	if($ac == 'sanpham')
		include_once('module/thongke/sanpham.php');
	else if($ac == 'thuchi')
		include_once('module/thongke/thuchi.php');
	else
		include_once('module/thongke/sanpham.php');

?>