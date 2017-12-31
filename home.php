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
	
	date_default_timezone_set('Asia/Ho_Chi_Minh');
	$date = date('Y-m-d');
	
	mysql_query("set names 'utf8'");
	/*$hangmoi = mysql_query("select	sp.masp, ctsp.mactsp, tensp, duongdan, ctsp.giaban, thuonghieu, ctsp.mausac
							from	sanpham sp, chitietsanpham ctsp, hinhanh ha
							where 	ctsp.trangthai = 1 and sp.trangthai = 1  and sp.masp = ctsp.masp and sp.masp = ha.masp
							group by ctsp.mactsp
							order by ngaynhap desc limit 0,10");
	*/
	$hangmoi = mysql_query("SELECT t1.masp, t1.mactsp, t1.tensp, t1.duongdan, t1.giaban, t1.thuonghieu, t1.mausac, t2.makm, t2.chietkhau, t2.tiengiamgia
							FROM
							(	select	sp.masp, ctsp.mactsp, tensp, duongdan, ctsp.giaban, thuonghieu, ctsp.mausac
								from	sanpham sp, chitietsanpham ctsp, hinhanh ha
								where 	ctsp.trangthai = 1 and sp.trangthai = 1  and sp.masp = ctsp.masp and sp.masp = ha.masp
								group by ctsp.mactsp
								order by ngaynhap desc limit 0,10
							)t1 left join
							(
								SELECT	km.makm, km.chietkhau, km.tiengiamgia, km.masp
								FROM	khuyenmai km, ctsp_km ctkm
								where	km.makm = ctkm.MaKM and ('$date' >= ctkm.NgayBD and '$date' <= ctkm.NgayKT) and km.masp <> ''
								group by km.makm
							)t2 on t1.masp = t2.masp");
	
	mysql_query("set names 'utf8'");	
	/*$khuyenmai = mysql_query("	select	sp.masp, ctsp.mactsp, tensp, duongdan, ctsp.giaban, thuonghieu, ctsp.mausac
							from	sanpham sp, chitietsanpham ctsp, khuyenmai km, hinhanh ha
							where 	ctsp.trangthai = 1 and sp.trangthai = 1  and sp.masp = ctsp.masp and sp.masp = km.masp and sp.masp = ha.masp
							group by ctsp.mactsp
							order by ngaynhap desc limit 0,10");*/
	$khuyenmai = mysql_query("SELECT t1.masp, t1.mactsp, t1.tensp, t1.duongdan, t1.giaban, t1.thuonghieu, t1.mausac, t2.makm, t2.chietkhau, t2.tiengiamgia
							FROM
							(	select	sp.masp, ctsp.mactsp, tensp, duongdan, ctsp.giaban, thuonghieu, ctsp.mausac
								from	sanpham sp, chitietsanpham ctsp, hinhanh ha
								where 	ctsp.trangthai = 1 and sp.trangthai = 1  and sp.masp = ctsp.masp and sp.masp = ha.masp
								group by ctsp.mactsp
								limit 0,10
							)t1,
							(
								SELECT	km.makm, km.chietkhau, km.tiengiamgia, km.masp
								FROM	khuyenmai km, ctsp_km ctkm
								where	km.makm = ctkm.MaKM and ('$date' >= ctkm.NgayBD and '$date' <= ctkm.NgayKT) and km.masp <> ''
								group by km.makm
							)t2 where t1.masp = t2.masp");
	
	mysql_query("set names 'utf8'");
	/*$makeup = mysql_query("	select	sp.masp, ctsp.mactsp, tensp, duongdan, ctsp.giaban, thuonghieu, ctsp.mausac
							from	sanpham sp, chitietsanpham ctsp, hinhanh ha
							where 	ctsp.trangthai = 1 and sp.trangthai = 1 and sp.masp = ha.masp and sp.masp = ctsp.masp and sp.madm in ('SThoi', 'MASCARA', 'KMAY', 'KMAT', 'SKem')
							group by ctsp.mactsp
							limit 0,10");
	)*/
	$makeup = mysql_query("SELECT t1.masp, t1.mactsp, t1.tensp, t1.duongdan, t1.giaban, t1.thuonghieu, t1.mausac, t2.makm, t2.chietkhau, t2.tiengiamgia
							FROM
							(	select	sp.masp, ctsp.mactsp, tensp, duongdan, ctsp.giaban, thuonghieu, ctsp.mausac
								from	sanpham sp, chitietsanpham ctsp, hinhanh ha
								where 	ctsp.trangthai = 1 and sp.trangthai = 1  and sp.masp = ctsp.masp and sp.masp = ha.masp and sp.madm in ('SThoi', 'MASCARA', 'KMAY', 'KMAT', 'SKem')
								group by ctsp.mactsp 
								limit 0,10
							)t1 left join
							(
								SELECT	km.makm, km.chietkhau, km.tiengiamgia, km.masp
								FROM	khuyenmai km, ctsp_km ctkm
								where	km.makm = ctkm.MaKM and ('$date' >= ctkm.NgayBD and '$date' <= ctkm.NgayKT) and km.masp <> ''
								group by km.makm
							)t2 on t1.masp = t2.masp");
							
	mysql_query("set names 'utf8'");
	/*
	$chamsocda = mysql_query("	select	sp.masp, ctsp.mactsp, tensp, duongdan, ctsp.giaban, thuonghieu, ctsp.mausac
							from	sanpham sp, chitietsanpham ctsp, hinhanh ha
							where 	ctsp.trangthai = 1 and sp.masp = ha.masp and sp.trangthai = 1  and sp.masp = ctsp.masp and sp.madm in ('MatNa', 'NHH', 'KCN', 'KemDD')
							group by ctsp.mactsp
							order by ngaynhap desc limit 0,10");
	*/
	$chamsocda = mysql_query("SELECT t1.masp, t1.mactsp, t1.tensp, t1.duongdan, t1.giaban, t1.thuonghieu, t1.mausac, t2.makm, t2.chietkhau, t2.tiengiamgia
							FROM
							(	select	sp.masp, ctsp.mactsp, tensp, duongdan, ctsp.giaban, thuonghieu, ctsp.mausac
								from	sanpham sp, chitietsanpham ctsp, hinhanh ha
								where 	ctsp.trangthai = 1 and sp.trangthai = 1  and sp.masp = ctsp.masp and sp.masp = ha.masp and sp.madm in ('MatNa', 'NHH', 'KCN', 'KemDD')
								group by ctsp.mactsp 
								limit 0,10
							)t1 left join
							(
								SELECT	km.makm, km.chietkhau, km.tiengiamgia, km.masp
								FROM	khuyenmai km, ctsp_km ctkm
								where	km.makm = ctkm.MaKM and ('$date' >= ctkm.NgayBD and '$date' <= ctkm.NgayKT) and km.masp <> ''
								group by km.makm
							)t2 on t1.masp = t2.masp");
?>


            
            	<!--Khuyến mãi-->
            	<div class = 'list-item'>
                	
                    <div class = 'list-item-title'>
                    	<div>HÀNG MỚI VỀ</div>
                        <a href='#'>Xem thêm</a>
                    </div>
                    
                    <div class = 'list-item-product' data-id = 'km'>
                    
                    	<button class = 'arrow-left' data-id = 'km'></button>
                    	<ul>
                    	
                        	<li>
                            <?php
                            	$i = 0;

								while($record = mysql_fetch_assoc($hangmoi))
								{
									$i++;
							?>
                            
                                <a href = 'product-detail.php?id=<?php echo $record['mactsp'] ?>'>
                                        <div class = 'product-home'>
                                            <img src="image/mypham/<?php echo $record['duongdan'] ?>"/>
                                            <p>
                                            <?php
												$giamgia = $giaban = 0; $check_qt = 0;
												if($record['makm'] == "")
												{
													$giaban = $record['giaban'];
												}
												else
												{
													if($record['chietkhau'] != 0)
													{
														$giamgia = $record['chietkhau'];
														$giaban = $record['giaban'] - ($record['giaban']*($giamgia/100));	
													}
													else if($record['tiengiamgia'] != 0)
													{
														$giamgia = $record['tiengiamgia'];
														$giaban = $record['giaban'] - $record['tiengiamgia'];	
													}
													else if($record['chietkhau'] == 0 && $record['tiengiamgia'] == 0)
													{
														$check_qt = 1;
														$giaban = $record['giaban'];	
													}
												}
											?>
                                            	<span class = 'product-price-home'><?php echo number_format($giaban) ?> đ</span>
                                            	<strike><?php echo $giamgia == 0 ?  "" :  number_format($record['giaban'])."đ" ?></strike>
                                            </p>
                                            <p class = 'text-highlight'><?php echo $record['thuonghieu'] ?></p>
                                            <?php
												echo $record['mausac'] != "" ? "<p class='product-mausac'>Màu: ".$record['mausac']."</p>" : "";
											?>
                                            <?php
                                            	if($check_qt == 1)
													echo "<p>Có quà tặng</p>";
											?>
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
    
                                    while($record = mysql_fetch_assoc($hangmoi))
                                    {
                                        $i++;
                                ?>
                                
                                    <a href = 'product-detail.php?id=<?php echo $record['mactsp'] ?>'>
                                        <div class = 'product-home'>
                                            <img src="image/mypham/<?php echo $record['duongdan'] ?>"/>
                                            <p>
                                            <?php
												$giamgia = $giaban = 0; $check_qt = 0;
												if($record['makm'] == "")
												{
													$giaban = $record['giaban'];
												}
												else
												{
													if($record['chietkhau'] != 0)
													{
														$giamgia = $record['chietkhau'];
														$giaban = $record['giaban'] - ($record['giaban']*($giamgia/100));	
													}
													else if($record['tiengiamgia'] != 0)
													{
														$giamgia = $record['tiengiamgia'];
														$giaban = $record['giaban'] - $record['tiengiamgia'];	
													}
													else if($record['chietkhau'] == 0 && $record['tiengiamgia'] == 0)
													{
														$check_qt = 1;
														$giaban = $record['giaban'];	
													}
												
												}
											?>
                                            	<span class = 'product-price-home'><?php echo number_format($giaban) ?> đ</span>
                                            	<strike><?php echo $giamgia == 0 ?  "" :  number_format($record['giaban'])."đ" ?></strike>
                                            </p>
                                            <p class = 'text-highlight'><?php echo $record['thuonghieu'] ?></p>
                                            <?php
												echo $record['mausac'] != "" ? "<p class='product-mausac'>Màu: ".$record['mausac']."</p>" : "";
											?>
                                            <?php
                                            	if($check_qt == 1)
													echo "<p>Có quà tặng</p>";
											?>
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
    								//echo mysql_num_rows($makeup);
                                    while($re_make = mysql_fetch_assoc($makeup))
                                    {
                                        $i++;
								?>
                                <a href = 'product-detail.php?id=<?php echo $re_make['mactsp'] ?>'>
                                        <div class = 'product-home'>
                                            <img src="image/mypham/<?php echo $re_make['duongdan']?>"/>
                                            <?php
												$giamgia = $giaban = 0; $check_qt = 0;
												if($re_make['makm'] == "")
												{
													$giaban = $re_make['giaban'];
												}
												else
												{
													if($re_make['chietkhau'] != 0)
													{
														$giamgia = $re_make['chietkhau'];
														$giaban = $re_make['giaban'] - ($re_make['giaban']*($giamgia/100));	
													}
													else if($re_make['tiengiamgia'] != 0)
													{
														$giamgia = $re_make['tiengiamgia'];
														$giaban = $re_make['giaban'] - $re_make['tiengiamgia'];	
													}
													else if($re_make['chietkhau'] == 0 && $re_make['tiengiamgia'] == 0)
													{
														$check_qt = 1;
														$giaban = $re_make['giaban'];	
													}
												
												}
											?>
                                            	<span class = 'product-price-home'><?php echo number_format($giaban) ?> đ</span>
                                            	<strike><?php echo $giamgia == 0 ?  "" :  number_format($re_make['giaban'])."đ" ?></strike>
                                            </p>
                                            <p class = 'text-highlight'><?php echo $re_make['thuonghieu'] ?></p>
                                            <?php
												echo $re_make['mausac'] != "" ? "<p class='product-mausac'>Màu: ".$re_make['mausac']."</p>" : "";
											?>
                                            <?php
                                            	if($check_qt == 1)
													echo "<p>Có quà tặng</p>";
											?>
                                            <p class = 'product-name-home'><?php echo $re_make['tensp'] ?></p>
                                        </div>
                                    </a>
                                
                                <?php
										if($i==5)
											break;
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
                                <a href = 'product-detail.php?id=<?php echo $re_make['mactsp'] ?>'>
                                        <div class = 'product-home'>
                                            <img src="image/mypham/<?php echo $re_make['duongdan']?>"/>
                                            <?php
												$giamgia = $giaban = 0; $check_qt = 0;
												if($re_make['makm'] == "")
												{
													$giaban = $re_make['giaban'];
												}
												else
												{
													if($re_make['chietkhau'] != 0)
													{
														$giamgia = $re_make['chietkhau'];
														$giaban = $re_make['giaban'] - ($re_make['giaban']*($giamgia/100));	
													}
													else if($re_make['tiengiamgia'] != 0)
													{
														$giamgia = $re_make['tiengiamgia'];
														$giaban = $re_make['giaban'] - $re_make['tiengiamgia'];	
													}
													else if($re_make['chietkhau'] == 0 && $re_make['tiengiamgia'] == 0)
													{
														$check_qt = 1;
														$giaban = $re_make['giaban'];	
													}
												
												}
											?>
                                            	<span class = 'product-price-home'><?php echo number_format($giaban) ?> đ</span>
                                            	<strike><?php echo $giamgia == 0 ?  "" :  number_format($re_make['giaban'])."đ" ?></strike>
                                            </p>
                                            <p class = 'text-highlight'><?php echo $re_make['thuonghieu'] ?></p>
                                            <?php
												echo $re_make['mausac'] != "" ? "<p class='product-mausac'>Màu: ".$re_make['mausac']."</p>" : "";
											?>
                                            <?php
                                            	if($check_qt == 1)
													echo "<p>Có quà tặng</p>";
											?>
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
                            	<?php
									$i = 0;
    
                                    while($re_csd = mysql_fetch_assoc($chamsocda))
                                    {
                                        $i++;
								?>
                                <a href = 'product-detail.php?id=<?php echo $re_csd['mactsp'] ?>'>
                                        <div class = 'product-home'>
                                            <img src="image/mypham/<?php echo $re_csd['duongdan']?>"/>
                                            <?php
												$giamgia = $giaban = 0; $check_qt = 0;
												if($re_csd['makm'] == "")
												{
													$giaban = $re_csd['giaban'];
												}
												else
												{
													if($re_csd['chietkhau'] != 0)
													{
														$giamgia = $re_csd['chietkhau'];
														$giaban = $re_csd['giaban'] - ($re_csd['giaban']*($giamgia/100));	
													}
													else if($re_csd['tiengiamgia'] != 0)
													{
														$giamgia = $re_csd['tiengiamgia'];
														$giaban = $re_csd['giaban'] - $re_csd['tiengiamgia'];	
													}
													else if($re_csd['chietkhau'] == 0 && $re_csd['tiengiamgia'] == 0)
													{
														$check_qt = 1;
														$giaban = $re_csd['giaban'];	
													}
												
												}
											?>
                                            	<span class = 'product-price-home'><?php echo number_format($giaban) ?> đ</span>
                                            	<strike><?php echo $giamgia == 0 ?  "" :  number_format($re_csd['giaban'])."đ" ?></strike>
                                            </p>
                                            <p class = 'text-highlight'><?php echo $re_csd['thuonghieu'] ?></p>
                                            <?php
												echo $re_csd['mausac'] != "" ? "<p class='product-mausac'>Màu: ".$re_csd['mausac']."</p>" : "";
											?>
                                            <?php
                                            	if($check_qt == 1)
													echo "<p>Có quà tặng</p>";
											?>
                                            <p class = 'product-name-home'><?php echo $re_csd['tensp'] ?></p>
                                        </div>
                                    </a>
                                
                                <?php
										if($i==5)
											break;
									}
								?>
                        
                        		<div class="clear"></div>
                                
                            </li>
                            <li>
                            	<?php
									$i = 0;
    
                                    while($re_csd = mysql_fetch_assoc($chamsocda))
                                    {
                                        $i++;
								?>
                                <a href = 'product-detail.php?id=<?php echo $re_csd['mactsp'] ?>'>
                                        <div class = 'product-home'>
                                            <img src="image/mypham/<?php echo $re_csd['duongdan']?>"/>
                                            <?php
												$giamgia = $giaban = 0; $check_qt = 0;
												if($re_csd['makm'] == "")
												{
													$giaban = $re_csd['giaban'];
												}
												else
												{
													if($re_csd['chietkhau'] != 0)
													{
														$giamgia = $re_csd['chietkhau'];
														$giaban = $re_csd['giaban'] - ($re_csd['giaban']*($giamgia/100));	
													}
													else if($re_csd['tiengiamgia'] != 0)
													{
														$giamgia = $re_csd['tiengiamgia'];
														$giaban = $re_csd['giaban'] - $re_csd['tiengiamgia'];	
													}
													else if($re_csd['chietkhau'] == 0 && $re_csd['tiengiamgia'] == 0)
													{
														$check_qt = 1;
														$giaban = $re_csd['giaban'];	
													}
												
												}
											?>
                                            	<span class = 'product-price-home'><?php echo number_format($giaban) ?> đ</span>
                                            	<strike><?php echo $giamgia == 0 ?  "" :  number_format($re_csd['giaban'])."đ" ?></strike>
                                            </p>
                                            <p class = 'text-highlight'><?php echo $re_csd['thuonghieu'] ?></p>
                                            <?php
												echo $re_csd['mausac'] != "" ? "<p class='product-mausac'>Màu: ".$re_csd['mausac']."</p>" : "";
											?>
                                            <?php
                                            	if($check_qt == 1)
													echo "<p >Có quà tặng</p>";
											?>
                                            <p class = 'product-name-home'><?php echo $re_csd['tensp'] ?></p>
                                        </div>
                                    </a>
                                <?php
								
									}
								?>
                        
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