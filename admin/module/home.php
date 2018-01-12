<?php
	date_default_timezone_set('Asia/Ho_Chi_Minh');
	$ngaybd = $ngaykt = date('Y-m-d');
	$list_hd = $list_ctgh = $list_voucher = array();
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

	function TinhHD($mahd, $list_hd, $list_ctgh, $list_voucher)
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
		return $tongtien;
		
	}
	
	function XemNgay($ngaybd, $ngaykt,  $list_hd, $list_ctgh, $list_voucher)
	{
		$tongtien = 0;
		date_default_timezone_set('Asia/Ho_Chi_Minh');
		$ngay = date('Y/m/d', strtotime($ngaybd));

		$tongkho = $tonghd = $tongluong = $tongloi = 0;			
		while($ngay <= date('Y/m/d', strtotime($ngaykt)))
		{
			$tien = 0;
			$tien_hd = $tien_kho = $tien_luong = $tien_loi = 0;
			
			foreach($list_hd as $key=>$value)
			{
				if(strtotime($list_hd[$key]['ngayxuat']) == strtotime($ngay))
				{
					//$arr = array(); $arr = TinhHD($key, $list_hd, $list_ctgh, $list_voucher);
					//$tien_loi += $arr['tongloi'];
					//$tien_hd += $arr['tongtien'];
					
					$tien_hd += TinhHD($key, $list_hd, $list_ctgh, $list_voucher);
					
					$tien += $tien_hd; 
				}
			}
	
			$ngay = strtotime((date('Y/m/d', strtotime($ngay))) . "+1 day");
			$ngay = strftime("%Y/%m/%d", $ngay);
			$tongtien += $tien;
			$tonghd += $tien_hd; $tongloi += $tien_loi;
		}	
		//echo $tonghd."<br/>";
		return $tonghd;
	}
	
	$doanhthungay = XemNgay($ngaybd, $ngaykt, $list_hd, $list_ctgh, $list_voucher);
?>

<div style=" width: 99%; padding-left: 10px;  border-bottom: solid 1px #ccc;  ">

	
    	<b>KẾT QUẢ BÁN HÀNG HÔM NAY</b>
    
	<p style="font-size: 15px; "><?php echo count($list_hd) ?> hóa đơn</p>
    <p style="font-size: 22px; color: #f90; font-weight: bold"><?php echo number_format($doanhthungay) ?></p>
</div>

<br />
<br />

<?php

	date_default_timezone_set('Asia/Ho_Chi_Minh');
	$date = date('Y-m-d');
	$month = date('m', strtotime($date));	
	$year = date('Y', strtotime($date));	

	mysql_query("set names 'utf8'");
	
	$kq = mysql_query("	select	cthd.mactsp, tensp, mausac, sum(cthd.soluong) 'soluong'
						from	hoadon hd, chitiethoadon cthd, sanpham sp, chitietsanpham ctsp
						where	hd.mahd = cthd.mahd and sp.masp = ctsp.masp and cthd.mactsp = ctsp.mactsp
							and hd.trangthai = 1 and month(ngayxuat) = $month and year(ngayxuat) = $year
						group by cthd.mactsp order by sum(cthd.soluong) desc limit 0,10");

?>

<div style="width: 99%; padding-left: 10px; text-align: left; border-bottom: solid 1px #ccc;  height: 40px;">

	<?php
		mysql_query("SET NAMES 'utf8'");
		$donhang = mysql_query("SELECT MaGH FROM GioHang WHERE TrangThai = 0");
		
			echo "<p style = 'font-weight: bold; '>CÓ <a style = 'color: #FA2359;' href='admin.php?quanly=hoadon&ac=giohang'>".mysql_num_rows($donhang)." ĐƠN HÀNG</a> CHỜ GIẢI QUYẾT</p>";	
		
	?>

</div>
<br /><br />
<div style="width: 99%; padding-left: 10px">

	<div style='width: 100%; height: 40px; border-bottom: solid 1px #ccc; line-height: 40px; '>
    	<b>TOP 10 CÁC SẢN PHẨM BÁN CHẠY TRONG THÁNG</b>
    </div>
	
    <table id='home-tk' class="tb-lietke" width="80%" border="1" style="border-collapse: collapse">
    
    	<tr>
        	<th width="25%">Mã sản phẩm</th>
            <th width="50%">Tên sản phẩm</th>
   			<th width="15">Số lượng bán ra</th>
        </tr>
        
    <?php
	
		while($re_kq = mysql_fetch_assoc($kq))
		{
	?>
    	<tr>
        	<td><?php echo $re_kq['mactsp'] ?></td>
            <td><p><?php echo $re_kq['tensp'] ?><p>
            	<p><?php echo ($re_kq['mausac'] != "" ? "Màu: ".$re_kq['mausac'] : "")?></p></td>
            <td align="center"><?php echo $re_kq['soluong'] ?></td>
        </tr>
    <?php	
		}
	
	?>
    
    </table>
    
</div>


