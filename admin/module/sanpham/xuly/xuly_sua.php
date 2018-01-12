<?php
	function Tao_PN()
	{
		$phieunhap = mysql_query('select MaPhieu from PhieuNhap');
		
		if(mysql_num_rows($phieunhap) == 0)
			return 'PN1';
		
		$re_pn = mysql_fetch_assoc($phieunhap);
		$number = substr($re_pn['MaPhieu'], 2);
				
		while($re_pn = mysql_fetch_assoc($phieunhap))
		{
			$temp = substr($re_pn['MaPhieu'], 2);
			if($number < $temp)
				$number = $temp;
		}
		
		return 'PN'.++$number;
					
	}
?>

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
		$gianhap = $_POST['gianhap'];
		mysql_query("set names 'utf8'");
		$ctsp = mysql_query("insert into chitietsanpham(masp, mactsp, mausac, ngaysx, hansudung, soluong, giaban, trangthai) values('$masp', '$mactsp', '$mausac', '$ngaysx', '$hsd', $soluong, $giaban, 1)");	
		
		$mapn = Tao_PN();
		date_default_timezone_set('Asia/Ho_Chi_Minh');
		$date = date('Y-m-d');
		$nk = mysql_query("insert into phieunhap(maphieu, ngaynhap, manv) values('$mapn', '$date', '".$_SESSION['user']."')");
		$nk = mysql_query("insert into chitietphieunhap values('$mapn', '$mactsp', $soluong, $gianhap)");
		//echo $ctsp;
		echo json_encode(array("masp"=>"$masp", "mactsp"=>"$mactsp", "mausac"=>"$mausac", "soluong"=>"$soluong", "ngaysx"=>"$ngaysx", "hsd"=>"$hsd", "giaban"=>"$giaban", "gianhap"=>"$gianhap"));
	
	}
	else if($_POST['ac'] == 'get')
	{
		$id = $_POST['id'];
		mysql_query("set names 'utf8'");
		$kq = mysql_query("select ctsp.mactsp, mausac, ctsp.soluong, ngaysx, hansudung, giaban, gianhap from chitietsanpham ctsp, chitietphieunhap ctpn where ctpn.mactsp = ctsp.mactsp and ctsp.mactsp = '$id' limit 0,1");
		$re_kq = mysql_fetch_assoc($kq);
		$mausac = $re_kq['mausac'];
		$soluong = $re_kq['soluong'];
		$ngaysx = $re_kq['ngaysx'];
		$hsd = $re_kq['hansudung'];
		//$gianhap = $_SESSION['list-ctsp'][$id]['gianhap'];
		$giaban = $re_kq['giaban'];
		$gianhap = $re_kq['gianhap'];
		echo json_encode(array("id"=>"$id", "mausac"=>"$mausac", "soluong"=>"$soluong", "ngaysx"=>"$ngaysx", "hsd"=>"$hsd", "giaban"=>"$giaban", "gianhap"=>"$gianhap"));
	}
	else if($_POST['ac'] == 'sua')
	{
		$id = $_POST['id'];
		
		$mausac = $_POST['mausac'];
		$soluong = $_POST['soluong'];
		$ngaysx = $_POST['ngaysx'];
		$hsd = $_POST['hsd'];
		$giaban = $_POST['giaban'];
		mysql_query("set names 'utf8'");
		$kq = mysql_query("update chitietsanpham set mausac='$mausac', ngaysx = '$ngaysx', hansudung = '$hsd', soluong = $soluong where mactsp = '$id'");
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
		//require('../../../../config/config.php');
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
	else if($_POST['ac'] == 'get_pn')
	{
		$id = $_POST['id'];
		$mactsp = $_POST['mactsp'];
		mysql_query("set names 'utf8'");
		$pn = mysql_query("select ctpn.maphieu, date(ngaynhap) as 'ngaynhap', ctpn.mactsp, ctsp.mausac, ngaysx, hansudung, ctpn.soluong from phieunhap pn, chitietsanpham ctsp, chitietphieunhap ctpn
					where pn.maphieu = ctpn.maphieu and ctpn.mactsp = ctsp.mactsp and ctpn.maphieu = '$id' and ctpn.mactsp = '$mactsp'");
		$re_pn = mysql_fetch_assoc($pn);
		//echo json_encode(array("maphieu"=>"$re_pn[maphieu]", "ngaynhap" => "$re_pn[ngaynhap]", "mausac"=>"$re_pn[mausac]", "ngaysx"=>"$re_pn[ngaysx]", "hsd"=>"$re_pn[hansudung]", "soluong"=>"$re_pn[soluong]"));	
		
		$ngaynhap = $re_pn['ngaynhap'];
		$mausac =  $re_pn['mausac'];
		$ngaysx = $re_pn['ngaysx'];
		$hsd = $re_pn['hansudung'];
		$soluong = $re_pn['soluong'];
		//echo $ngaynhap." - ".$mausac." - ".$ngaysx." - ".$hsd." - ".$soluong;
		echo json_encode(array("ngaynhap" => "$ngaynhap", "mausac"=>"$mausac", "ngaysx"=>"$ngaysx", "hsd"=>"$hsd", "soluong"=>"$soluong"));	
	}
	else if($_POST['ac'] == 'edit_pn')
	{
		$id = $_POST['id'];
		$mactsp = $_POST['mactsp'];
		$soluongmoi = $_POST['soluongnhap'];
		$soluongbanra = $_POST['soluongbanra'];
		$soluonghienco = $soluongmoi - $soluongbanra; echo $soluongmoi." - ".$soluongbanra." = ".$soluonghienco;
		mysql_query("set names 'utf8'");
		$pn = mysql_query("update chitietphieunhap set soluong = $soluongmoi where maphieu = '$id' and mactsp = '$mactsp'");
		$kq = mysql_query("update chitietsanpham set soluong = $soluonghienco  where mactsp = '$mactsp'");

	}

?>