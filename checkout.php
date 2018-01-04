<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
	<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
    	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <script src="js/jquery-1.12.4.js"></script>
        <link type="text/css" rel='stylesheet' href="style.css"/>
    	<title>Thanh toán</title>
        
<?php

	function Tao_MaGH()
	{
		$result = mysql_query('Select MaGH from GioHang ');
		
		if(mysql_num_rows($result) == 0)
			return 'GH1';
			
		$dong = mysql_fetch_assoc($result);
		
		$number = substr($dong['MaGH'], 2);
		
		while($dong = mysql_fetch_assoc($result))
		{
			$temp = substr($dong['MaGH'], 2);
			if($number < $temp)
				$number = $temp;
		}
		return 'GH'.++$number;	
	}

?>

<?php
	session_start();
	ob_start();
	$url = "checkout.php";
	include_once('module/header.php');
	require('config/config.php');
	$loi = array();
	$ten = $diachi = $sdt = $ngaygiao = $loi['ten'] = $loi['diachi'] = $loi['sdt'] = NULL;
	$check_dn = 1;
	if(!isset($_SESSION['user']))
	{
		echo "<p class='title' style='margin-left: 23%; color: #f90;'>Vui lòng <a href='login.php?url=$url' style='color: blue; font-size: 20px;'>đăng nhập</a> để có thể nhận nhiều ưu đãi từ Azura Shop!</p><br><br>";
		//$check_dn = 0;
	}
	else
	{
		mysql_query("set names 'utf8'");
		$kh = mysql_query("select makh, tenkh, diachi, sodienthoai from khachhang where makh = '".$_SESSION['user']."'");
		$re_kh = mysql_fetch_assoc($kh);
		$ten = $re_kh['tenkh']; $diachi = $re_kh['diachi']; $sdt = $re_kh['sodienthoai'] ;
	}
	
	
	$arr_qt = array();
	$string_qt = "";
	foreach($_SESSION['cart'] as $key => $value)
	{
		if($_SESSION['cart'][$key]['maqt'] != "")
			$arr_qt[] = "'".$_SESSION['cart'][$key]['maqt']."'";
	}
	$string_qt = count($arr_qt) > 0 ? implode(',', $arr_qt) : "''"; 
	mysql_query("set names 'utf8'");

	$quatang = mysql_query("select ctsp.mactsp, tensp, ctsp.mausac, duongdan from sanpham sp, chitietsanpham ctsp, hinhanh ha where sp.masp = ctsp.masp and sp.masp = ha.masp and ctsp.mactsp in ($string_qt)");
	$list_qt = array();
	while($re_qt = mysql_fetch_assoc($quatang))
	{
		$list_qt[$re_qt['mactsp']]['tensp']=$re_qt['tensp'];
		$list_qt[$re_qt['mactsp']]['mausac']=$re_qt['mausac'];
		$list_qt[$re_qt['mactsp']]['duongdan']=$re_qt['duongdan'];
	}
?>

<?php

	date_default_timezone_set('Asia/Ho_Chi_Minh');
	$date = date('Y-m-d');
			

	foreach($_SESSION['cart'] as $key => $value)
	{
		$arr_id[] = "'$key'";
	}
	$string = implode(',', $arr_id);
	echo "mactsp: ".$string;
	mysql_query("set names 'utf8'");
			//lấy giá cả, khuyến mãi
	$sp_km = mysql_query("select km.makm, km.mota, km.masp, ctsp.mactsp, ctsp.giaban, km.giatrivoucher, km.giatridonhang, km.chietkhau, km.tiengiamgia, ctkm.id, ctkm.ngaybd, ctkm.ngaykt, ctkm.mactsp as 'maqt'
						from 	khuyenmai km, ctsp_km ctkm, sanpham sp, chitietsanpham ctsp
						where 	km.makm = ctkm.MaKM and km.masp = sp.masp and ctsp.MaSP = sp.MaSP
							and ctsp.MaCTSP in ($string) and km.trangthai = 1 
							and ('$date' >= ctkm.ngaybd and '$date' <= ctkm.ngaykt)");
	echo "slkm: ".mysql_num_rows($sp_km);
	$dem = 0;
	$list_km = array();
	if(mysql_num_rows($sp_km) > 0)
	{
		while($re_sp = mysql_fetch_assoc($sp_km))
		{
			$list_km[$dem]['mactsp'] = $re_sp['mactsp'];
			$list_km[$dem]['giaban'] = $re_sp['giaban'];
			$list_km[$dem]['makm'] = $re_sp['makm'];
			$list_km[$dem]['mota'] = $re_sp['mota'];
			$list_km[$dem]['giatrivoucher'] = $re_sp['giatrivoucher'];
			$list_km[$dem]['giatridonhang'] = $re_sp['giatridonhang'];
			$list_km[$dem]['chietkhau'] = $re_sp['chietkhau'];
			$list_km[$dem]['tiengiamgia'] = $re_sp['tiengiamgia'];
			$list_km[$dem]['mactkm'] = $re_sp['id'];
			$list_km[$dem]['ngaybd'] = $re_sp['ngaybd'];
			$list_km[$dem]['ngaykt'] = $re_sp['ngaykt'];
			$list_km[$dem]['maqt'] = $re_sp['maqt'];
			$dem++;	
			
	
		}
	}
	//trường hợp ko có quà tặng
	else
	{
		foreach($_SESSION['cart'] as $key => $value)
			$_SESSION['cart'][$key]['maqt'] = "";
	}
	
	//trường hợp thay đổi nội dung km, xóa bỏ 1 trong các quà tặng
	foreach($_SESSION['cart'] as $key => $value)
	{
		$check_qt = 0;
		foreach($list_km as $key_km => $value_km)
		{
			if($_SESSION['cart'][$key]['maqt'] == $list_km[$key_km]['maqt'])
			{
				$check_qt = 1;
				break;
			}
		}
		if(!$check_qt)
			$_SESSION['cart'][$key]['maqt'] = "";
	}

?>



<?php

	$check = 1;
	if(isset($_POST['ok']))
	{
		if(empty($_POST['ten']))
		{
			$loi['ten'] = 'Vui lòng nhập tên người nhận';	
			$check = 0;
		}
		else
			$ten = $_POST['ten'];
			
		if(empty($_POST['diachi']))
		{
			$loi['diachi'] = 'Vui lòng nhập địa chỉ người nhận';	
			$check = 0;
		}
		else
			$diachi = $_POST['diachi'];
			
		if(empty($_POST['sdt']))
		{
			$loi['sdt'] = 'Vui lòng nhập số điện thoại người nhận';	
			$check = 0;
		}
		else
			$sdt = $_POST['sdt'];
		
		$ngaygiao = $_POST['ngaygiao'];
		
		if(isset($_SESSION['cart']))
		{
			if($check)
			{
				mysql_query("set name 'utf8'");
				date_default_timezone_set('Asia/Ho_Chi_Minh');
				$ngaydat = date('Y/m/d H:i:s');	
	
				$id = Tao_MaGH();
				$user = isset($_SESSION['user']) ? $_SESSION['user'] : ""; 
				//echo $id;		
				mysql_query("set names 'utf8'");
				$kq = mysql_query("insert into giohang values('$id', '$user', '$ngaydat', '$ten', '$sdt', '$diachi', '$ngaygiao', 0)");
				
				foreach($_SESSION['cart'] as $key => $value)
				{
					mysql_query("set names 'utf8'");
					$makm = "000";
					foreach($list_km as $key_km => $value_km)
					{
						if($list_km[$key_km]['mactsp'] == $key)
						{
							$makm = $list_km[$key_km]['makm'];
							//add quà tặng với giá bán = 0
							if($list_km[$key_km]['maqt'] == $_SESSION['cart'][$key]['maqt'] && $list_km[$key_km]['maqt'] != "")
							{
								$kq = mysql_query("UPDATE ChiTietSanPham SET SoLuong = SoLuong - 1 WHERE MaCTSP = '".$list_km[$key_km]['maqt']."'");
								
								$kq = mysql_query("insert into chitietgiohang(magh, mactsp, soluong, makm, quatang) values('$id', '".$list_km[$key_km]['maqt']."', 1, '000', 1)");
								break;
							}
								
						}
					}
					
					$kq = mysql_query("insert into chitietgiohang(magh, mactsp, soluong, makm) values('$id', '$key', ".$_SESSION['cart'][$key]['soluong'].", '$makm')");
					
					$kq = mysql_query("UPDATE ChiTietSanPham SET SoLuong = SoLuong - ".$_SESSION['cart'][$key]['soluong']." WHERE MaCTSP = '$key'");
					
					//$kq = mysql_query("UPDATE SanPham SET LuotMua = LuotMua + ".$_SESSION['cart'][$key]['soluong']." WHERE MaSP = '".$_SESSION['cart'][$key]['masp']."'");
					
				}
				
				//insert pmh
				if(isset($_SESSION['voucher']))
				{
					foreach($_SESSION['voucher'] as $key_vc => $value_vc)
					{
						if($_SESSION['voucher'][$key_vc]['ngaybd'] >= $date && $_SESSION['voucher'][$key_vc]['ngaykt'] <= $date)
						{
							$kq = mysql_query("insert into pmh_gh values('$key_vc', '$id')");
							//có cần set trạng thái cho pmh đó ko nhỉ
							$kq = mysql_query("update phieumuahang set trangthai = 1 where maphieu = '$key_vc'");
						}
					}
				}
				
				unset($_SESSION['cart']);
				unset($_SESSION['voucher']);
						//header('location: index.php');
				echo "<br/><br/><p class='title'>ĐẶT HÀNG THÀNH CÔNG</p>";
				$check_dn = 0;
			}
		}
	}

?>

<?php
if($check_dn == 1)
{

?>
<form method="post">
<div id="ship-left">
	<p class="title">XÁC NHẬN ĐƠN HÀNG</p>
    
    <div class="cart-pro">
        	<ul>
            	<li class="checkout-title">
                	<div class='cart-item'>Sản phẩm</div>
                    <div class='cart-price'>Giá mua</div>
                    <div class='cart-soluong'>Số lượng</div>
                </li>
                <br />
                
                <?php
				$tongtien = 0; $giamgia = $chietkhau = 0;
					foreach($_SESSION['cart'] as $key => $value)
					{
				?>
            	<li>
                	<div class='cart-item'>
                    	<img src="image/mypham/<?php echo $_SESSION['cart'][$key]['hinhanh'] ?>"/>
                        <a href='product-detail.php?id=<?php echo $key ?>'><p><?php echo $_SESSION['cart'][$key]['tensp'] ?></p></a>
                    	<?php
							if($_SESSION['cart'][$key]['mausac'] != "")
                        		echo "<p>Màu sắc: ".$_SESSION['cart'][$key]['mausac']."</p>";
						?>
                        
                        <?php
						
							$arr_qt = array();
							foreach($list_km as $key_qt => $value_qt)
							{
								$giamgia = $chietkhau = 0;
								//nếu mà $key sp trong giỏ hàng có trong $list_km
								if($list_km[$key_qt]['mactsp'] == $key )
								{
									if($list_km[$key_qt]['maqt'] != "")
									{
										$arr_qt[] = "'".$list_km[$key_qt]['maqt']."'";
										
									}
									else if($list_km[$key_qt]['chietkhau'] != 0)
										$chietkhau = $list_km[$key_qt]['chietkhau'];
									else if($list_km[$key_qt]['tiengiamgia'] != 0)
										$giamgia = $list_km[$key_qt]['tiengiamgia'];
											
										//echo "maqt: ".$list_km[$key_qt]['maqt']." - ";
								}
							}
						
							
							if($_SESSION['cart'][$key]['maqt'] != "")
							{
								$maqt = $_SESSION['cart'][$key]['maqt'];
						?>
                        <div class='product-km' style="width: 58%; float: right;">
                        	Quà tặng kèm:
                        	<ul>
                        	
									<li title="<?php echo $list_qt[$maqt]['tensp'].($list_qt[$maqt]['mausac'] != "" ? " - Màu sắc: ".$list_qt[$maqt]['mausac'] : "") ?>">
                                    	<a href="product-detail.php?id=<?php echo $maqt ?>">
                                                <img style='width: 70px; height: 70px;' src='image/mypham/<?php echo $list_qt[$maqt]['duongdan'] ?>'/>
                                        </a>
                                    </li>
                            </ul>
                        </div>
                        <?php
							}
						?>
                    </div>
                    
                    <div class='cart-price'>
                    <?php
						if($giamgia == 0 && $chietkhau == 0)
						{
						$giaban = $_SESSION['cart'][$key]['giaban'];
					?>
							<p class="cart-price-final"><?php echo number_format($_SESSION['cart'][$key]['giaban']) ?> đ</p>
							<!--<p><strike>215.000 đ</strike></p> -->         
					<?php
						}
						else
						{
							if($chietkhau != 0)
							{
								$giaban = $_SESSION['cart'][$key]['giaban'] - ($_SESSION['cart'][$key]['giaban'] * ($chietkhau/100));
								echo "<p><span class = 'cart-price-final'>".number_format($giaban)." đ</span> </p>";	
								echo "<p >Giá gốc: ".number_format($_SESSION['cart'][$key]['giaban'])." đ</p>";
								echo "<p style='font-size: 12px;'>Tiết kiệm: ".number_format($chietkhau)."%</p>";
							}
							else if($giamgia != 0)
							{
								$giaban = $_SESSION['cart'][$key]['giaban'] - $giamgia;
								echo "<p><span class = 'cart-price-final'>".number_format($_SESSION['cart'][$key]['giaban'] - $giamgia)." đ</span></p>";	
								echo "<p>Giá gốc: ".number_format($_SESSION['cart'][$key]['giaban'])." đ</p>";
								echo "<p style='font-size: 13px;'>Tiết kiệm: ".number_format($giamgia)." đ</p>";
							}	
							else
							{
								$giaban = $list_km[$key]['giaban'];
								echo "<p style='font-size: 13px;'><span class = 'cart-price-final'>".number_format($_SESSION['cart'][$key]['giaban'])." đ</span></p>";	
							}
						}
					?>
                    	
                    </div>
                    
                    <div class='cart-soluong'>
                    	<p><?php echo $_SESSION['cart'][$key]['soluong'] ?></p>
                    </div>
  
                    <div class="clear"></div>
                </li>
                <?php
						$tongtien += ($giaban * $_SESSION['cart'][$key]['soluong']);
					}
				?>
                <!--
                <li>
                
                	<div class='cart-item'>
                    	<img src="image/mypham/00328475-1_1_2.jpg"/>
                        <a href='#'><p>Xịt khoáng nhiều khoáng chất abc 350ml</p></a>
                    </div>
                    
                    <div class='cart-price'>
                    	<p class="cart-price-final">185.000 đ</p>
                    </div>
                    
                    <div class='cart-soluong'>
                    	<p>1</p>
                    </div>
                	
                    <div class="clear"></div>
                </li>
            	-->
            </ul>
    </div>
    
    <div class="clear"></div>   
    
    <?php

		$chietkhau_hd = $giamgia_hd = 0;
		
		mysql_query("set names 'utf8'");
		$khuyenmai = mysql_query("select km.makm, km.mota, ctsp.giaban, km.giatrivoucher, km.giatridonhang, km.chietkhau, km.tiengiamgia, ctkm.id, ctkm.ngaybd, ctkm.ngaykt, ctkm.mactsp as 'maqt'
								from 	khuyenmai km, ctsp_km ctkm, chitietsanpham ctsp
								where 	km.makm = ctkm.MaKM  and  ctsp.MaCTSP = ctkm.mactsp and km.trangthai = 1 
									and ('$date' >= ctkm.ngaybd and '$date' <= ctkm.ngaykt)
									and km.masp = ''");
			
		$arr_qt = array();
		while($re_km = mysql_fetch_assoc($khuyenmai))
		{
			if($tongtien >= $re_km['giatridonhang'])
			{
				if($re_km['maqt'] != "")
				{
					$arr_qt[] = "'".$re_km['maqt']."'"; 
				}
				else if($re_km['chietkhau'] != "0")
				{
					$chietkhau_hd = $re_km['chietkhau'];
					$giamgia_hd = 0;
				}
				else if($re_km['tiengiamgia'] != "0")
				{
					$giamgia_hd = $re_km['tiengiamgia'];	
					$chietkhau_hd = 0;
				}
			}
		}
		$string_qt = count($arr_qt) > 0 ? implode(',', $arr_qt) : "''"; 

	?>
     
    <p class="title" style="text-align: left;">
        
        <?php
		//quà tặng kèm cho hóa đơn
			
			mysql_query("set names 'utf8'");
			$quatang = mysql_query("select ctsp.mactsp, tensp, ctsp.mausac, duongdan from sanpham sp, chitietsanpham ctsp, hinhanh ha where sp.masp = ctsp.masp and sp.masp = ha.masp and ctsp.mactsp in ($string_qt) group by sp.masp");
			if(mysql_num_rows($quatang) > 0)
			{
				echo "<p class='title'>QUÀ TẶNG KÈM</p><br />";
        		echo "<ul>";	
			}

			while($re_qt = mysql_fetch_assoc($quatang))
			{
		?>
        	<li>
            	<a href='product-detail.php?id=<?php echo $re_qt['maqt'] ?>'>
				<div class='quatang-item'>
                    	<img src="image/mypham/<?php echo $re_qt['duongdan'] ?>"/>
                        <p><?php echo $re_qt['tensp'] ?></p>
               	</div>
                </a>
            </li>
        <?php
			}
		?>
        </ul>
    <?php
	echo "<pre>"; print_r($_SESSION['cart']); echo "</pre>";
	echo "<pre>"; print_r($list_km); echo "</pre>";	
?>
</div>

<div id="ship-right">

	<?php
	if(!isset($_SESSION['voucher']))
	{
		if($chietkhau_hd != 0)
		{
			$price = $tongtien - ($tongtien * ($chietkhau_hd/100));	
		}
		else
		{
			$price = $tongtien - $giamgia_hd;	
		}
	}
	else
	{
		$chietkhau_hd = $giamgia_hd = 0;
		foreach($_SESSION['voucher'] as $key => $value)
		{
			if($_SESSION['voucher'][$key]['ngaybd'] >= $date && $_SESSION['voucher'][$key]['ngaykt'] <= $date)
				$giamgia_hd +=$_SESSION['voucher'][$key]['giatri'];
			else
			{
				unset($_SESSION['voucher'][$key]);
				if(count($_SESSION['voucher']) == 0)
					unset($_SESSION['voucher']);	
			}
		}
		
		$price = $tongtien - $giamgia_hd;
	}
	?>
	<input type='hidden' id='price' value="<?php echo $price ?>"/> 
    <input type='hidden' id='tiensp' value="<?php echo $tongtien ?>"/> 
    <p class="title">GIÁ TRỊ ĐƠN HÀNG</p>
    <table cellspacing="10px">
    	<tr>
        	<td width="50%" style="text-align: left;">Tiền sản phẩm:</td>
            <td width="50%" style="text-align: right;  font-weight: bold; font-size: 15px"><?php echo number_format($tongtien) ?> đ</td>
        </tr>
        <!--
        <tr>
        	<td width="40%">Phí vận chuyển:</td>
            <td width="56%">.. đ</td>
        </tr>
        -->
        <!--
        <tr>
        	<td width="40%">Thuế VAT:</td>
            <td width="56%">... đ</td>
        </tr>
        -->
        <tr>
        	<td width="50%" style="text-align: left;">Giảm giá:</td>
            <td width="50%" style="text-align: right;  font-weight: bold; font-size: 15px"><span id='tiengiamgia'><?php echo $chietkhau_hd!=0?$chietkhau_hd:$giamgia_hd ?></span> <?php echo $chietkhau_hd!=0?"%":"đ" ?> </td>
        </tr>
         <tr>
        	<td width="50%" style="text-align: left;">Tạm tính:</td>
            <td width="50%" style="text-align: right; color: #F03; font-weight: bold; font-size: 18px"><span id='tamtinh'><?php echo number_format($price) < 0 ? 0 : number_format($price) ?></span> đ</td>
        </tr>
        <tr>
        	<td colspan="2" style="font-size: 13px; font-style: italic">(Phí trên chưa bao gồm thuế VAT và phí vận chuyển)</td>
        </tr>
    </table>
    
    
    <br /><br />
    <p class="title">THÔNG TIN GIAO HÀNG</p>
    <div id="ship-info">
        
        <p>Họ và tên người nhận</p>
        <input type='text' value="<?php echo $ten ?>" class='txt-info' name='ten'/>
        <?php
        	
			if(!empty($loi['ten']))
				echo "<p class='error'>".$loi['ten']."</p>";
		?>
        <p>Số điện thoại</p>
        <input type='text' value="<?php echo $sdt ?>" class='txt-info' name='sdt'/>
        <?php
        	
			if(!empty($loi['sdt']))
				echo "<p class='error'>".$loi['sdt']."</p>";
		?>
        <p>Địa chỉ giao hàng</p>
        <textarea class="txt-diachi" name='diachi'><?php echo $diachi ?></textarea>
        <?php
        	
			if(!empty($loi['diachi']))
				echo "<p class='error'>".$loi['diachi']."</p>";
		?>
        <p>Chọn ngày giao hàng</p>
        <input type='date' class="txt-info" name='ngaygiao'/>
    </div>
    
    <br /><br />
    <input type='submit' name='ok' class='btn-cart' value='Đặt hàng'/>
    
</div>

<div class="clear"></div>
<?php
}
?>
</form>

<?php
	ob_flush();
	mysql_close($conn);
	include_once('module/bottom.php');
?>