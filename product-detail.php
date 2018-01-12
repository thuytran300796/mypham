

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
	<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
    	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <script src="js/jquery-1.12.4.js"></script>
        <link type="text/css" rel='stylesheet' href="style.css"/>
    	<title>Chi tiết sản phẩm</title>
		<script>

			$(document).ready(function(e) {
				
				$('.choose-qt').click(function()
				{
					$('.product-km li').css('border', 'solid 1px #ccc');
					maqt = $(this).attr('data-maqt');	
					$("a[data-maqt='"+maqt+"']").closest('li').css('border', 'solid 2px #3CC');
				});
				
				$('#them').click(function()
				{
					alert('hello');	
				});
			});
	
		</script>
<?php
	session_start();
	//$_SESSION['user'] = 'thuytran3007';
	//$_SESSION['username'] = 'Trân Phạm';
	//unset($_SESSION['user']);
	ob_start();
	
	if(isset($_REQUEST['id']))
		$id = $_REQUEST['id'];
		
	$url = "product-detail.php?id=$id";
	
	include_once('module/header.php');
	require('config/config.php');
	
	date_default_timezone_set('Asia/Ho_Chi_Minh');
	$date = date('Y-m-d');
	
	$ha = mysql_query("select duongdan from hinhanh ha, sanpham sp, chitietsanpham ctsp where ctsp.masp = sp.masp and sp.masp = ha.masp and ctsp.mactsp = '".$id."'");
	
	$list_ha = array();
	$m = 0;
	while($re_ha = mysql_fetch_assoc($ha))
	{
		$list_ha[$m++] = $re_ha['duongdan'];
	}
	
	mysql_query("set names 'utf8'");
	$sp = mysql_query("select sp.masp, tensp, ctsp.mausac, donvitinh, mota, trongluong, thuonghieu, ctsp.giadexuat, ctsp.giaban, madm, ctsp.soluong from sanpham sp, chitietsanpham ctsp  where sp.masp = ctsp.masp and ctsp.mactsp = '$id'");
	$re_sp = mysql_fetch_assoc($sp);
	
	mysql_query("set names 'utf8'");
	$khuyenmai = mysql_query("select km.makm, km.mota, km.masp, km.giatrivoucher, km.giatridonhang, km.chietkhau, km.tiengiamgia, ctkm.id, ctkm.ngaybd, ctkm.ngaykt, ctkm.mactsp
							from 	khuyenmai km, ctsp_km ctkm, sanpham sp, chitietsanpham ctsp
							where 	km.makm = ctkm.MaKM and km.masp = sp.masp and ctsp.MaSP = sp.MaSP
								and ctsp.MaCTSP = '$id' and km.trangthai = 1 
								and ('$date' >= ctkm.ngaybd and '$date' <= ctkm.ngaykt)");
								
	$list_km = array();
	$dem = 0;
	while($re_km = mysql_fetch_assoc($khuyenmai))
	{
		$list_km[$dem]['makm'] = $re_km['makm'];
		$list_km[$dem]['mota'] = $re_km['mota'];
		$list_km[$dem]['giatrivoucher'] = $re_km['giatrivoucher'];
		$list_km[$dem]['giatridonhang'] = $re_km['giatridonhang'];
		$list_km[$dem]['chietkhau'] = $re_km['chietkhau'];
		$list_km[$dem]['tiengiamgia'] = $re_km['tiengiamgia'];
		$list_km[$dem]['mactkm'] = $re_km['id'];
		$list_km[$dem]['ngaybd'] = $re_km['ngaybd'];
		$list_km[$dem]['ngaykt'] = $re_km['ngaykt'];
		$list_km[$dem]['maqt'] = $re_km['mactsp'];
		$dem++;
	}
	//echo "km: ".count($list_km);
	mysql_query("set names 'utf8'");
	$binhluan = mysql_query("select mabl, bl.makh,tenkh, hinhdaidien, noidung, ngay from binhluan bl, khachhang kh where mactsp = '$id' and bl.makh = kh.makh order by ngay desc" );
	//echo mysql_num_rows($binhluan);
	
	

	
?>


<script>

	$(document).ready(function(e) {
   
		$('.com-submit').click(function()
		{
			var noidung = $('.com-mess').val();
			
			var id = $('.com-submit').attr('data-id');

			var user = '<?php echo $_SESSION['user'] ?>';
			
			$.ajax
			({
				url: "js/xuly/comment_xuly.php",
				type: "post",
				data: "id=" + id + "&user=" + user + "&noidung=" + noidung,
				async: true,
				success:function(kq)
				{
					if($('#com-list li').length == 0)
					{
						$('#com-list').html(kq);
					}
					else
					{
						$('#com-list li:eq(0)').before(kq);	
					}
				}
				
				
			});
			$('.com-mess').val("");

			return false;
		});
		
    });

</script>

<input type='hidden' name='id' value='<?php echo $id ?>'/>

	<div class = 'wrap-left-protail'>
		
		<div class = 'product-content'>
		
			<div class = 'product-image'>

				<div class = 'img-big'>
					<img id = 'img-large' src="image/mypham/<?php echo $list_ha[0]  ?>"/>
				</div>
                <!--<button class = 'arrow-left-img'></button>-->
                <div class = 'img-sml'>
					<?php
						$dem = 1;
						foreach($list_ha as $key => $value)
						{
					?>
					<div class = 'img-sml-index'>
						<img id = 'img-small-<?php echo $dem?>' src="image/mypham/<?php echo $value ?>" onclick="document.getElementById('img-large').src = document.getElementById('img-small-<?php echo $dem ?>').src"/>
					</div>
					<?php
							$dem++;
						}
					?>
				</div>
               	<button class = 'arrow-right-img'  data-id = 'km'></button>
                

			</div>
			
			<div class = 'product-normal'>
				<p class="product-name-detail"><?php echo $re_sp['tensp'] ?></p>
                <?php echo ($re_sp['mausac'] != "" ? "<p>Màu sắc: ".$re_sp['mausac']."</p>" : "" ) ?>
            	<p>Thương hiệu: <span class="text-highlight"> <?php echo $re_sp['thuonghieu'] ?></span></p>
                <p>Trọng lượng/Thể tích: <?php echo $re_sp['trongluong'] ?></p>
                <p>Đơn vị tính: <?php echo $re_sp['donvitinh'] ?></p>
                <!--<p><span class = 'product-price-detail'><?php echo number_format($re_sp['giaban']) ?> đ</span> Đã bao gồm thuế VAT</p>-->
   
   				<?php
					$loaiqt = 0; //giảm giá
					
					//nếu là giảm bằng % hay tiền thì trong bảng ctsp_km chỉ có 1 record
					if(count($list_km) == 1)
					{
						if($list_km[0]['chietkhau'] != "0")
						{
							$giamgia = $list_km[0]['chietkhau']; //5%
							$tiengiamgia = $re_sp['giaban'] * ($giamgia/100); 
							echo "<p><span class = 'product-price-detail'>".number_format($re_sp['giaban'] - $tiengiamgia)." đ</span> Đã bao gồm thuế VAT</p>";	
							echo "<p>Giá gốc: ".number_format($re_sp['giaban'])."đ - Tiết kiệm: ".number_format($giamgia)."% (".number_format($tiengiamgia)." đ)</p>";
						}
						else if($list_km[0]['tiengiamgia'] != "0")
						{
							$giamgia = 	$list_km[0]['tiengiamgia'];
							echo "<p><span class = 'product-price-detail'>".number_format($re_sp['giaban'] - $giamgia)." đ</span> Đã bao gồm thuế VAT</p>";	
							echo "<p>Giá gốc: ".number_format($re_sp['giaban'])."đ - Tiết kiệm: ".number_format($giamgia)." đ</p>";
						}
						else if($list_km[0]['maqt'] != "")
						{
							$loaiqt = 1; echo "<p><span class = 'product-price-detail'>".number_format($re_sp['giaban'])." đ</span> Đã bao gồm thuế VAT</p>";
						}
					}
					// nếu tặng quà thì bảng ctsp_km phải có từ 1 record trở lên và nếu 0 có record nào thì sp đó ko có km
					else if(count($list_km) > 1)
					{
						$loaiqt = 1; //quà tặng
						echo "<p><span class = 'product-price-detail'>".number_format($re_sp['giaban'])." đ</span> Đã bao gồm thuế VAT</p>";
					}
					else if(count($list_km) == 0)
					{
						echo "<p><span class = 'product-price-detail'>".number_format($re_sp['giaban'])." đ</span> Đã bao gồm thuế VAT</p>";	
						$loaiqt = 0;
					}
					//echo "Loại qt: ".$loaiqt;
				?>
                
                
                <table cellspacing="10px">
                    
 			                
                <form action = "cart.php" method="post">
                
                	<input type='hidden' name='id' value='<?php echo $id ?>'/>
          			<input type='hidden' name='mausac' value='<?php echo $re_sp['mausac'] ?>'/>
                
                    <tr>
                    	<td><p>Số lượng:</p></td>
                        <td><input type='text' value='1' name='soluong' id='txt-soluong' onKeyPress="check_soluong"/></td>
                    </tr>
                    
                    <tr>
                    	<?php
							if($re_sp['soluong'] <= 0)
								echo "<p style='font-size: 18px; font-weight: bold'>HẾT HÀNG</p>";
							else
								echo "<td colspan='2'><input id='btn-add-cart' name='them' id='them' type='submit' value='Thêm vào giỏ hàng'/></td>";
						?>
                    	
                    </tr>
                    
                    
                    <input type='hidden' name='masp' value="<?php echo $re_sp['masp'] ?>"/>
                    <input type='hidden' name='tensp' value="<?php echo $re_sp['tensp'] ?>"/>
                    <input type='hidden' name='hinhanh' value="<?php echo $list_ha[0] ?>"/>
                    <!--<input type='hidden' name='makm' value="<?php echo $re_sp['makm'] ?>"/>-->
                    <input type='hidden' name='giaban' value="<?php echo $re_sp['giaban'] ?>"/>

                    
                    
                    <?php
						//nếu khách đã chọn quà tặng
						//if($loaiqt == 1)
						//{
							if(isset($_GET['maqt']))
							{
								$maqt = $_GET['maqt'];
							}
							else
							{
								$maqt = "";
								/*echo "<script>alert('Vui lòng click chọn quà tặng đi kèm');</script>";*/
							}	
						//}
					?>
                    <input type='hidden' name='maqt' id='quatang' value='<?php echo $maqt ?>'/>
                </form>
                </table>
                
     			<hr />
                
                <div class='product-km' >
                	
                     <?php
													
						//$re_km = mysql_fetch_assoc($khuyenmai);
						if($loaiqt == 1)
						{
							
							$arr_maqt = array();
							foreach($list_km as $key => $value)
							{
								$arr_maqt[] = "'".$list_km[$key]['maqt']."'";	
							}
							$string = implode(',', $arr_maqt);
							
							mysql_query("set names 'utf8'");
							$quatang = mysql_query("select ctsp.mactsp, tensp, ctsp.mausac, duongdan from sanpham sp, chitietsanpham ctsp, hinhanh ha where sp.masp = ctsp.masp and sp.masp = ha.masp and ctsp.mactsp in ($string) group by ctsp.mactsp");
							
							echo "<p class='title-general'>KHUYẾN MÃI ĐANG ÁP DỤNG CHO SẢN PHẨM NÀY</p>";
							echo "<p>".$list_km[0]['mota']."</p>";
							echo "<ul>";
							while($re_qt = mysql_fetch_assoc($quatang))
							{
								if($re_qt['mactsp'] == $maqt || $maqt == "")
								{
									$maqt = $re_qt['mactsp'];
					?>			
                    			<li style="border: solid 1px #3cc;" title="<?php echo $re_qt['tensp'].($re_qt['mausac'] != "" ? " - Màu sắc: ".$re_qt['mausac'] : "") ?>">
                                	<a href='product-detail.php?id=<?php echo $id ?>&maqt=<?php echo $re_qt['mactsp'] ?>' class='choose-qt' data-maqt='<?php echo $re_qt['mactsp'] ?>'>
                                		<img src='image/mypham/<?php echo $re_qt['duongdan'] ?>'/>
                                    </a>
                                </li>
                    <?php
								}
								else
								{
					?>
                    			<li  title="<?php echo $re_qt['tensp'].($re_qt['mausac'] != "" ? " - Màu sắc: ".$re_qt['mausac'] : "") ?>">
                                	<a href='product-detail.php?id=<?php echo $id ?>&maqt=<?php echo $re_qt['mactsp'] ?>' class='choose-qt' data-maqt='<?php echo $re_qt['mactsp'] ?>'>
                                		<img src='image/mypham/<?php echo $re_qt['duongdan'] ?>'/>
                                    </a>
                                </li>
                    <?php	
								}
							}
							echo "</ul>";
						}
					?>
                    <div class="clear"></div>
                </div>
               
			</div>
			
			<div class ='clear'></div>
		</div>
		
		<div class = 'product-info'>
        	<p><b>Mô tả sản phẩm</b></p>
			<?php
				echo $re_sp['mota'];
			?>
		</div>
		
        <!-- COMMENT -->
        <div id = 'comment'>
        
        	<p style='font-size: 18px; font-weight: bold; color: #F90;	'>KHÁCH HÀNG NHẬN XÉT</p>
    	<form  action="product-detail.php?id=<?php echo $id ?>">
            <fieldset>
            
                <legend>Viết nhận xét của bạn vào bên dưới</legend>
                    <textarea class='com-mess'></textarea>
                	<input type='hidden' name='id' value='<?php echo $id ?>'/>
                	<input type = 'submit' class='com-submit' data-id="<?php echo $id ?>" value="Gửi"/>
            </fieldset>
        </form> 
            <p style='font-size: 18px; font-weight: bold; color: #F90;	margin-top: 3%;'>CÁC NHẬN XÉT TRƯỚC ĐÓ</p>
          	<ul id='com-list'>
            	<?php
					while($re_bl = mysql_fetch_assoc($binhluan))
					{
				?>
                <li>
                	<div class='com-info'>
                    	<img src="image/khachhang/<?php echo $re_bl['hinhdaidien'] ?>"/>
                        <p><?php echo $re_bl['tenkh']." &nbsp;".date('H:i:s d/m/Y', strtotime($re_bl['ngay']))." &nbsp;"; ?> </p>
                        <p><?php echo $re_bl['noidung']?></p>
                        <!--<p><a href="javascript:void(0)" class="rep-a" data-repa='<?php echo $re_bl['mabl'] ?>'>Gửi trả lời</a></p>-->
                    </div>
                    <div class="clear"></div>
             		<!--các bình luận conn-->
                    <!--
                    <ul>
                    
                    	<li>
                        	<div class='com-info'>
                                <img src="image/khachhang/16700007_736167479867040_1149049724_n.jpg"/>
                                <p>Thủy Trân 30/11/2017 16:59:24</p>
                                <p>Màu son lên đẹp, đều màu và lâu trôi</p>
                            </div>
                            <div class="clear"></div>
                        </li>
                    
                    </ul>-->
                <form>
                    <fieldset style="margin-left: 75px; display: none" class="rep-form<?php echo $re_bl['mabl'] ?>">
            
                        <legend>Viết nhận xét của bạn vào bên dưới</legend>
                    	<!--<form>-->
                            <textarea class='re-mess'></textarea>
                        <!--</form>-->
                        <input type='submit' class = 're-submit'  value='Gửi'/>
                    </fieldset>
                </form>
                </li>
                <?php
					}
				?>
                <!--
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
               <form>
                    <fieldset style="margin-left: 75px; display: none" class="rep-form">
            
                        <legend>Viết nhận xét của bạn vào bên dưới</legend>
                            <textarea class='re-mess'></textarea>
                        <input type='submit' class = 're-submit'  value='Gửi'/>
                    </fieldset>
				</form>
                    <div class="clear"></div>  
                </li> -->
                
            </ul>
        
        </div>
		
		<div class = 'clear'></div>
	</div>
    <!--END div left-->
	

	<div class = 'wrap-right-protail'>
    
    	<?php
				/*$sql = "	select	sp.masp, tensp, sp.giaban, sp.giadexuat, thuonghieu, sum(cthd.soluong) as 'tong'
							from	sanpham sp, chitietsanpham ctsp, chitiethoadon cthd
							where	sp.masp = ctsp.masp and ctsp.mactsp = cthd.mactsp and sp.trangthai = 1
							group by sp.masp
							order by sum(cthd.soluong) desc";*/
			$sql = "	SELECT t1.masp, t1.mactsp, t1.tensp, t1.duongdan, t1.giaban, t1.thuonghieu, t1.mausac, t2.makm, t2.chietkhau, t2.tiengiamgia
						FROM
						(	select	sp.masp, ctsp.mactsp, tensp, duongdan, ctsp.giaban, thuonghieu, ctsp.mausac
							from	sanpham sp, chitietsanpham ctsp, hinhanh ha
							where 	ctsp.trangthai = 1 and sp.trangthai = 1  and sp.masp = ctsp.masp and sp.masp = ha.masp and tensp like '%".mysql_escape_string($re_sp['tensp'])."%' and ctsp.mactsp <> '$id'
							group by ctsp.mactsp 
							limit 0,5
						)t1 left join
						(
							SELECT	km.makm, km.chietkhau, km.tiengiamgia, km.masp
							FROM	khuyenmai km, ctsp_km ctkm
							where	km.makm = ctkm.MaKM and ('$date' >= ctkm.NgayBD and '$date' <= ctkm.NgayKT) and km.masp <> ''
							group by km.makm
						)t2 on t1.masp = t2.masp";
			mysql_query("set names 'utf8'");
			$sp_lq = mysql_query($sql);
			if(mysql_num_rows($sp_lq) > 0)
			{
		?>
    
    	<div class="list-pro">
        	
            <div class = 'list-item-title'>
            	SẢN PHẨM LIÊN QUAN
            </div>
            <?php
				while($re_lq = mysql_fetch_assoc($sp_lq))
				{
			?>
            
           	<div class = 'pro-sml'>
                <img src="image/mypham/<?php echo $re_lq['duongdan'] ?>"/>
                    <a href='product-detail.php?id=<?php echo $re_lq['mactsp'] ?>'>
                    <div>
                        <p><?php echo $re_lq['tensp'] ?></p>
                        <p>Màu: <?php echo $re_lq['mausac'] ?></p>
                        <p class="text-highlight"><?php echo $re_lq['thuonghieu'] ?></p>
                        <p>
                        	<?php
								$giamgia = $giaban = 0; $check_qt = 0;
								if($re_lq['makm'] == "")
								{
									$giaban = $re_lq['giaban'];
								}
								else
								{
									if($re_lq['chietkhau'] != 0)
									{
										$giamgia = $re_lq['chietkhau'];
										$giaban = $re_lq['giaban'] - ($re_lq['giaban']*($giamgia/100));	
									}
									else if($re_lq['tiengiamgia'] != 0)
									{
										$giamgia = $re_lq['tiengiamgia'];
										$giaban = $re_lq['giaban'] - $re_lq['tiengiamgia'];	
									}
									else if($re_lq['chietkhau'] == 0 && $re_lq['tiengiamgia'] == 0)
									{
										$check_qt = 1;
										$giaban = $re_lq['giaban'];	
									}
													
								}
							?>
                            <span class = 'product-price-home'><?php echo number_format($giaban) ?> đ</span>
                            <strike><?php echo $giamgia == 0 ?  "" :  number_format($re_lq['giaban'])."đ" ?></strike>
                        </p>
                        
                    </div>
                    </a>
            </div>
            
            <?php
				}
			?>
            <!--
            <div class='pro-xemthem'>
            	<a href='#'>Xem thêm</a>
            </div>
            -->
        </div>
		<?php
			}
		?>
    	 <?php
				//$sp_thuonghieu = mysql_query("select masp, tensp, giaban, giadexuat, thuonghieu from sanpham where thuonghieu = '".$re_sp['thuonghieu']."' and masp not in ('".$re_sp['masp']."')");
				//$sp_thuonghieu = mysql_query("select sp.masp, mactsp, tensp, mausac, ctsp.giaban, ctsp.giadexuat, thuonghieu from sanpham sp, chitietsanpham ctsp where sp.masp = ctsp.masp and thuonghieu = '".$re_sp['thuonghieu']."' and sp.masp not in ('".$re_sp['masp']."')");
				$sp_thuonghieu = mysql_query("SELECT t1.masp, t1.mactsp, t1.tensp, t1.duongdan, t1.giaban, t1.thuonghieu, t1.mausac, t2.makm, t2.chietkhau, t2.tiengiamgia
											FROM
											(	select	sp.masp, ctsp.mactsp, tensp, duongdan, ctsp.giaban, thuonghieu, ctsp.mausac
												from	sanpham sp, chitietsanpham ctsp, hinhanh ha
												where 	ctsp.trangthai = 1 and sp.trangthai = 1  and sp.masp = ctsp.masp and sp.masp = ha.masp and thuonghieu = '".mysql_escape_string($re_sp['thuonghieu'])."' and sp.masp <> '".$re_sp['masp']."'
												group by ctsp.mactsp 
												limit 0,5
											)t1 left join
											(
												SELECT	km.makm, km.chietkhau, km.tiengiamgia, km.masp
												FROM	khuyenmai km, ctsp_km ctkm
												where	km.makm = ctkm.MaKM and ('$date' >= ctkm.NgayBD and '$date' <= ctkm.NgayKT) and km.masp <> ''
												group by km.makm
											)t2 on t1.masp = t2.masp");
				if(mysql_num_rows($sp_thuonghieu) > 0)
				{
		?>
    
    	<div class="list-pro">
        	
            <div class = 'list-item-title'>
            	SẢN PHẨM CÙNG THƯƠNG HIỆU
            </div>
           <?php
				while($re_thuonghieu = mysql_fetch_assoc($sp_thuonghieu))
				{
			?>
                <div class = 'pro-sml'>
                    <img src="image/mypham/<?php echo $re_thuonghieu['duongdan'] ?>"/>
                    <a href='product-detail.php?id=<?php echo $re_thuonghieu['mactsp'] ?>'>
                    <div>
                        <p><?php echo $re_thuonghieu['tensp'] ?></p>
                        <p>Màu: <?php echo $re_thuonghieu['mausac'] ?></p>
                        <p class="text-highlight"><?php echo $re_thuonghieu['thuonghieu'] ?></p>
                        <p>
                        	<?php
								$giamgia = $giaban = 0; $check_qt = 0;
								if($re_thuonghieu['makm'] == "")
								{
									$giaban = $re_thuonghieu['giaban'];
								}
								else
								{
									if($re_thuonghieu['chietkhau'] != 0)
									{
										$giamgia = $re_thuonghieu['chietkhau'];
										$giaban = $re_thuonghieu['giaban'] - ($re_thuonghieu['giaban']*($giamgia/100));	
									}
									else if($re_thuonghieu['tiengiamgia'] != 0)
									{
										$giamgia = $re_thuonghieu['tiengiamgia'];
										$giaban = $re_thuonghieu['giaban'] - $re_thuonghieu['tiengiamgia'];	
									}
									else if($re_thuonghieu['chietkhau'] == 0 && $re_thuonghieu['tiengiamgia'] == 0)
									{
										$check_qt = 1;
										$giaban = $re_thuonghieu['giaban'];	
									}
													
								}
							?>
                            <span class = 'product-price-home'><?php echo number_format($giaban) ?> đ</span>
                            <strike><?php echo $giamgia == 0 ?  "" :  number_format($re_thuonghieu['giaban'])."đ" ?></strike>
                        </p>
                        
                    </div>
                    </a>
                </div>
            <?php
				}
			?>	
            
			<!--
            <div class='pro-xemthem'>
            	<a href='#'>Xem thêm</a>
            </div>
            -->
        </div>
        <?php
				}
		?>
        
        <?php
			$gia_goiy = $re_sp['giaban'] * (15/100);
		   		$sq_goiy = mysql_query("SELECT t1.masp, t1.mactsp, t1.tensp, t1.duongdan, t1.giaban, t1.thuonghieu, t1.mausac, t2.makm, t2.chietkhau, t2.tiengiamgia
										FROM
										(	select	sp.masp, ctsp.mactsp, tensp, duongdan, ctsp.giaban, thuonghieu, ctsp.mausac
											from	sanpham sp, chitietsanpham ctsp, hinhanh ha
											where 	ctsp.trangthai = 1 and sp.trangthai = 1  and sp.masp = ctsp.masp and sp.masp = ha.masp  and sp.masp <> '".$re_sp['masp']."' and( ctsp.giaban <= (".$re_sp['giaban']." + $gia_goiy)  and ctsp.giaban >= (".$re_sp['giaban']." - $gia_goiy))
											group by ctsp.mactsp 
											limit 0,5
										)t1 left join
										(
											SELECT	km.makm, km.chietkhau, km.tiengiamgia, km.masp
											FROM	khuyenmai km, ctsp_km ctkm
											where	km.makm = ctkm.MaKM and ('$date' >= ctkm.NgayBD and '$date' <= ctkm.NgayKT) and km.masp <> ''
											group by km.makm
										)t2 on t1.masp = t2.masp");
			if(mysql_num_rows($sq_goiy))
			{
		?>
        
        <div class="list-pro">
        	
            <div class = 'list-item-title'>
            	GỢI Ý CHO BẠN
            </div>
           <?php
		   		
				while($re_goiy = mysql_fetch_assoc($sq_goiy))
				{
			?>
                <div class = 'pro-sml'>
                    <img src="image/mypham/<?php echo $re_goiy['duongdan'] ?>"/>
                    <a href='product-detail.php?id=<?php echo $re_goiy['mactsp'] ?>'>
                    <div>
                        <p><?php echo $re_goiy['tensp'] ?></p>
                        <p>Màu: <?php echo $re_goiy['mausac'] ?></p>
                        <p class="text-highlight"><?php echo $re_goiy['thuonghieu'] ?></p>
                        <p>
                        	<?php
								$giamgia = $giaban = 0; $check_qt = 0;
								if($re_goiy['makm'] == "")
								{
									$giaban = $re_goiy['giaban'];
								}
								else
								{
									if($re_goiy['chietkhau'] != 0)
									{
										$giamgia = $re_goiy['chietkhau'];
										$giaban = $re_goiy['giaban'] - ($re_goiy['giaban']*($giamgia/100));	
									}
									else if($re_goiy['tiengiamgia'] != 0)
									{
										$giamgia = $re_goiy['tiengiamgia'];
										$giaban = $re_goiy['giaban'] - $re_goiy['tiengiamgia'];	
									}
									else if($re_goiy['chietkhau'] == 0 && $re_goiy['tiengiamgia'] == 0)
									{
										$check_qt = 1;
										$giaban = $re_goiy['giaban'];	
									}
													
								}
							?>
                            <span class = 'product-price-home'><?php echo number_format($giaban) ?> đ</span>
                            <strike><?php echo $giamgia == 0 ?  "" :  number_format($re_goiy['giaban'])."đ" ?></strike>
                        </p>
                        
                    </div>
                    </a>
                </div>
            <?php
				}
			?>	
            
			<!--
            <div class='pro-xemthem'>
            	<a href='#'>Xem thêm</a>
            </div>
            -->
        </div>
	
	</div>
    <?php
			}
	?>
	
	<div class = 'clear'></div>
    
    
<?php
	include_once('module/bottom.php');
	//mysql_close($conn);
?>

<?php

	function KhuyenMai()
	{
		
	}

?>