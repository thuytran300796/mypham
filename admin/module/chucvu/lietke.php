<script>

	$(document).ready(function(e) {
        $('#close-submit').click(function()
		{
			$('.popup').fadeOut();
			//return false;
		});
		
		$('#btn-cv').click(function()
		{
	
			$('.popup').fadeIn('fast'); 
		});
		
		$('#ten_cv, #hesoluong, #phucap').keyup(function()
		{
			$(this).next('.error').hide();
		});
		
		$('#add-cv').click(function()
		{
			tencv = $('#ten_cv').val();
			hesoluong = $('#hesoluong').val();
			phucap = $('#phucap').val();
			check = 1;
				
			if(tencv == "")
			{
				check = 0;
				$('#ten_cv').next('.error').show();	
			}
			if(hesoluong == "")
			{
				check = 0;
				$('#hesoluong').next('.error').show();	
			}	
			if(phucap == "")
			{
				check = 0;
				$('#phucap').next('.error').show();	
			}	
			
			if(check == 1)
			{
				$.ajax
				({
					url: "module/chucvu/xuly/xuly.php",
					data: "ac=them&tencv="+tencv+"&hesoluong="+hesoluong+"&phucap="+phucap,
					type: "post",
					async: true,
					success:function(kq)
					{
						alert('Thêm thành công');
						$('.popup').fadeOut('fast'); 
						$('#ten_cv').val("");
						$('#hesoluong').val("");
						$('#phucap').val("");
						$('.tb-lietke').append(kq);
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
			}
		});
		
		$('.tb-lietke').delegate('.del-cv','click',function()
		{
			if(confirm('Bạn có chắc chắn muốn xóa không?'))
			{
				id = $(this).attr('data-id');
				$.ajax
				({
					url: "module/chucvu/xuly/xuly.php",
					data: "ac=xoa&macv="+id,
					type: "post",
					async: true,
					success:function(kq)
					{
						alert('Xóa thành công');
						$("a[data-id='"+id+"']").closest('tr').hide();
					}	
				});
				return false;	
			}
		});
		
    });

</script>

<?php
	
	mysql_query("set names 'utf8'");
	$chucvu = mysql_query("select * from chucvu where trangthai = 1");	
	
?>

	
    
    <div id="nhacungcap">
    	
        <p class="title">CHỨC VỤ</p><br />

        <input type='button' id='btn-cv' value = 'Thêm mới' class="sub" style="float: right; margin-right: 30px"/><br /><div class="clear"></div>
        <table class = "tb-lietke"  border="1" >
        
            <tr>
                <th width="15%">Mã chức vụ</th>
                <th width="25%">Tên chức vụ</th>
                <th width="25%">Hệ số lương</th>
                <th width="15%">Phụ cấp</th>
                <!--<th width="7%">Sửa</th>-->
                <th width="7%">Xóa</th>
            </tr>
           
        <?php
            while($re_cv = mysql_fetch_assoc($chucvu))
			{
		?>
                <tr>
                    <td><?php echo $re_cv['MaCV'] ?></td>
                    <td><?php echo $re_cv['TenCV'] ?></td>
                    <td><?php echo $re_cv['HeSoLuong']?> </td>
                    <td><?php echo number_format($re_cv['PhuCap']) ?> đ</td>
                    <!--<td align="center"><a href = "admin.php?quanly=chucvu&ac=sua&id=<?php echo $re_cv['MaCV'] ?>">Sửa</a></td>-->
                    <td align="center"><a href = "javascript:void(0)" class='del-cv' data-id="<?php echo $re_cv['MaCV'] ?>">Xóa</a></td>
                </tr>
        <?php
			}
		?>
            
        </table>
    
    </div>
    
<div id='pop-chucvu' class="popup" style="width: 45%; height: 300px; border: solid 1px; position: absolute; top: 15%; left: 35%;background: #EFF8FB; margin: auto; display: none">

	<div>
    	<h3>Thêm chức vụ</h3>
        <img style="float: right; padding-top: 5px; padding-right: 5px;" src="../image/close.PNG" id='close-submit'/>
    </div>

	<form>
            	<!--<input type='hidden' name='quanly' value='nhacc'/>-->
                <table>
                    <tr>
                        <td> Tên chức vụ:</td>
                        <td>
                        	<input type='text' class='txt-sp' id='ten_cv' value=''/>
                        	<span class="error" style="display: none">Vui lòng nhập tên chức vụ</span></td>
                    </tr>
                    <tr>
                        <td>Hệ số lương:</td>
                        <td><input type='text' class='txt-sp' id='hesoluong' value=''/>
                        <span class="error" style="display: none">Vui lòng nhập hệ số chức vụ</span></td>
                    </tr>
                    <tr>
                        <td>Phụ cấp:</td>
                        <td><input type='text' class='txt-sp' id='phucap' value=''/>
                    	<span class="error" style="display: none">Vui lòng nhập phụ cấp</span></td>
                    </tr>
                    <tr>
                    	<td></td>
                        <td><input type='button' class="sub" style="width: 220px" id='add-cv'  value='Thêm' />
                        </td>
                    </tr>
                </table>
            </form>
</div>