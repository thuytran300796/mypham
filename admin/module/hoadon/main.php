<?php

	if(isset($_GET['ac']))
	{
	
		$ac = $_GET['ac'];
		
		if($ac == 'giohang')
			require('module/hoadon/giohang.php');
		else if($ac == 'lk_hd')
			require('module/hoadon/hoadon.php');
		else if($ac == 'taohd')
			require('module/hoadon/taohd.php');
		
	}

?>