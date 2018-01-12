

<script>

	function Check_LoaiKM()
	{
		loaikm = $('#loaikm').val();
		if(loaikm == 'QT')
		{
			$('#noidung-km').attr('placeholder', 'Nhập tên hoặc mã sản phẩm');
			$('#noidung-km').attr('data-noidung', 'qt');
			$('#title-km').html("Chọn quà tặng: ");
			$('#list-qt').show();
			$('#voucher').hide();
		}
		else if(loaikm == '%')
		{
			$('#noidung-km').attr('placeholder', 'Nhập % giảm giá');
			$('#noidung-km').attr('data-noidung', '%');
			$('#title-km').html("Giảm: ");
			$('#list-qt').hide();
			$('#voucher').hide();
			<?php unset($_SESSION['list-qt']); ?>
					//alert('%');
		}
		else if(loaikm == 'VND')
		{
			$('#noidung-km').attr('placeholder', 'Nhập số tiền giảm giá');
			$('#noidung-km').attr('data-noidung', 'tien');
			$('#title-km').html("Giảm: ");
			$('#list-qt').hide();
			$('#voucher').hide();
			<?php unset($_SESSION['list-qt']); ?>
					//alert('VND');
		}
		else if(loaikm == 'PMH')
		{
			$('#noidung-km').attr('placeholder', 'Nhập giá trị voucher');
			$('#noidung-km').attr('data-noidung', 'voucher');
			$('#title-km').html("Trị giá: ");
			$('#list-qt').hide();
			//$('#voucher').show();
			<?php unset($_SESSION['list-qt']); ?>
			//alert('PMH');
		}	
	}

	function Check_LoaiAD()
	{
		loaiad = $('#loaiad').val();

		if(loaiad == 'all')
		{
			$('#doituong').fadeOut();
			$('#spad').hide();
		}
		else if(loaiad == 'trigia')
		{
			$('#doituong').attr('placeholder', 'Nhập trị giá đơn hàng');
			$('#doituong').attr('data-doituong', 'trigia');
			$('#doituong').fadeIn();
			$('#spad').hide();
		}
		else if(loaiad == 'sp')
		{
			$('#doituong').attr('placeholder', 'Nhập mã hoặc tên sản phẩm ');
			$('#doituong').attr('data-doituong', 'sp');
			$('#doituong').fadeIn();
		}
	}
	
	$(document).ready(function(e)
	{
		/*
		if($('#loaiad').val() == 'all')
		{
			$('#doituong').fadeOut();
			$('#spad').hide();
		}
		*/
		Check_LoaiKM();Check_LoaiAD();
	
        check_qt = check_spad = 1;
		$('#loaikm').change(function()
		{
			Check_LoaiKM();
			return false;
		});
		
		$('.quick-result').mouseleave(function()
		{
			$('.quick-result').hide();
		});
		
		$('#loaiad').change(function()
		{
			Check_LoaiAD();
			return false;
		});
		
		$('#noidung-km').keyup(function()
		{
			if($(this).attr('data-noidung') == 'qt')
			{
				keyword = $(this).val();
				//alert(keyword);
				if(keyword == "")
					$('.quick-result').css('display', 'none');
				else
				{
					$.ajax
					({
						url: "module/khuyenmai/xuly/xuly.php",
						type: "post",
						data: "ac=get_qt&keyword="+keyword,
						async: true,	
						success:function(kq)
						{
							$('.quick-result').css('display', 'block');
							$('.quick-result').css('left', '300px');
							$('.quick-result').html(kq);
						}
					});
				}
			}
			else if($(this).attr('data-noidung') == '%')
			{
				
			}
			else 
			{
				
			}
			return false;
		});
		
		$('#doituong').keyup(function()
		{
			if($(this).attr('data-doituong') == 'sp')
			{
				keyword = $(this).val();
				//alert(keyword);
				if(keyword == "")
					$('.quick-result').css('display', 'none');
				else
				{
					$.ajax
					({
						url: "module/khuyenmai/xuly/xuly.php",
						type: "post",
						data: "ac=get_sp&keyword="+keyword,
						async: true,	
						success:function(kq)
						{
							$('.quick-result').css('display', 'block');
							$('.quick-result').css('left', '850px');
							$('.quick-result').html(kq);
						}
					});
				}
			}
			else if($(this).attr('data-doituong') == 'trigia')
			{
				
			}
			return false;
		});
		
		//click thêm quà tặng
		$('#themkm .quick-result').delegate('.ctsp-qt', 'click', function()
		{
			//maqt = $('.ctsp-qt').attr('data-ctspqt');
			maqt = $(this).attr('data-ctspqt');
			//alert(maqt);
			$('#list-qt').show();
			
			$.ajax
			({
				url: "module/khuyenmai/xuly/xuly.php",
				type: "post",
				data: "ac=get_info&maqt="+maqt,
				async: true,	
				success:function(kq)
				{
					$('#list-qt ul').append(kq);
					//$("a[data-ctsp='"+maqt+"']").closest('li').hide();
					$("a[data-ctspqt='"+maqt+"']").closest(".quick-result li").hide();
				}
			});
			
			return false;
		});
		
		//click xóa quà tặng
		$('#themkm #list-qt').delegate('.del-ctspqt', 'click', function()
		{
			//maqt = $('.ctsp-qt').attr('data-ctspqt');
			maqt = $(this).attr('data-ctspqt');
			alert(maqt);
			
			$.ajax
			({
				url: "module/khuyenmai/xuly/xuly.php",
				type: "post",
				data: "ac=del_qt&maqt="+maqt,
				async: true,	
				success:function(kq)
				{
					$("a[data-ctspqt='"+maqt+"']").closest("#list-qt li").hide();
					//alert(kq);
					if(kq == '0')
					{
						$('#list-qt').hide();
						check_qt = 0;
					}
				}
			});
			
			return false;
		});
		
		//bấm chọn sản phẩm áp dụng
		$('#themkm .quick-result').delegate('.spad', 'click', function()
		{
			maspad = $(this).attr('data-spad');
		
			$.ajax
			({
				url: "module/khuyenmai/xuly/xuly.php",
				type: "post",
				data: "ac=get_infosp&maspad="+maspad,
				async: true,
				//dataType: "json",	
				success:function(kq)
				{
					$('#spad p:eq(1)').html(kq);
					$('#spad p:eq(1)').css('padding-left', '10px');
					$('#spad').show();
				}
			});
		
			return false;
		});
		$('#themkm #spad').delegate('.del-spad', 'click', function()
		{
			maspad = $(this).attr('data-spad');
			//alert(maspad);
			
			$.ajax
			({
				url: "module/khuyenmai/xuly/xuly.php",
				type: "post",
				data: "ac=del_spad&maspad="+maspad,
				async: true,
				//dataType: "json",	
				success:function(kq)
				{
					$('#spad').hide();
				}
			});		
		
			return false;
		});
		
		
		$('#ok').click(function()
		{
			alert('makm: '+$('#makm').val());
			
			check = 1;
			sl = "0";
			
			loaikm = $('#loaikm').val();
			if(loaikm != 'QT')
			{

				if($('#noidung-km').val() == "")
				{
					$('.error-loaikm').html('Vui lòng nhập trị giá');
					$('.error-loaikm').fadeIn();
					check = 0;
				}
				else
				{
					if(isNaN($('#noidung-km').val()))	
					{
						$('.error-loaikm').html('Chỉ được nhập số từ 0 đến 9');
						$('.error-loaikm').fadeIn();
						check = 0;	
					}
				}
			}
			
			loaiad = $('#loaiad').val();
			if(loaiad == 'trigia')
			{
				if($('#doituong').val() == "")
				{
					$('.error-loaiad').html('Vui lòng nhập trị giá đơn hàng');
					$('.error-loaiad').fadeIn();
					check = 0;
				}
				else
				{
					if(isNaN($('#doituong').val()))	
					{
						$('.error-loaiad').html('Chỉ được nhập số từ 0 đến 9');
						$('.error-loaiad').fadeIn();
						check = 0;	
					}

				}
			}

			if(check == 1)
			{
				makm = $('#makm').val(); alert(makm);
				noidung = $('#noidung-km').val();
				doituong = $('#doituong').val();
				mota = $('#mota').val();
				ngaybd = $('#ngaybd').val(); ngaykt = $('#ngaykt').val();
				//voucher_bd = $('#voucher-bd').val(); voucher_kt = $('#voucher-kt').val();
				data = "ac=suakm&makm="+makm+"&loaikm=" + loaikm + "&loaiad=" + loaiad + "&noidung=" +noidung+ "&doituong=" +doituong+ "&mota="+mota+"&ngaybd="+ngaybd+"&ngaykt="+ngaykt;
				//data = "ac=themkm&loaikm=" + loaikm + "&loaiad=" + loaiad + "&noidung=" +noidung+ "&doituong=" +doituong+ "&mota="+mota+"&ngaybd="+ngaybd+"&ngaykt="+ngaykt;
				alert(data);
				$.ajax
				({
					url: "module/khuyenmai/xuly/xuly.php",
					type: "post",
					data: data,
					dataType: 'json',
					async: true,
					success:function(kq)
					{
						//$('#test').html(kq);
						if(kq.error_sp != "")
						{
							$('.error-loaiad').html(kq.error_sp);
							$('.error-loaiad').fadeIn();	
						}
						if(kq.error_qt != "")
						{
							$('.error-loaikm').html(kq.error_qt);
							$('.error-loaikm').fadeIn();	
						}
						if(kq.notify == "Thành công")
						{
							alert('Chỉnh sửa thông tin thành công');
							//window.onunload();
							//Load();
							<?php unset($_SESSION['list-qt']); unset($_SESSION['spad']); ?>	
							window.location.replace("admin.php?quanly=khuyenmai&ac=lietke");
						}
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
			}
			
			//alert(check);
			return false;
		});
		
		$('#doituong').keyup(function()
		{
			$('.error-loaiad').fadeOut();
		});
		
		$('#noidung-km').keyup(function()
		{
			$('.error-loaikm').fadeOut();	
		});
		
		window.onunload = function ()
		{
			//return "Do you really want to close?";
			
			if(myWindow.closed)
			{
				<?php unset($_SESSION['list-qt']); unset($_SESSION['spad']); ?>	
				//alert('load');
			}
			
		};
		
    });

	function Load()
	{
		window.onunload = function ()
		{
			//return "Do you really want to close?";
			if(myWindow.closed)
			{
				<?php //unset($_SESSION['list-qt']); //unset($_SESSION['spad']); ?>	
			}
			
		};
	}

</script>

<?php
	
	$makm = $_GET['makm'];
	mysql_query("set names 'utf8'");
	$km = mysql_query("	select	km.makm, km.masp, km.chietkhau, km.tiengiamgia, km.giatrivoucher, km.giatridonhang, mota, ctkm.ngaybd, ctkm.ngaykt
						from	khuyenmai km, ctsp_km ctkm
						where	km.makm = ctkm.makm and km.makm = '$makm'");
	$re_km = mysql_fetch_assoc($km);
	
	$loaikm = $loaiad = $noidung = $doituong = $spad = NULL;
	$list_qt = array();
	$ngaybd = $re_km['ngaybd']; $ngaykt = $re_km['ngaykt'];
	
	if($re_km['chietkhau'] != "0")
	{
		$loaikm = "%";
		$noidung = $re_km['chietkhau'];
	}
	else if($re_km['tiengiamgia'] != "0")
	{
		$loaikm = "VND";
		$noidung = $re_km['tiengiamgia'];
	}
	else if($re_km['giatrivoucher'] != "0")
	{
		$loaikm = "PMH";
		$noidung = $re_km['giatrivoucher'];
	}
	else if($re_km['chietkhau']==0 &&  $re_km['tiengiamgia']==0  && $re_km['giatrivoucher']==0)
	{
		$loaikm = "QT";
		mysql_query("set names 'utf8'");
		$quatang = mysql_query("select 	ctsp.masp, ctkm.mactsp, tensp, ctsp.mausac
								from	ctsp_km ctkm, khuyenmai km, sanpham sp, chitietsanpham ctsp
								where	ctkm.makm = km.makm and sp.masp = ctsp.masp and ctsp.mactsp = ctkm.mactsp
									and km.makm = '".$re_km['makm']."'");	
		while($re_qt = mysql_fetch_assoc($quatang))
		{
			$_SESSION['list-qt'][] = $re_qt['mactsp'];
			$list_qt[] = "<li>"."<p>".$re_qt['tensp'].".".($re_qt['mausac'] == "" ? "" : " - Màu sắc: ".$re_qt['mausac']).""."<a href='javascript:void(0)' class='del-ctspqt' data-ctspqt='".$re_qt['mactsp']."' > - Xóa</a>".count($_SESSION['list-qt'])."</p>"."</li>";
			
			//$re_qt['tensp'].($re_qt['mausac']=="" ? "" : " - Màu sắc: ".$re_qt['mausac'])."<a href='javascript:void(0)' class='del-ctspqt' data-ctspqt='".$re_qt['mactsp']."'> - Xóa</a>";
		}
		//echo count($_SESSION['list-qt']);
	}
	
	if($re_km['giatridonhang'] != "0")
	{
		$loaiad = "trigia";
		$doituong = $re_km['giatridonhang'];
	}
	else if($re_km['giatridonhang'] == "0" && $re_km['masp'] == "")
	{
		$loaiad = "all";
	}
	else if($re_km['masp'] != "")
	{
		echo "nè:". $re_km['masp'];
		$loaiad = "sp";
		mysql_query("set names 'utf8'");
		$sanpham = mysql_query("select masp, tensp, tenncc from sanpham sp, nhacungcap ncc where sp.mancc = ncc.mancc and masp = '".$re_km['masp']."'");
		$re_sp = mysql_fetch_assoc($sanpham);
		$_SESSION['spad'][0]['masp'] = $re_sp['masp'];
		$_SESSION['spad'][0]['tensp'] = $re_sp['tensp']." - Nhà cung cấp: ".$re_sp['tenncc']."<a href ='javascript:void(0)' class='del-spad' data-spad='".$re_sp['masp']."'> - Xóa</a>";

	}
	
?>

<?php

	if(isset($_SESSION['list-qt']))
	{	
		echo "QT:"."<pre>"; print_r($_SESSION['list-qt']); echo "</pre>";
	}
	else
		echo "ko QT";
		
	if(isset($_SESSION['spad']))
	{	
		echo "SP:"."<pre>"; print_r($_SESSION['spad']); echo "</pre>";
	}
	else
		echo "ko SP";

?>

<form method="post">
<div id='themkm' style="width: 95%; margin: auto; position: relative">

	<p class="title">CHỈNH SỬA THÔNG TIN KHUYẾN MÃI</p>
	<input type="hidden" id='makm' value="<?php echo $_GET['makm'] ?>" style="display: none;">
	<table width="100%" cellspacing="20px">
    
    	<tr>
        	<td width="9%" style="color: #f90; font-size: 13px; font-weight: bold">Loại khuyến mãi</td>
            <td class="item-km">
            
            	<select id='loaikm' name='loaikm' class="cbb-sp">
            
                	<?php
					
                    	if($loaikm == '%')
						{
							echo "<option selected='selected' value='%'>Giảm theo %</option>";
							echo "<option value='VND'>Giảm theo VND</option>";
							echo "<option value='QT'>Quà tặng</option>";
							echo "<option value='PMH'>Phiếu mua hàng</option>";
						}
						else if($loaikm == 'VND')
						{
							echo "<option value='%'>Giảm theo %</option>";
							echo "<option selected='selected' value='VND'>Giảm theo VND</option>";
							echo "<option value='QT'>Quà tặng</option>";
							echo "<option value='PMH'>Phiếu mua hàng</option>";
						}
						else if($loaikm == 'QT')
						{
							echo "<option value='%'>Giảm theo %</option>";
							echo "<option value='VND'>Giảm theo VND</option>";
							echo "<option selected='selected' value='QT'>Quà tặng</option>";
							echo "<option value='PMH'>Phiếu mua hàng</option>";
						}
						else if($loaikm == 'PMH')
						{
							echo "<option value='%'>Giảm theo %</option>";
							echo "<option value='VND'>Giảm theo VND</option>";
							echo "<option value='QT'>Quà tặng</option>";
							echo "<option selected='selected' value='PMH'>Phiếu mua hàng</option>";
						}
						else
						{
							echo "<option value='%'>Giảm theo %</option>";
							echo "<option value='VND'>Giảm theo VND</option>";
							echo "<option value='QT'>Quà tặng</option>";
							echo "<option value='PMH'>Phiếu mua hàng</option>";
						}
						
					?>
                    
                    
                   
                </select>
                <span id='title-km'>Giảm: </span><input id='noidung-km'  data-noidung='%' class="txt-sp" value="<?php echo $noidung ?>"/>
                
                <span>Áp dụng cho: </span>
                <select id='loaiad' name='loaiad' class="cbb-sp">
                	<?php
						if($loaiad == 'all')
						{
							echo "<option selected='selected' value='all'>Tất cả đơn hàng</option>";
							echo "<option value='trigia'>Trị giá đơn hàng từ:</option>";
							echo "<option value='sp'>Sản phẩm</option>";
						}
						else if($loaiad == 'trigia')
						{
							echo "<option value='all'>Tất cả đơn hàng</option>";
							echo "<option selected='selected' value='trigia'>Trị giá đơn hàng từ:</option>";
							echo "<option value='sp'>Sản phẩm</option>";
						}
						else if($loaiad == 'sp')
						{
							echo "<option value='all'>Tất cả đơn hàng</option>";
							echo "<option value='trigia'>Trị giá đơn hàng từ:</option>";
							echo "<option selected='selected' value='sp'>Sản phẩm</option>";
						}
						else
						{
							echo "<option value='all'>Tất cả đơn hàng</option>";
							echo "<option value='trigia'>Trị giá đơn hàng từ:</option>";
							echo "<option value='sp'>Sản phẩm</option>";
						}
					?>
                	
                    
                    
                </select>
                
                <input class="txt-sp" id='doituong' data-doituong='all' value="<?php echo $doituong ?>"/>
                
                <div style="width: 88%; height: 20px;">
                	<span class="error error-loaikm" style="float: left; display: none; width: 45%; text-align: right; "></span>
                	<span class="error error-loaiad" style="float: right; display: none; width: 45%; text-align: right;  "></span>
        		</div>
                <div class="clear"></div>
                
                <div id='spad' style=" margin-top: 20px;">
                	<p><i>Sản phẩm áp dụng</i></p>
                    <p>
                    	<?php
                        	if(isset($_SESSION['spad']))
								echo $_SESSION['spad'][0]['tensp'];
						?>
                    </p>
                </div>
            
                
                <div id='list-qt' style=" margin-top: 20px;">
                    <p><i>Các sản phẩm được tặng kèm</i></p>
                    <ul >
                    	<?php
						if(isset($list_qt))
						{
							foreach($list_qt as $key => $value)
							{
								echo "$value";	
							}
						}
						?>
                    </ul>
                </div>
                
                <div id='voucher' style='display: none;'>
                	<table cellspacing="10px">
                    	<tr>
                        	<td>PMH có hiệu lực từ: </td>
                            <td><input type='date' id='voucher-bd' class="txt-sp" value="<?php echo $ngaybd ?>"/></td>
                        </tr>
                        <tr>
                        	<td>đến: </td>
                            <td><input type='date' id='voucher-kt' class="txt-sp" value="<?php echo $ngaykt ?>"/></td>
                        </tr>
                    </table>
                </div>
                
                <ul class = "quick-result">
                	
            	</ul>

            </td>
        </tr>
        
        <tr>
        	<td width="9%" style="color: #f90; font-size: 13px; font-weight: bold">Mô tả:</td>
            <td class="item-km"><textarea id="mota" style="border: solid 1px #ccc; border-radius: 3px; padding: 10px 10px;" cols="70" rows="5"></textarea></td>
        </tr>
        
        <tr>
        	<td width="9%" style="color: #f90; font-size: 13px; font-weight: bold">Thời hạn áp dụng</td>
            <td class="item-km">
            	<span>Bắt đầu áp dụng từ: </span><input type='date' id='ngaybd' name = 'ngaybd' value="<?php echo $ngaybd ?>" class="txt-sp"/> (mm-dd-yyyy)
                <span>Kết thúc vào: </span><input type='date' id='ngaykt' name = 'ngaykt' value="<?php echo $ngaykt ?>" class="txt-sp"/> (mm-dd-yyyy)
            </td>
        </tr>
        
        <tr>
        	<td></td>
        	<td><input type='submit' id='ok' class="sub" value="Chỉnh sửa"/></td>
        </tr>
    
    </table>

</div>
</form>

<div id='test'>aaa</div>