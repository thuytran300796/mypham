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
	
	$giamgia = $chietkhau = 0;
	
	//echo "số lượng: ".$_POST['soluong'];
	//echo "<br/>id: ".$_POST['id'];
	
	//unset($_SESSION['cart']);
	$list_km = array(); //$dem = 0;
		$arr_id = array();
	
	if(!isset($_SESSION['cart']))
		$_SESSION['cart'] = NULL;

	
	if(isset($_POST['id']))
	{
		//echo "có";
		$ctsp = $_POST['id'];
		if(!isset($_SESSION['cart'][$ctsp]))
		{
			$_SESSION['cart'][$ctsp]['soluong'] = $_POST['soluong'];
			$_SESSION['cart'][$ctsp]['giaban'] = $_POST['giaban'];
			$_SESSION['cart'][$ctsp]['hinhanh'] = $_POST['hinhanh'];
			$_SESSION['cart'][$ctsp]['masp'] = $_POST['masp'];
			$_SESSION['cart'][$ctsp]['tensp'] = $_POST['tensp'];
			$_SESSION['cart'][$ctsp]['maqt'] = $_POST['maqt'];  
			//mysql_query("set names 'utf8'");
			//$mausac = mysql_query("select mausac, giaban, giadexuat from chitietsanpham where mactsp = '$ctsp' and soluong > 0");
			//$re_mausac = mysql_fetch_assoc($mausac);
			$_SESSION['cart'][$ctsp]['mausac'] = $_POST['mausac'];
		}
		else
		{
			$_SESSION['cart'][$ctsp]['soluong'] = $_POST['soluong'];
			$_SESSION['cart'][$ctsp]['maqt'] = $_POST['maqt'];  
		}
		
	}
	
	
	if(isset($_SESSION['cart']))
	{
		date_default_timezone_set('Asia/Ho_Chi_Minh');
		$date = date('Y-m-d');
			
	
		
	
		foreach($_SESSION['cart'] as $key => $value)
		{
			$arr_id[] = "'$key'";
		}
		$string = implode(',', $arr_id);
		echo "mactsp: ".$string;
		mysql_query("set names 'utf8'");
		//lấy giá cả, khuyến mãi với đối tượng là các ctsp có trong giỏ hàng
		$sp_km = mysql_query("select km.makm, km.mota, km.masp, ctsp.mactsp, ctsp.giaban, km.giatrivoucher, km.giatridonhang, km.chietkhau, km.tiengiamgia, ctkm.id, ctkm.ngaybd, ctkm.ngaykt, ctkm.mactsp as 'maqt'
							from 	khuyenmai km, ctsp_km ctkm, sanpham sp, chitietsanpham ctsp
							where 	km.makm = ctkm.MaKM and km.masp = sp.masp and ctsp.MaSP = sp.MaSP
								and ctsp.MaCTSP in ($string) and km.trangthai = 1 
								and ('$date' >= ctkm.ngaybd and '$date' <= ctkm.ngaykt)");
		echo "slkm: ".mysql_num_rows($sp_km);
		$dem = 0;
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
					

					if(isset($_GET['mactsp']) && isset($_GET['maqt']))
					{
						if($_GET['mactsp'] == $re_sp['mactsp'])
						{
							//dùng để kiểm tra sự cố tình nhập mã qt trên đường dẫn - nếu ko có thì ko add
							if($re_sp['maqt'] == $_GET['maqt'])
								$_SESSION['cart'][$_GET['mactsp']]['maqt'] = $_GET['maqt'];
						}
					}
					
			}
			foreach($_SESSION['cart'] as $key => $value)
			{
				$check_qt = 0;
				foreach($list_km as $key_km => $value_km)
				{
					//gán mặc định 1 quà tặng khi khách chưa chọn quà
					if($_SESSION['cart'][$key]['maqt'] == $list_km[$key_km]['maqt'])
					{
						$check_qt = 1;
						break;
					}
				}
				if(!$check_qt)
					$_SESSION['cart'][$key]['maqt'] = "";
			}

		}
		else
		{
			foreach($_SESSION['cart'] as $key => $value)
				$_SESSION['cart'][$key]['maqt'] = "";
			
		}
		
		//unset($_SESSION['cart']);
		
		//foreach($list_km as $key => $value)
			//echo $key. " - ";
			
		
	}
	
	if(isset($_GET['check']))
	{
		if($_GET['check'] == 'huy')	
		{
			$id_huy = $_GET['ctsp'];
			if(isset($_SESSION['cart'][$id_huy]))
				unset($_SESSION['cart'][$id_huy]);
			if(count($_SESSION['cart'])==0)
				unset($_SESSION['cart']);
			
			foreach($list_km as $key => $value)
			{
				if($list_km[$key]['mactsp'] == $id_huy)
					unset($list_km[$key]);
			}
			if(count($list_km) == 0)
				$list_km = array();
		}
		else
		{
			if(isset($_SESSION['cart']))
				unset($_SESSION['cart']);	
			$list_km = array();
			unset($_SESSION['voucher']);
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
                        <a href='product-detail.php?id=<?php echo $key ?>'><p><?php echo $_SESSION['cart'][$key]['tensp'] ?></p></a>
                    <?php
						if($_SESSION['cart'][$key]['mausac'] != "")
                        	echo "<p>Màu sắc: ".$_SESSION['cart'][$key]['mausac']."</p>";
					?>
                        <a href="cart.php?check=huy&ctsp=<?php echo $key ?>" style="color: #F90">Xóa</a>
                        
                    <?php
						//nếu có khuyến mãi 
						//if(in_array($key, $list_km))
						//{
							//nếu km là quà tặng
							//if($list_km[$key]['maqt'] != "")
							//{	
								$arr_qt = array();
								foreach($list_km as $key_qt => $value_qt)
								{
									$giamgia = $chietkhau = 0;
									//nếu mà $key sp trong giỏ hàng có trong $list_km
									if($list_km[$key_qt]['mactsp'] == $key )
									{
										if($list_km[$key_qt]['maqt'] != "")
											$arr_qt[] = "'".$list_km[$key_qt]['maqt']."'";
										else if($list_km[$key_qt]['chietkhau'] != 0)
											$chietkhau = $list_km[$key_qt]['chietkhau'];
										else if($list_km[$key_qt]['tiengiamgia'] != 0)
											$giamgia = $list_km[$key_qt]['tiengiamgia'];
											
										//echo "maqt: ".$list_km[$key_qt]['maqt']." - ";
									}
								}
								$string_qt = count($arr_qt) > 0 ? implode(',', $arr_qt) : "''"; 
								mysql_query("set names 'utf8'");
								$quatang = mysql_query("select ctsp.mactsp, tensp, ctsp.mausac, duongdan from sanpham sp, chitietsanpham ctsp, hinhanh ha where sp.masp = ctsp.masp and sp.masp = ha.masp and ctsp.mactsp in ($string_qt)");
					?>
                        <div class='product-km' style=" width: 58%; float: right">
                        	<?php echo ($string_qt != "''" ?   "<p style='color: #000;'>Chọn một trong số các quà tặng sau:</p>" : "");?>
                       		<ul>
                            	<?php
									while($re_qt = mysql_fetch_assoc($quatang))
									{
										if($re_qt['mactsp'] == $_SESSION['cart'][$key]['maqt'] || $_SESSION['cart'][$key]['maqt'] == "")
										{
											$_SESSION['cart'][$key]['maqt'] = $re_qt['mactsp'];
								?>
                                		
                                		<li style='border: solid 2px #0CC;' title="<?php echo $re_qt['tensp'].($re_qt['mausac'] != "" ? " - Màu sắc: ".$re_qt['mausac'] : "") ?>">
                                <?php
										}
										else
										{
								?>
                                		<li  title="<?php echo $re_qt['tensp'].($re_qt['mausac'] != "" ? " - Màu sắc: ".$re_qt['mausac'] : "") ?>">
                                <?php
										}
								?>
                                            <a href='cart.php?mactsp=<?php echo $key ?>&maqt=<?php echo $re_qt['mactsp'] ?>' class='choose-qt'  data-maqt='<?php echo $re_qt['mactsp'] ?>'>
                                                <img style='width: 70px; height: 70px;' src='image/mypham/<?php echo $re_qt['duongdan'] ?>'/>
                                            </a>
                                        </li>
								<?php
									}
								?>
                            </ul>
                            <div class="clear"></div>
                        </div>
                        
                	<?php
							//}
						//}
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
                    	<input type='submit' class='btn-sub' data-id='<?php echo $key ?>' value='-' />
                    	<input type="text" class="txt-soluong txt-soluong-<?php echo $key ?> " value="<?php echo $_SESSION['cart'][$key]['soluong'] ?>"/>
                        <input type='submit' class='btn-plus' data-id='<?php echo $key ?>' value='+' />
                    </div>
                    
                    <div class='cart-thanhtien'>
                    	<p>
						<?php
                        	$thanhtien = $_SESSION['cart'][$key]['soluong'] * $giaban;
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
    
    <!-- quà tặng-->
    <div id="quatang">
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
            	<a href='product-detail.php?id=<?php echo $re_qt['mactsp'] ?>'>
				<div class='quatang-item'>
                    	<img src="image/mypham/<?php echo $re_qt['duongdan'] ?>"/>
                        <p><?php echo $re_qt['tensp'].($re_qt['mausac'] != "" ? " - Màu sắc: ".$re_qt['mausac']."" :"") ?></p>
               	</div>
                </a>
            </li>
        <?php
			}
		?>
        </ul>
    </div>
<?php
	echo "<pre>"; print_r($_SESSION['cart']); echo "</pre>";
	echo "<pre>"; print_r($list_km); echo "</pre>";	
?>
</div>



<div id = "cart-right">
	
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
	echo "tổng: ".$price;
	?>
	<input type='hidden' id='price' value="<?php echo $price ?>"/> <!--tiền hóa đơn-->
    <input type='hidden' id='tiensp' value="<?php echo $tongtien ?>"/> <!--tiền sp-->
	<table width="100%" style="padding: 20px; margin: auto; border: solid 1px #ccc; border-radius: 3px">
 
    	<tr>
        	<td width="50%" style="text-align: left;">Tiền sản phẩm:</td>
            <td width="50%" style="text-align: right;  font-weight: bold; font-size: 15px"><?php echo number_format($tongtien) ?> đ</td>
        </tr>
        
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
    
    <?php
	
	?>
    
    <form action="checkout.php">
    	<br />
        <ul id='list-voucher'>
        	<b></b>
        <?php
			if(isset($_SESSION['voucher']))
			{
		
        		echo 	"<b>Các voucher được áp dụng:</b>";
            	
				foreach($_SESSION['voucher'] as $key => $value)
				{
            		echo 	"<li>Mã phiếu: ".$key." (-".$_SESSION['voucher'][$key]['giatri']."đ)<a href='javascript:void(0)' data-maphieu='$key' class='del-voucher'> - Xóa</a></li>";
				}
			}
		?>
        </ul>
    	<br /><input type="submit" value="Tiến hành đặt hàng" class="btn-cart"/></br></br>
    </form>
    
    <form>
    	<p style="font-size: 12px;">Bạn có mã giảm giá? <a href="javascript:void(0)" class='a-code' style="color: #06C; font-weight: bold;font-size: 12px;">Vui lòng click vào đây để nhập...</a></p>
        <div class='code'>
    		<input type='text'  id='magiamgia' value="" style="width: 159px; height: 30px; padding: 3px; border: solid 1px #ccc; border-radius: 3px; "/>
            <input type='button'  id = 'code-submit' value="Đồng ý"/>
        </div>
    </form>
    
</div>
<?php
	}
	if(isset($_SESSION['voucher']))
		echo count($_SESSION['voucher']);
?>

<script>
	
	$(document).ready(function(e) {
		
		//$('#list-voucher').hide();
		
        $('#code-submit').click(function()
		{
			maphieu = $('#magiamgia').val();
			tienhd = $('#price').val(); //alert('Tiền hd: '+tienhd);
			//tonggiam = parseFloat($('#tiengiamgia').val());
			//alert($('#tiengiamgia').val());
			
			$.ajax
			({
				url: "js/xuly/voucher_xuly.php",
				data: "ac=them&maphieu="+maphieu+"&tienhd="+tienhd,
				dataType: "json",
				type: "post",
				async: true,
				success:function(kq)
				{
					if(kq.maphieu != '')
					{
						$('#list-voucher').show();
						$('#list-voucher b').html("Các voucher được áp dụng:");
						$('#list-voucher').append("<li>Mã phiếu: "+maphieu+" (-"+kq.giatri+" đ)<a href='javascript:void(0)' data-maphieu='"+kq.maphieu+"' class='del-voucher'> - Xóa</a></li>");
						
						$('#tiengiamgia').html(kq.tonggiam);
						$('#tamtinh').html(kq.tamtinh);
						$('#price').val(kq.tamtinh); //alert($('#price').val());
					}
					else
						alert(kq.error);
					$('#magiamgia').val('');
				},
				error: function (jqXHR, exception)
				{
					//alert("Lỗi rồi");
					 var msg = '';
					if (jqXHR.status === 0) {
						msg = 'Not connect.\n Verify Network.';
					} else if (jqXHR.status == 404) {
						msg = 'Requested page not found. [404]';
					} else if (jqXHR.status == 500) {
						msg = 'Internal Server Error [500].';
					} else if (exception === 'parsererror') {
						msg = 'Requested JSON parse failed.';
					} else if (exception === 'timeout') {
						msg = 'Time out error.';
					} else if (exception === 'abort') {
						msg = 'Ajax request aborted.';
					} else {
						msg = 'Uncaught Error.\n' + jqXHR.responseText;
					}
					alert(msg);
				}	
			});
			return false;
		});
		
		$('#list-voucher').delegate('.del-voucher', 'click', function()
		{
			maphieu = $(this).attr('data-maphieu');
			tiensp = $('#tiensp').val();
			tienhd = $('#price').val();
			//alert(tienhd); alert(tiensp);
			$.ajax
			({
				url: "js/xuly/voucher_xuly.php",
				data: "ac=xoa&maphieu="+maphieu+"&tienhd="+tienhd+"&tiensp="+tiensp,
				type: "post",
				dataType: "json",
				async: true,
				success:function(kq)
				{
					
					$("a[data-maphieu='"+maphieu+"']").closest('#list-voucher li').fadeOut();
					
					if(kq.soluong == 0)
						$('#list-voucher').hide();
					
					$('#tamtinh').html(kq.tienhd); $('#price').val(kq.tienhd); alert($('#price').val());
					$('#tiengiamgia').html(kq.tonggiam);
					$('#magiamgia').val('');
				},
				error: function (jqXHR, exception)
				{
					//alert("Lỗi rồi");
					 var msg = '';
					if (jqXHR.status === 0) {
						msg = 'Not connect.\n Verify Network.';
					} else if (jqXHR.status == 404) {
						msg = 'Requested page not found. [404]';
					} else if (jqXHR.status == 500) {
						msg = 'Internal Server Error [500].';
					} else if (exception === 'parsererror') {
						msg = 'Requested JSON parse failed.';
					} else if (exception === 'timeout') {
						msg = 'Time out error.';
					} else if (exception === 'abort') {
						msg = 'Ajax request aborted.';
					} else {
						msg = 'Uncaught Error.\n' + jqXHR.responseText;
					}
					alert(msg);
				}	
			});
			return false;
		});
    });
	
</script>


<?php


	ob_flush();
	include_once('module/bottom.php');
?>


