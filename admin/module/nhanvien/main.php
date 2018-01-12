<?php

	if(isset($_REQUEST['ac']))
	{
		$ac = $_REQUEST['ac'];
		if($ac == 'lietke')
			require('module/nhanvien/lietke.php');
		else if($ac == 'luong')
			require('module/nhanvien/luong.php');
		else if($ac == 'tinhluong')
			require('module/nhanvien/tinhluong.php');
	}

?>