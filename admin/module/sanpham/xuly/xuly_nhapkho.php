<?php

	
	
	require('../../../../config/config.php');
	
	$ac = isset($_POST['ac']) ? $_POST['ac'] : "";
	
	if($ac == 'search')
	{
		$keyword = mysql_escape_string($_POST['keyword']);
		mysql_query("set names 'utf8'");
		$kq = mysql_query("select ctsp.mactsp, sp.masp, sp.tensp, ctsp.mausac, ctsp.ngaysx, ctsp.hansudung, thuonghieu, tenncc, duongdan, ctpn.gianhap
							from sanpham sp, chitietsanpham ctsp, nhacungcap ncc, hinhanh ha, chitietphieunhap ctpn
							where sp.masp = ctsp.masp and ncc.mancc = sp.mancc and sp.masp = ha.masp and sp.trangthai = 1 and ctsp.trangthai = 1
							and (tensp LIKE '%$keyword%' or sp.masp LIKE '%$keyword%' or ctsp.mactsp LIKE '%$keyword%')
							and ctpn.mactsp = ctsp.mactsp
							group by ctsp.mactsp");
							
		while($re_kq = mysql_fetch_assoc($kq))
		{
			echo "<li>";
			echo 	"<a href='javascript:void(0)' data-id='".$re_kq['mactsp']."'>";
			echo 		"<img src='../image/mypham/".$re_kq['duongdan']."'/>";
			echo 		"<div style='background: none'>";
			echo 			"<p>".$re_kq['tensp']."</p>";
			echo 			"<p>Màu sắc: ".$re_kq['mausac']."</p>";
			echo 			"<p>Date: ".date('d/m/Y', strtotime($re_kq['ngaysx']))." - ".date('d/m/Y', strtotime($re_kq['hansudung']))."</p>";
			echo 			"<p>Thương hiệu: ".$re_kq['thuonghieu']."</p>";
			echo			"<p>Nhà cung cấp: ".$re_kq['tenncc']."</p>";
			echo			"<p>Giá nhập: ".$re_kq['gianhap']."</p>";
			echo 		"</div>";
			echo 	"</a>";
			echo "</li>";
			echo "<div class='clear' style='background: none'></div>";
		}	
	}
	else if($ac == 'get_ctsp')
	{
		$id = isset($_POST['id']) ? $_POST['id'] : "";
		mysql_query("set names 'utf8'");
		$kq = mysql_query("select ctsp.mactsp, sp.masp, sp.tensp, ctsp.mausac, ctsp.ngaysx, ctsp.hansudung, thuonghieu, tenncc, ctpn.gianhap
							from sanpham sp, chitietsanpham ctsp, nhacungcap ncc, chitietphieunhap ctpn
							where sp.masp = ctsp.masp and ncc.mancc = sp.mancc and ctpn.mactsp = ctsp.mactsp and sp.trangthai = 1 and ctsp.trangthai = 1
							and  ctsp.mactsp = '$id' group by ctsp.mactsp
							");
		$re_kq = mysql_fetch_assoc($kq);
		
		if(!isset($_SESSION['nhapkho']))
			$_SESSION['nhapkho'] = NULL;
		$_SESSION['nhapkho'][$re_kq['mactsp']]['soluong'] = 1; 
		$_SESSION['nhapkho'][$re_kq['mactsp']]['gianhap'] = $re_kq['gianhap']; 
		$_SESSION['nhapkho'][$re_kq['mactsp']]['thanhtien'] = 0; 
		
		echo "<tr data-id='".$re_kq['mactsp']."'>";
        echo 	"<td><a href='javascript:void(0)' class='del' data-id='".$re_kq['mactsp']."'><img src='../image/del.png' /></a></td>";
        echo	"<td>".$re_kq['mactsp']."</td>";
        echo 	"<td><p><b>".$re_kq['tensp']."</b></p>
					<p style='font-size: 13px;'>NCC: ".$re_kq['tenncc']."</p>
					<p style='font-size: 13px;'>Màu sắc: ".$re_kq['mausac']."</p>
					<p style='font-size: 13px;'>Ngày SX: ".date('d/m/Y', strtotime($re_kq['ngaysx']))."</p>
					<p style='font-size: 13px;'>Hạn SD: ".date('d/m/Y', strtotime($re_kq['hansudung']))."</p>
				</td>";
        echo 	"<td align='center'><input type='submit' class='btn-sub' data-id='".$re_kq['mactsp']."' value='-' />
                    <input type='text' readonly='readonly' class='txt-soluong txt-soluong-".$re_kq['mactsp']."' value='1'/>
                    <input type='submit' class='btn-plus' data-id='".$re_kq['mactsp']."' value='+' /></td>";
       	echo 	"<td>
                	<input type='text'  readonly='readonly' class='txt-sp gianhap gianhap".$re_kq['mactsp']."' data-id='".$re_kq['mactsp']."' style='width: 100px; text-align: right' value='".$re_kq['gianhap']."'/>	
                </td>";
        echo 	"<td align='right'><input type='text'  readonly='readonly' class='txt-sp thanhtien thanhtien".$re_kq['mactsp']."' data-id='".$re_kq['mactsp']."' style='width: 100px; text-align: right' value='".$re_kq['gianhap']."'/></td>";
        echo	"</tr>";
	}
	else if($ac == 'change_soluong')
	{
		$id = isset($_POST['id']) ? $_POST['id'] : "";
		$soluong = isset($_POST['soluongmoi']) ? $_POST['soluongmoi'] : 0;
		$_SESSION['nhapkho'][$id]['soluong'] = $soluong;
	}
	else if($ac == 'change_gianhap')
	{
		$id = isset($_POST['id']) ? $_POST['id'] : ""; $tongtien = 0;
		$gianhap = isset($_POST['gianhap']) ? $_POST['gianhap'] : 0;
		$_SESSION['nhapkho'][$id]['gianhap'] = $gianhap;
		$_SESSION['nhapkho'][$id]['thanhtien'] = $thanhtien = $gianhap * $_SESSION['nhapkho'][$id]['soluong'];
		foreach($_SESSION['nhapkho'] as $key=>$value)
			$tongtien += $_SESSION['nhapkho'][$key]['soluong'] * $_SESSION['nhapkho'][$key]['gianhap'];
		echo json_encode(array("gianhap"=>"$gianhap", "thanhtien"=>"$thanhtien", "tongtien"=>"$tongtien"));
	}
	else if($ac == 'search_sp')
	{
		$keyword = mysql_escape_string($_POST['keyword']);
		mysql_query("set names 'utf8'");
		$kq = mysql_query("select sp.masp, sp.tensp, thuonghieu, tenncc, duongdan
							from sanpham sp, nhacungcap ncc, hinhanh ha
							where ncc.mancc = sp.mancc and sp.masp = ha.masp and sp.trangthai = 1 
							and (tensp LIKE '%$keyword%' or sp.masp LIKE '%$keyword%')
							group by sp.masp");
		while($re_kq = mysql_fetch_assoc($kq))
		{
			//echo json_encode(array("masp"=>"$masp", "tensp"=>"$tensp", "ten));
			echo "<li>";
			echo 	"<a href='javascript:void(0)' data-id='".$re_kq['masp']."'>";
			echo 		"<img src='../image/mypham/".$re_kq['duongdan']."'/>";
			echo 		"<div>";
			echo 			"<p>".$re_kq['tensp']."</p>";
			echo 			"<p>Thương hiệu: ".$re_kq['thuonghieu']."</p>";
			echo			"<p>Nhà cung cấp: ".$re_kq['tenncc']."</p>";
			echo 		"</div>";
			echo 	"</a>";
			echo "</li>";
			echo "<div class='clear'></div>";
		}
	}
	else if($ac == 'get_sp')
	{
		$id = isset($_POST['id']) ? $_POST['id'] : "";
		mysql_query("set names 'utf8'");
		$kq = mysql_query("select sp.masp, sp.tensp, tenncc
							from sanpham sp, nhacungcap ncc
							where ncc.mancc = sp.mancc and sp.trangthai = 1
							and  sp.masp = '$id' 
							");
		$re_kq = mysql_fetch_assoc($kq);
		echo json_encode(array("masp" => "$re_kq[masp]", "tensp" => "$re_kq[tensp]", "tenncc"=>"$re_kq[tenncc]"));
	}
	else if($ac == 'them_ctsp')
	{
		$masp = $_POST['masp'];
		$mausac = $_POST['mausac']; $ngaysx = $_POST['ngaysx']; $hsd = $_POST['hsd']; $giaban = $_POST['giaban']; $gianhap = $_POST['gianhap'];
		$tensp = $_POST['tensp']; $tenncc = $_POST['tenncc'];
		$mactsp = mysql_query("select count(mactsp) as 'number' from chitietsanpham");
		$mactsp = mysql_fetch_assoc($mactsp);
		$mactsp =(int)$mactsp['number'] + 1;
		
		mysql_query("set names 'utf8'");
		$kq = mysql_query("insert into chitietsanpham(masp, mactsp, mausac, ngaysx, hansudung, soluong, giaban, trangthai) values('$masp', '$mactsp', '$mausac', '$ngaysx', '$hsd', 0, $giaban, 1)");	
		
		if(!isset($_SESSION['nhapkho']))
			$_SESSION['nhapkho'] = NULL;
		$_SESSION['nhapkho'][$mactsp]['soluong'] = 1; 
		$_SESSION['nhapkho'][$mactsp]['gianhap'] = $gianhap; 
		$_SESSION['nhapkho'][$mactsp]['thanhtien'] = 0; 
		echo "<tr data-id='".$mactsp."'>";
        echo 	"<td><a href='javascript:void(0)' class='del' data-id='".$mactsp."'><img src='../image/del.png' /></a></td>";
        echo	"<td>".$mactsp."</td>";
        echo 	"<td><p><b>".$tensp."</b></p>
					<p style='font-size: 13px;'>NCC: ".$tenncc."</p>
					<p style='font-size: 13px;'>Màu sắc: ".$mausac."</p>
					<p style='font-size: 13px;'>Ngày SX: ".date('d/m/Y', strtotime($ngaysx))."</p>
					<p style='font-size: 13px;'>Hạn SD: ".date('d/m/Y', strtotime($hsd))."</p>
				</td>";
        echo 	"<td align='center'><input type='submit' class='btn-sub' data-id='".$mactsp."' value='-' />
                    <input type='text' readonly='readonly' class='txt-soluong txt-soluong-".$mactsp."' value='1'/>
                    <input type='submit' class='btn-plus' data-id='".$mactsp."' value='+' /></td>";
       	echo 	"<td>
                	<input type='text' class='txt-sp gianhap gianhap".$mactsp."' data-id='".$mactsp."' style='width: 100px; text-align: right' value='".$gianhap."'/>	
                </td>";
        echo 	"<td align='right'><input type='text'  readonly='readonly' class='txt-sp thanhtien thanhtien".$mactsp."' data-id='".$mactsp."' style='width: 100px; text-align: right' value='".$gianhap."'/></td>";
        echo	"</tr>";
	}
	else if($ac == 'nhapkho')
	{
		$string = "";
		$mapn = Tao_PN();
		date_default_timezone_set('Asia/Ho_Chi_Minh');
		$date = date('Y/m/d H:i:s');
		$kq = mysql_query("insert into phieunhap(maphieu, ngaynhap, manv) values('$mapn', '$date', '".$_SESSION['user']."')");
		foreach($_SESSION['nhapkho'] as $key => $value)
		{
			mysql_query("set names 'utf8'");
			$kq = mysql_query("insert into chitietphieunhap values('$mapn','$key', ".$_SESSION['nhapkho'][$key]['soluong'].", ".$_SESSION['nhapkho'][$key]['gianhap'].")");	
			$kq = mysql_query("update chitietsanpham set soluong = (soluong + ".$_SESSION['nhapkho'][$key]['soluong'].") where mactsp = '$key'");
		}
		unset($_SESSION['nhapkho']);
	}	
	mysql_close($conn);
?>

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