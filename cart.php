<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
	<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
    	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <script src="js/jquery-1.12.4.js"></script>
        <link type="text/css" rel='stylesheet' href="style.css"/>
    	<title>Giỏ hàng</title>
        
        <script>
			
			$(document).ready(function(e) {
                
				$('.btn-plus').click(function()
				{
					ctsp = $(this).attr('data-id');  //alert(ctsp);
					soluong = parseInt($('.txt-soluong-'+ctsp).val());
					soluong = soluong + 1; //alert(soluong);
					
					$.ajax
					({
						url: "js/xuly/cart_xuly.php",
						type: "post",
						data: "ctsp=" + ctsp + "&soluongmoi=" + soluong,
						async: true,
						success:function(kq)
						{
							//location:reload();
							//alert(kq);
							window.location="cart.php";
						}
					});
					//return false;	
				});
				$('.btn-sub').click(function()
				{
					ctsp = $(this).attr('data-id');  //alert(ctsp);
					soluong = parseInt($('.txt-soluong-'+ctsp).val());
					soluong = (soluong - 1) == 0 ? 1 : (soluong-1); //alert(soluong);
					
					$.ajax
					({
						url: "js/xuly/cart_xuly.php",
						type: "post",
						data: "ctsp=" + ctsp + "&soluongmoi=" + soluong,
						async: true,
						success:function(kq)
						{
							//location:reload();
							//alert(kq);
							window.location="cart.php";
						}
					});
					//return false;	
				});
            });
			
		</script>

<?php
	session_start();
	ob_start();
	$url = "cart.php";
	include_once('module/header.php');
	include_once('config/config.php');
	
	//echo "số lượng: ".$_POST['soluong'];
	//echo "<br/>id: ".$_POST['id'];
	
	if(!isset($_SESSION['cart']))
		$_SESSION['cart'] = NULL;
	
	if(isset($_POST['ctsp']))
	{
		//echo "có";
		$ctsp = $_POST['ctsp'];
		if(!isset($_SESSION['cart'][$ctsp]))
		{
			$_SESSION['cart'][$ctsp]['soluong'] = $_POST['soluong'];
			$_SESSION['cart'][$ctsp]['hinhanh'] = $_POST['hinhanh'];
			$_SESSION['cart'][$ctsp]['makm'] = $_POST['makm'];
			$_SESSION['cart'][$ctsp]['giaban'] = $_POST['giaban'];
			$_SESSION['cart'][$ctsp]['id'] = $_POST['id'];
			$_SESSION['cart'][$ctsp]['tensp'] = $_POST['tensp'];
			mysql_query("set names 'utf8'");
			$mausac = mysql_query("select mausac, giaban, giadexuat from chitietsanpham where mactsp = '$ctsp' and soluong > 0");
			$re_mausac = mysql_fetch_assoc($mausac);
			$_SESSION['cart'][$ctsp]['mausac'] = $re_mausac['mausac'];
		}
		else
		{
			$_SESSION['cart'][$ctsp]['soluong'] = $_POST['soluong'];
		}
	}
	//unset($_SESSION['cart']);
	//echo "<pre>"; print_r($_SESSION['cart']); echo "</pre>";
	
	if(isset($_GET['check']))
	{
		if($_GET['check'] == 'huy')	
		{
			$id_huy = $_GET['ctsp'];
			if(isset($_SESSION['cart'][$id_huy]))
				unset($_SESSION['cart'][$id_huy]);
			if(count($_SESSION['cart'])==0)
				unset($_SESSION['cart']);
		}
		else
		{
			if(isset($_SESSION['cart']))
				unset($_SESSION['cart']);	
		}
	}
	
?>

<?php
	if(!isset($_SESSION['cart']))
	{
		echo "<p style='margin-left: 18%; font-size: 25px; font-weight: bold; '>CHƯA CÓ SẢN PHẨM NÀO TRONG GIỎ HÀNG! TIẾP TỤC <a href='home.php' style='font-size: 25px; font-weight: bold; color: blue'>MUA SẮM</a></p>";
	}
	else
	{
?>

<div id = "cart-left">

	<div id="cart">
    	<p class="title">GIỎ HÀNG</p><br />
        
    	<div class="cart-pro">

        	<ul>

                <li>
                <div class="checkout-title">
                	<div class='cart-item'>Sản phẩm</div>
                    <div class='cart-price'>Giá mua</div>
                    <div class='cart-soluong'>Số lượng</div>
                    <div class='cart-thanhtien'>Thành tiền</div>
        </div><br/><br />
                </li>
                <?php
				$tongtien = 0;
					foreach($_SESSION['cart'] as $key => $value)
					{
						$thanhtien = 0; 
				?>
               	
            	<li>
                	
                    
                	<div class='cart-item'>
                    	<img src="image/mypham/<?php echo $_SESSION['cart'][$key]['hinhanh'] ?>"/>
                        <a href='product-detail.php?id=<?php echo $_SESSION['cart'][$key]['id'] ?>'><p><?php echo $_SESSION['cart'][$key]['tensp'] ?></p></a>
                        <?php
							if($_SESSION['cart'][$key]['mausac'] != "")
                        		echo "<p>Màu sắc: ".$_SESSION['cart'][$key]['mausac']."</p>";
						?>
                        <a href="cart.php?check=huy&ctsp=<?php echo $key ?>" style="color: #F90">Xóa</a>
                    </div>
                    
                    <div class='cart-price'>
                    	<p class="cart-price-final"><?php echo number_format($_SESSION['cart'][$key]['giaban']) ?>đ</p>
                        <!--<p><strike>215.000 đ</strike></p> -->         
                    </div>
                    
                    <div class='cart-soluong'>
                    	<input type='submit' class='btn-sub' data-id='<?php echo $key ?>' value='-' />
                    	<input type="text" class="txt-soluong txt-soluong-<?php echo $key ?> " value="<?php echo $_SESSION['cart'][$key]['soluong'] ?>"/>
                        <input type='submit' class='btn-plus' data-id='<?php echo $key ?>' value='+' />
                    </div>
                    
                    <div class='cart-thanhtien'>
                    	<p>
						<?php
                        	$thanhtien = $_SESSION['cart'][$key]['soluong'] * $_SESSION['cart'][$key]['giaban'];
							$tongtien += $thanhtien;
							echo number_format($thanhtien);
						?> đ
                        </p>
                    </div>
                	
                    <div class="clear"></div>
                </li>
                <?php
					}
				?>
                <!--
                <li>
                
                	<div class='cart-item'>
                    	<img src="image/mypham/00328475-1_1_2.jpg"/>
                        <a href='#'><p>Xịt khoáng nhiều khoáng chất abc 350ml</p></a>
                        <a href="#" style="color: #F90">Xóa</a>
                    </div>
                    
                    <div class='cart-price'>
                    	<p class="cart-price-final">185.000 đ</p>
                        <p><strike>215.000 đ</strike></p>           
                    </div>
                    
                    <div class='cart-soluong'>
                    	<input type="text" class="txt-soluong" value="1"/>
                    </div>
                    
                    <div class='cart-thanhtien'>
                    	<p>185.000 đ</p>
                    </div>
                	
                    <div class="clear"></div>
                </li>
                -->
            </ul>
			<a href='cart.php?check=huyall' style="color: #F60">Hủy giỏ hàng</a>
            
        </div>
    </div>
    
    <!-- quà tặng-->
    <div id="quatang">
    	<p class="title">QUÀ TẶNG KÈM</p><br />
        
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

</div>



<div id = "cart-right">
	<table width="100%" style="padding: 20px; margin: auto; border: solid 1px #ccc; border-radius: 3px">
 
    	<tr>
        	<td width="40%" style="text-align: left;">Tạm tính:</td>
            <td width="60%" style="text-align: right; color: #F06; font-weight: bold; font-size: 20px"><?php echo number_format($tongtien) ?> đ</td>
        </tr>
        
        <tr>
        	<td colspan="2" style="font-size: 13px; font-style: italic">(Phí trên chưa bao gồm thuế VAT và phí vận chuyển)</td>
        </tr>
    </table>
    
    <form action="checkout.php">
    	<br /><input type="submit" value="Tiến hành đặt hàng" class="btn-cart"/></br></br>
    </form>
    
    <form>
    	<p style="font-size: 12px;">Bạn có mã giảm giá? <a href="#" class='a-code' style="color: #06C; font-weight: bold;font-size: 12px;">Vui lòng click vào đây để nhập...</a></p>
        <div class='code'>
    		<input type='text' name='magiamgia' value="" style="width: 159px; height: 30px; padding: 3px; border: solid 1px #ccc; border-radius: 3px; "/>
            <input type='submit' name='code-submit' id = 'code-submit' value="Đồng ý"/>
        </div>
    </form>
</div>
<?php
	}
?>


<?php
	ob_flush();
	include_once('module/bottom.php');
?>