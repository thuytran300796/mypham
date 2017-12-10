<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
	<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
    	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <script src="js/jquery-1.12.4.js"></script>
        <link type="text/css" rel='stylesheet' href="style.css"/>
    	<title>Thanh toán</title>

<?php
	session_start();
	ob_start();
	$url = "checkout.php";
	include_once('module/header.php');
	
	$loi = array();
	$ten = $diachi = $sdt = $loi['ten'] = $loi['diachi'] = $loi['sdt'] = NULL;
?>

<form>

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
        <input type='text' value="" class='txt-info' name='ten'/>
        <p>Số điện thoại</p>
        <input type='text' value="" class='txt-info' name='sdt'/>
        <p>Địa chỉ giao hàng</p>
        <textarea class="txt-diachi" name='diachi'></textarea>
        <p>Chọn ngày giao hàng</p>
        <input type='date' class="txt-info" name='ngaygiao'/>
    </div>
    
    <br /><br />
    <input type='submit' class='btn-cart' value='Đặt hàng'/>
    
</div>

<div class="clear"></div>
</form>

<?php
	ob_flush();
	include_once('module/bottom.php');
?>