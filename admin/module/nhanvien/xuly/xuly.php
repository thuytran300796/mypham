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
			$matkhau = md5('123456');
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
		else if($ac == 'del')
		{
			$id = $_POST['id'];
			$kq = mysql_query("update nhanvien set trangthai = 0 where manv = '$id'");
			echo json_encode(array("id"=>"$id"));
		}
		else if($ac == 'xemluong')
		{
			$ngaybd = $_POST['ngaybd']; $ngaykt = $_POST['ngaykt']; $keyword = $_POST['keyword'];
			mysql_query("set names 'utf8'");
			$luong = mysql_query("	select	ngay, tennv, hesoluong, phucap, songaycong, thuong, phat, luongcoban
							from	nhanvien nv, chucvu cv, chitietluong ctl
							where	nv.manv = ctl.manv and ctl.macv = cv.macv and ngay>='$ngaybd' and ngay<='$ngaykt' and (tennv LIKE '%$keyword%' or nv.manv LIKE '%$keyword%')");
							
			echo "<tr>";
        	echo "<th width='10%'>Ngày</th>";
            echo "<th width='15%'>Tên NV</th>";
            echo "<th width='10%'>HS lương</th>";
            echo "<th width='10%'>Phụ cấp</th>";
            echo "<th width='10%'>Lương CB</th>";
            echo "<th width='10%'>Số ngày công</th>";
            echo "<th width='10%'>Thưởng</th>";
            echo "<th width='10%'>Phạt</th>";
            echo "<th width='10%'>Tổng</th>";
        	echo "</tr>";
				
			while($re_luong = mysql_fetch_assoc($luong))
			{
				echo "<tr>";
				echo 	"<td>".date('d-m-Y', strtotime($re_luong['ngay']))."</td>";
				echo	 "<td>".$re_luong['tennv']."</td>";
				echo 	"<td>".$re_luong['hesoluong']."</td>";
				echo 	"<td>".number_format($re_luong['phucap'])."</td>";
				echo 	"<td>".number_format($re_luong['luongcoban'])."</td>";
				echo 	"<td>".$re_luong['songaycong']."</td>";
				echo 	"<td>".number_format($re_luong['thuong'])."</td>";
				echo 	"<td>".number_format($re_luong['phat'])."</td>";
				echo 	"<td>".number_format($tong)."</td>";
        		echo "</tr>";
			}
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