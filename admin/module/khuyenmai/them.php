<script>

	$(document).ready(function(e) {
        
		$('#loaikm').change(function()
		{
			loaikm = $(this).val();

			if(loaikm == 'QT')
			{
				$('#noidung-km').attr('placeholder', 'Nhập tên hoặc mã sản phẩm');
				$('#noidung-km').attr('data-noidung', 'qt');
				$('#title-km').html("Chọn quà tặng: ");
			}
			else if(loaikm == '%')
			{
				$('#noidung-km').attr('placeholder', 'Nhập % giảm giá');
				$('#noidung-km').attr('data-noidung', '%');
				$('#title-km').html("Giảm: ");
			}
			else
			{
				$('#noidung-km').attr('placeholder', 'Nhập số tiền giảm giá');
				$('#noidung-km').attr('data-noidung', 'tien');
				$('#title-km').html("Giảm: ");
			}
		});
		
		$('#loaiad').change(function()
		{
			loaiad = $(this).val();

			if(loaiad == 'all')
			{
				$('#doituong').fadeOut();
			}
			else if(loaiad == 'trigia')
			{
				$('#doituong').attr('placeholder', 'Nhập trị giá đơn hàng');
				$('#doituong').attr('data-doituong', 'trigia');
				$('#doituong').fadeIn();
			}
			else
			{
				$('#doituong').attr('placeholder', 'Nhập mã hoặc tên sản phẩm ');
				$('#doituong').attr('data-doituong', 'sp');
				$('#doituong').fadeIn();
			}
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
		
		
		$('#themkm .quick-result').delegate('.ctsp-qt').click(function()
		{
			//maqt = $('.ctsp-qt').attr('data-ctspqt');
			maqt = $(this).attr('data-ctspqt');
			alert(maqt);
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
				}
			});
			
			return false;
		});
		
    });

</script>


<div id='themkm' style="width: 95%; margin: auto; position: relative">

	<p class="title">THÊM KHUYẾN MÃI</p>

	<table width="100%" cellspacing="20px">
    
    	<tr>
        	<td width="9%" style="color: #f90; font-size: 13px; font-weight: bold">Loại khuyến mãi</td>
            <td class="item-km">
            
            	<select id='loaikm' class="cbb-sp">
                	<option value='%'>Giảm theo %</option>
                    <option value='VND'>Giảm theo VND</option>
                    <option value='QT'>Quà tặng</option>
                </select>
                <span id='title-km'>Giảm</span><input id='noidung-km' data-noidung='%' class="txt-sp" value=""/>
                
                <span>Áp dụng cho: </span>
                <select id='loaiad' class="cbb-sp">
                	<option value='all'>Tất cả đơn hàng</option>
                    <option value='trigia'>Trị giá đơn hàng từ:</option>
                    <option value='sp'>Sản phẩm</option>
                </select>
                
                <input class="txt-sp" id='doituong' data-doituong='all' value=""/>
                
				<br /><br />
                <div id='list-qt' style="display: none">
                    <p><i>Các sản phẩm được tặng kèm</i></p>
                    <ul >
                    </ul>
                </div>
                
                <ul class = "quick-result">
                	
            	</ul>

            </td>
        </tr>
        
        <tr>
        	<td width="9%" style="color: #f90; font-size: 13px; font-weight: bold">Thời hạn áp dụng</td>
            <td class="item-km">
            	<span>Bắt đầu áp dụng từ: </span><input type='date' class="txt-sp"/>
                <span>Kết thúc vào: </span><input type='date' class="txt-sp"/>
            </td>
        </tr>
        
        <tr>
        	<td></td>
        	<td><input type='submit' class="sub" value="Thêm"/></td>
        </tr>
    
    </table>

</div>