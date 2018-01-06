<script>

	$(document).ready(function(e) {
        
		$('#keyword').keyup(function()
		{
			keyword = $('#keyword').val();
			//alert(keyword);
			
			if(keyword == "")
				$('#pn-left .quick-result').css('display', 'none');
			else
			{
				$.ajax
				({
					url: "module/sanpham/xuly/xuly_nhapkho.php",
					type: "post",
					data: "ac=search&keyword="+keyword,
					async: true,	
					success:function(kq)
					{
						$('#pn-left .quick-result').css('display', 'block');
						$('#pn-left .quick-result').html(kq);
					}
				});				
			}
			
			return false;	
		});
		
		$('#pop-sp #keyword-sp').keyup(function()
		{
			keyword = $('#keyword-sp').val();
			//alert(keyword);
			
			if(keyword == "")
				$('#pop-sp .quick-result').css('display', 'none');
			else
			{
				$.ajax
				({
					url: "module/sanpham/xuly/xuly_nhapkho.php",
					type: "post",
					data: "ac=search_sp&keyword="+keyword,
					async: true,	
					success:function(kq)
					{
						$('#pop-sp .quick-result').css('display', 'block');
						$('#pop-sp .quick-result').html(kq);
					}
				});				
			}
			
			return false;	
		});
		
		$('.quick-result').mouseleave(function()
		{
			$('.quick-result').hide();
		});
		
		
		$('#pn-left .quick-result').delegate('a', 'click', function()
		{
			id = $(this).attr('data-id');
			
			$.ajax
			({
				url: "module/sanpham/xuly/xuly_nhapkho.php",
				type: "post",
				data: "ac=get_ctsp&id="+id,
				async: true,	
				success:function(kq)
				{
					$('#pn-left table').append(kq);
				}		
			});
			return false;
		});
		
		$('#pop-sp .quick-result').delegate('a', 'click', function()
		{
			id = $(this).attr('data-id'); 
			
			$.ajax
			({
				url: "module/sanpham/xuly/xuly_nhapkho.php",
				type: "post",
				data: "ac=get_sp&id="+id,
				async: true,	
				dataType: 'json',
				success:function(kq)
				{
					$('#masp').val(kq.masp);
					$('#tensp').val(kq.tensp);
					$('#tenncc').val(kq.tenncc);
				}		
			});
			return false;
		});
		
		$('#add').click(function()
		{
			id = $('#masp').val();
			mausac = $('#mausac').val();
			ngaysx = $('#ngaysx').val();
			hsd = $('#hsd').val();
			giaban = $('#giaban').val();
			gianhap = $('#gianhap').val();	
			tensp = $('#tensp').val();
			tenncc = $('#tenncc').val();
			$.ajax
			({
				url: "module/sanpham/xuly/xuly_nhapkho.php",
				type: "post",
				data: "ac=them_ctsp&masp="+id+"&mausac="+mausac+"&ngaysx="+ngaysx+"&hsd="+hsd+"&giaban="+giaban+"&gianhap="+gianhap+"&tensp="+tensp+"&tenncc="+tenncc,
				async: true,	
				success:function(kq)
				{
					$('#pop-sp').hide();
					$('#pn-left table').append(kq);
				}		
			});
			return false;
		});
		
		$('#pn-left').delegate('.btn-plus', 'click', function()
		{
			id = $(this).attr('data-id'); 
			soluong = parseInt($('.txt-soluong-'+id).val());
			soluong = soluong + 1;
			
			$.ajax
			({
				url: "module/sanpham/xuly/xuly_nhapkho.php",
				type: "post",
				data: "ac=change_soluong&id=" + id + "&soluongmoi=" + soluong,
				async: true,
				success:function(kq)
				{
					$('.txt-soluong-'+id).val(soluong);	

				}	
			});
			ThayDoi_GiaNhap();
			return false;	
		});
		$('#pn-left').delegate('.btn-sub', 'click', function()
		{
			
			id = $(this).attr('data-id');  //alert(ctsp);
			soluong = parseInt($('.txt-soluong-'+id).val());
			soluong = (soluong - 1) == 0 ? 1 : (soluong-1); //alert(soluong);
					
			$.ajax
			({
				url: "module/sanpham/xuly/xuly_nhapkho.php",
				type: "post",
				data: "ac=change_soluong&id=" + id + "&soluongmoi=" + soluong,
				async: true,
				success:function(kq)
				{
					$('.txt-soluong-'+id).val(soluong);
				}
			});
			ThayDoi_GiaNhap();
			
			return false;
		});
		
		$('#pn-left table').delegate('.gianhap', 'keyup', function()
		{
			id = $(this).attr('data-id'); 
			ThayDoi_GiaNhap();
		});
		
		$('.error').hide();
		
		$('#nhapkho').click(function()
		{
			$.ajax
			({
				url: "module/sanpham/xuly/xuly_nhapkho.php",
				type: "post",
				data: "ac=nhapkho",
				async: true,
				success:function(kq)
				{
					alert("Nhập kho thành công!");
					window.location("admin.php?quanly=sanpham");	
				}
			});
		});
		
		$('#close-submit').click(function()
		{
			$('#pop-sp').fadeOut();
		});
		
		$('#themctsp').click(function()
		{
			$('#pop-sp').fadeIn();
		});
		
		function ThayDoi_GiaNhap()
		{
			
			gianhap = $('.gianhap'+id).val(); 
			$.ajax
			({
				url: "module/sanpham/xuly/xuly_nhapkho.php",
				type: "post",
				data: "ac=change_gianhap&id="+id+"&gianhap="+gianhap,
				dataType: 'json',
				async: true,	
				success:function(kq)
				{
					$('.thanhtien'+id).val(kq.thanhtien);
					$('#tongtien').val(kq.tongtien);
				}		
			});
			return false;
		}
    });

</script>

<?php
	if(isset($_SESSION['nhapkho'])) unset($_SESSION['nhapkho']);//echo "<pre>"; print_r($_SESSION['nhapkho']); echo "</pre>";
	date_default_timezone_set('Asia/Ho_Chi_Minh');
	$date = date('Y-m-d');	
	
	function Tao_PN()
	{
		$phieunhap = mysql_query('select MaPhieu from PhieuNhap');
		
		if(mysql_num_rows($phieunhap) == 0)
			return 'PN1';
		
		$re_pn = mysql_fetch_assoc($phieunhap);
		$number = substr($re_pn['MaPhieu'], 2);
				
		while($re_pn = mysql_fetch_assoc($phieunhap))
		{
			$temp = substr($re_pn['MaPhieu'], 2);
			if($number < $temp)
				$number = $temp;
		}
		
		return 'PN'.++$number;
					
	}
?>

<p class="title">NHẬP HÀNG</p><br />

<div id='pn-left'>

	<div class='quick-search'>
    	<form>
        	<input type='text' class="txt-sp" style="width: 400px;" id='keyword' name='keyword' placeholder="Nhập mã hoặc tên sản phẩm..."/>
           	<input value='+' id='themctsp' type="button" class="sub" style="width: 38px; height: 32px; text-align: center; font-size: 36px; line-height: 20px; font-weight: bold; position: absolute; top: 0px; margin-left: 10px;"/>
            
            <ul class = "quick-result">
                
                    <div class="clear"></div>
            </ul>
            
            
        </form>
    </div>
    <div class="clear"></div>

	<table width="100%" style="border-collapse:collapse">
        	
            <tr>
            	<th width='3%'>Xóa</th>
            	<th width='17%'>Mã sản phẩm</th>
                <th width='30%'>Tên sản phẩm</th>
                <th width='17%'>Số lượng</th>
                <th width='13%'>Đơn giá</th>
                <th width='15%'>Thành tiền</th>
            </tr>
            

    	 	<!--
            <tr data-id=''>
            	<td><a href='javascript:void(0)' class='del' data-id=''><img src='../image/del.png' /></a></td>
            	<td>Mã SP nè</td>
                <td><b>Tên SP nè</b></td>
                <td align="center"><input type='submit' class='btn-sub' data-id='' value='-' />
                    <input type="text" readonly="readonly" class="txt-soluong txt-soluong-<?php echo '' ?> " value="1"/>
                    <input type='submit' class='btn-plus' data-id='' value='+' /></td>
                <td>
                	<input type='text' class='txt-sp gianhap-' style="width: 100px; text-align: right" value=''/>	
                </td>
                <td align="right"><input type='text' readonly='readonly' class='txt-sp thanhtien-' style='width: 100px; text-align: right' value=''/></td>
            </tr>
         	-->
      </table>
	

</div>

<form>
<div id='pn-right' >

	<table>
    
    	<tr>
        	<td>Mã phiếu nhập:</td>
            <td><?php echo Tao_PN() ?></td>
        </tr>
        
        <tr>
        	<td>Ngày tạo:</td>
            <td><?php echo date('d-m-Y') ?></td>
        </tr>
        
         <tr>
        	<td>Người nhập:</td>
            <td><?php echo $_SESSION['name'] ?></td>
        </tr>
        
        <tr>
        	<td>Tổng tiền:</td>
            <td><input type='text' style='width: 120px; font-size: 17px; font-weight: bold; text-align: right;' class="txt-sp" readonly='readonly' id='tongtien' value="0"/></td>
        </tr>
        
        <tr>
            <td colspan="2"><input type='submit' id='nhapkho' style='width: 100%; background: #f90'  class="sub" value="NHẬP HÀNG"/></td>
        </tr>
    
    </table>

</div>
</form>

<div id='pop-sp'>
	<div style='height: 40px; background: #f90'>
    	<h3>Thêm chi tiết sản phẩm</h3>
        <img style="float: right; padding-top: 5px; padding-right: 5px;" src="../image/close.PNG" id='close-submit'/>
    </div>
    
    <div class='quick-search' style='background: none;'>
    	<form>
        	<input type='text' class="txt-sp" style="width: 400px;" id='keyword-sp' name='keyword' placeholder="Nhập mã hoặc tên sản phẩm..."/>
        
            <ul class = "quick-result">
               	<div class="clear"></div>
            </ul>
            
            
        </form>
    </div>


	<form>
            	<!--<input type='hidden' name='quanly' value='nhacc'/>-->
                <table>
                	<input type='hidden' value='' id='masp'/>
                    <tr>
                        <td>Tên sản phẩm:</td>
                        <td><input type='text' readonly="readonly" class="txt-sp" id='tensp' value=''/></td>
                    </tr>
                    
                    <tr>
                        <td>Nhà cung cấp:</td>
                        <td><input type='text' readonly="readonly" class="txt-sp" id='tenncc' value=''/></td>
                    </tr>
                
                    <tr>
                        <td>Màu sắc:</td>
                        <td><input type='text' class="txt-sp" id='mausac' value=''/></td>
                    </tr>
                    
                    <tr>
                        <td>Ngày sản xuất:</td>
                        <td><input type='date' class="txt-sp" id='ngaysx' value='<?php echo $date ?>'/><span> (mm/dd/yyyy)</span></td>
                    </tr>
                    <tr>
                        <td>Hạn sử dụng:</td>
                        <td><input type='date' class="txt-sp" id='hsd' value='<?php echo $date ?>'/><span> (mm/dd/yyyy)</span></td>
                    </tr>
                    <tr>
                        <td>Giá nhập:</td>
                        <td><input type='text' style='text-align: right;' class="txt-sp" id='gianhap' value=''/><span class="error"> Vui lòng nhập giá nhập</span></td>
                    </tr>
                    <tr>
                        <td>Giá bán:</td>
                        <td><input type='text' style='text-align: right;' class="txt-sp" id='giaban' value=''/><span class="error"> Vui lòng nhập giá bán</span></td>
                    </tr>
                    <tr>
                    	<td></td>
                        <td><input type='button' id='add' class='sub' style='width: 170px;' value='Thêm' />
                        </td>
                    </tr>
                </table>
            </form>
</div>
