<?php

	session_start();

	require('../../../../config/config.php');

	if($_POST['ac'] == 'get_qt')
	{
		
		
		$keyword = mysql_escape_string($_POST['keyword']);
		
		mysql_query("set names 'utf8'");
		$kq = mysql_query("	select ctsp.mactsp, sp.masp, sp.tensp, ctsp.mausac, thuonghieu, tenncc
							from sanpham sp, chitietsanpham ctsp, nhacungcap ncc
							where sp.masp = ctsp.masp and ncc.mancc = sp.mancc and sp.trangthai = 1 and ctsp.trangthai = 1 and ctsp.soluong > 0
							and ( tensp LIKE '%$keyword%' OR sp.masp LIKE '%$keyword%')");
							
		while($re_kq = mysql_fetch_assoc($kq))
		{
			$hinhanh = mysql_query("select duongdan from hinhanh where masp = '".$re_kq['masp']."' limit 0,1");
			$re_ha = mysql_fetch_assoc($hinhanh);
			echo "<li>";
			echo 	"<a href='javascript:void(0)' class='ctsp-qt' data-ctspqt = '".$re_kq['mactsp']."'>";
			echo 		"<img src='../image/mypham/".$re_ha['duongdan']."'/>";
			echo 		"<div>";
			echo 			"<p>".$re_kq['tensp']."</p>";
			echo 			"<p>".$re_kq['mausac']."</p>";
			echo 			"<p>Thương hiệu: ".$re_kq['thuonghieu']."</p>";
			echo			"<p>Nhà cung cấp: ".$re_kq['tenncc']."</p>";
			echo 		"</div>";
			echo 	"</a>";
			echo "</li>";
			echo "<div class='clear'></div>";
		}
	}
	else if($_POST['ac'] == 'get_info')
	{
		$maqt = $_POST['maqt'];
		
		mysql_query("set names 'utf8'");
		$kq = mysql_query("	select ctsp.mactsp, sp.masp, sp.tensp, ctsp.mausac, thuonghieu, tenncc
							from sanpham sp, chitietsanpham ctsp, nhacungcap ncc
							where sp.masp = ctsp.masp and ncc.mancc = sp.mancc and sp.trangthai = 1 and ctsp.trangthai = 1 and ctsp.soluong > 0
							and ctsp.mactsp = '$maqt'");
		$re_kq = mysql_fetch_assoc($kq);
		
		$_SESSION['list-qt'][] = $re_kq['mactsp'];
		
		echo "<li>";
		echo	"<p>".$re_kq['tensp'].""; echo  $re_kq['mausac'] == "" ? "" : " - Màu sắc: ".$re_kq['mausac']."";
		echo	" <a href='javascript:void(0)' class='del-ctspqt' data-ctspqt='".$re_kq['mactsp']."' > - Xóa</a> ".count($_SESSION['list-qt'])."</p>";
		echo "</li>";
	}
	else if($_POST['ac'] == 'del_qt')
	{
		$maqt = $_POST['maqt'];
		
		foreach($_SESSION['list-qt'] as $key => $value)
		{
			if($value == $maqt)
			{
				unset($_SESSION['list-qt'][$key]);
				//break;	
			}
		}
		if(count($_SESSION['list-qt']) == 0)
		{
			unset($_SESSION['list-qt']);
			echo "0";	
		}
		else
			echo count($_SESSION['list-qt']);
	}
	//sản phẩm ad
	else if($_POST['ac'] == 'get_sp')
	{
		date_default_timezone_set('Asia/Ho_Chi_Minh'); $date = date('Y-m-d');
		
		//loại bỏ những sp đang có km 
		$kq = mysql_query("select masp from khuyenmai km, ctsp_km ctkm where km.makm = ctkm.makm and (ctkm.ngaybd <= '$date' and ctkm.ngaykt >= '$date')");
		$arr = array(); $string = "";
		while($re_kq = mysql_fetch_assoc($kq))
		{
			$arr[] = "'".$re_kq['masp']."'";
		}
		$string = count($arr) > 0 ? implode(',', $arr) : "''";
		
		$keyword = mysql_escape_string($_POST['keyword']);
		
		mysql_query("set names 'utf8'");
		$kq = mysql_query("	select sp.masp, sp.tensp, thuonghieu, tenncc
							from sanpham sp, nhacungcap ncc
							where ncc.mancc = sp.mancc and sp.trangthai = 1
							and ( tensp LIKE '%$keyword%' OR masp LIKE '%$keyword%') and masp not in ($string)") ;
							
		while($re_kq = mysql_fetch_assoc($kq))
		{
			$hinhanh = mysql_query("select duongdan from hinhanh where masp = '".$re_kq['masp']."' limit 0,1");
			$re_ha = mysql_fetch_assoc($hinhanh);
			echo "<li>";
			echo 	"<a href='javascript:void(0)' class='spad' data-spad = '".$re_kq['masp']."'>";
			echo 		"<img src='../image/mypham/".$re_ha['duongdan']."'/>";
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
	else if($_POST['ac'] == 'get_infosp')
	{
		$maspad = $_POST['maspad'];
		
		mysql_query("set names 'utf8'");
		
		$kq = mysql_query("select masp, tensp, thuonghieu, tenncc from sanpham sp, nhacungcap ncc where sp.mancc = ncc.mancc and masp = '$maspad'");
		$re_kq = mysql_fetch_assoc($kq);
	
		$_SESSION['spad'][0]['masp'] = $maspad;
		$_SESSION['spad'][0]['tensp'] = "".$re_kq['tensp']." - Nhà cung cấp: ".$re_kq['tenncc']."";
		
		echo	 "<p>".$re_kq['tensp']." - Nhà cung cấp: ".$re_kq['tenncc']." <a href ='javascript:void(0)' class='del-spad' data-spad='".$re_kq['masp']."'> - Xóa</a></p>";

		//echo json_encode(array("masp"=>"".$re_kq['masp']."", "tensp"=>"".$re_kq['tensp'].""));
	}
	else if($_POST['ac'] == 'del_spad')
	{
		$maspad = $_POST['maspad'];
		unset($_SESSION['spad']);	
	}
	else if($_POST['ac'] == 'themkm')
	{		
		
		$makm = tao_makm();		
		$ngaybd = $_POST['ngaybd']; $ngaykt = $_POST['ngaykt'] ; $mota = $_POST['mota']; $noidung = $_POST['noidung']; $doituong = $_POST['doituong'];
		
		$sql = $check_sp = $check_qt = "";
		
		if($_POST['loaikm'] == '%')
		{
			if($_POST['loaiad'] == 'all')
			{
				$sql = "insert into khuyenmai(makm, mota, chietkhau, trangthai) values('$makm', '$mota', $noidung, 1)";
				truyvan($sql);
				$mactkm = tao_mactkm();
				$sql = "insert into ctsp_km(id, makm, ngaybd, ngaykt) values('$mactkm', '$makm', '$ngaybd', '$ngaykt')";
				truyvan($sql);
			}
			else if($_POST['loaiad'] == 'trigia')
			{
				$sql = "insert into khuyenmai(makm, mota, chietkhau, giatridonhang, trangthai) values('$makm',  '$mota', $noidung, $doituong, 1)";
				truyvan($sql);
				$mactkm = tao_mactkm();
				$sql = "insert into ctsp_km(id, makm, ngaybd, ngaykt) values('$mactkm', '$makm', '$ngaybd', '$ngaykt')";
				truyvan($sql);
			}
			else
			{
				if((!isset($_SESSION['spad'])) || count($_SESSION['spad'])==0)	
				{
					//echo json_encode(array("error_sp"=>"Vui lòng chọn sản phẩm áp dụng"));
					//echo "error_sp";	
					$check_sp = "Vui lòng chọn sản phẩm áp dụng";	
				}
				else
				{
					$sql = "insert into khuyenmai(makm, mota, chietkhau, masp, trangthai) values('$makm',  '$mota', ".$_POST['noidung'].", '".$_SESSION['spad'][0]['masp']."', 1)";
					truyvan($sql);
					$mactkm = tao_mactkm();
					$sql = "insert into ctsp_km(id, makm, ngaybd, ngaykt) values('$mactkm', '$makm', '$ngaybd', '$ngaykt')";
					truyvan($sql);
				}
			}
			
		}
		else if($_POST['loaikm'] == 'VND')
		{
			if($_POST['loaiad'] == 'all')
			{
				$sql = "insert into khuyenmai(makm, mota, tiengiamgia, trangthai) values('$makm', '$mota', $noidung, 1)";
				truyvan($sql);
				$mactkm = tao_mactkm();
				$sql = "insert into ctsp_km(id, makm, ngaybd, ngaykt) values('$mactkm', '$makm', '$ngaybd', '$ngaykt')";
				truyvan($sql);
			}
			else if($_POST['loaiad'] == 'trigia')
			{
				$sql = "insert into khuyenmai(makm, mota, tiengiamgia, giatridonhang, trangthai) values('$makm',  '$mota', $noidung, $doituong, 1)";
				truyvan($sql);
				$mactkm = tao_mactkm();
				$sql = "insert into ctsp_km(id, makm, ngaybd, ngaykt) values('$mactkm', '$makm', '$ngaybd', '$ngaykt')";
				truyvan($sql);
			}
			else
			{
				if((!isset($_SESSION['spad'])) || count($_SESSION['spad'])==0)	
				{
					//echo json_encode(array("error_sp"=>"Vui lòng chọn sản phẩm áp dụng"));
					//echo "error_sp";	
					$check_sp = "Vui lòng chọn sản phẩm áp dụng";	
				}
				else
				{
					$sql = "insert into khuyenmai(makm, mota, tiengiamgia, masp, trangthai) values('$makm',  '$mota', $noidung, '".$_SESSION['spad'][0]['masp']."', 1)";
					truyvan($sql);
					$mactkm = tao_mactkm();
					$sql = "insert into ctsp_km(id, makm, ngaybd, ngaykt) values('$mactkm', '$makm', '$ngaybd', '$ngaykt')";
					truyvan($sql);
				}
			}
			
		}
		else if($_POST['loaikm'] == 'QT')
		{
			//nếu chưa chọn quà tặng thì $sql = "" => ko query đc
			if((!isset($_SESSION['list-qt'])) || count($_SESSION['list-qt'])==0)
			{
				$check_qt = "Vui lòng chọn quà tặng";
			}
			else
			{
				// cho all bill
				if($_POST['loaiad'] == 'all')
				{
					$sql = "insert into khuyenmai(makm, mota, trangthai) values('$makm', '$mota', 1)";
					truyvan($sql);
					foreach($_SESSION['list-qt'] as $key => $value)
						{
							$mactkm = tao_mactkm();
							truyvan("insert into ctsp_km(id, makm, ngaybd, ngaykt, mactsp) values('$mactkm', '$makm', '$ngaybd', '$ngaykt', '$value')");	
						}
				}
				//cho bill trị giá trên ? VND
				else if($_POST['loaiad'] == 'trigia')
				{
					$sql = "insert into khuyenmai(makm, mota,  giatridonhang, trangthai) values('$makm',  '$mota', $doituong, 1)";
					truyvan($sql);
					foreach($_SESSION['list-qt'] as $key => $value)
						{
							$mactkm = tao_mactkm();
							truyvan("insert into ctsp_km(id, makm, ngaybd, ngaykt, mactsp) values('$mactkm', '$makm', '$ngaybd', '$ngaykt', '$value')");	
						}
				}
				// cho sản phẩm
				else
				{
					//nếu chưa chọn spad thì $sql = "" => ko query đc
					if((!isset($_SESSION['spad'])) || count($_SESSION['spad'])==0)	
					{
						//echo "error_sp";	
						$check_sp = "Vui lòng chọn sản phẩm áp dụng";	
					}
					else
					{
						$sql = "insert into khuyenmai(makm, mota, masp, trangthai) values('$makm',  '$mota', '".$_SESSION['spad'][0]['masp']."', 1)";
						truyvan($sql);
						
						foreach($_SESSION['list-qt'] as $key => $value)
						{
							$mactkm = tao_mactkm();
							truyvan("insert into ctsp_km(id, makm, ngaybd, ngaykt, mactsp) values('$mactkm', '$makm', '$ngaybd', '$ngaykt', '$value')");	
						}
					}
				}
				
			}
		}
		else if($_POST['loaikm'] == 'PMH')
		{
			// cho all bill
			if($_POST['loaiad'] == 'all')
			{
				$sql = "insert into khuyenmai(makm, mota, giatrivoucher, trangthai) values('$makm', '$mota', $noidung, 1)";
				truyvan($sql);
				$mactkm = tao_mactkm();
				$sql = "insert into ctsp_km(id, makm, ngaybd, ngaykt) values('$mactkm', '$makm', '$ngaybd', '$ngaykt')";
				truyvan($sql);
			}
			else if($_POST['loaiad'] == 'trigia')
			{
				$sql = "insert into khuyenmai(makm, mota, giatrivoucher, giatridonhang, trangthai) values('$makm',  '$mota', $noidung, $doituong, 1)";
				truyvan($sql);
				$mactkm = tao_mactkm();
				$sql = "insert into ctsp_km(id, makm, ngaybd, ngaykt) values('$mactkm', '$makm', '$ngaybd', '$ngaykt')";
				truyvan($sql);
			}
		}
		
		if($check_qt != "" || $check_sp != "")
			echo json_encode(array("error_sp"=>"$check_sp", "error_qt"=>"$check_qt"));
		else if($check_qt == "" && $check_sp == "")
			echo json_encode(array("notify"=>"Thành công"));
	}
	else if($_POST['ac'] == 'suakm')
	{
		$makm = $_POST['makm'];		
		$ngaybd = $_POST['ngaybd']; $ngaykt = $_POST['ngaykt'] ; $mota = $_POST['mota']; $noidung = $_POST['noidung']; $doituong = $_POST['doituong'];
		
		$sql = $check_sp = $check_qt = "";
		
		if($_POST['loaikm'] == '%')
		{
			if($_POST['loaiad'] == 'all')
			{
				$sql = "update khuyenmai set chietkhau = $noidung, tiengiamgia = 0, giatrivoucher = 0, giatridonhang = 0, masp = '', mota = '$mota' where makm = '$makm' ";
				truyvan($sql);
				
				//$sql = "update ctsp_km set ngaybd='$ngaybd', ngaykt='$ngaykt' where makm = '$makm'";
				$sql = "update ctsp_km set ngaybd='$ngaybd', ngaykt='$ngaykt', mactsp = '' where makm = '$makm'";
				truyvan($sql);
			}
			else if($_POST['loaiad'] == 'trigia')
			{
				$sql = "update khuyenmai set chietkhau = $noidung, tiengiamgia = 0, giatrivoucher = 0, giatridonhang = $doituong, masp = '', mota = '$mota' where makm = '$makm' ";
				truyvan($sql);
				
				//$sql = "update ctsp_km set ngaybd='$ngaybd', ngaykt='$ngaykt' where makm = '$makm'";
				$sql = "update ctsp_km set ngaybd='$ngaybd', ngaykt='$ngaykt', mactsp = '' where makm = '$makm'";
				truyvan($sql);
			}
			else
			{
				if((!isset($_SESSION['spad'])) || count($_SESSION['spad'])==0)	
				{
					//echo json_encode(array("error_sp"=>"Vui lòng chọn sản phẩm áp dụng"));
					//echo "error_sp";	
					$check_sp = "Vui lòng chọn sản phẩm áp dụng";	
				}
				else
				{
					$sql = "update khuyenmai set chietkhau = $noidung, tiengiamgia = 0, giatrivoucher = 0, giatridonhang = 0, masp = '".$_SESSION['spad'][0]['masp']."', mota = '$mota' where makm = '$makm' ";
					truyvan($sql);
					
					$sql = "update ctsp_km set ngaybd='$ngaybd', ngaykt='$ngaykt', mactsp = '' where makm = '$makm'";
					truyvan($sql);
				}
				
			}
			
		}
		else if($_POST['loaikm'] == 'VND')
		{
			if($_POST['loaiad'] == 'all')
			{
				$sql = "update khuyenmai set chietkhau = 0, tiengiamgia = $noidung, giatrivoucher = 0, giatridonhang = 0, masp = '', mota = '$mota' where makm = '$makm' ";
				truyvan($sql);
				
				//$sql = "update ctsp_km set ngaybd='$ngaybd', ngaykt='$ngaykt' where makm = '$makm'";
				$sql = "update ctsp_km set ngaybd='$ngaybd', ngaykt='$ngaykt', mactsp = '' where makm = '$makm'";
				truyvan($sql);
			}
			else if($_POST['loaiad'] == 'trigia')
			{
				$sql = "update khuyenmai set chietkhau = 0, tiengiamgia = $noidung, giatrivoucher = 0, giatridonhang = $doituong, masp = '', mota = '$mota' where makm = '$makm' ";
				truyvan($sql);
				
				$sql = "update ctsp_km set ngaybd='$ngaybd', ngaykt='$ngaykt', mactsp = '' where makm = '$makm'";
				truyvan($sql);
			}
			else
			{
				if((!isset($_SESSION['spad'])) || count($_SESSION['spad'])==0)	
				{
					//echo json_encode(array("error_sp"=>"Vui lòng chọn sản phẩm áp dụng"));
					//echo "error_sp";	
					$check_sp = "Vui lòng chọn sản phẩm áp dụng";	
				}
				else
				{
					$sql = "update khuyenmai set chietkhau = 0, tiengiamgia = $noidung, giatrivoucher = 0, giatridonhang = 0, masp = '".$_SESSION['spad'][0]['masp']."', mota = '$mota' where makm = '$makm' ";
					truyvan($sql);
					
					$sql = "update ctsp_km set ngaybd='$ngaybd', ngaykt='$ngaykt', mactsp = '' where makm = '$makm'";
					truyvan($sql);
				}
			}
			
		}
		else if($_POST['loaikm'] == 'QT')
		{
			//nếu chưa chọn quà tặng thì $sql = "" => ko query đc
			if((!isset($_SESSION['list-qt'])) || count($_SESSION['list-qt'])==0)
			{
				$check_qt = "Vui lòng chọn quà tặng";
			}
			else
			{
				// cho all bill
				if($_POST['loaiad'] == 'all')
				{
					$sql = "update khuyenmai set mota = '$mota', chietkhau = 0, giatrivoucher = 0, tiengiamgia = 0, giatridonhang = 0, masp = '' where makm = '$makm'";
					truyvan($sql);
					
					$sql = "delete from ctsp_km where makm = '$makm'"; truyvan($sql);
					foreach($_SESSION['list-qt'] as $key => $value)
					{
						$mactkm = tao_mactkm();
						truyvan("insert into ctsp_km(id, makm, ngaybd, ngaykt, mactsp) values('$mactkm', '$makm', '$ngaybd', '$ngaykt', '$value')");	
					}
				}
				//cho bill trị giá trên ? VND
				else if($_POST['loaiad'] == 'trigia')
				{
					$sql = "update khuyenmai set mota = '$mota', chietkhau = 0, giatrivoucher = 0, tiengiamgia = 0, giatridonhang = $doituong, masp = '' where makm = '$makm'";
					truyvan($sql);
					
					$sql = "delete from ctsp_km where makm = '$makm'"; truyvan($sql);
					foreach($_SESSION['list-qt'] as $key => $value)
					{
						$mactkm = tao_mactkm();
						truyvan("insert into ctsp_km(id, makm, ngaybd, ngaykt, mactsp) values('$mactkm', '$makm', '$ngaybd', '$ngaykt', '$value')");	
					}
				}
				// cho sản phẩm
				else
				{
					//nếu chưa chọn spad thì $sql = "" => ko query đc
					if((!isset($_SESSION['spad'])) || count($_SESSION['spad'])==0)	
					{
						//echo "error_sp";	
						$check_sp = "Vui lòng chọn sản phẩm áp dụng";	
					}
					else
					{
						$sql = "update khuyenmai set mota = '$mota', chietkhau = 0, giatrivoucher = 0, tiengiamgia = 0, giatridonhang = 0, masp = '".$_SESSION['spad'][0]['masp']."' where makm = '$makm'";
						truyvan($sql);
						
						$sql = "delete from ctsp_km where makm = '$makm'"; truyvan($sql);
						foreach($_SESSION['list-qt'] as $key => $value)
						{
							$mactkm = tao_mactkm();
							truyvan("insert into ctsp_km(id, makm, ngaybd, ngaykt, mactsp) values('$mactkm', '$makm', '$ngaybd', '$ngaykt', '$value')");	
						}
					}
				}
				
			}
		}
		else if($_POST['loaikm'] == 'PMH')
		{
			// cho all bill
			if($_POST['loaiad'] == 'all')
			{
				$sql = "update khuyenmai set mota = '$mota', chietkhau = 0, giatrivoucher = $noidung, tiengiamgia = 0, giatridonhang = 0, masp = '' where makm = '$makm'";
				truyvan($sql);
					
				$sql = "delete from ctsp_km where makm = '$makm'"; truyvan($sql);
				$mactkm = tao_mactkm();
				truyvan("insert into ctsp_km(id, makm, ngaybd, ngaykt) values('$mactkm', '$makm', '$ngaybd', '$ngaykt')");
			}
			else if($_POST['loaiad'] == 'trigia')
			{
				$sql = "update khuyenmai set mota = '$mota', chietkhau = 0, giatrivoucher = $noidung, tiengiamgia = 0, giatridonhang = $doituong, masp = '' where makm = '$makm'";
				truyvan($sql);
					
				$sql = "delete from ctsp_km where makm = '$makm'"; truyvan($sql);
				$mactkm = tao_mactkm();
				truyvan("insert into ctsp_km(id, makm, ngaybd, ngaykt) values('$mactkm', '$makm', '$ngaybd', '$ngaykt')");
			}
		}
		
		if($check_qt != "" || $check_sp != "")
			echo json_encode(array("error_sp"=>"$check_sp", "error_qt"=>"$check_qt"));
		else if($check_qt == "" && $check_sp == "")
			echo json_encode(array("notify"=>"Thành công"));
	}
	else if($_POST['ac'] == 'in')
	{
		$soluong = $_POST['soluong'];
		$voucher_bd = $_POST['voucher_bd']; $voucher_kt = $_POST['voucher_kt'];
		$trigia = $_POST['trigia'];
		for($i=0; $i<$soluong; $i++)
		{
			$maphieu = tao_mapmh();
			mysql_query("set names 'ut8f'");
			$pmh = mysql_query("insert into phieumuahang(maphieu, ngaybd, ngaykt, giatri, trangthai) values('$maphieu', '$voucher_bd', '$voucher_kt', $trigia, 0)");	
		}
	}
	else if($_POST['ac'] == 'xoakm')
	{
		$makm = $_POST['makm'];
		$sql = "update khuyenmai set trangthai = 0 where makm = '$makm'";
		truyvan($sql);
	}
	
	mysql_close($conn);
?>

<?php

	function tao_mapmh()
	{
		$result = mysql_query("select MaPhieu from PhieuMuaHang ");
		
		if(mysql_num_rows($result) == 0)
			return  'PMH1';
		else
		{
			$dong = mysql_fetch_assoc($result);
			
			$number = substr($dong['MaPhieu'], 3);
			
			while($dong = mysql_fetch_assoc($result))
			{
				$temp = substr($dong['MaPhieu'], 3);
				if($number < $temp)
					$number = $temp;
			}
			return 'PMH'.++$number;
		}
	}
	
	function tao_mactkm()
	{
		$result = mysql_query("select id from ctsp_km ");
		
		if(mysql_num_rows($result) == 0)
			return  '1';
		else
		{
			$dong = mysql_fetch_assoc($result);
			
			$number = (int)$dong['id'];
			
			while($dong = mysql_fetch_assoc($result))
			{
				$temp = (int)$dong['id'];
				if($number < $temp)
					$number = $temp;
			}
			return ++$number;
		}
	}
	
	function tao_makm()
	{
				$result = mysql_query("select MaKM from KhuyenMai where MaKM <> '000'");

		if(mysql_num_rows($result) == 0)
			return 'KM1';
		else
		{
			$dong = mysql_fetch_assoc($result);
			
			$number = substr($dong['MaKM'], 2);
			
			while($dong = mysql_fetch_assoc($result))
			{
				$temp = substr($dong['MaKM'], 2);
				if($number < $temp)
					$number = $temp;
			}
			return 'KM'.++$number;
		}
	}
	
	function truyvan($query)
	{
		mysql_query("set names 'utf8'");
		$kq = mysql_query($query);	
	}
	
?>