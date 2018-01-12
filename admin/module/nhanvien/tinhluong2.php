<script>

	$(document).ready(function(e) {
       
	   $('.quick-result').mouseleave(function()
		{
			$('.quick-result').hide();
		});
	   
	   $('#keyword').keyup(function()
		{
			keyword = $('#keyword').val();
			//alert(keyword);
			
			if(keyword == "")
				$('#luong-left .quick-result').css('display', 'none');
			else
			{
				$.ajax
				({
					url: "module/nhanvien/xuly/luong_xuly.php",
					type: "post",
					data: "ac=search&keyword="+keyword,
					async: true,	
					success:function(kq)
					{
						$('#luong-left .quick-result').css('display', 'block');
						$('#luong-left .quick-result').html(kq);
					}
				});				
			}
			
			return false;	
		});
		
		$('#luong-left .quick-result').delegate('a', 'click', function()
		{
			id = $(this).attr('data-id'); 
			
			$.ajax
			({
				url: "module/nhanvien/xuly/luong_xuly.php",
				type: "post",
				data: "ac=get_nv&id="+id,
				async: true,	
				success:function(kq)
				{
					$('#luong-left table').append(kq);
				}		
			});
			return false;
		});
		
		$('#luong-left table').delegate('#chucvu', 'change', function()
		{
			macv = $(this).val(); 
			manv = $(this).attr('data-id');
			$.ajax
			({
				url: "module/nhanvien/xuly/luong_xuly.php",
				type: "post",
				data: "ac=get_cv&macv="+macv+"&manv="+manv,
				async: true,	
				dataType: "json",
				success:function(kq)
				{
					//alert(kq.heso + " - " + kq.phucap);
					$('.heso'+manv).val(kq.heso);
					$('.phucap'+manv).val(kq.phucap);

				}		
			});
			return false;
		});
		
		$('#luong-left table').delegate('#songaycong', 'keyup', function()
		{
			songaycong = $(this).val();
			$.ajax
			({
				url: "module/nhanvien/xuly/luong_xuly.php",
				type: "post",
				data: "ac=songaycong&value="+songaycong+"&manv="+manv,
				async: true,	
				success:function(kq)
				{
					//alert(kq.heso + " - " + kq.phucap);
					$('.tong'+manv).val(kq);
				}		
			});
			return false;
		});
		
		$('#luong-left table').delegate('#luongcb', 'keyup', function()
		{
			luongcb = $(this).val();
			$.ajax
			({
				url: "module/nhanvien/xuly/luong_xuly.php",
				type: "post",
				data: "ac=luongcb&value="+luongcb+"&manv="+manv,
				async: true,	
				success:function(kq)
				{
					alert(luongcb);
					$('.tong'+manv).val(kq);
				}		
			});
			return false;
		});
		
		$('#luong-left table').delegate('#thuong', 'keyup', function()
		{
			thuong = $(this).val(); 
			$.ajax
			({
				url: "module/nhanvien/xuly/luong_xuly.php",
				type: "post",
				data: "ac=thuong&value="+thuong+"&manv="+manv,
				async: true,	
				success:function(kq)
				{
					alert(kq);
					$('.tong'+manv).val(kq);
				}	
			});
			return false;
		});
		
		$('#luong-left table').delegate('#phat', 'keyup', function()
		{
			phat = $(this).val();
			$.ajax
			({
				url: "module/nhanvien/xuly/luong_xuly.php",
				type: "post",
				data: "ac=phat&value="+phat+"&manv="+manv,
				async: true,	
				success:function(kq)
				{
					$('.tong'+manv).val(kq);
				}		
			});
			return false;
		});
	    
	});

</script>

<?php
	//if(isset($_SESSION['luong'])) unset($_SESSION['luong']);
	//unset($_SESSION['luong']);
	echo "<pre>"; print_r($_SESSION['luong']); echo "</pre>";
?>


<div id='luong-left' style='width:98%'>
	<div class='quick-search'>
    	<form>
        	<input type='text' class="txt-sp" style="width: 400px; text-align: left" id='keyword' name='keyword' placeholder="Nhập mã hoặc tên nhân viên..."/>

            <ul class = "quick-result">
                
                    <div class="clear"></div>
            </ul>
        </form>
    </div>
    <div class="clear"></div>
    
    <table width="100%" style="border-collapse:collapse">
        	
            <tr>
            	<th width='3%'>Xóa</th>
            	<th width='8%'>Mã NV</th>
                <th width='12%'>Tên nhân viên</th>
                <th width='12%'>Chức vụ</th>
                <th width='6%'>Hệ số</th>
                <th width='10%'>Phụ cấp</th>
                <th width='10%'>Số ngày công</th>
                <th width='10%'>Lương cơ bản</th>
                <th width='10%'>Thưởng</th>
                <th width='10%'>Phạt</th>
                <th width='12%'>Tổng</th>
            </tr>
            
            <tr>
            	<td><img src='../image/del.png' /></td>
                <td>NV1</td>
                <td>Phạm Thị Thủy Trân</td>
                <td><select class='cbb-sp' id='chucvu'>
                		<option value='nhanvien'>Nhân viên</option>
                        <option value='quanly'>Quản lý</option>
                	</select>
                </td>
 				<td><input class='txt-sp' readonly='readonly' id='heso' type='text'/></td>
 				<td><input class='txt-sp' readonly='readonly' id='phucap' type='text'/></td>
                <td><input class='txt-sp' id='songaycong' type='text'/></td>
                <td><input class='txt-sp' id='luongcb' type='text'/></td>
                <td><input class='txt-sp' id='thuong' type='text'/></td>
                <td><input class='txt-sp' id='phat' type='text'/></td>
                <td><input class='txt-sp' readonly='readonly' id='tong' type='text'/></td>
 			</tr>
      </table>
</div>
