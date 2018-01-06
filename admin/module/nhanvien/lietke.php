<?php
	$keyword= "";
	mysql_query("set names 'utf8'");
	$nhanvien = mysql_query("	select manv, tennv, gioitinh, ngaysinh, diachi, sodienthoai, cmnd
								from nhanvien
								where trangthai = 1");
	
	if(isset($_POST['search']))
	{
		$keyword = mysql_escape_string($_POST['keyword']);
		mysql_query("set names 'utf8'");
		$nhanvien = mysql_query("	select manv, tennv, gioitinh, ngaysinh, diachi, sodienthoai, cmnd
									from nhanvien
									where trangthai = 1 and (tennv LIKE '%$keyword%' or manv LIKE '%$keyword%')");
	}
?>

<script>

	$(document).ready(function(e)
	{
   		$('.error').hide();
		
		$('#close-submit, #cancle').click(function()
		{
			$('.popup').fadeOut(); Reset_Popup();
			//return false;
		});
		
		$('#ten').keyup(function()
		{
			$('#ten').next('.error').fadeOut();	
		});
		
		$('#nv-add').click(function()
		{
			//alert('a');
			$('.popup div h3').html('Thêm nhân viên');
			$('.pop-sub').attr
			({
				value: "Thêm mới",
				id: "add"	
			});
			$('.popup').fadeIn();	
		});
		
		$('.tb-lietke').delegate('.edit', 'click', function()
		{
			id = $(this).attr('data-id');
			$('.pop-sub').attr
			({
				value: "Chỉnh sửa",
				id: "edit"	
			});
			ajax('get_data', id);
			$('.popup').fadeIn();
			//alert(id);	
		});
		
		$('.tb-lietke').delegate('.del', 'click', function()
		{
			if(confirm("Bạn có chắc chắn muốn vô hiệu hóa tài khoản này không?"))
			{
				id = $(this).attr('data-id');
				ajax('del', id);	
			}
		});
		
		$('.pop-sub').click(function()
		{
			if($('#ten').val() == "")
			{
				$('#ten').next('.error').fadeIn();
			}
			else
			{
			//coi là thêm hay sửa
				action = $(this).attr('id');
				
				if(action == 'add')
				{
					ajax('add');	
				}
				else if(action == 'edit')
				{
					ajax('edit', id);
				}
			}
			return false;
		});
		
		function ajax(action, id)
		{
			if(action == 'add')
			{
				ten = $('#ten').val();
				gioitinh = $('#gioitinh').val();
				ngaysinh = $('#ngaysinh').val();
				diachi = $('#diachi').val();
				sdt = $('#sdt').val();
				cmnd = $('#cmnd').val();
				data = "ac=add&ten="+ten+"&gioitinh="+gioitinh+"&ngaysinh="+ngaysinh+"&diachi="+diachi+"&sdt="+sdt+"&cmnd="+cmnd;	
			}
			else if(action == 'get_data')
			{
				data = "ac=get_data&id="+id;	
			}
			else if(action == 'edit')
			{
				ten = $('#ten').val();
				gioitinh = $('#gioitinh').val();
				ngaysinh = $('#ngaysinh').val();
				diachi = $('#diachi').val();
				sdt = $('#sdt').val();
				cmnd = $('#cmnd').val();
				data = "ac=edit&id="+id+"&ten="+ten+"&gioitinh="+gioitinh+"&ngaysinh="+ngaysinh+"&diachi="+diachi+"&sdt="+sdt+"&cmnd="+cmnd;	
			}
			else
			{
				data = "ac=del&id="+id;	
			}
			$.ajax
			({
				url: "module/nhanvien/xuly/xuly.php",
				type: "post",
				data: data,
				dataType: 'json',
				async: true,
				success:function(kq)
				{
					if(action == 'add')
					{
						$('.popup').fadeOut('fast', function()
						{
							//html = "<tr><td>"+kq.manv+"</td><td>"+kq.ten+"</td><td>"+kq.gioitinh+"</td><td>"+kq.ngaysinh+"</td><td>"+kq.cmnd+"</td><td>"+kq.diachi+"</td><td>"+kq.sdt+"</td><td align='center'><a href='javascript:void(0)' class='edit' data-id='"+kq.manv+"'>Sửa</a></td><td align='center'><a href='javascript:void(0)' class='del' data-id='"+kq.manv+"'>Vô hiệu hóa</a></td></tr>";
							$('#nhanvien .tb-lietke').append("<tr><td>"+kq.manv+"</td><td>"+kq.ten+"</td><td>"+kq.gioitinh+"</td><td>"+kq.ngaysinh+"</td><td>"+kq.cmnd+"</td><td>"+kq.diachi+"</td><td>"+kq.sdt+"</td><td align='center'><a href='javascript:void(0)' class='edit' data-id='"+kq.manv+"'>Sửa</a></td><td align='center'><a href='javascript:void(0)' class='del' data-id='"+kq.manv+"'>Vô hiệu hóa</a></td></tr>");
							//$('#test').html(kq.manv);
						});
						Reset_Popup();
						alert('Thêm thành công!');
					}
					else if(action == 'get_data')
					{
						$('#ten').val(kq.ten); $('#gioitinh').val(kq.gioitinh); $('#ngaysinh').val(kq.ngaysinh);
						$('#cmnd').val(kq.cmnd); $('#diachi').val(kq.diachi); $('#sdt').val(kq.sdt);
					}
					else if(action === 'edit')
					{
						$('.popup').fadeOut('fast', function()
						{
							$("a[data-id='"+id+"']").closest('.tb-lietke tr').find('td:eq(1)').html(kq.ten);
							$("a[data-id='"+id+"']").closest('.tb-lietke tr').find('td:eq(2)').html(kq.gioitinh);
							$("a[data-id='"+id+"']").closest('.tb-lietke tr').find('td:eq(3)').html(kq.ngaysinh);
							$("a[data-id='"+id+"']").closest('.tb-lietke tr').find('td:eq(4)').html(kq.cmnd);
							$("a[data-id='"+id+"']").closest('.tb-lietke tr').find('td:eq(5)').html(kq.diachi);
							$("a[data-id='"+id+"']").closest('.tb-lietke tr').find('td:eq(6)').html(kq.sdt);
							Reset_Popup();
							alert('Chỉnh sửa thành công!');
						});
					}
					else
					{
						alert('Thao tác thành công!');
						$("a[data-id='"+id+"']").closest('.tb-lietke tr').fadeOut();		
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
		
    });
	
	function Reset_Popup()
	{
		$('#ten').val(""); $('#ngaysinh').val("");
		$('#cmnd').val(""); $('#diachi').val(""); $('#sdt').val("");	
	}

</script>

<div id='nhanvien' style='width: 100%; margin: auto;'>

	<p class="title">DANH SÁCH NHÂN VIÊN</p>
        
    
        <div style='width: 100%; height: 50px; margin: 3% auto 1%; '>
        	<form method='post'>
        	<div style=" width: 92%; float: left; text-align: right">
            	<input type='text' class='txt-sp' value='<?php echo $keyword ?>' name = 'keyword' style="width: 300px" placeholder="Nhập tên hoặc mã nhân viên..."/>
                <input type='submit' class='sub' name='search' value='Tìm'/>
            </div>
            </form>   
             

            <div style=" width: 7%; float: right;">
            	<input type='button'  value='Thêm mới' id="nv-add" class="sub" />
            </div>

        </div>
        
    <div class="clear"></div>

	<table width="100%" class='tb-lietke' border="1">
    	
        <tr>
        	<th width="10%">Mã NV</th>
            <th width="17%">Tên nhân viên</th>
            <th width="7%">Giới tính</th>
            <th width="10%">Ngày sinh</th>
            <th width="10%">CMND</th>
            <th width="20%">Địa chỉ</th>
            <th width="10%">SĐT</th>
            <th width="5%">Sửa</th>
            <th width="8%">Vô hiệu hóa</th>
        </tr>
        
	<?php
		while($re_nv = mysql_fetch_assoc($nhanvien))
		{
	?>
        <tr>
      		<td><?php echo $re_nv['manv'] ?></td>  
            <td><?php echo $re_nv['tennv'] ?></td>  
            <td><?php echo ($re_nv['gioitinh'] == 0 ? "Nữ" : "Nam")  ?></td>  
            <td><?php echo $re_nv['ngaysinh'] ?></td>  
            <td><?php echo $re_nv['cmnd'] ?></td>  
            <td><?php echo $re_nv['diachi'] ?></td>  
            <td><?php echo $re_nv['sodienthoai'] ?></td>  
            <td align="center"><a href="javascript:void(0)" class="edit" data-id='<?php echo $re_nv['manv'] ?>'>Sửa</a></td>
            <td align="center"><a href="javascript:void(0)" class="del" data-id='<?php echo $re_nv['manv'] ?>'>Vô hiệu hóa</a></td>
        </tr>
    <?php
		}
	?>
    </table>
</div>


<div class="popup" style="top: 15%; display: none;">
    	
        <div>
            <h3></h3>
            <img style="float: right; padding-top: 5px; padding-right: 5px;" src="../image/close.PNG" id='close-submit'/>
        </div>
            
        
        	<table>
            	<tr>
                	<td>Tên nhân viên:</td>
                	<td><input class="txt-sp" type='text' id='ten' value=''/><span class="error"> Vui lòng nhập tên</span></td>
             	</tr>
                    
                <tr>
                    <td>Giới tính:</td>
                    <td>
                    	<select style="width: 270px;" class="cbb-sp" id='gioitinh'>
                        	<option value='1'>Nam</option>
                            <option value='0'>Nữ</option>
                        </select>
                    </td>
                 </tr>
                 
                 <tr>
                    <td>Ngày sinh:</td>
                    <td><input class="txt-sp" style="width: 250px;" type='date' id='ngaysinh' value=''/></td>
                 </tr>
                 
                 <tr>
                     <td>CMND:</td>
                     <td><input class="txt-sp" type='text' id='cmnd' value='' /></td>
                 </tr>
                 
                 <tr>
                     <td>Địa chỉ:</td>
                     <td><textarea  id = 'diachi' ></textarea></td>
                 </tr>
                 
                 <tr>
                     <td>Số điện thoại:</td>
                     <td><input class="txt-sp" type='text' id='sdt' value='' /></td>
                 </tr>
                 
                 <tr>
                    <td></td>
                    <td><input type='submit'  class='pop-sub' value='' />
                        <input type='submit' id="cancle" value='Thoát'/>
                    </td>
                 </tr>
                 
                </table>
            
        </div>
        
    </div>