

<script>

	$(document).ready(function(e) {
		
		$('.quick-result').mouseleave(function()
		{
			$('.quick-result').hide();
		});
		
        check_qt = check_spad = 1;
		$('#loaikm').change(function()
		{
			loaikm = $(this).val();
			
			//alert(loaikm);
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
			}
			else if(loaikm == 'VND')
			{
				$('#noidung-km').attr('placeholder', 'Nhập số tiền giảm giá');
				$('#noidung-km').attr('data-noidung', 'tien');
				$('#title-km').html("Giảm: ");
				$('#list-qt').hide();
				$('#voucher').hide();
				<?php unset($_SESSION['list-qt']); ?>
			}
			else if(loaikm == 'PMH')
			{
				$('#noidung-km').attr('placeholder', 'Nhập giá trị voucher');
				$('#noidung-km').attr('data-noidung', 'voucher');
				$('#title-km').html("Trị giá: ");
				$('#list-qt').hide();
				//$('#voucher').show();
				<?php unset($_SESSION['list-qt']); ?>
			}
			return false;
		});
		
		$('#loaiad').change(function()
		{
			loaiad = $(this).val();

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
			//alert(maqt);
			
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
				noidung = $('#noidung-km').val();
				doituong = $('#doituong').val();
				mota = $('#mota').val();
				ngaybd = $('#ngaybd').val(); ngaykt = $('#ngaykt').val();
				voucher_bd = $('#voucher-bd').val(); voucher_kt = $('#voucher-kt').val();
				data = "ac=themkm&loaikm=" + loaikm + "&loaiad=" + loaiad + "&noidung=" +noidung+ "&doituong=" +doituong+ "&mota="+mota+"&ngaybd="+ngaybd+"&ngaykt="+ngaykt+"&voucher_bd="+voucher_bd+"&voucher_kt"+voucher_kt;
				//data = "ac=themkm&loaikm=" + loaikm + "&loaiad=" + loaiad + "&noidung=" +noidung+ "&doituong=" +doituong+ "&mota="+mota+"&ngaybd="+ngaybd+"&ngaykt="+ngaykt;
				//alert(data);
				$.ajax
				({
					url: "module/khuyenmai/xuly/xuly.php",
					type: "post",
					data: data,
					dataType: 'json',
					async: true,
					success:function(kq)
					{
						$('#test').html(kq);
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
							//alert('Thêm thành công');
							//window.onunload();
							//Load();
							<?php //unset($_SESSION['list-qt']); //unset($_SESSION['spad']); ?>	
							window.location.replace("admin.php?quanly=khuyenmai&ac=lietke");
						}
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
				<?php unset($_SESSION['list-qt']); unset($_SESSION['spad']); ?>	
			}
			
		};
	}

</script>

<?php
	//unset($_SESSION['list-qt']);
	date_default_timezone_set('Asia/Ho_Chi_Minh');
	$date = date('Y-m-d');
	$ngaybd = $ngaykt = $date;
	//echo $date;
	/*
	if(isset($_SESSION['list-qt']))
	{	
		echo "<pre>"; print_r($_SESSION['list-qt']); echo "</pre>";
	}
	else
		echo "ko";
	
	if(isset($_SESSION['spad']))
	{	
		echo "<pre>"; print_r($_SESSION['spad']); echo "</pre>";
	}
	else
		echo "ko";
		*/
	if(isset($_POST['ok']))
	{
		//nhớ unset SESSION[list-qt] và SESSION[spad]
		//echo "hey";
		
		$loaikm = $_POST['loaikm'];
		$loaiad = $_POST['loaiad'];
		$ngaybd = $_POST['ngaybd'];
		$ngaykt = $_POST['ngaykt'];
	}
	
?>

<form method="post">
<div id='themkm' style="width: 95%; margin: auto; position: relative">

	<p class="title">THÊM KHUYẾN MÃI</p>

	<table width="100%" cellspacing="20px">
    
    	<tr>
        	<td width="9%" style="color: #f90; font-size: 13px; font-weight: bold">Loại khuyến mãi</td>
            <td class="item-km">
            
            	<select id='loaikm' name='loaikm' class="cbb-sp">
                	<option value='%'>Giảm theo %</option>
                    <option value='VND'>Giảm theo VND</option>
                    <option value='QT'>Quà tặng</option>
                    <option value='PMH'>Phiếu mua hàng</option>
                	<?php
					/*
                    	if($loaikm == '%')
						{
							echo "<option selected='selected' value='%'>Giảm theo %</option>";
							echo "<option value='VND'>Giảm theo VND</option>";
							echo "<option value='QT'>Quà tặng</option>";
						}
						else if($loaikm == 'VND')
						{
							echo "<option value='%'>Giảm theo %</option>";
							echo "<option selected='selected' value='VND'>Giảm theo VND</option>";
							echo "<option value='QT'>Quà tặng</option>";
						}
						else if($loaikm == 'QT')
						{
							echo "<option value='%'>Giảm theo %</option>";
							echo "<option value='VND'>Giảm theo VND</option>";
							echo "<option selected='selected' value='QT'>Quà tặng</option>";
						}
						else
						{
							echo "<option value='%'>Giảm theo %</option>";
							echo "<option value='VND'>Giảm theo VND</option>";
							echo "<option value='QT'>Quà tặng</option>";
						}
						*/	
					?>
                    
                    
                   
                </select>
                <span id='title-km'>Giảm: </span><input id='noidung-km'  data-noidung='%' class="txt-sp" value=""/>
                
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
                
                <input class="txt-sp" style="display: none" id='doituong' data-doituong='all' value=""/>
                
                <div style="width: 88%; height: 20px;">
                	<span class="error error-loaikm" style="float: left; display: none; width: 45%; text-align: right; ">Vui lòng abc</span>
                	<span class="error error-loaiad" style="float: right; display: none; width: 45%; text-align: right;  ">Vui lòng abc</span>
        		</div>
                <div class="clear"></div>
                
                <div id='spad' style="display: none; margin-top: 20px;">
                	<p><i>Sản phẩm áp dụng</i></p>
                    <p>
                    
                    </p>
                </div>
            
                        
                <div id='list-qt' style="display: none; margin-top: 20px;">
                    <p><i>Các sản phẩm được tặng kèm</i></p>
                    <ul >
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
        	<td><input type='submit' id='ok' class="sub" value="Thêm"/></td>
        </tr>
    
    </table>

</div>
</form>

<!--<div id='test'>aaa</div>-->