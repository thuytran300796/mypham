<?php
	function Tao_MaHD()
	{
		$result = mysql_query('Select MaHD from HoaDon ');
		
		if(mysql_num_rows($result) == 0)
			return 'HD1';
			
		$dong = mysql_fetch_assoc($result);
		
		$number = substr($dong['MaHD'], 2);
		
		while($dong = mysql_fetch_assoc($result))
		{
			$temp = substr($dong['MaHD'], 2);
			if($number < $temp)
				$number = $temp;
		}
		return 'HD'.++$number;	
	}
?>

<?php
	ob_start();

	$id = isset($_REQUEST['id']) ?  $_REQUEST['id'] : ""; $chietkhau = $phivanchuyen = $thue = 0;
	
	mysql_query("set names 'utf8'");
	$giohang = mysql_query("
								select		gh.magh, gh.makh, ngaydat, ngaygiao, hotennguoinhan, sdt, diachi, gh.trangthai, tensp,  count(gh.magh) 'slsp'
								from		giohang gh, chitietgiohang ctgh, sanpham sp, chitietsanpham ctsp
								where		gh.magh = ctgh.magh and ctgh.mactsp = ctsp.mactsp and ctsp.masp = sp.masp and gh.magh = '$id'
								group by 	gh.magh
							");
	$re_gh = mysql_fetch_assoc($giohang);
	
	
	
	mysql_query("set names 'utf8'");
	$ctgh = mysql_query("select t1.magh, t1.mactsp, t1.tensp, t1.mausac, t1.duongdan, t1.soluong, t1.giaban, t1.thue, t2.makm, t2.chietkhau, t2.tiengiamgia, t1.quatang
						from
						(	select	ctgh.magh, ctgh.mactsp, tensp, ctsp.mausac, duongdan, ctgh.soluong, ctsp.giaban, sp.thue, ctgh.makm, quatang
							from	chitietgiohang ctgh, chitietsanpham ctsp,  hinhanh ha, sanpham sp
							where	ctgh.mactsp = ctsp.mactsp  and ctgh.magh = '$id' and ha.masp = sp.masp and sp.masp = ctsp.masp
							group by ctsp.mactsp
						)t1 left join
						(
							select	km.makm, km.chietkhau, km.tiengiamgia, km.masp
							from	khuyenmai km, ctsp_km ctkm
							where	km.makm = ctkm.makm and km.makm <> '000' and km.masp != ''
							group by	km.makm
						)t2 on t1.makm = t2.makm
						");
						
	$ngaydat = date('Y-m-d', strtotime($re_gh['ngaydat']));  $giamgia = 0;
	mysql_query("set names 'utf8'");
	$km_hd = mysql_query("select	km.makm, km.chietkhau, km.tiengiamgia, km.giatridonhang, ctkm.ngaybd, ctkm.ngaykt
						from		khuyenmai km, ctsp_km ctkm
						where		km.makm = ctkm.makm and km.makm <> '000' and km.masp = '' and ('$ngaydat' >= ctkm.ngaybd and '$ngaydat'<=ctkm.ngaykt)
						group by	km.makm");
		
	if(isset($_POST['id']) && isset($_POST['xuat']))
	{
		
		$kq = mysql_query("update giohang set trangthai = 1 where magh = '$id'");
		
		$chietkhau = $_POST['chietkhau'];
		$phivanchuyen = $_POST['phivanchuyen'];
		$thue = $_POST['thue'];
		$makm = $_POST['makm'];
		
		$mahd = Tao_MaHD(); $user = isset($_SESSION['user']) ? $_SESSION['user'] : "";
		date_default_timezone_set('Asia/Ho_Chi_Minh');
		$ngayxuat = date('Y/m/d H:i:s');	
		
		mysql_query("set names 'utf8'");
		$hd = mysql_query("insert into hoadon(mahd, manv, ngayxuat, makh, makm, chietkhau, phivanchuyen, thue, hotennguoinhan, sdt, diachi, trangthai) values('$mahd', '$user', '$ngayxuat', '".$re_gh['makh']."', '$makm', $chietkhau, $phivanchuyen, $thue, '".$re_gh['hotennguoinhan']."','".$re_gh['sdt']."', '".$re_gh['diachi']."', 1)");
		if(!$hd) echo mysql_error()."<br/>";
		
		while($re_ctgh = mysql_fetch_assoc($ctgh))
		{
			mysql_query("set names 'utf8'");
			
			$cthd = mysql_query("insert into chitiethoadon(mahd, mactsp, soluong, makm, quatang) values('$mahd','".$re_ctgh['mactsp']."', ".$re_ctgh['soluong'].", '".$re_ctgh['makm']."', ".$re_ctgh['quatang'].")");
			
			if(!$cthd)  echo mysql_error()."<br/>";
		}
		
		$voucher = mysql_query("select maphieu, magh from pmh_gh where magh = '$id'");
		while($re_voucher = mysql_fetch_assoc($voucher))
		{
			$kq = mysql_query("insert into pmh_hd values('".$re_voucher['maphieu']."', '$mahd')");
		}
	}
						
	$list_ctgh = array();
	$dem = 0;
	$arr = array();
	$string = "";
	while($re_ctgh = mysql_fetch_assoc($ctgh))
	{
		$list_ctgh[$dem]['magh'] = $re_ctgh['magh'];
		$list_ctgh[$dem]['mactsp'] = $re_ctgh['mactsp'];
		$list_ctgh[$dem]['tensp'] = $re_ctgh['tensp'];
		$list_ctgh[$dem]['mausac'] = $re_ctgh['mausac'];
		$list_ctgh[$dem]['duongdan'] = $re_ctgh['duongdan'];
		$list_ctgh[$dem]['soluong'] = $re_ctgh['soluong'];
		$list_ctgh[$dem]['giaban'] = $re_ctgh['giaban'];
		$list_ctgh[$dem]['thue'] = $re_ctgh['thue'];
		$list_ctgh[$dem]['makm'] = $re_ctgh['makm'];
		$list_ctgh[$dem]['chietkhau'] = $re_ctgh['chietkhau'];
		$list_ctgh[$dem]['tiengiamgia'] = $re_ctgh['tiengiamgia'];
		$list_ctgh[$dem]['quatang'] = $re_ctgh['quatang'];
		$dem++;	
		$arr[] = "'".$re_ctgh['magh']."'";
	}
	//echo "<pre>";print_r($list_ctgh); echo "</pre>";
	
	$string = implode(',', $arr);
	$voucher = mysql_query("select magh, gh.maphieu, giatri from pmh_gh gh, phieumuahang pmh where gh.maphieu = pmh.maphieu and gh.magh ='$id'");
	$list_voucher = array();
	$dem = 0;
	while($re_voucher = mysql_fetch_assoc($voucher))
	{
		$list_voucher[$dem]['magh'] = $re_voucher['magh'];
		$list_voucher[$dem]['maphieu'] = $re_voucher['maphieu'];
		$list_voucher[$dem]['giatri'] = $re_voucher['giatri'];
		$dem++;
	}
?>

<script>

	$(document).ready(function(e) {
        
		$('#phivanchuyen, #chietkhau').keyup(function()
		{
			if(isNaN($(this).val()))
				$(this).val(0);
			
			tiensp = $('#tiensp').val();
			giamgia = $('#giamgia').val();
			voucher = $('#voucher').val();
			chietkhau = parseInt($('#chietkhau').val() == "" ? 0 : $('#chietkhau').val()); //alert(chietkhau);
			phivanchuyen = parseInt($('#phivanchuyen').val() == "" ? 0 :  $('#phivanchuyen').val());
			tongcong = parseInt(tiensp - giamgia - voucher);
			tongcong = parseInt(tongcong - tongcong * (chietkhau/100) + phivanchuyen);
			$('#tongcong').val(tongcong);
		});
		
		$('#phivanchuyen, #chietkhau').mouseleave(function()
		{
			if($(this).val()=="")
				$(this).val(0);
		});
		
		
		
    });

</script>

<div id = "bill-info">
    
    	<p style = "color: #3CA937; font-weight: bold; font-size: 25px;">THÔNG TIN GIAO HÀNG</p>
    
		<table cellspacing="20px" style = "text-align: left">
        	<tr>
            	<td style = "font-weight: bold">Ngày đặt</td>
                <td><?php echo date('H:m:s d-m-Y', strtotime($re_gh['ngaydat'])) ?></td>
            </tr>
            
            <tr>
            	<td style = "font-weight: bold">Họ tên: </td>
                <td><?php echo $re_gh['hotennguoinhan'] ?></td>
            </tr>
            
            <tr>
            	<td style = "font-weight: bold">Địa chỉ: </td>
                <td><?php echo $re_gh['diachi'] ?></td>
            </tr>
            
            <tr>
            	<td style = "font-weight: bold">Số điện thoại: </td>
                <td><?php echo $re_gh['sdt'] ?></td>
            </tr>
            
            <tr>
            	<td style = "font-weight: bold">Ngày giao: </td>
                <td><?php echo date('d-m-Y', strtotime($re_gh['ngaygiao'])) ?></td>
            </tr>

        </table>
    
</div>

<form method="post">
<div id = "list-pro">
    
    	<p style = "color: #3CA937; font-weight: bold; font-size: 25px;">CHI TIẾT ĐƠN HÀNG</p>
        
        
    
    	<table class = "list-bill" border="1">
        	
            <tr>
            	<th width="20%">Mã SP</th>
                <th width="40%">Thông tin sản phẩm</th>
                <th width="10%">Số lượng</th>
                <th width="15%">Giá bán</th>
                <th width="15%">Thành tiền</th>
            </tr>
            
         <?php
		 	$tongtien = $tamtinh = $tienvoucher = $thue= 0;
		 	for($i=0; $i<count($list_ctgh); $i++)
			{
				$thanhtien = $giaban = 0;
		 ?>
            
            <tr>
            
            	<td style = "color: #3CA937; font-weight: bold; text-align: left; padding-left: 10px;"><?php echo $list_ctgh[$i]['mactsp'] ?></td>
            	<td>
                
                	<div id = "bill-pro">
                    
                    	<div id = "bill-pro-img">
                        
                        	<img src = "../image/mypham/<?php echo $list_ctgh[$i]['duongdan'] ?>"/>
                        
                        </div>
                        
                        <div id = "bill-pro-info">
                            <a href='product-detail.php?id=<?php echo $list_ctgh[$i]['mactsp'] ?>'>
                                <p ><?php echo $list_ctgh[$i]['quatang'] == 0 ? $list_ctgh[$i]['tensp'] : $list_ctgh[$i]['tensp']." (Quà tặng)" ?></p>
                               	<?php  echo $list_ctgh[$i]['mausac'] != "" ? "<p>Màu sắc: ".$list_ctgh[$i]['mausac']."</p>" :  "" ?>
                            </a>
                        </div>
                    	<div class = "clear"></div>
                    </div>
                    
                
                    
                </td>
                <td><?php echo $list_ctgh[$i]['soluong'] ?></td>
                <td >
				<?php
				
					if($list_ctgh[$i]['quatang'] == 0)
					{
						if($list_ctgh[$i]['makm'] != "")
						{
							
							if($list_ctgh[$i]['chietkhau'] != 0)
							{
								$giamgia = $list_ctgh[$i]['chietkhau'];
								$giaban = $list_ctgh[$i]['giaban'] - ($list_ctgh[$i]['giaban'] * ($giamgia/100)) ;
								$thanhtien += $giaban * $list_ctgh[$i]['soluong'];
							}
							else if($list_ctgh[$i]['tiengiamgia'] != 0)
							{
								$giamgia = $list_ctgh[$i]['tiengiamgia'];
								$giaban = $list_ctgh[$i]['giaban'] - $giamgia;
								$thanhtien += $giaban* $list_ctgh[$i]['soluong'];
							}
							else
							{
								$giaban = $list_ctgh[$i]['giaban'];
								$thanhtien += $giaban* $list_ctgh[$i]['soluong'];
							}
						}
						else
						{
							$giaban = $list_ctgh[$i]['giaban'];
							$thanhtien += $giaban* $list_ctgh[$i]['soluong'];
						}
						$thue += (($giaban/((100+$list_ctgh[$i]['thue'])/$list_ctgh[$i]['thue'])) * $list_ctgh[$i]['soluong']);
						$tamtinh += $thanhtien;
					}
					echo number_format($giaban);
				?> 
                 
                 đ</td>
                <td style="text-align: right"><?php echo number_format($thanhtien); ?> đ</td>
            </tr>
            
       <?php
			}
		?>
     
            <tr>
            	<td colspan="4" style = "text-align: right; font-weight: bold;">Tiền sản phẩm:</td>
                <td style="text-align: right"><input id='tiensp'  style='text-align:right' name='tiensp' type='text' readonly="readonly" class='txt-sp' value="<?php echo $tamtinh ?>" /></td></td>
            </tr>
            
            <tr>
            	<td colspan="4" style = "text-align: right; font-weight: bold;">Giảm giá:</td>
                <td style="text-align: right">
                
            <?php
				$makm = "000";
				while($re_km = mysql_fetch_assoc($km_hd))
				{
					if($re_km['chietkhau'] != "0")
					{
						//echo "ck";
						if($re_km['giatridonhang'] != 0)
						{
							if($tamtinh >= $re_km['giatridonhang'])
							{
								$giamgia = 	$tamtinh * ($re_km['chietkhau']/100); $makm = $re_km['makm'];
							}
							else
							{
								$giamgia =  0;
							}
						}
						else
						{
							$giamgia = $tamtinh * ($re_km['chietkhau']/100); $makm = $re_km['makm'];
						}
						break;
					}
					else if($re_km['tiengiamgia'] != "0")
					{
						//echo "tien";
						if($re_km['giatridonhang'] != 0)
						{
							if($tamtinh >= $re_km['giatridonhang'])
							{
								$giamgia = $re_km['tiengiamgia'];
								$makm = $re_km['makm'];
							}
							else
								$giamgia = 0;
						}
							
						else
						{
							$giamgia = $re_km['tiengiamgia']; $makm = $re_km['makm'];
						}
						break;
					}
					else if($re_km['tiengiamgia'] == "0" && $re_km['chietkhau'] == "0")
					{
						$giamgia = 0;	
						$makm = $re_km['makm'];
					}
					//if($makm != '000')
						//break;
				}
									
				//echo "số km: ".mysql_num_rows($km_hd);
				/*
				while($re_km = mysql_fetch_assoc($km_hd))
				{
				
					if($re_km['chietkhau'] != "0")
					{
						if($re_km['giatridonhang'] != 0)
							$giamgia = $tamtinh >= $re_km['giatridonhang'] ? ($tamtinh * ($re_km['chietkhau']/100)) : 0;
						else
							$giamgia = $tamtinh * ($re_km['chietkhau']/100);
					}
					else if($re_km['tiengiamgia'] != "0")
					{
						if($re_km['giatridonhang'] != 0)
							$giamgia = $tamtinh >= $re_km['giatridonhang'] ? $re_km['tiengiamgia'] : 0;
						else
							$giamgia = $re_km['tiengiamgia'];
					}
					else
					{
						$giamgia = 0;	
					}
				}
				*/
				for($j = 0; $j<count($list_voucher); $j++)
				{
					if($re_gh['magh'] == $list_voucher[$j]['magh'])
					{
						$tienvoucher += $list_voucher[$j]['giatri'];	
					}
				}
				//echo number_format($giamgia);
			?>
                
                <input id='giamgia'  style='text-align:right' name='giamgia' type='text' readonly="readonly" class='txt-sp' value="<?php echo (int)$giamgia ?>" /></td>
            </tr>
            
            <tr>
            	<td colspan="4" style = "text-align: right; font-weight: bold;">Voucher áp dụng:</td>
                <td style="text-align: right"><input id='voucher'  style='text-align:right' name='voucher' type='text' readonly="readonly" class='txt-sp' value="<?php echo $tienvoucher ?>" /></td>
            </tr>
            
            <tr>
            	<td colspan="4" style = "text-align: right; font-weight: bold">Thuế VAT: </td>
                <td><input id='thue'  style='text-align:right' name='thue' type='text' readonly="readonly" class='txt-sp' value="<?php echo (int)$thue ?>" /></td>
            </tr>
            
            <tr>
            	<td colspan="4" style = "text-align: right; font-weight: bold">Chiết khấu: </td>
                <td><input id='chietkhau'  style='text-align:right' name='chietkhau' type='text' class='txt-sp' value="<?php echo $chietkhau ?>" /></td>
            </tr>
            
            <tr>
            	<td colspan="4" style = "text-align: right; font-weight: bold">Phí vận chuyển: </td>
                <td><input id='phivanchuyen' style='text-align:right' name='phivanchuyen' type='text' class='txt-sp' value="<?php echo number_format($phivanchuyen) ?>" /></td>
            </tr>
            
            <tr>
            	<td colspan="4" style = "text-align: right; font-weight: bold;">Tổng cộng: </td>
                <!--<td style = "font-size: 22px; color: #090; font-weight: bold; text-align: right"><?php echo number_format($tamtinh - $giamgia - $tienvoucher) ?> đ</td>-->
                <td >
                	<input style = "font-size: 22px; font-weight: bold; text-align: right" id='tongcong'  style='text-align:right' name='tongcong' type='text' readonly="readonly" class='txt-sp' value="<?php echo $tamtinh - $giamgia - $tienvoucher ?>" />
                </td>
            </tr>
            
            <tr>
            	<td colspan="5" style = "text-align: right;">
                	<?php
						if(!isset($_GET['huy']))
							echo "<input style='float: right' type='submit' name='xuat' value='Xuất hóa đơn' class='sub'/>";
						else
							echo "<input style='float: right' type='submit' name='huy' value='Hủy hóa đơn' class='sub'/>";
					?>
                	
                </td>
            </tr>
            
            <input type='hidden' name='id' value = '<?php echo $id ?>'/>
           	<input type='hidden' name='makm' value = '<?php echo $makm ?>'/>
        </table>
</div>
</form>
<div class="clear"></div>




<?php
	ob_flush();
?>