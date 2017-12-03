<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
	<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
    	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <script src="js/jquery-1.12.4.js"></script>
        <link type="text/css" rel='stylesheet' href="style.css"/>
    	<title>Giỏ hàng</title>

<?php
	include_once('module/header.php');
?>

<div id = "cart-left">

	<div id="cart">
    	<p class="title">GIỎ HÀNG</p><br />
    	<div class="cart-pro">
        
        	<ul>
            
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
            
            </ul>
		
        </div>
    </div>
    
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
            <td width="60%" style="text-align: right; color: #F06; font-weight: bold; font-size: 20px">189.000 đ</td>
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
	include_once('module/bottom.php');
?>