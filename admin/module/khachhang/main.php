<?php

	if(isset($_GET['ac']))
	{
		$ac = $_GET['ac'];
		if($ac == "reset")
		{
			
			require('module/khachhang/lietke.php');		
		}
		else if($ac == 'lichsu')
		{
			require('module/khachhang/lichsu.php');
		}
	}
	else
	{
		require('module/khachhang/lietke.php');	
	}

?>