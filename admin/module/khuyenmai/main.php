<?php

	if(isset($_REQUEST['ac']))
	{
		$ac = $_REQUEST['ac'];
		if($ac == "lietke")
			require('module/khuyenmai/lietke.php');	
		else if($ac == 'them')
			require('module/khuyenmai/them.php');	
	}



?>