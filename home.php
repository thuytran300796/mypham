<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
	<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
    	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <script src="js/jquery-1.12.4.js"></script>
        <link type="text/css" rel='stylesheet' href="style.css"/>
    	<title>Trang chủ</title>

<?php

	session_start();
	
	$url = "home.php";
	
	include_once('module/header.php');
	include_once('config/config.php');
	
	
	
	mysql_query("set names 'utf8'");
	$result = mysql_query("select masp, tensp, giaban, giadexuat, thuonghieu, makm from sanpham where trangthai = 1 order by ngaynhap desc limit 0,10");
	
	mysql_query("set names 'utf8'");
	$makeup = mysql_query("select masp, tensp, giaban, giadexuat from sanpham where madm = 'SThoi' and trangthai = 1 order by ngaynhap desc limit 0,10");
	

	
?>


            
            	<!--Khuyến mãi-->
            	<div class = 'list-item'>
                	
                    <div class = 'list-item-title'>
                    	<div>CÁC SẢN PHẨM ĐANG ÁP DỤNG KHUYẾN MÃI</div>
                        <a href='#'>Xem thêm</a>
                    </div>
                    
                    <div class = 'list-item-product' data-id = 'km'>
                    
                    	<button class = 'arrow-left' data-id = 'km'></button>
                    	<ul>
                    	
                        	<li>
                            <?php
                            	$i = 0;

								while($record = mysql_fetch_assoc($result))
								{
									$ha = mysql_query("select duongdan from hinhanh where masp = '".$record['masp']."' limit 0,1");
									$re_ha = mysql_fetch_assoc($ha);
									$i++;
							?>
                            
                                <a href = 'product-detail.php?id=<?php echo $record['masp'] ?>'>
                                    <div class = 'product-home'>
                                        <img src="image/mypham/<?php echo $re_ha['duongdan'] ?>"/>
                                        <p>
                                        	<span class = 'product-price-home'><?php echo number_format($record['giaban']) ?> đ</span>
                                            <strike><?php if($record['giadexuat'] == $record['giaban'])  echo ""; else echo number_format($record['giaban'])."đ"; ?></strike>
                                        </p>
                                        <p class = 'text-highlight'><?php echo $record['thuonghieu'] ?></p>
                                        <p class = 'product-name-home'><?php echo $record['tensp'] ?></p>
                                        
                                    </div>
                                </a>
                            
                        	<?php
									if($i == 5)
										break;
								}
							?>
                        		<div class="clear"></div>
                                
                            </li>
                            <li>

								<?php
                                    $i = 0;
    
                                    while($record = mysql_fetch_assoc($result))
                                    {
                                        $ha = mysql_query("select duongdan from hinhanh where masp = '".$record['masp']."' limit 0,1");
									$re_ha = mysql_fetch_assoc($ha);
                                        $i++;
                                ?>
                                
                                    <a href = 'product-detail.php?id=<?php echo $record['masp'] ?>'>
                                        <div class = 'product-home'>
                                            <img src="image/mypham/<?php echo $re_ha['duongdan'] ?>"/>
                                            <p>
                                            	<span class = 'product-price-home'><?php echo number_format($record['giaban']) ?> đ</span>
                                            	<strike><?php if($record['giadexuat'] == $record['giaban'])  echo ""; else echo number_format($record['giaban'])."đ"; ?></strike></p>
                                            <p class = 'product-name-home'><?php echo $record['tensp'] ?></p>
                                        </div>
                                    </a>
                                
                                <?php
                                        if($i == 5)
                                            break;
                                    }
                                ?>
                        		<div class="clear"></div>
                                
                            </li>
                            <button class = 'arrow-right'  data-id = 'km'></button>
                            <div class="clear"></div>
                    	</ul>
                    </div>
                </div>
                <!--list-item-->
                
                
                <div class = 'list-item'>
                	
                    <div class = 'list-item-title'>
                    	<div>Trang Điểm</div>
                        <a href='#'>Xem thêm</a>
                    </div>
                    
                    <div class = 'list-item-product' data-id='td'>
                    
                    	<button class = 'arrow-left' data-id='td' ></button>
                    	<ul>
                    	
                        	<li>
                            	<?php
									$i = 0;
    
                                    while($re_make = mysql_fetch_assoc($makeup))
                                    {
                                        $ha = mysql_query("select duongdan from hinhanh where masp = '".$re_make['masp']."' limit 0,1");
										$re_ha = mysql_fetch_assoc($ha);
                                        $i++;
								?>
                                <a href = 'product-detail.php?id=<?php echo $re_make['masp'] ?>'>
                                        <div class = 'product-home'>
                                            <img src="image/mypham/<?php echo $re_ha['duongdan']?>"/>
                                            <p>
                                            	<span class = 'product-price-home'><?php echo number_format($re_make['giaban']) ?> đ</span>
                                            	<strike><?php if($record['giadexuat'] == $record['giaban'])  echo ""; else echo number_format($record['giaban'])."đ"; ?></strike></p>
                                            <p class = 'product-name-home'><?php echo $re_make['tensp'] ?></p>
                                        </div>
                                    </a>
                                
                                <?php
								
									}
								?>
                        
                        		<div class="clear"></div>
                                
                            </li>
                            <li>
                            	<?php
									$i = 0;
    
                                    while($re_make = mysql_fetch_assoc($makeup))
                                    {
                                        $ha = mysql_query("select duongdan from hinhanh where masp = '".$re_make['masp']."' limit 0,1");
										$re_ha = mysql_fetch_assoc($ha);
                                        $i++;
								?>
                                <a href = 'product-detail.php?id=<?php echo $re_make['masp'] ?>'>
                                        <div class = 'product-home'>
                                            <img src="image/mypham/<?php echo $re_ha['duongdan'] ?>"/>
                                            <p>
                                            	<span class = 'product-price-home'><?php echo number_format($re_make['giaban']) ?> đ</span>
                                            	<strike><?php if($record['giadexuat'] == $record['giaban'])  echo ""; else echo number_format($record['giaban'])."đ"; ?></strike></p>
                                            <p class = 'product-name-home'><?php echo $re_make['tensp'] ?></p>
                                        </div>
                                    </a>
                                
                                <?php
								
									}
								?>
                        
                        		<div class="clear"></div>
                                
                            </li>
                            <button class = 'arrow-right'  data-id = 'td'></button>
                            <div class="clear"></div>
                    	</ul>
                    </div>
                    
                </div>
                
                <div class = 'list-item'>
                	
                    <div class = 'list-item-title'>
                    	<div>Chăm sóc da</div>
                        <a href='#'>Xem thêm</a>
                    </div>
                    
                    <div class = 'list-item-product' data-id='csd'>
                    
                    	<button class = 'arrow-left' data-id='csd' ></button>
                    	<ul>
                    	
                        	<li>
                            
                                <a href = '#'>
                                    <div class = 'product-home'>
                                        <img src="image/mypham/za-1--1-.u3059.d20170516.t110909.650151.jpg"/>
                                        <p><span class = 'product-price-home'>2.159.000 đ</span> <strike>205.000 đ</strike></p>
                                        <p class = 'product-name-home'>Kem Chống Nắng Giúp Bảo Vệ Hiệu Quả Và Làm Sáng Da Dành Cho Da Dầu Za True White Ex Perfect Protector SPF50/PA+++ ZA (30ml)</p>
                                    </div>
                                </a>
                                
                                <a href = '#'>
                                    <div class = 'product-home'>
                                        <img src="image/mypham/00328475-1_1_2.jpg"/>
                                        <p><span class = 'product-price-home'>195.000 VND</span> <strike>401.000 VND</strike></p>
                                        <p class = 'product-name-home'>Combo 2 Nước Xịt Khoáng Evoluderm 150ml Và 400ml</p>
                                    </div>
                                </a>
                                <a href = '#'>
                                    <div class = 'product-home'>
                                        <img src="image/mypham/5882fee2f11b9277a38a483dee02fed8.jpg"/>
                                        <p><span class = 'product-price-home'>230.000 VND</span> <strike>315.000 VND</strike></p>
                                        <p class = 'product-name-home'>Bảng Màu Mắt The 24K Nudes Maybelline (3g)</p>
                                    </div>
                                </a>
                                <a href = '#'>
                                    <div class = 'product-home'>
                                        <img src="image/mypham/1338573964764_s_01.d20171013.t193702.969943.jpg"/>
                                        <p><span class = 'product-price-home'>180.000 VND</span> <strike>270.000 VND</strike></p>
                                        <p class = 'product-name-home'>Son Bền Màu Lâu Trôi Và Dưỡng Ẩm Za Vivid Dare Lipstick 3.5g</p>
                                    </div>
                                </a>
                                <a href = '#'>
                                    <div class = 'product-home'>
                                        <img src="image/mypham/maybelline-fresh-matte-light.u2409.d20170329.t100000.761073.jpg"/>
                                        <p><span class = 'product-price-home'>300.000 VND</span> <strike>385.000 VND</strike></p>
                                        <p class = 'product-name-home'>Phấn Nước Cushion Kiềm Dầu Maybelline 14g</p>
                                    </div>
                                </a>
                        
                        		<div class="clear"></div>
                                
                            </li>
                            <li>

                                <a href = '#'>
                                    <div class = 'product-home'>
                                        <img src="image/mypham/00328475-1_1_2.jpg"/>
                                        <p><span class = 'product-price-home'>195.000 VND</span> <strike>401.000 VND</strike></p>
                                        <p class = 'product-name-home'>Combo 2 Nước Xịt Khoáng Evoluderm 150ml Và 400ml</p>
                                    </div>
                                </a>
                                
                                <a href = '#'>
                                    <div class = 'product-home'>
                                        <img src="image/mypham/za-1--1-.u3059.d20170516.t110909.650151.jpg"/>
                                        <p><span class = 'product-price-home'>159.000 VND</span> <strike>205.000 VND</strike></p>
                                        <p class = 'product-name-home'>Kem Chống Nắng Giúp Bảo Vệ Hiệu Quả Và Làm Sáng Da Dành Cho Da Dầu Za True White Ex Perfect Protector SPF50/PA+++ ZA (30ml)</p>
                                    </div>
                                </a>
                                <a href = '#'>
                                    <div class = 'product-home'>
                                        <img src="image/mypham/maybelline-fresh-matte-light.u2409.d20170329.t100000.761073.jpg"/>
                                        <p><span class = 'product-price-home'>300.000 VND</span> <strike>385.000 VND</strike></p>
                                        <p class = 'product-name-home'>Phấn Nước Cushion Kiềm Dầu Maybelline 14g</p>
                                    </div>
                                </a>
                                <a href = '#'>
                                    <div class = 'product-home'>
                                        <img src="image/mypham/1338573964764_s_01.d20171013.t193702.969943.jpg"/>
                                        <p><span class = 'product-price-home'>180.000 VND</span> <strike>270.000 VND</strike></p>
                                        <p class = 'product-name-home'>Son Bền Màu Lâu Trôi Và Dưỡng Ẩm Za Vivid Dare Lipstick 3.5g</p>
                                    </div>
                                </a>
                                <a href = '#'>
                                    <div class = 'product-home'>
                                        <img src="image/mypham/5882fee2f11b9277a38a483dee02fed8.jpg"/>
                                        <p><span class = 'product-price-home'>230.000 VND</span> <strike>315.000 VND</strike></p>
                                        <p class = 'product-name-home'>Bảng Màu Mắt The 24K Nudes Maybelline (3g)</p>
                                    </div>
                                </a>
                                
                        
                        		<div class="clear"></div>
                                
                            </li>
                            <button class = 'arrow-right'  data-id = 'csd'></button>
                            <div class="clear"></div>
                    	</ul>
                    </div>
                    
                </div>
            
<?php
	include_once('module/bottom.php');
	mysql_close($conn);
?>