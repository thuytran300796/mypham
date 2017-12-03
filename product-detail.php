<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
	<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
    	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <script src="js/jquery-1.12.4.js"></script>
        <link type="text/css" rel='stylesheet' href="style.css"/>
    	<title>Chi tiết sản phẩm</title>

<?php
	include_once('module/header.php');
?>

<form>

	<div class = 'wrap-left-protail'>
		
		<div class = 'product-content'>
		
			<div class = 'product-image'>

				<div class = 'img-big'>
					<img src="image/mypham/maybelline-fresh-matte-light.u2409.d20170329.t100000.761073.jpg"/>
				</div>
                <button class = 'arrow-left'  data-id = 'km'></button>
                <div class = 'img-sml'>
					
					<div class = 'img-sml-index'>
						<img src="image/mypham/maybelline-fresh-matte-light.u2409.d20170329.t100000.761073.jpg"/>
					</div>
					
					<div class = 'img-sml-index'>
						<img src="image/mypham/maybelline-fresh-matte-light.u2409.d20170329.t100000.761073.jpg"/>
					</div>
					
					<div class = 'img-sml-index'>
						<img src="image/mypham/maybelline-fresh-matte-light.u2409.d20170329.t100000.761073.jpg"/>
					</div>
					
					<div class = 'img-sml-index'>
						<img src="image/mypham/maybelline-fresh-matte-light.u2409.d20170329.t100000.761073.jpg"/>
					</div>
                    
				</div>
                <button class = 'arrow-right'  data-id = 'km'></button>
                

			</div>
			
			<div class = 'product-normal'>
				<p class="product-name-detail">Bảng Màu Mắt The 24K Nudes Maybelline (3g)</p>
            <p>Thương hiệu:<span class="text-highlight"> Bobbi Grown</span></p>
            <hr />
                <p><span class = 'product-price-detail'>159.000 đ</span> Đã bao gồm thuế VAT</p>
                <p>Giá thị trường: <strike>205.000 đ</strike></p>
                <p>Tiết kiệm: 46.000 VND</p>
                <hr />
                <table cellspacing="10px">
                	<tr>
                    	<td><p>Chọn màu:</p></td>
                        <td><select class='cbb-pro'>
                            <option value='hong'>Hồng</option>
                            <option>Cam</option>
                            <option>Đỏ</option>
                        </select></td>
                    </tr>
          
                    <tr>
                    	<td><p>Số lượng:</p></td>
                        <td><input type='text' value='1' class='txt-soluong' onKeyPress="check_soluong"/></td>
                    </tr>
                    
                    <tr>
                    	<td colspan="2"><input id='btn-add-cart' type='submit' value="Thêm vào giỏ hàng"/></td>
                    </tr>
                </table>
                
     			<hr />
                <p class='title-general'>KHUYẾN MÃI</p>
             	<p>Tặng kèm quà tặng abc</p>
			</div>
			
			<div class ='clear'></div>
		</div>
		
		<div class = 'product-info'>
			aaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa<br/>
			aaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa<br/>
			aaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa<br/>
			aaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa<br/>
			aaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa<br/>
			aaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa<br/>
		</div>
		
        <!-- COMMENT -->
        <div id = 'comment'>
        
        	<p style='font-size: 18px; font-weight: bold; color: #F90;	'>KHÁCH HÀNG NHẬN XÉT</p>
    
            <fieldset>
            
                <legend>Viết nhận xét của bạn vào bên dưới</legend>
            	
                <!--<form>-->
                    <textarea class='com-mess'></textarea>
                <!--</form>-->
            	<input type='submit' class='com-submit' value='Gửi'/>
            </fieldset>
            
            <p style='font-size: 18px; font-weight: bold; color: #F90;	margin-top: 3%;'>CÁC NHẬN XÉT TRƯỚC ĐÓ</p>
          	<ul id='com-list'>
            	
                <li>
                	<div class='com-info'>
                    	<img src="image/khachhang/16700007_736167479867040_1149049724_n.jpg"/>
                        <p>Thủy Trân 30/11/2017 16:59:24</p>
                        <p>Màu son lên đẹp, đều màu và lâu trôi</p>
                        <p><a href="javascript:void(0)" class="rep-a" data-repa='1'>Gửi trả lời</a></p>
                    </div>
                    <div class="clear"></div>
             		<!--các bình luận conn-->
                    <ul>
                    
                    	<li>
                        	<div class='com-info'>
                                <img src="image/khachhang/16700007_736167479867040_1149049724_n.jpg"/>
                                <p>Thủy Trân 30/11/2017 16:59:24</p>
                                <p>Màu son lên đẹp, đều màu và lâu trôi</p>
                            </div>
                            <div class="clear"></div>
                        </li>
                    
                    </ul>
                    
                    <fieldset style="margin-left: 75px; display: none" class="rep-form">
            
                        <legend>Viết nhận xét của bạn vào bên dưới</legend>
                    	<!--<form>-->
                            <textarea class='com-mess'></textarea>
                        <!--</form>-->
                        <input type='submit' class='com-submit' value='Gửi'/>
                    </fieldset>
                    
                </li>
                <li>
                	
                    <div class='com-info'>
                    	<img src="image/khachhang/16700007_736167479867040_1149049724_n.jpg"/>
                        <p>Thủy Trân 30/11/2017 16:59:24</p>
                        <p>son thì mình thấy cũng ok, nhưng chai chống nắng tặng kèm - ôi trời ơi da mình da dầu mà bôi lên da bị khô bông tróc hai bên cánh mũi, mình dùng xịt khoáng innisfree chữa cháy cũng bớt khô đc tí. Các bạn da khô cân nhắc kỹ trước khi dùng.
                        son thì mình thấy cũng ok, nhưng chai chống nắng tặng kèm - ôi trời ơi da mình da dầu mà bôi lên da bị khô bông tróc hai bên cánh mũi, mình dùng xịt khoáng innisfree chữa cháy cũng bớt khô đc tí. Các bạn da khô cân nhắc kỹ trước khi dùng
                        son thì mình thấy cũng ok, nhưng chai chống nắng tặng kèm - ôi trời ơi da mình da dầu mà bôi lên da bị khô bông tróc hai bên cánh mũi, mình dùng xịt khoáng innisfree chữa cháy cũng bớt khô đc tí. Các bạn da khô cân nhắc kỹ trước khi dùng.
                        son thì mình thấy cũng ok, nhưng chai chống nắng tặng kèm - ôi trời ơi da mình da dầu mà bôi lên da bị khô bông tróc hai bên cánh mũi, mình dùng xịt khoáng innisfree chữa cháy cũng bớt khô đc tí. Các bạn da khô cân nhắc kỹ trước khi dùng</p>
                        <p><a href="javascript:void(0)" class="rep-a">Gửi trả lời</a></p>
                    </div>
                    
                    <fieldset style="margin-left: 75px; display: none" class="rep-form">
            
                        <legend>Viết nhận xét của bạn vào bên dưới</legend>
                    	<!--<form>-->
                            <textarea class='com-mess'></textarea>
                        <!--</form>-->
                        <input type='submit' class='com-submit' value='Gửi'/>
                    </fieldset>

                    <div class="clear"></div>  
                </li>
                
            </ul>
        
        </div>
		
		<div class = 'clear'></div>
	</div>
    <!--END div left-->
	

	<div class = 'wrap-right-protail'>
	
    	<div class="list-pro">
        	
            <div class = 'list-item-title'>
            	TOP SẢN PHẨM BÁN CHẠY
            </div>
            
          
           	<div class = 'pro-sml'>
                <img src="image/mypham/1338573964764_s_01.d20171013.t193702.969943.jpg"/>
                <div>
                	<p>Son Vivid Dare Lipstick 3.5g </p>
                    <p>Za</p>
                    <p class="product-price-home">188.000 đ</p>
                    <p><strike>188.000 đ</strike></p>
                </div>
            </div>
            
            <div class = 'pro-sml'>
                <img src="image/mypham/1338573964764_s_01.d20171013.t193702.969943.jpg"/>
                <div>
                	<p>Son Vivid Dare Lipstick 3.5g </p>
                    <p>Za</p>
                    <p class="product-price-home">188.000 đ</p>
                    <p><strike>188.000 đ</strike></p>
                </div>
            </div>
            
            <div class = 'pro-sml'>
                <img src="image/mypham/1338573964764_s_01.d20171013.t193702.969943.jpg"/>
                <div>
                	<p>Son Vivid Dare Lipstick 3.5g </p>
                    <p>Za</p>
                    <p class="product-price-home">188.000 đ</p>
                    <p><strike>188.000 đ</strike></p>
                </div>
            </div>
			
            <div class='pro-xemthem'>
            	<a href='#'>Xem thêm</a>
            </div>
        </div>
        
        <div class="list-pro">
        	
            <div class = 'list-item-title'>
            	TOP SẢN PHẨM BÁN CHẠY
            </div>
            
          
           	<div class = 'pro-sml'>
                <img src="image/mypham/1338573964764_s_01.d20171013.t193702.969943.jpg"/>
                <div>
                	<p>Son Vivid Dare Lipstick 3.5g </p>
                    <p>Za</p>
                    <p class="product-price-home">188.000 đ</p>
                    <p><strike>188.000 đ</strike></p>
                </div>
            </div>
            
            <div class = 'pro-sml'>
                <img src="image/mypham/1338573964764_s_01.d20171013.t193702.969943.jpg"/>
                <div>
                	<p>Son Vivid Dare Lipstick 3.5g </p>
                    <p>Za</p>
                    <p class="product-price-home">188.000 đ</p>
                    <p><strike>188.000 đ</strike></p>
                </div>
            </div>
            
            <div class = 'pro-sml'>
                <img src="image/mypham/1338573964764_s_01.d20171013.t193702.969943.jpg"/>
                <div>
                	<p>Son Vivid Dare Lipstick 3.5g </p>
                    <p>Za</p>
                    <p class="product-price-home">188.000 đ</p>
                    <p><strike>188.000 đ</strike></p>
                </div>
            </div>
            
            <div class='pro-xemthem'>
            	<a href='#'>Xem thêm</a>
            </div>

        </div>
	
	</div>
	
	<div class = 'clear'></div>
</form>    
    
<?php
	include_once('module/bottom.php');
?>