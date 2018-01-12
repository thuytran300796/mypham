<?php

	date_default_timezone_set('Asia/Ho_Chi_Minh');
	$ngaybd = $ngaykt = $date = date('Y-m-d');
	$loaixem = 'ngay';
	$list_hd = $list_nk = $list_ctgh = $list_luong = $list_voucher = array();
	if(isset($_POST['xem']))
	{
		$ngaybd = $_POST['ngaybd']; $ngaykt = $_POST['ngaykt'];
		$loaixem = $_POST['loaixem'];
		
		if($loaixem == 'thang') //tháng
		{
			$month = date('m', strtotime($ngaybd));	
			$year = date('Y', strtotime($ngaybd));	
			$dateint = mktime(0,0,0, $month, 1, $year); 
			$ngaybd = (string)date('Y-m-d', $dateint);
			
			$ngaykt = (string)date('Y-m-t', strtotime($ngaykt));
		}
		else if($loaixem == 'nam') //năm
		{
			$year = date('Y', strtotime($ngaybd));	
			$dateint = mktime(0,0,0, 1, 1, $year);
			$ngaybd = (string)date('Y-m-d', $dateint);
			
			$year = date('Y', strtotime($ngaykt));	
			$dateint = mktime(0,0,0, 12, 31, $year);
			$ngaykt = (string)date('Y-m-d', $dateint);
		}	
	}
	
	mysql_query("set names 'utf8'");
		$hoadon = mysql_query(" select		hd.mahd, date(ngayxuat) 'ngayxuat', phivanchuyen, hd.chietkhau as 'ckhd', km.makm, km.chietkhau, km.tiengiamgia, km.giatridonhang, hd.thue
								from		hoadon hd, khuyenmai km
								where		hd.makm = km.makm and hd.trangthai = 1 and (date(hd.ngayxuat) >= '$ngaybd' and date(hd.ngayxuat) <= '$ngaykt')
								group by hd.mahd
							");
	
		mysql_query("set names 'utf8'");
		$cthd = mysql_query("select t1.mahd, t1.mactsp, t1.soluong, t1.giaban, t2.makm, t2.chietkhau, t2.tiengiamgia, t1.gianhap, t1.quatang
							from
							(	select	sp.masp, cthd.mahd, cthd.mactsp, cthd.soluong, ctsp.giaban, cthd.makm, ctpn.gianhap, cthd.quatang
								from	chitiethoadon cthd, chitietsanpham ctsp, hoadon hd, sanpham sp, chitietphieunhap ctpn
								where	cthd.mactsp = ctsp.mactsp and hd.mahd = cthd.mahd and sp.masp = ctsp.masp and (date(hd.ngayxuat) >= '$ngaybd' and date(hd.ngayxuat) <= '$ngaykt' and ctpn.mactsp=ctsp.mactsp)
								group by cthd.macthd
							)t1 left join
							(
								select	km.makm, km.chietkhau, km.tiengiamgia, km.masp
								from	khuyenmai km, ctsp_km ctkm
								where	km.makm = ctkm.makm and km.makm <> '000' and km.masp <> ''
								group by	km.makm
							)t2 on t1.makm = t2.makm
						");
		$dem=0;
		
		while($re_hd = mysql_fetch_assoc($hoadon))
		{
			$list_hd[$re_hd['mahd']]['ngayxuat'] = $re_hd['ngayxuat'];
			$list_hd[$re_hd['mahd']]['pvc'] = $re_hd['phivanchuyen'];
			$list_hd[$re_hd['mahd']]['ckhd'] = $re_hd['ckhd'];
			$list_hd[$re_hd['mahd']]['thue'] = $re_hd['thue'];
			$list_hd[$re_hd['mahd']]['makm'] = $re_hd['makm'];
			$list_hd[$re_hd['mahd']]['chietkhau'] = $re_hd['chietkhau'];
			$list_hd[$re_hd['mahd']]['tiengiamgia'] = $re_hd['tiengiamgia'];
			$list_hd[$re_hd['mahd']]['giatridonhang'] = $re_hd['giatridonhang'];
			$dem++;
		}
		$dem = 0;
		while($re_cthd = mysql_fetch_assoc($cthd))
		{
			$list_ctgh[$dem]['mahd'] = $re_cthd['mahd'];
			$list_ctgh[$dem]['mactsp'] = $re_cthd['mactsp'];
			$list_ctgh[$dem]['soluong'] = $re_cthd['soluong'];
			$list_ctgh[$dem]['giaban'] = $re_cthd['giaban'];
			$list_ctgh[$dem]['makm'] = $re_cthd['makm'];
			$list_ctgh[$dem]['chietkhau'] = $re_cthd['chietkhau'];
			$list_ctgh[$dem]['tiengiamgia'] = $re_cthd['tiengiamgia'];
			$list_ctgh[$dem]['gianhap'] = $re_cthd['gianhap'];
			$list_ctgh[$dem]['quatang'] = $re_cthd['quatang'];
			$dem++;	
		}
		
		$voucher = mysql_query("select mahd, hd.maphieu, giatri from pmh_hd hd, phieumuahang pmh where hd.maphieu = pmh.maphieu");
		$dem = 0;
		while($re_voucher = mysql_fetch_assoc($voucher))
		{
			$list_voucher[$dem]['mahd'] = $re_voucher['mahd'];
			$list_voucher[$dem]['maphieu'] = $re_voucher['maphieu'];
			$list_voucher[$dem]['giatri'] = $re_voucher['giatri'];
			$dem++;
		}
		$nhapkho = 	mysql_query("select	pn.maphieu, date(ngaynhap) 'ngaynhap', sum(ctpn.soluong * gianhap) 'tien'
								from	chitietphieunhap ctpn, phieunhap pn
								where	ctpn.maphieu = pn.maphieu and (date(pn.ngaynhap) >= '$ngaybd' and date(pn.ngaynhap) <= '$ngaykt')
								group by pn.maphieu
								");
		$dem = 0;
		while($re_nk = mysql_fetch_assoc($nhapkho))
		{
			$list_nk[$re_nk['maphieu']]['ngaynhap'] = $re_nk['ngaynhap'];
			$list_nk[$re_nk['maphieu']]['tien'] = $re_nk['tien'];
		}
		//lương nv
		$luong = mysql_query("select	ngay, songaycong,hesoluong,luongcoban,phucap,thuong, phat
								from	chitietluong ctl, chucvu cv
								where	ctl.macv = cv.macv
									and	ctl.ngay >= '$ngaybd' and ctl.ngay <= '$ngaykt'
								");
		$dem = 0;
		while($re_luong = mysql_fetch_assoc($luong))
		{
			$list_luong[$dem]['ngay'] = $re_luong['ngay'];
			$list_luong[$dem]['songaycong'] = $re_luong['songaycong'];
			$list_luong[$dem]['heso'] = $re_luong['hesoluong'];
			$list_luong[$dem]['phucap'] = $re_luong['phucap'];
			$list_luong[$dem]['luongcb'] = $re_luong['luongcoban'];
			$list_luong[$dem]['thuong'] = $re_luong['thuong'];
			$list_luong[$dem]['phat'] = $re_luong['phat'];
			$dem++;
		}
?>

<div style='width: 78%; float: right;'><p class='title'>THỐNG KÊ THU CHI</p></div>
<div class="clear"></div>
<BR />
<div id='sp-left' style="width: 20%">
	<form method="post">
        <div>
            
            
           	<table width="100%">
           		<tr>
                	<td style="padding: 10px">Từ: </td>
                    <td align="right"><input type='date' class="txt-sp date" name='ngaybd' value='<?php echo $ngaybd ?>'/></td>
                </tr>
                <tr>
                	<td style="padding: 10px">đến: </td>
                    <td align="right"><input type='date' class="txt-sp date" name='ngaykt' value='<?php echo $ngaykt ?>'/></td>
                </tr>
           	</table>
			<select name='loaixem' class="cbb-sp" style="width: 235px">
            	<?php
					if(isset($_POST['loaixem']))
					{
						if($_POST['loaixem'] == 'ngay')
						{
							echo "<option value = 'ngay' selected='selected'>Theo ngày</option>";
							echo "<option value = 'thang'>Theo tháng</option>";
							echo "<option value = 'nam'>Theo năm</option>";
						}
						else if($_POST['loaixem'] == 'thang')
						{
							echo "<option value = 'ngay'>Theo ngày</option>";
							echo "<option value = 'thang' selected='selected'>Theo tháng</option>";
							echo "<option value = 'nam'>Theo năm</option>";
						}
						else if($_POST['loaixem'] == 'nam')
						{
							echo "<option value = 'ngay' >Theo ngày</option>";
							echo "<option value = 'thang'>Theo tháng</option>";
							echo "<option value = 'nam' selected='selected'>Theo năm</option>";
						}	
					}
					else
					{
						echo "<option value = 'ngay' >Theo ngày</option>";
						echo "<option value = 'thang'>Theo tháng</option>";
						echo "<option value = 'nam' >Theo năm</option>";
					}
				?>
            </select>
            <input type='submit' id = 'search-sp' name='xem' value='Xem' class="sub" style="width: 235px"/>
        </div>
	</form>
</div>

<div id='tksp-right'>
<table class="tb-lietke" width="100%" border="1">
	
    
    <tr>
    	<th></th>
    	<th colspan="2">Chi</th>
        <th colspan="2">Thu</th>
    </tr>
    <tr>
    	<th>Thời gian</th>
        <th>Lương nhân viên</th>
        <th>Tiền nhập hàng</th>
        <th>Tiền bán hàng</th>
        <th>Tiền lời</th>
    </tr>
    
<?php
	if($loaixem == 'ngay')
	{
		XemNgay($ngaybd, $ngaykt, $list_ctgh, $list_hd, $list_nk, $list_voucher, $list_luong);	
	}
	else if($loaixem == 'thang')
	{
		XemThang($ngaybd, $ngaykt, $list_ctgh, $list_hd, $list_nk, $list_voucher, $list_luong);		
	}
	else
	{
		XemNam($ngaybd, $ngaykt, $list_ctgh, $list_hd, $list_nk, $list_voucher, $list_luong);		
	}
?>

    

</table>
</div>

<?php

	//chỉ tính cho 1 hóa đơn
	function TinhHD($mahd, $ngaybd, $ngaykt, $list_ctgh, $list_hd, $list_nk, $list_voucher)
	{
		$thanhtien = $tongtien = 0;
		$tienloi = $tongloi = 0;
		$tienvon = 0;
		//tính tiền trong chi tiết hóa đơn
		for($i=0; $i<count($list_ctgh); $i++)
		{
			$giamgia = 0; $tiensp = 0;
			if($list_ctgh[$i]['mahd'] == $mahd )
			{
				//nếu nó ko phải quà tặng thì mới tính
				if($list_ctgh[$i]['quatang'] == 0)
				{
					//nếu có km
					if($list_ctgh[$i]['makm'] != "000")
					{
						if($list_ctgh[$i]['chietkhau'] != 0)
						{
							$giamgia = $list_ctgh[$i]['chietkhau'];
							$thanhtien += ($list_ctgh[$i]['giaban'] - ($list_ctgh[$i]['giaban'] * ($giamgia/100))) * $list_ctgh[$i]['soluong'];
							$tiensp = ($list_ctgh[$i]['giaban'] - ($list_ctgh[$i]['giaban'] * ($giamgia/100))) * $list_ctgh[$i]['soluong'];
						}
						else if($list_ctgh[$i]['tiengiamgia'] != 0)
						{
							$giamgia = $list_ctgh[$i]['tiengiamgia'];
							$thanhtien += ($list_ctgh[$i]['giaban'] - $giamgia)* $list_ctgh[$i]['soluong'];
							$tiensp = ($list_ctgh[$i]['giaban'] - $giamgia)* $list_ctgh[$i]['soluong'];
						}
								//khi ko có km
						else
						{
							$thanhtien += ($list_ctgh[$i]['giaban'])* $list_ctgh[$i]['soluong'];
							$tiensp = ($list_ctgh[$i]['giaban'])* $list_ctgh[$i]['soluong'];
						}
					}
					else
					{
						$thanhtien += ($list_ctgh[$i]['giaban'])* $list_ctgh[$i]['soluong'];
						$tiensp = ($list_ctgh[$i]['giaban'])* $list_ctgh[$i]['soluong'];
					}
				}
				
				//$tienloi += $tiensp - $list_ctgh[$i]['gianhap'] * $list_ctgh[$i]['soluong']; 	
				//ko phải quà tặng vẫn phải tính tiền vốn
				$tienvon +=  $list_ctgh[$i]['gianhap'] * $list_ctgh[$i]['soluong'];			
				//echo $mahd.": ".$tienvon."<Br/>";
			}
			
		}
		
		//tính tiền hóa đơn
		$giam_hd =  $check_km = 0;
		if($list_hd[$mahd]['chietkhau'] != "0")
		{
			if($list_hd[$mahd]['giatridonhang'] != 0)
			{
				$tongtien = $thanhtien >= $list_hd[$mahd]['giatridonhang'] ? ($thanhtien - ($thanhtien * ($list_hd[$mahd]['chietkhau']/100))) : $thanhtien;
			}
			else
			{
				$tongtien = $thanhtien - ($thanhtien * ($list_hd[$mahd]['chietkhau']/100));
			}	
		}
		else if($list_hd[$mahd]['tiengiamgia'] != "0")
		{
			if($list_hd[$mahd]['giatridonhang'] != 0)
			{
				$tongtien = $thanhtien >= $list_hd[$mahd]['giatridonhang'] ? ($thanhtien - $list_hd[$mahd]['tiengiamgia']) : $thanhtien;
			}
			else
			{
				$tongtien = $thanhtien - $list_hd[$mahd]['tiengiamgia'];
			}
		}
		else
		{
			$tongtien = $thanhtien;
		}
			//echo $tongtien."<br/>";
		$tien_voucher = 0;
		for($j = 0; $j<count($list_voucher); $j++)
		{
			if($mahd == $list_voucher[$j]['mahd'])
			{
				$tongtien -= $list_voucher[$j]['giatri'];	
				$tien_voucher += $list_voucher[$j]['giatri'];	
			}
		}
			
		//$ckhd = $tongtien*($list_hd[$mahd]['ckhd']/100);  
		$ckhd = $list_hd[$mahd]['ckhd'];  
		$tongtien = $tongtien - $ckhd + $list_hd[$mahd]['pvc']; 
		$tongloi = $tongtien - $tienvon - $list_hd[$mahd]['thue']; //echo $mahd." - ".$tongloi."<br/>";
		
		//return $tongtien;
		return array("tongtien"=>$tongtien, "tongloi"=>$tongloi);
	}

	function XemNgay($ngaybd, $ngaykt, $list_ctgh, $list_hd, $list_nk, $list_voucher, $list_luong)
	{
		$tongtien = 0;
		date_default_timezone_set('Asia/Ho_Chi_Minh');
		$ngay = date('Y/m/d', strtotime($ngaybd));
				//echo $ngay;
		$tongkho = $tonghd = $tongluong = $tongloi = 0;			
		while($ngay <= date('Y/m/d', strtotime($ngaykt)))
		{
			$tien = 0;
			$tien_hd = $tien_kho = $tien_luong = $tien_loi = 0;
			
			foreach($list_hd as $key=>$value)
			{
				if(strtotime($list_hd[$key]['ngayxuat']) == strtotime($ngay))
				{
					$arr = array(); $arr = TinhHD($key, $ngaybd, $ngaykt, $list_ctgh, $list_hd, $list_nk, $list_voucher);
					
					$tien_loi += $arr['tongloi'];
					$tien_hd += $arr['tongtien'];
					
					$tien += $tien_hd; 
				}
			}
			//echo $tien_loi."<br/>";
					
			foreach($list_nk as $key=>$value)
			{
				if(strtotime($list_nk[$key]['ngaynhap']) == strtotime($ngay))
				{
					$tien_kho += $list_nk[$key]['tien'];
					
					$tien += $tien_kho;
				}
			}
			
			foreach($list_luong as $key=>$value)
			{
				if(strtotime($list_luong[$key]['ngay']) == strtotime($ngay))
				{
					$tien_luong += ($list_luong[$key]['songaycong'] * $list_luong[$key]['heso'] * $list_luong[$key]['luongcb'] + $list_luong[$key]['phucap'] + $list_luong[$key]['thuong'] - $list_luong[$key]['phat']);
					
					$tien += $tien_luong;
				}
			}
					
			
			if($tien > 0)
			{
		
                echo "<tr>";
                echo 	"<td>".date('d/m/Y', strtotime($ngay))."</td>";
                echo 	"<td>".number_format($tien_luong)."</td>";
				echo 	"<td>".number_format($tien_kho)."</td>";
                echo 	"<td>".number_format($tien_hd)."</td>";
				echo 	"<td>".number_format($tien_loi)."</td>";
                echo "</tr>";
        
			}
			$ngay = strtotime((date('Y/m/d', strtotime($ngay))) . "+1 day");
			$ngay = strftime("%Y/%m/%d", $ngay);
			$tongtien += $tien;
			$tonghd += $tien_hd; $tongkho += $tien_kho; $tongluong += $tien_luong; $tongloi += $tien_loi;
		}	
		echo "<tr>";
        echo 	"<td>Tổng cộng</td>";
		echo 	"<td>".number_format($tongluong)."</td>";
		echo 	"<td>".number_format($tongkho)."</td>";
        echo 	"<td>".number_format($tonghd)."</td>";
		echo 	"<td>".number_format($tongloi)."</td>";
        echo "</tr>"; 
	}
	
	function XemThang($ngaybd, $ngaykt, $list_ctgh, $list_hd, $list_nk, $list_voucher, $list_luong)
	{
		$tongtien = 0;
		date_default_timezone_set('Asia/Ho_Chi_Minh');
		$ngay = date('Y/m/d', strtotime($ngaybd));
				
		$tongkho = $tonghd = $tongluong = $tongloi = 0;			
		while(true)
		{
			$tien = 0;
			$tien_hd = $tien_kho = $tien_luong = $tien_loi = 0;
			
			$month = date('m', strtotime($ngay));
			$year = date('Y', strtotime($ngay));
			
			foreach($list_hd as $key=>$value)
			{
				if($month == date('m', strtotime($list_hd[$key]['ngayxuat'])) && $year == date('Y', strtotime($list_hd[$key]['ngayxuat'])))
				{
					$arr = array(); $arr = TinhHD($key, $ngaybd, $ngaykt, $list_ctgh, $list_hd, $list_nk, $list_voucher);
					
					$tien_loi += $arr['tongloi'];
					$tien_hd += $arr['tongtien'];
					
					$tien += $tien_hd; 
				}
			}
			//echo $tien_loi."<br/>";
					
			foreach($list_nk as $key=>$value)
			{
				if($month == date('m', strtotime($list_nk[$key]['ngaynhap'])) && $year == date('Y', strtotime($list_nk[$key]['ngaynhap'])))
				{
					$tien_kho += $list_nk[$key]['tien'];
					
					$tien += $tien_kho;
				}
			}
			
			foreach($list_luong as $key=>$value)
			{
				if($month == date('m', strtotime($list_luong[$key]['ngay'])) && $year == date('Y', strtotime($list_luong[$key]['ngay'])))
				{
					$tien_luong += ($list_luong[$key]['songaycong'] * $list_luong[$key]['heso'] * $list_luong[$key]['luongcb'] + $list_luong[$key]['phucap'] + $list_luong[$key]['thuong'] - $list_luong[$key]['phat']);
					
					$tien += $tien_luong;
				}
			}
					
			
			if($tien > 0)
			{
		
                echo "<tr>";
                echo 	"<td>".$month."/".$year."</td>";
				echo 	"<td>".number_format($tien_luong)."</td>";
				echo 	"<td>".number_format($tien_kho)."</td>";
                echo 	"<td>".number_format($tien_hd)."</td>";
				echo 	"<td>".number_format($tien_loi)."</td>";
                echo "</tr>";
        
			}
			
			$tongtien += $tien;
			$tonghd += $tien_hd; $tongkho += $tien_kho; $tongluong += $tien_luong; $tongloi += $tien_loi;
			
			$ngay = strtotime((date('Y-m-d', strtotime($ngay))) . "+1 month");
			$ngay = strftime("%Y/%m/%d", $ngay);
			if($month == date('m', strtotime($ngaykt)) && $year == date('Y', strtotime($ngaykt)))
			{
				break;
			}
		}	
		echo "<tr>";
        echo 	"<td>Tổng cộng</td>";
		echo 	"<td>".number_format($tongluong)."</td>";
		echo 	"<td>".number_format($tongkho)."</td>";
        echo 	"<td>".number_format($tonghd)."</td>";
		echo 	"<td>".number_format($tongloi)."</td>";
        echo "</tr>"; 
	}
	
	function XemNam($ngaybd, $ngaykt, $list_ctgh, $list_hd, $list_nk, $list_voucher, $list_luong)
	{
		$tongtien = 0;
		date_default_timezone_set('Asia/Ho_Chi_Minh');
		$ngay = date('Y/m/d', strtotime($ngaybd));
				
		$tongkho = $tonghd = $tongluong = $tongloi = 0;			
		while(true)
		{
			$tien = 0;
			$tien_hd = $tien_kho = $tien_luong = $tien_loi = 0;
			
			$month = date('m', strtotime($ngay));
			$year = date('Y', strtotime($ngay));
			
			foreach($list_hd as $key=>$value)
			{
				if( $year == date('Y', strtotime($list_hd[$key]['ngayxuat'])))
				{
					$arr = array(); $arr = TinhHD($key, $ngaybd, $ngaykt, $list_ctgh, $list_hd, $list_nk, $list_voucher);
					
					$tien_loi += $arr['tongloi'];
					$tien_hd += $arr['tongtien'];
					
					$tien += $tien_hd; 
				}
			}
			//echo $tien_loi."<br/>";
					
			foreach($list_nk as $key=>$value)
			{
				if( $year == date('Y', strtotime($list_nk[$key]['ngaynhap'])))
				{
					$tien_kho += $list_nk[$key]['tien'];
					
					$tien += $tien_kho;
				}
			}
			
			foreach($list_luong as $key=>$value)
			{
				if( $year == date('Y', strtotime($list_luong[$key]['ngay'])))
				{
					$tien_luong += ($list_luong[$key]['songaycong'] * $list_luong[$key]['heso'] * $list_luong[$key]['luongcb'] + $list_luong[$key]['phucap'] + $list_luong[$key]['thuong'] - $list_luong[$key]['phat']);
					
					$tien += $tien_luong;
				}
			}
					
			
			if($tien > 0)
			{
		
                echo "<tr>";
                echo 	"<td>".$year."</td>";
				echo 	"<td>".number_format($tien_luong)."</td>";
				echo 	"<td>".number_format($tien_kho)."</td>";
                echo 	"<td>".number_format($tien_hd)."</td>";
				echo 	"<td>".number_format($tien_loi)."</td>";
                echo "</tr>";
        
			}
			
			$tongtien += $tien;
			$tonghd += $tien_hd; $tongkho += $tien_kho; $tongluong += $tien_luong; $tongloi += $tien_loi;
			
			$ngay = strtotime((date('Y-m-d', strtotime($ngay))) . "+1 year");
			$ngay = strftime("%Y/%m/%d", $ngay);
			
			if($year == date('Y', strtotime($ngaykt)))
			{
				break;
			}
		}	
		echo "<tr>";
        echo 	"<td>Tổng cộng</td>";
		echo 	"<td>".number_format($tongluong)."</td>";
		echo 	"<td>".number_format($tongkho)."</td>";
        echo 	"<td>".number_format($tonghd)."</td>";
		echo 	"<td>".number_format($tongloi)."</td>";
        echo "</tr>"; 
	}


?>