<?php

	if(isset($_REQUEST['ac']))
	{
		$ac = $_REQUEST['ac'];
		if($ac == 'lietke')
			require('module/nhanvien/lietke.php');
	}

?>