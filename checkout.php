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
	}
	else
	{
		mysql_query("set names 'utf8'");
		$kh = mysql_query("select makh, tenkh, diachi, sodienthoai from khachhang where makh = '".$_SESSION['user']."'");
		$re_kh = mysql_fetch_assoc($kh);
		$ten = $re_kh['tenkh']; $diachi = $re_kh['diachi']; $sdt = $re_kh['sodienthoai'] ;
	}
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
				$date = date('Y/m/d H:i:s');	
	
				$id = Tao_MaGH();
				//echo $id;		
				mysql_query("set names 'utf8'");
				$kq = mysql_query("insert into giohang values('$id', '".$_SESSION['user']."', '$date', '$ten', '$sdt', '$diachi', '$ngaygiao', 1)");
				
				foreach($_SESSION['cart'] as $key => $value)
				{
					mysql_query("set names 'utf8'");
					$kq = mysql_query("insert into chitietgiohang values('$id', '$key', ".$_SESSION['cart'][$key]['soluong'].", ".$_SESSION['cart'][$key]['giaban'].", '000')");
					$kq = mysql_query("UPDATE ChiTietSanPham SET SoLuong = SoLuong - ".$_SESSION['cart'][$key]['soluong']." WHERE MaCTSP = '$key'");
					$kq = mysql_query("UPDATE SanPham SET LuotMua = LuotMua + ".$_SESSION['cart'][$key]['soluong']." WHERE MaSP = '".$_SESSION['cart'][$key]['id']."'");
				}
				unset($_SESSION['cart']);
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
				$tongtien = 0;
					foreach($_SESSION['cart'] as $key => $value)
					{
				?>
            	<li>
                	<div class='cart-item'>
                    	<img src="image/mypham/<?php echo $_SESSION['cart'][$key]['hinhanh'] ?>"/>
                        <a href='product-detail.php?id=<?php echo $_SESSION['cart'][$key]['id'] ?>'><p><?php echo $_SESSION['cart'][$key]['tensp'] ?></p></a>
                    	<?php
							if($_SESSION['cart'][$key]['mausac'] != "")
                        		echo "<p>Màu sắc: ".$_SESSION['cart'][$key]['mausac']."</p>";
						?>
                    </div>
                    
                    <div class='cart-price'>
                    <?php
						$giaban = $_SESSION['cart'][$key]['giaban'];
						echo "<p class='cart-price-final'>".number_format($giaban)." đ</p>";
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
    <p class="title" style="text-align: left;">QUÀ TẶNG KÈM</p><br />
        
        <ul>
        	<li>
            	<a href='#'>
				<div class='quatang-item'>
                    	<img src="image/mypham/00328475-1_1_2.jpg"/>
                        <p>Xịt khoáng nhiều khoáng chất abc 350ml</p>
               	</div>
                </a>
            </li>
        </ul>
    
</div>

<div id="ship-right">
	
    <p class="title">GIÁ TRỊ ĐƠN HÀNG</p>
    <table cellspacing="10px">
    	<tr>
        	<td width="40%">Tiền sản phẩm:</td>
            <td width="56%"><?php echo number_format($tongtien) ?> đ</td>
        </tr>
        <!--
        <tr>
        	<td width="40%">Phí vận chuyển:</td>
            <td width="56%">.. đ</td>
        </tr>
        -->
        <tr>
        	<td width="40%">Thuế VAT:</td>
            <td width="56%">... đ</td>
        </tr>
        <tr>
        	<td width="40%">Giảm giá:</td>
            <td width="56%">0 đ</td>
        </tr>
        <tr>
        	<td width="40%" style="text-align: right; font-weight: bold;font-size: 20px;">Tổng cộng:</td>
            <td width="56%" style="text-align: right; font-size: 20px; font-weight: bold; color: #F06;"><?php echo number_format($tongtien) ?> đ</td>
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