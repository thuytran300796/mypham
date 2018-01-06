<?php

	require('../../../../config/config.php');

	$ac = isset($_POST['ac']) ? $_POST['ac'] : "";
	
	if($ac == 'huy')
	{
		$id = isset($_POST['id']) ? $_POST['id'] : "";
		$kq = mysql_query("update giohang set trangthai = 2 where magh = '$id'");	
	}
	else if($ac == 'huyhd')
	{
		$id = isset($_POST['id']) ? $_POST['id'] : "";
		$kq = mysql_query("update hoadon set trangthai = 2 where mahd = '$id'");	
	}


	mysql_close();
?>