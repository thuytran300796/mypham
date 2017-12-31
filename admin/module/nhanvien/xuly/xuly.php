<?php

	require('../../../../config/config.php');
	if(isset($_POST['ac']))
	{
		$ac = $_POST['ac'];
		
		if($ac == 'add')
		{
			$manv = tao_manv();
			$ten = $_POST['ten']; $gioitinh = $_POST['gioitinh']; $ngaysinh = $_POST['ngaysinh']; $diachi = $_POST['diachi'];
			$sdt = $_POST['sdt']; $cmnd = $_POST['cmnd'];
			$matkhau = '123456';
			mysql_query("set names 'utf8'");
			$kq = mysql_query("insert into nhanvien(manv, tennv, gioitinh, ngaysinh, diachi, sodienthoai, cmnd, matkhau, trangthai)
											value('$manv', '$ten', '$gioitinh', '$ngaysinh', '$diachi', '$sdt', '$cmnd', '$matkhau', 1)");	
			$gioitinh = ($gioitinh == 0 ? "Nữ" :"Nam");
			echo json_encode(array("manv"=>"$manv", "ten"=>"$ten", "gioitinh"=>"$gioitinh", "ngaysinh"=>"$ngaysinh",  "diachi"=>"$diachi", "sdt"=>"$sdt", "cmnd"=>"$cmnd", "matkhau"=>"$matkhau"));
		}
		else if($ac == 'get_data')
		{
			$id = $_POST['id'];
			mysql_query("set names 'utf8'");
			$kq = mysql_query("select manv, tennv, gioitinh, ngaysinh, diachi, sodienthoai, cmnd, matkhau, trangthai from nhanvien where manv='$id'");
			$re_kq = mysql_fetch_assoc($kq);
			echo json_encode(array("manv"=>"$re_kq[manv]", "ten"=>"$re_kq[tennv]", "gioitinh"=>"$re_kq[gioitinh]", "ngaysinh"=>"$re_kq[ngaysinh]",  "diachi"=>"$re_kq[diachi]", "sdt"=>"$re_kq[sodienthoai]", "cmnd"=>"$re_kq[cmnd]", "matkhau"=>"$re_kq[matkhau]"));
		}
		else if($ac == 'edit')
		{
			$id = $_POST['id'];
			$ten = $_POST['ten']; $gioitinh = $_POST['gioitinh']; $ngaysinh = $_POST['ngaysinh']; $diachi = $_POST['diachi'];
			$sdt = $_POST['sdt']; $cmnd = $_POST['cmnd'];
			mysql_query("set names 'utf8'");
			$kq = mysql_query("update nhanvien set tennv = '$ten', gioitinh = '$gioitinh', ngaysinh = '$ngaysinh', diachi = '$diachi', sodienthoai = '$sdt', cmnd = '$cmnd' where manv = '$id'");
			$gioitinh = ($gioitinh == 0 ? "Nữ" :"Nam");
			echo json_encode(array("manv"=>"$id", "ten"=>"$ten", "gioitinh"=>"$gioitinh", "ngaysinh"=>"$ngaysinh",  "diachi"=>"$diachi", "sdt"=>"$sdt", "cmnd"=>"$cmnd"));
		}
		else
		{
			$id = $_POST['id'];
			$kq = mysql_query("update nhanvien set trangthai = 0 where manv = '$id'");
			echo json_encode(array("id"=>"$id"));
		}
	}

	mysql_close($conn);
?>

<?php
	
	function tao_manv()
	{
		mysql_query("set names 'utf8'");
		$result = mysql_query("select manv from nhanvien where manv <> 'admin'");
		if(mysql_num_rows($result) == 0)
			return 'NV1';
			
		$re_dong = mysql_fetch_assoc($result);
			
		$number = substr($re_dong['manv'], 2);
			
		while($re_dong = mysql_fetch_assoc($result))
		{
			$temp = substr($re_dong['manv'], 2);
			if($number < $temp)
				$number = $temp;
		}
		
		return 'NV'.++$number;
	}
	
?>