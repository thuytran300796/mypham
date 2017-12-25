<?php

	session_start();
	require('../../../../config/config.php');

//echo json_encode(array("mausac"=>"pink", "soluong"=>"10"));

	if($_POST['ac'] == 'them')
	{
		
		$mactsp = mysql_query("select count(mactsp) as 'number' from chitietsanpham");
		$mactsp = mysql_fetch_assoc($mactsp);
		$mactsp =(int)$mactsp['number'] + 1;
		
		$masp = $_POST['masp'];
		$mausac = $_POST['mausac'];
		$soluong = $_POST['soluong'];
		//$soluong = 0;
		$ngaysx = $_POST['ngaysx'];
		$hsd = $_POST['hsd'];
		//$gianhap = $_POST['gianhap'];
		$giaban = $_POST['giaban'];
		
		mysql_query("set names 'utf8'");
		$ctsp = mysql_query("insert into chitietsanpham(masp, mactsp, mausac, ngaysx, hansudung, soluong, giaban, trangthai) values('$masp', '$mactsp', '$mausac', '$ngaysx', '$hsd', $soluong, $giaban, 1)");	
		
		//echo $ctsp;
		echo json_encode(array("masp"=>"$masp", "mactsp"=>"$mactsp", "mausac"=>"$mausac", "soluong"=>"$soluong", "ngaysx"=>"$ngaysx", "hsd"=>"$hsd", "giaban"=>"$giaban"));
	
	}
	else if($_POST['ac'] == 'get')
	{
		$id = $_POST['id'];
		mysql_query("set names 'utf8'");
		$kq = mysql_query("select mactsp, mausac, soluong, ngaysx, hansudung, giaban from chitietsanpham where mactsp = '$id'");
		$re_kq = mysql_fetch_assoc($kq);
		$mausac = $re_kq['mausac'];
		$soluong = $re_kq['soluong'];
		$ngaysx = $re_kq['ngaysx'];
		$hsd = $re_kq['hansudung'];
		//$gianhap = $_SESSION['list-ctsp'][$id]['gianhap'];
		$giaban = $re_kq['giaban'];
		
		echo json_encode(array("id"=>"$id", "mausac"=>"$mausac", "soluong"=>"$soluong", "ngaysx"=>"$ngaysx", "hsd"=>"$hsd", "giaban"=>"$giaban"));
	}
	else if($_POST['ac'] == 'sua')
	{
		$id = $_POST['id'];
		
		$mausac = $_POST['mausac'];
		$soluong = $_POST['soluong'];
		$ngaysx = $_POST['ngaysx'];
		$hsd = $_POST['hsd'];
		$giaban = $_POST['giaban'];
		
		$kq = mysql_query("update chitietsanpham set mausac='$mausac', ngaysx = '$ngaysx', hansudung = '$hsd' where mactsp = '$id'");
		//echo $kq;
	}
	else if($_POST['ac'] == 'xoa')
	{
		$id = $_POST['id'];
		$kq = mysql_query("delete from chitietsanpham where mactsp = '$id'");	
	}
	else if($_POST['ac'] == 'xoahinh')
	{
		$maha = $_POST['maha'];
		$kq = mysql_query("delete from hinhanh where maha = '$maha'");	
	}
	else if($_POST['ac'] == 'themncc')
	{
		$mancc = "";
		require('../../../../config/config.php');
		$result = mysql_query("select mancc from nhacungcap");
		if(mysql_num_rows($result) == 0)
			$mancc = 'NCC1';
		else
		{
			$dong = mysql_fetch_assoc($result);
			
			$number = substr($dong['mancc'], 3);
			
			while($dong = mysql_fetch_assoc($result))
			{
				$temp = substr($dong['mancc'], 3);
				if($number < $temp)
					$number = $temp;
			}
			$mancc = 'NCC'.++$number;	
		}
		echo $mancc;
		
		$ten = $_POST['ten'];
		$diachi = $_POST['diachi'];
		$sdt = $_POST['sdt'];
		$email = $_POST['email'];
		$ghichu = $_POST['ghichu'];
		
		mysql_query("set names 'utf8'");
		$result = mysql_query("insert into nhacungcap(mancc, tenncc, diachi, sdt, email, ghichu, trangthai) values('$mancc', '$ten', '$diachi', '$sdt', '$email', '$ghichu', 1)");
		
		$result = mysql_query("select mancc, tenncc from nhacungcap where trangthai =1");
		while($record = mysql_fetch_assoc($result))
		{
			if($record['mancc'] == $mancc)
				echo "<option selected='selected' value = '".$record['mancc']."'>".$record['tenncc']."</option>";
			else
				echo "<option value = '".$record['mancc']."'>".$record['tenncc']."</option>";
		}
		//mysql_close($conn);
	}

?>