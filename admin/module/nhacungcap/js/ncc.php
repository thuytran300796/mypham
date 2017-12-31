<?php

	$action = $_POST['action'];
	require('../../../../config/config.php');
	//gọi config từ file ncc.php
	
	
	if($action == 'add')
	//if(isset($_POST['ok']))
	{
		

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
		
		$result = mysql_query("select count(MaNCC) 'id' from nhacungcap");
		$re = mysql_fetch_assoc($result);
		$i = (int)$re['id']+ 1;
		echo json_encode(array("id"=>"$id","ten"=>"$ten", "diachi" => "$diachi", "sdt" => "$sdt", "email" => "$email", "ghichu"=>"$ghichu"));
		
	}
	else if($action == 'get_data')
	{
		mysql_query("set names 'utf8'");
		$result = mysql_query("select * from NhaCungCap where mancc = '".$_POST['id']."'");
		$kq = mysql_fetch_assoc($result);
		echo json_encode(array("id"=>"$kq[MaNCC]", "ten"=>"$kq[TenNCC]", "diachi"=>"$kq[DiaChi]", "sdt"=>"$kq[SDT]", "email"=>"$kq[Email]", "ghichu"=>"$kq[GhiChu]"));
	}
	else if($action == 'edit')
	{
		$ten = $_POST['ten'];
		$diachi = $_POST['diachi'];
		$sdt = $_POST['sdt'];
		$email = $_POST['email'];
		$ghichu = $_POST['ghichu'];
		$id = $_POST['id'];
		
		mysql_query("set names 'utf8'");
		$result = mysql_query("	update nhacungcap set tenncc = '$ten', diachi = '$diachi', sdt = '$sdt', email = '$email', ghichu = '$ghichu'
								where mancc = '$id'");
		echo json_encode(array("id"=>"$id", "ten"=>"$ten", "diachi"=>"$diachi", "sdt"=>"$sdt", "email"=>"$email", "ghichu"=>"$ghichu"));
	}
	else
	{
		$id = $_POST['id'];
		mysql_query("set names 'utf8'");
		$result = mysql_query("update nhacungcap set trangthai = 0 where mancc = '$id'");
		echo json_encode(array("id"=>"$id"));
	}

	mysql_close();
?>