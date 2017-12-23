<?php

	$action = $_POST['action'];
	
	//gọi config từ file ncc.php
	
	
	if($action == 'add')
	//if(isset($_POST['ok']))
	{
		require('../../../../config/config.php');

		$result = mysql_query("select MaNCC from NhaCungCap");
			
		if(mysql_num_rows($result) == 0)
			$id = 'NCC1';
		else
		{		
			$re_dong = mysql_fetch_assoc($result);
			
			$number = substr($re_dong['MaNCC'], 3);
			
			while($re_dong = mysql_fetch_assoc($result))
			{
				$temp = substr($re_dong['MaNCC'], 3);
				if($number < $temp)
					$number = $temp;
			}
			$id = 'NCC'.++$number;
		}
		
		$ten = $_POST['ten'];
		$diachi = $_POST['diachi'];
		$sdt = $_POST['sdt'];
		$email = $_POST['email'];
		$ghichu = $_POST['ghichu'];

		mysql_query("set names 'utf8'");
		$result = mysql_query("insert into nhacungcap values ('$id', '$ten', '$diachi', '$sdt', '$email', '$ghichu', 1)");
		if(mysql_num_rows($result) > 0)
		{
			$result = mysql_query("select count(MaNCC) 'id' from nhacungcap");
			$re = mysql_fetch_assoc($result);
			$i = int($re['id'])+ 1;
			echo json_encode(array("i"=>"$i","id"=>"$id","ten"=>"$ten", "diachi" => "$diachi", "sdt" => "$sdt", "email" => "$email", "ghichu"=>"$ghichu"));
		}
	}
	
	mysql_close();
?>