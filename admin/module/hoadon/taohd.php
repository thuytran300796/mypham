<?php
	function Tao_MaHD()
	{
		$result = mysql_query('Select MaHD from HoaDon ');
		
		if(mysql_num_rows($result) == 0)
			return 'HD1';
			
		$dong = mysql_fetch_assoc($result);
		
		$number = substr($dong['MaHD'], 2);
		
		while($dong = mysql_fetch_assoc($result))
		{
			$temp = substr($dong['MaHD'], 2);
			if($number < $temp)
				$number = $temp;
		}
		return 'HD'.++$number;	
	}
?>

<?php

	if(!isset($_SESSION['cart_ad']))
	{
		$_SESSION['cart_ad'] = NULL; //echo "null";
	}
	
	if(isset($_POST['thanhtoan']))
	{
		if(count($_SESSION['cart_ad']) == 0)
		{
			echo "<script>alert('Thao tác không thành công. Phải có ít nhất một sản phẩm đươc bán ra');</script>";
			return false;	
		}
		
		//echo "chiết khấu: ".$_POST['chietkhau'];	
		$chietkhau_bill = $_POST['chietkhau'];
		$phivanchuyen = $_POST['pvc'];
		$thue = $_POST['thue'];
		$makh = $_POST['taikhoankh'];
		$diachi = $_POST['diachi'];
		$sdt = $_POST['sdt'];
		$ten = $_POST['ten'];	
		$tongcong = $_POST['tongcong'];
		$diemsudung = $_POST['diemsudung'];
		
		$makm = $_POST['makm'] == "" ? '000' : $_POST['makm']; //echo "MaKM: ".$makm;
		
		date_default_timezone_set('Asia/Ho_Chi_Minh');
		$ngayxuat = date('Y/m/d H:i:s');	$date = date('Y-m-d');
		
		$mahd = Tao_MaHD(); $user = isset($_SESSION['user']) ? $_SESSION['user'] : "";
		mysql_query("set names 'utf8'");
		$hd = mysql_query("insert into hoadon(mahd, manv, ngayxuat, makh, makm, chietkhau, phivanchuyen, thue, hotennguoinhan, sdt, diachi, trangthai) values('$mahd', '$user', '$ngayxuat', '$makh', '$makm', $chietkhau_bill, $phivanchuyen, $thue, '$ten','$sdt', '$diachi', 1)");
		//echo "insert into hoadon(mahd, manv, ngayxuat, makh, makm, chietkhau, phivanchuyen, thue, hotennguoinhan, sdt, diachi, trangthai) values('$mahd', '$user', '$ngayxuat', '$makh', '$makm', $chietkhau_bill, $phivanchuyen, $thue, '$ten','$sdt', '$diachi', 1)";
		if(!$hd) echo mysql_error()."<br/>";
		
		if($makh != "" && $makm != "000")
		{
			$diem = ((int)($tongcong / 100000))*10;
			$hd = mysql_query("update khachhang set diemtichluy = diemtichluy + $diem where makh = '$makh'");
		}
		
		foreach($_SESSION['cart_ad'] as $key=>$value)
		{
			mysql_query("set names 'utf8'");
			$status_qt = $key != 'QT000' ? 0 : 1; //QT000 là hình thức km quà tặng áp dụng cho hóa đơn
			$mactsp = $key != 'QT000' ? $key : $_SESSION['cart_ad'][$key]['maqt'];
			$makm = $_SESSION['cart_ad'][$key]['makm'] == "" ? '000' : $_SESSION['cart_ad'][$key]['makm'];
			$cthd = mysql_query("insert into chitiethoadon(mahd, mactsp, soluong, makm, quatang) values('$mahd', '$mactsp', ".$_SESSION['cart_ad'][$key]['soluong'].", ' ".$makm."', $status_qt)");
			if($_SESSION['cart_ad'][$key]['maqt'] != "" && $key != 'QT000')
			{
				$cthd = mysql_query("insert into chitiethoadon(mahd, mactsp, soluong, makm, quatang) values('$mahd','".$_SESSION['cart_ad'][$key]['maqt']."', ".$_SESSION['cart_ad'][$key]['soluong'].", '000', 1)");
				$kq = mysql_query("UPDATE ChiTietSanPham SET SoLuong = SoLuong - ".$_SESSION['cart_ad'][$key]['soluong']." WHERE MaCTSP = '".$_SESSION['cart_ad'][$key]['maqt']."'");
			}
			if(!$cthd)  echo mysql_error()."<br/>";
			$kq = mysql_query("UPDATE ChiTietSanPham SET SoLuong = SoLuong - ".$_SESSION['cart_ad'][$key]['soluong']." WHERE MaCTSP = '$key'");
		}
		
		if(isset($_SESSION['voucher_ad']))
		{
			foreach($_SESSION['voucher_ad'] as $key_vc => $value_vc)
			{
				if($_SESSION['voucher_ad'][$key_vc]['ngaybd'] <= $date && $_SESSION['voucher_ad'][$key_vc]['ngaykt'] >= $date)
				{
					$kq = mysql_query("insert into pmh_hd values('$key_vc', '$mahd')");
					//có cần set trạng thái cho pmh đó ko nhỉ
					$kq = mysql_query("update phieumuahang set trangthai = 1 where maphieu = '$key_vc'");
				}
			}
		}
				
		unset($_SESSION['cart_ad']);
		unset($_SESSION['voucher_ad']);
		$chietkhau_bill = 0; $phivanchuyen = 0; $tongtien = $diemsudung = 0;
	}
	else
	{
		$makh = $diachi = $sdt = $ten = "";	
		$chietkhau_bill = $phivanchuyen = $thue = $diemsudung = 0;
	}
	//echo "<pre>"; print_r($_SESSION['cart_ad']); echo "</pre>";
?>

<script>

	$(document).ready(function(e) {
		
		
        
		$('#keyword').keyup(function()
		{
			keyword = $('#keyword').val();
			//alert(keyword);
			
			if(keyword == "")
				$('#taohd-left .quick-result').css('display', 'none');
			else
			{
				$.ajax
				({
					url: "module/hoadon/xuly/taohd_xuly.php",
					type: "post",
					data: "ac=search&keyword="+keyword,
					async: true,	
					success:function(kq)
					{
						$('#taohd-left .quick-result').css('display', 'block');
						$('#taohd-left .quick-result').html(kq);
					}
				});
				
				
			}
			
			return false;	
		});
		
		$('#keyword').keyup(function()
		{
			$('#keyword').attr('placeholder', 'Nhập tên hoặc mã sản phẩm cần tìm...');	
		});
		
		$('#keyword-kh').keyup(function()
		{
			$('#keyword-kh').attr('placeholder', 'Nhập tên hoặc tài khoản khách hàng...');	
		});
		
		$('#keyword-kh').keyup(function()
		{
			keyword_kh = $('#keyword-kh').val();
			//alert(keyword);
			
			if(keyword_kh == "")
				$('#taohd-right .quick-result').css('display', 'none');
			else
			{
				$.ajax
				({
					url: "module/hoadon/xuly/khachhang_xuly.php",
					type: "post",
					data: "ac=search&keyword="+keyword_kh,
					async: true,	
					success:function(kq)
					{
						$('#taohd-right .quick-result').css('display', 'block');
						$('#taohd-right .quick-result').html(kq);
					}
				});				
			}
			
			return false;	
		});
		
		$('#taohd-right .quick-result').delegate('li a', 'click', function()
		{
			makh = $(this).attr('data-makh');
			$.ajax
			({
				url: "module/hoadon/xuly/khachhang_xuly.php",
				type: "post",
				data: "ac=get_kh&makh="+makh,
				async: true,
				dataType: 'json',
				success:function(kq)
				{
					$('#taikhoankh').val(kq.makh);
					$('#ten').val(kq.ten);
					$('#diachi').val(kq.diachi);
					$('#sdt').val(kq.sdt);
					$('#diemtichluy').html(kq.diemtichluy);
				}
			});
			return false;
		});
		
		$('.quick-result').mouseleave(function()
		{
			$('.quick-result').hide();
		});
		
		function TienSP()
		{
			$.ajax
			({
				url: "module/hoadon/xuly/taohd_xuly.php",
				type: "post",
				data: "ac=tinhtien",
				dataType: 'json',
				async: true,
				success:function(data)
				{
					$('#tiensp').val(data.tiensp);
					$('#thue').val(data.thue);
				}
			});
			//alert('tien trong');
			TinhTien();
			return false;
		}
		
		$('#taohd-left .quick-result').delegate('li a', 'click', function()
		{
			id = $(this).attr('data-id');
			
			$.ajax
			({
				url: "module/hoadon/xuly/taohd_xuly.php",
				type: "post",
				data: "ac=get_sp&id="+id,
				async: true,
				success:function(kq)
				{
					$('#taohd-left table').append(kq);
					//TienSP();
					//alert('tien ngoai');
					//TinhTien();
					window.location="admin.php?quanly=hoadon&ac=taohd";
				}	
			});
			
			return false;	
		});
		
		
		
		$('#taohd-left').delegate('.btn-plus', 'click', function()
		{
			id = $(this).attr('data-id'); 
			soluong = parseInt($('.txt-soluong-'+id).val());
			soluong = soluong + 1;
			
			$.ajax
			({
				url: "module/hoadon/xuly/taohd_xuly.php",
				type: "post",
				data: "ac=soluong&id=" + id + "&soluongmoi=" + soluong,
				async: true,
				success:function(kq)
				{
					$('.txt-soluong-'+id).val(soluong);	
					//TienSP();
					//TinhTien();
					window.location="admin.php?quanly=hoadon&ac=taohd";
				}	
			});
			//alert('tien: '+$('#tiensp').val());
			return false;	
		});
		$('#taohd-left').delegate('.btn-sub', 'click', function()
		{
			
			id = $(this).attr('data-id');  //alert(ctsp);
			soluong = parseInt($('.txt-soluong-'+id).val());
			soluong = (soluong - 1) == 0 ? 1 : (soluong-1); //alert(soluong);
					
			$.ajax
			({
				url: "module/hoadon/xuly/taohd_xuly.php",
				type: "post",
				data: "ac=soluong&id=" + id + "&soluongmoi=" + soluong,
				async: true,
				success:function(kq)
				{
					$('.txt-soluong-'+id).val(soluong);
					window.location="admin.php?quanly=hoadon&ac=taohd";
					//TienSP();
					//TinhTien();
				}
			});
			
			
			return false;	
		});	
		
		
		
		$('.hd-sp table').delegate('.del', 'click', function()
		{
			id = $(this).attr('data-id');
			$.ajax
			({
				url: "module/hoadon/xuly/taohd_xuly.php",
				type: "post",
				data: "ac=del&id="+id,
				dataType: 'json',
				async: true,
				success:function(kq)
				{
					$("a[data-id='"+id+"']").closest("tr").fadeOut('fast');
					window.location="admin.php?quanly=hoadon&ac=taohd";
					//TienSP();
					//TinhTien();
				}
			});
			
			return false;		
		});	
		
		$('.hd-sp').delegate('.choose-qt', 'click', function()
		{
			maqt = $(this).attr('data-maqt'); mactsp = $(this).attr('data-mactsp'); //alert(mactsp);
			$.ajax
			({
				url: "module/hoadon/xuly/taohd_xuly.php",
				type: "post",
				data: "ac=qt&maqt="+maqt+"&mactsp="+mactsp,
				async: true,
				success:function(kq)
				{
					//alert(kq);
					$("a[data-mactsp='"+mactsp+"']").closest("li").css('border', 'solid 1px #CCC');
					$("a[data-maqt='"+maqt+"']").closest("li").css('border', 'solid 2px #0CC');
				}
			});
			return false;
		});
		
		$("#taohd-right #chietkhau, #taohd-right #pvc").keyup(function()
		{
			//alert('change');
			if(isNaN($(this).val()))
			{
				$(this).val(0);
				return false;
			}
			TinhTien();
			//alert('change');	
			
			//alert($('#tongcong').val());
		});

		$('#thanhtoan').click(function()
		{
			//alert('sp: '+$('#tiensp').val()+' - giảm km: '+$('#giamkm').val()+ ' - voucher: '+$('#voucher').val());
		});
		
		function TinhTien()
		{
			tiensp = parseInt($('#tiensp').val()); 
			giamkm = parseInt($('#giamkm').val() == ""  ? 0 : $('#giamkm').val()); 
			voucher = parseInt($('#voucher').val() == ""  ? 0 : $('#voucher').val());
			chietkhau = parseInt($('#chietkhau').val() == "" ? 0 : $('#chietkhau').val());
			thue = parseInt($('#thue').val() == ""  ? 0 : $('#thue').val());
			pvc = parseInt($('#pvc').val() == "" ? 0 : $('#pvc').val());
			//alert('sp: '+tiensp+' giamkm: '+giamkm+' voucher: '+voucher+' chietkhau: '+chietkhau+' pvc: '+pvc);
			//alert(tiensp + ' - ' + giamkm + ' - ' + voucher + ' - thue: ' + thue );
			tongcong =  parseInt(tiensp - giamkm - voucher);  //alert('tong: ' + tongcong);
			tongcong = parseInt((tongcong-chietkhau)+pvc);
			//tongcong =  tongcong - (tongcong * (chietkhau/100)) + pvc;
			//tongcong =  tongcong - chietkhau + pvc;
			tongcong =  tongcong < 0 ? 0 : tongcong; 
			$('#tongcong').val(tongcong);	
		}
    });
	
		

</script>

<?php

	if(isset($_SESSION['cart_ad']))
	{
		//echo "<pre>"; echo print_r($_SESSION['cart_ad']); echo "</pre>"; 

		foreach($_SESSION['cart_ad'] as $key => $value)
		{
			$arr_id[] = "'$key'";
		}
		$string = implode(',', $arr_id);
		//echo "mactsp: ".$string;
		mysql_query("set names 'utf8'");
		//tạo hóa đơn trực tiếp cho khách nên cần phải lưu lại km, giá khi đã insert vô session, phòng ngừa km hay giá bị thay đổi giá
		$sp_km = mysql_query("select km.makm, km.mota, km.masp, ctsp.mactsp, ctsp.giaban, km.giatrivoucher, km.giatridonhang, km.chietkhau, km.tiengiamgia, ctkm.id, ctkm.ngaybd, ctkm.ngaykt, ctkm.mactsp as 'maqt'
							from 	khuyenmai km, ctsp_km ctkm, sanpham sp, chitietsanpham ctsp
							where 	km.makm = ctkm.MaKM and km.masp = sp.masp and ctsp.MaSP = sp.MaSP
								and ctsp.MaCTSP in ($string) 
							");
		
		$list_qt = array();
		$dem = 0;
		if(mysql_num_rows($sp_km) > 0)
		{
			while($re_sp = mysql_fetch_assoc($sp_km))
			{
				$list_qt[$dem]['mactsp'] = $re_sp['mactsp'];
				$list_qt[$dem]['maqt'] = $re_sp['maqt'];
				$dem++;	
									
				if(isset($_GET['mactsp']) && isset($_GET['maqt']))
				{
					if($_GET['mactsp'] == $re_sp['mactsp'])
					{
						//dùng để kiểm tra sự cố tình nhập mã qt trên đường dẫn - nếu ko có thì ko add
						if($re_sp['maqt'] == $_GET['maqt'])
							$_SESSION['cart_ad'][$_GET['mactsp']]['maqt'] = $_GET['maqt'];
					}
				}
									
			}
			//nếu ko cho sửa khuyến mãi thì có thể bỏ code này
			foreach($_SESSION['cart_ad'] as $key => $value)
			{
				$check_qt = 0;
				foreach($list_qt as $key_km => $value_km)
				{
					if(($_SESSION['cart_ad'][$key]['maqt'] == $list_qt[$key_km]['maqt'] && $key == $list_qt[$key_km]['mactsp']) || $key == 'QT000')
					{
						//echo "key: ".$key;
						$check_qt = 1;
						break;
					}
				}
				if(!$check_qt)
				{
					$_SESSION['cart_ad'][$key]['maqt'] = "";
				}
			}
			//nếu có km thì ko áp dụng voucher
			if(isset($_SESSION['voucher']))
			{
				unset($_SESSION['voucher']);
				echo "<script>alert('Voucher sẽ không được áp dụng khi cửa hàng có chương trình khuyến mãi');</script>";	
			}
		}
		else
		{
			foreach($_SESSION['cart_ad'] as $key => $value)
			{
				if($key != 'QT000')
				$_SESSION['cart_ad'][$key]['maqt'] = "";
			}
		}
	}
	
	if(!isset($_SESSION['hoadon']))
		$_SESSION['hoadon'] = NULL;
		
	date_default_timezone_set('Asia/Ho_Chi_Minh');
	$date = date('Y-m-d');
		
	if(isset($_SESSION['cart_ad']))
	{
		if(count($_SESSION['cart_ad']) == 0)
		{
			unset($_SESSION['cart_ad']);
			unset($_SESSION['voucher']);	
		}
	}
	
?>


<p class="title">TẠO HÓA ĐƠN</p><br />

<div id='taohd-left'>

	<div class='quick-search'>
    	<form>
        	<input type='text' class="txt-sp" style="width: 400px;" id='keyword' name='keyword' placeholder="Nhập mã hoặc tên sản phẩm..."/>
            
            <ul class = "quick-result" style="display: none;">
                 <div class="clear"></div>
            </ul>         
        </form>
    </div>
    
    
    <div class="hd-sp">
    
    	<table width="100%" style="border-collapse:collapse">
        	
            <tr>
            	<th width='5%'></th>
            	<th width='18%'></th>
                <th width='40%'></th>
                <th width='20%'></th>
                <th width='15%'></th>
            </tr>
            
    <?php
		//unset($_SESSION['cart_ad']);
		$tiensp = $thue = 0;
		if(isset($_SESSION['cart_ad']))
		{
			
		foreach($_SESSION['cart_ad'] as $key => $value)
		{
			if($key != 'QT000')
			{
	?>           
    	 
            <tr data-id=<?php echo $key ?>>
            	<td><a href='javascript:void(0)' class='del' data-id='<?php echo $key ?>'><img src='../image/del.png' /></a></td>
            	<td><?php echo $key ?></td>
                <td><b><?php echo  $_SESSION['cart_ad'][$key]['tensp']?></b><br />
                	<p><?php echo $_SESSION['cart_ad'][$key]['mausac'] != "" ? ("<p>Màu sắc: ".$_SESSION['cart_ad'][$key]['mausac']."</p>") : "" ?></p>
                	<?php
						$arr_qt = array();
						foreach($list_qt as $key_qt => $value_qt)
						{
							$giamgia = $chietkhau = 0;
							//nếu mà $key sp trong giỏ hàng có trong $list_qt
							if($list_qt[$key_qt]['mactsp'] == $key )
							{
								if($list_qt[$key_qt]['maqt'] != "")
									$arr_qt[] = "'".$list_qt[$key_qt]['maqt']."'";
							}
						}
						$string_qt = count($arr_qt) > 0 ? implode(',', $arr_qt) : "''"; 
						mysql_query("set names 'utf8'");
						$quatang = mysql_query("select ctsp.mactsp, tensp, ctsp.mausac, duongdan from sanpham sp, chitietsanpham ctsp, hinhanh ha where sp.masp = ctsp.masp and sp.masp = ha.masp and ctsp.mactsp in ($string_qt)  group by ctsp.mactsp");
					?>
                
                	<div class='product-km' style="width: 100%; float: left;">
                    	<ul>
                    <?php echo ($string_qt != "''" ?   "<p style='color: #000; font-size: 13px;'>Chọn một trong số các quà tặng sau:</p>" : "");?>
                        <?php
							while($re_qt = mysql_fetch_assoc($quatang))
							{
								if($re_qt['mactsp'] == $_SESSION['cart_ad'][$key]['maqt'] || $_SESSION['cart_ad'][$key]['maqt'] == "")
								{
									$_SESSION['cart_ad'][$key]['maqt'] = $re_qt['mactsp'];
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
                                    <a href='javascript:void(0)'  class='choose-qt' data-mactsp='<?php echo $key ?>' data-maqt='<?php echo $re_qt['mactsp']?>'>
                                    	<img style='width: 70px; height: 70px;' src='../image/mypham/<?php echo $re_qt['duongdan'] ?>'/>
                                    </a>
                                </li>
						<?php
								}
						?>
                        </ul>
                        <div class="clear"></div>
                   </div>
                </td>
                <td align="center"><input type='submit' class='btn-sub' data-id='<?php echo $key ?>' value='-' />
                    <input type="text" readonly="readonly" class="txt-soluong txt-soluong-<?php echo $key ?> " value="<?php echo isset($_SESSION['cart_ad'][$key]['soluong']) ? $_SESSION['cart_ad'][$key]['soluong'] : 1 ?>"/>
                    <input type='submit' class='btn-plus' data-id='<?php echo $key ?>' value='+' /></td>
                <td align="right">
                	<?php
							$giamgia = 0;
							if($_SESSION['cart_ad'][$key]['chietkhau'] != 0)
							{
								$giamgia = ($_SESSION['cart_ad'][$key]['chietkhau']/100) * $_SESSION['cart_ad'][$key]['giaban'];
							}
							else if($_SESSION['cart_ad'][$key]['tiengiamgia'] != 0)
							{
								$giamgia = $_SESSION['cart_ad'][$key]['tiengiamgia'] 	;
							}
							if($giamgia > 0)
							{
								echo "<p>".number_format($_SESSION['cart_ad'][$key]['giaban'] - $giamgia)." đ</p>";
								echo "<p><strike>".number_format($_SESSION['cart_ad'][$key]['giaban'])." đ<strike></p>";
							}
							else
								echo "<p>".number_format($_SESSION['cart_ad'][$key]['giaban'])." đ</p>";
						?>
                </td>
            </tr>
         
    <?php
			$tiensp += ($_SESSION['cart_ad'][$key]['giaban'] - $giamgia) * $_SESSION['cart_ad'][$key]['soluong'];
			$thue += (int)(($_SESSION['cart_ad'][$key]['giaban'] - $giamgia) / ((100+$_SESSION['cart_ad'][$key]['thue'])/$_SESSION['cart_ad'][$key]['thue'])) * $_SESSION['cart_ad'][$key]['soluong'];
			
			}
		}
			
		}
	?>

            
        </table>
    
    </div>
    
    <!--quà tặng-->
    <div id="quatang">
        <?php
		//quà tặng kèm cho hóa đơn
			
			$chietkhau_hd = $giamgia_hd = 0;
		
			mysql_query("set names 'utf8'");
			$khuyenmai = mysql_query("select km.makm, km.mota, ctsp.giaban, km.giatrivoucher, km.giatridonhang, km.chietkhau, km.tiengiamgia, ctkm.id, ctkm.ngaybd, ctkm.ngaykt, ctkm.mactsp as 'maqt'
									from 	khuyenmai km, ctsp_km ctkm, chitietsanpham ctsp
									where 	km.makm = ctkm.MaKM  and  ctsp.MaCTSP = ctkm.mactsp and km.trangthai = 1 
										and ('$date' >= ctkm.ngaybd and '$date' <= ctkm.ngaykt)
										and km.masp = ''");
			
			//nếu ko có khuyến mãi
			if(mysql_num_rows($khuyenmai) == 0)
			{
				if(isset($_SESSION['cart_ad']['QT000'])) unset($_SESSION['cart_ad']['QT000']);
			}
			
			$makm = ""; //lưu lại khuyến mãi của hóa đơn
			$arr_qt_hd = array(); $check_qt_hd = 0;
			while($re_km = mysql_fetch_assoc($khuyenmai))
			{
				if($tiensp >= $re_km['giatridonhang'])
				{
					if($re_km['maqt'] != "")
					{
						$arr_qt_hd[] = "'".$re_km['maqt']."'"; 
					}
					else if($re_km['chietkhau'] != "0")
					{
						//$chietkhau_hd = $re_km['chietkhau'];
						//$giamgia_hd = 0;
						$giamgia_hd = $tiensp * ($re_km['chietkhau'] / 100);
					}
					else if($re_km['tiengiamgia'] != "0")
					{
						$giamgia_hd = $re_km['tiengiamgia'];	
						//$chietkhau_hd = 0;
					}
					//nếu thỏa điều kiện km thì xóa voucher
					if(isset($_SESSION['voucher']))
					{
						unset($_SESSION['voucher']);
						//echo "vô 3";
						echo "<script>alert('Voucher đã bị hủy vì cửa hàng đang áp dụng chương trình khuyến mãi')</script>";	
					}
					$makm = $re_km['makm'];
					if(isset($_SESSION['cart_ad']['QT000']))
					{
						if($_SESSION['cart_ad']['QT000']['maqt'] == $re_km['maqt'])
							$check_qt_hd = 1;
					}
				}
				else
				{
					if(isset($_SESSION['cart_ad']['QT000']))
						unset($_SESSION['cart_ad']['QT000']);
				}
			
			}
			
			if($check_qt_hd == 0) unset($_SESSION['cart_ad']['QT000']); //nếu mã qt ko khớp thì xóa QT000 để xuống dưới nó gán lại mặc định
			
			$string_qt_hd = count($arr_qt_hd) > 0 ? implode(',', $arr_qt_hd) : "''"; 		
			mysql_query("set names 'utf8'");
			$quatang_hd = mysql_query("select ctsp.mactsp, tensp, ctsp.mausac, duongdan from sanpham sp, chitietsanpham ctsp, hinhanh ha where sp.masp = ctsp.masp and sp.masp = ha.masp and ctsp.mactsp in ($string_qt_hd) group by ctsp.mactsp");
			if(mysql_num_rows($quatang_hd) > 0)
			{
				echo "<p class='title left'>QUÀ TẶNG KÈM</p><br />";
				echo ($string_qt_hd != "''" ?   "<p style='color: #000; font-size: 13px;'>Chọn một trong số các quà tặng sau:</p>" : "");
        		echo "<ul>";	
			}

			while($re_qt_hd = mysql_fetch_assoc($quatang_hd))
			{
		?>
        	<li>
            	<?php
				if(isset($_SESSION['cart_ad']))
				{
					if(array_key_exists('QT000', $_SESSION['cart_ad']))
					{
						
						if($_SESSION['cart_ad']['QT000']['maqt'] == $re_qt_hd['mactsp']) 
							echo "<div class='quatang-item' style='border: solid 2px #0cc'>";	
						else
							echo "<div class='quatang-item'>";	
					}
					else
					{
						$_SESSION['cart_ad']['QT000']['soluong'] = 1;
						$_SESSION['cart_ad']['QT000']['giaban'] = 0;
						$_SESSION['cart_ad']['QT000']['makm'] = '000';
						$_SESSION['cart_ad']['QT000']['maqt'] = $re_qt_hd['mactsp'];
						$_SESSION['cart_ad']['QT000']['chietkhau'] = 0;
						$_SESSION['cart_ad']['QT000']['tiengiamgia'] = 0;
						echo "<div class='quatang-item' style='border: solid 2px #0cc'>";	
					}
				}
				//gán mặc định
				else
				{
					echo "<div class='quatang-item'>";
					
				}
				?>
                	<a href='javascript:void(0)' data-qthd='<?php echo $re_qt_hd['mactsp'] ?>'>
                    	<img src="../image/mypham/<?php echo $re_qt_hd['duongdan'] ?>"/>
                        <p><?php echo $re_qt_hd['tensp'].($re_qt_hd['mausac'] != "" ? " - Màu sắc: ".$re_qt_hd['mausac']."" :"") ?></p>
                    </a>
               	</div>
                
            </li>
        <?php
			}
		?>
        	<div class="clear"></div>
        </ul>
        <div class="clear"></div>
    </div>

</div>



<div id='taohd-right'>
	
    <?php
		$tongtien = 0;
		
		/*
		//nếu có chiết khấu %
		if($chietkhau_hd > 0)
			$tongtien = (int)($tiensp - $tiensp * ($chietkhau_hd/100));
		//nếu có giảm tiền hoặc ko giảm tiền
		else 
			$tongtien = $tiensp - $giamgia_hd;
		*/
		
		if($giamgia_hd > 0)
			$tongtien = $tiensp - $giamgia_hd;
		else
			$tongtien = $tiensp;
		
		$voucher = 0;
		if(isset($_SESSION['voucher_ad']))
		{
			
			foreach($_SESSION['voucher_ad'] as $key => $value)
			{
				if($_SESSION['voucher_ad'][$key]['ngaybd'] <= $date && $_SESSION['voucher_ad'][$key]['ngaykt'] >= $date)
					$voucher +=$_SESSION['voucher_ad'][$key]['giatri'];
				else
				{
					unset($_SESSION['voucher_ad'][$key]);
					if(count($_SESSION['voucher_ad']) == 0)
						unset($_SESSION['voucher_ad']);	
				}
			}
			$tongtien -= $voucher;
		}
		$tongtien = $tongtien < 0 ? 0 : $tongtien;
		
	?>
    
<form method="post">
    
    <table width="100%" style="border-collapse: collapse">
   
    	<tr>
        	<td colspan="2">
            	<!--<input type='text' style='width: 270px;' class="txt-sp" placeholder="Nhập tên hoặc tài khoản khách hàng..."/>-->
                <div class='quick-search'>
                <form>
                    <input type='text' class="txt-sp" style="width: 270px;" id='keyword-kh' name='keyword' placeholder="Nhập tên hoặc tài khoản khách hàng..."/>
                    
                    <ul class = "quick-result" style="display: none;">
                         <div class="clear"></div>
                    </ul>         
                </form>
            	</div>
            </td>
        </tr>
        <tr>
        	<td>Tài khoản KH:</td>
            <td><input type='text' readonly="readonly" id='taikhoankh' name='taikhoankh' class="txt-sp" value='<?php echo $makh ?>'/></td>
        </tr>
        <tr>
        	<td >Họ tên người nhận:</td>
            <td ><input type='text' id='ten' name='ten' class="txt-sp" value='<?php echo $ten ?>'/></td>
        </tr>
        
        <tr>
        	<td >SĐT:</td>
            <td ><input type='text' id='sdt' name='sdt' class="txt-sp" value='<?php echo $sdt ?>'/></td>
        </tr>
        <tr>
        	<td>Địa chỉ giao hàng:</td>
            <td ><textarea type='text' id='diachi' name='diachi' class="txt-sp" style='height: 70px; text-align: justify'><?php echo $diachi ?></textarea></td>
        </tr>
    	<tr>
        	<td>Sử dụng: </td>
            <td><input type='text' style="width: 30px" id='diemsudung' name='diemsudung' class="txt-sp" value='<?php echo $diemsudung ?>'/><b>/</b><span id="diemtichluy" style='font-size: 18px;'></span><span style="font-size: 13px">điểm tích lũy</span></td>
        </tr>
    </table>
    
    <table cellspacing="50" width="100%" style="border-collapse:collapse">
    
    
    	<tr>
        	<td>Tổng tiền hàng:</td>
            <td class="right" ><input id='tiensp' type='text' class='txt-sp' readonly='readonly' value='<?php echo $tiensp ?>'/></td>
        </tr>
        
        <tr>
        	<td>Giảm KM:</td>
            <td class="right" ><input id='giamkm' type='text' class='txt-sp' readonly='readonly' value='<?php echo $chietkhau_hd > 0 ? $chietkhau_hd."%" : ($giamgia_hd > 0 ? $giamgia_hd : 0) ?>'/></td>
        </tr>
        
        <tr>
        	<td>Voucher:</td>
            <td class="right"><input id='voucher' readonly="readonly" type='text' class='txt-sp' value='<?php echo $voucher ?>' /></td>
        </tr>

        <tr>
        	<td>Chiết khấu:</td>
            <td class="right" ><input id='chietkhau' name='chietkhau' type='text' class='txt-sp' value="<?php echo $chietkhau_bill ?>" /></td>
        </tr>
        
		<tr>
        	<td>Thuế VAT:</td>
            <td class="right"><input id='thue' name='thue' readonly='readonly' type='text' class='txt-sp' value='<?php echo $thue ?>'/></td>
        </tr>
        
        <tr>
        	<td>Phí vận chuyển:</td>
            <td class="right" ><input id='pvc' name='pvc' type='text' class='txt-sp' value="<?php echo $phivanchuyen ?>"  /></td>
        </tr> 
        
        <tr>
        	<td>Tổng cộng:</td>
            <td class="right"  ><input style="font-size: 18px; font-weight: bold" id='tongcong' name='tongcong' type='text' class='txt-sp' readonly='readonly' value='<?php echo $tongtien ?>'/></td>
        </tr>
        
        <tr>
        	<td colspan="2"><input id = 'thanhtoan' name='thanhtoan' type='submit' style="width: 100%; text-align: center" class="sub" value='THANH TOÁN' /></td>
        </tr>       
        <!--lưu lại cái makm khi click vào thanh toán, tránh trg hợp khi vừa click xong mà nó hết km thì vẫn còn-->
    	<input type='hidden' name='makm' value='<?php echo $makm ?>'/>
    </table>
    </form>
    <form>
    	
         <ul id='list-voucher'>
        	<b></b>
        <?php
			if(isset($_SESSION['voucher_ad']))
			{
		
        		echo 	"<b>Các voucher được áp dụng:</b>";
            	
				foreach($_SESSION['voucher_ad'] as $key => $value)
				{
            		echo 	"<li>Mã phiếu: ".$key." (-".$_SESSION['voucher_ad'][$key]['giatri']."đ)<a href='javascript:void(0)' data-maphieu='$key' class='del-voucher'> - Xóa</a></li>";
				}
			}
		?>
        </ul>
    
    	<p style="font-size: 12px;">Bạn có mã giảm giá? <a href="javascript:void(0)" class='a-code' style="color: #06C; font-weight: bold;font-size: 12px;">Vui lòng click vào đây để nhập...</a></p>
        <div class='code'>
    		<input type='text'  id='magiamgia' value="" style="width: 159px; height: 30px; padding: 3px; border: solid 1px #ccc; border-radius: 3px; "/>
            <input type='button'  id = 'code-submit' value="Đồng ý"/>
        </div>
</form>
    
</div>

<div class="clear"></div>

<script>
	$(document).ready(function(e) {
        $('.a-code').click(function()
				{
					$('.code').show();	
				});
		$('#code-submit').click(function()
		{
			maphieu = $('#magiamgia').val();
			tienhd = $('#tiensp').val(); //alert('Tiền hd: '+tienhd);
			//tonggiam = parseFloat($('#tiengiamgia').val());
			//alert($('#tiengiamgia').val());
			
			$.ajax
			({
				url: "module/hoadon/xuly/voucher_xuly.php",
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
						
						$('#voucher').val(kq.tonggiam);
						//$('#').html(kq.tamtinh);
						//$('#price').val(kq.tamtinh); //alert($('#price').val());
						TinhTien();
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
			//tienhd = $('#tongcong').val();
			//alert(tienhd); alert(tiensp);
			$.ajax
			({
				url: "module/hoadon/xuly/voucher_xuly.php",
				data: "ac=xoa&maphieu="+maphieu+"&tiensp="+tiensp,
				type: "post",
				dataType: "json",
				async: true,
				success:function(kq)
				{
					
					$("a[data-maphieu='"+maphieu+"']").closest('#list-voucher li').fadeOut();
					
					if(kq.soluong == 0)
						$('#list-voucher').hide();
					//tiền sp
					//$('#tiensp').val(kq.tienhd);
					//tổng bill
					//$('#tongcong').val(kq.tienhd); 
					$('#voucher').val(kq.tonggiam);
					$('#magiamgia').val('');
					TinhTien();
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
		
		function TinhTien()
		{
			tiensp = parseFloat($('#tiensp').val()); 
			giamkm = parseFloat($('#giamkm').val() == ""  ? 0 : $('#giamkm').val()); 
			voucher = parseFloat($('#voucher').val() == ""  ? 0 : $('#voucher').val());
			chietkhau = parseFloat($('#chietkhau').val() == "" ? 0 : $('#chietkhau').val());
			thue = parseFloat($('#thue').val() == ""  ? 0 : $('#thue').val());
			pvc = parseFloat($('#pvc').val() == "" ? 0 : $('#pvc').val());
			//alert(tiensp + ' - ' + giamkm + ' - ' + voucher + ' - thue: ' + thue );
			tongcong =  tiensp - giamkm - voucher;  //alert('tong: ' + tongcong);
			//tongcong =  tongcong - (tongcong * (chietkhau/100)) + pvc;
			tongcong =  tongcong - chietkhau + pvc;
			tongcong =  tongcong < 0 ? 0 : tongcong; 
			$('#tongcong').val(tongcong);	
		}
		
		$('#quatang').delegate('li a', 'click', function()
		{
			maqt_hd = $(this).attr('data-qthd');
			$.ajax
			({
				url: "module/hoadon/xuly/taohd_xuly.php",
				data: "ac=chonqt&maqt_hd="+maqt_hd,
				type: "post",
				async: true,
				success:function(kq)
				{
					$('#quatang .quatang-item').css('border', 'none');
					$("a[data-qthd='"+maqt_hd+"']").closest(".quatang-item").css('border', 'solid 2px #0CC');
				}
			});	
		});
    });
	
	
</script>

<?php //echo "<pre>"; echo print_r($_SESSION['cart_ad']); echo "</pre>"; ?>