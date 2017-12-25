<?php

	if(!isset($_GET['ac']))
		include_once('module/sanpham/lietkesp.php');
	else
	{
		if($_GET['ac'] == 'themsp')
		{
			include_once('module/sanpham/themsp.php');			
		}
		else if($_GET['ac'] == 'suasp')
		{
			include_once('module/sanpham/suasp.php');		
		}
		else if($_REQUEST['ac'] == 'nhapsp')
			{
				require('module/sanpham/nhapsp.php');		
			}
	}

	//include_once('main-left.php');
	//include_once('main-right.php');
?>