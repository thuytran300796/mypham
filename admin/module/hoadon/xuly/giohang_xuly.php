<?php

	require('../../../../config/config.php');

	$ac = isset($_POST['ac']) ? $_POST['ac'] : "";
	
	if($ac == 'huy')
	{
		$id = isset($_POST['id']) ? $_POST['id'] : "";
		$price = $_POST['price']; $makh = $_POST['makh'];
		$kq = mysql_query("update giohang set trangthai = 2 where magh = '$id'");	
		$kq = mysql_query("select magh, mactsp, soluong from chitietgiohang where magh = '$id'");
		while($re_kq = mysql_fetch_assoc($kq))
		{
			$result = mysql_query("update chitietsanpham set soluong = soluong + ".$re_kq['soluong']." where mactsp = '".$re_kq['mactsp']."'");
		}
		if($makh != "")
		{
			$diem = ((int)($price / 100000))*10;
			$kq = mysql_query("update khachhang set diemtichluy = diemtichluy - $diem where makh = '$makh'"); 	
		}
	}
	else if($ac == 'huyhd')
	{
		$id = isset($_POST['id']) ? $_POST['id'] : "";
		$price = $_POST['price']; $makh = $_POST['makh'];
		$kq = mysql_query("update hoadon set trangthai = 2 where mahd = '$id'");
		$kq = mysql_query("select mahd, mactsp, soluong from chitiethoadon where mahd = '$id'");
		while($re_kq = mysql_fetch_assoc($kq))
		{
			$result = mysql_query("update chitietsanpham set soluong = soluong + ".$re_kq['soluong']." where mactsp = '".$re_kq['mactsp']."'");
		}
		if($makh != "")
		{
			$diem = ((int)($price / 100000))*10;
			$kq = mysql_query("update khachhang set diemtichluy = diemtichluy - $diem where makh = '$makh'"); 	
		}
	}


	mysql_close();
?>