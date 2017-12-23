<?php

	session_start();
//echo json_encode(array("mausac"=>"pink", "soluong"=>"10"));

	if($_POST['ac'] == 'them')
	{
		
		$mausac = $_POST['mausac'];
		$soluong = $_POST['soluong'];
		$ngaysx = $_POST['ngaysx'];
		$hsd = $_POST['hsd'];
		$gianhap = $_POST['gianhap'];
		$giaban = $_POST['giaban'];
		
		
			
		
		if(!isset($_SESSION['list-ctsp']))
		{
			$i = 0;
		}
		else
		{
			$i = count($_SESSION['list-ctsp']);
		}
			//$i = count($_SESSION['list-ctsp']);
			$_SESSION['list-ctsp'][$i]['mausac'] = $mausac;
			$_SESSION['list-ctsp'][$i]['soluong'] = $soluong;
			$_SESSION['list-ctsp'][$i]['ngaysx'] = $ngaysx;
			$_SESSION['list-ctsp'][$i]['hsd'] = $hsd;
			$_SESSION['list-ctsp'][$i]['gianhap'] = $gianhap;
			$_SESSION['list-ctsp'][$i]['giaban'] = $giaban;

	
		echo json_encode(array("id"=>"$i", "mausac"=>"$mausac", "soluong"=>"$soluong", "ngaysx"=>"$ngaysx", "hsd"=>"$hsd", "gianhap"=>"$gianhap", "giaban"=>"$giaban"));
	
	}
	else if($_POST['ac'] == 'get')
	{
		$id = $_POST['id'];
		$mausac = $_SESSION['list-ctsp'][$id]['mausac'];
		$soluong = $_SESSION['list-ctsp'][$id]['soluong'];
		$ngaysx = $_SESSION['list-ctsp'][$id]['ngaysx'];
		$hsd = $_SESSION['list-ctsp'][$id]['hsd'];
		$gianhap = $_SESSION['list-ctsp'][$id]['gianhap'];
		$giaban = $_SESSION['list-ctsp'][$id]['giaban'];
		echo json_encode(array("id"=>"$id", "mausac"=>"$mausac", "soluong"=>"$soluong", "ngaysx"=>"$ngaysx", "hsd"=>"$hsd", "gianhap"=>"$gianhap", "giaban"=>"$giaban"));
	}
	else if($_POST['ac'] == 'sua')
	{
		$id = $_POST['id'];
		
		$_SESSION['list-ctsp'][$id]['mausac'] = $_POST['mausac'];
		$_SESSION['list-ctsp'][$id]['soluong'] = $_POST['soluong'];
		$_SESSION['list-ctsp'][$id]['ngaysx'] = $_POST['ngaysx'];
		$_SESSION['list-ctsp'][$id]['hsd'] = $_POST['hsd'];
		$_SESSION['list-ctsp'][$id]['gianhap'] = $_POST['gianhap'];
		$_SESSION['list-ctsp'][$id]['giaban'] = $_POST['giaban'];
	}
	else if($_POST['ac'] == 'xoa')
	{
		$id = $_POST['id'];
		unset($_SESSION['list-ctsp'][$id]);	
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