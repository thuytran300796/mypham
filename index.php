<?php
	session_start();
	//unset($_SESSION['list-mausac']['1']);
	if(isset($_SESSION['list-mausac']))
	{
		echo "<pre>";
		print_r($_SESSION['list-mausac']);
		echo "</pre>";	
	}
	
	unset($_SESSION['list-mausac']);
	
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
    	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    	<title>Trang chủ</title>
        <script src="js/jquery-1.12.4.js"></script>
        <script>

			$(document).ready(function(e) {
                
				$('#themctsp').click(function()
				{
					
					//ẩn soluongsp
					$('#soluongsp').closest("tr").fadeOut("fast");
						
					//alert('e');
					mausac = $('.mausac').val();
					soluongctsp = $('.soluongctsp').val();
					$.ajax
					({
							
						url: "xuly.php",
						type: "post",
						data: "action=themctsp&mausac=" + mausac + "&soluongctsp=" + soluongctsp,
						dataType: "json",
						async: true,
						success:function(kq)
						{
							//nếu có lỗi nhập liệu
							if(kq.errorsl == 'errorsl')
							{
								//alert('lỗi sl');
								$('#nhaplieu tr:eq(1) td:last').css('display', 'block');
								$('#nhaplieu tr:eq(1) td:last').html('Vui lòng nhập ký tự từ 0 đến 9');
								$('.mausac').val(kq.mausac);
							}
							else
							{
								
								//if($('#list-ctsp th').length == 0)
								length = $('#list-ctsp tr').length;
								$('#nhaplieu tr:eq(1) td:last').css('display', 'none');
								//alert(kq.id);
								if(length == 0)
								{
									//$('#list-ctsp').html(kq);
									$('#list-ctsp').append("<tr><td>"+kq.mausac+"</td><td>"+kq.soluongctsp+"</td><td><a  href='#' data-ctid='"+kq.id+"' class = 'del-ctsp'>Xóa</a></td><td><a  href='#' data-ctid='"+kq.id+"' class = 'sua-ctsp'>Sửa</a></td></tr>");
								}
								else
								{
									//$('#list-ctsp tr:eq('+(length-1)+')').after(kq);
									$('#list-ctsp tr:eq('+(length-1)+')').after("<tr><td>"+kq.mausac+"</td><td>"+kq.soluongctsp+"</td><td><a  href='#' data-ctid='"+kq.id+"' class = 'del-ctsp'>Xóa</a></td><td><a  href='#' data-ctid='"+kq.id+"' class = 'sua-ctsp'>Sửa</a></td></tr>");
								}
							}
						}
					});
					$('.mausac').val("");
					$('.soluongctsp').val("");
					
					return false;
				});
				
				$('#list-ctsp').delegate('.del-ctsp', 'click', function()
				{
					id = $(this).attr('data-ctid');
					//alert(id);
					$.ajax
					({
						url: "xuly.php",
						type: "post",
						data: "action=delctsp&id=" + id,
						async: true,
						success:function(kq)
						{
							//lựa chọn "tr" nằm bên ngoài thẻ a có data-ctid = id
							$("a[data-ctid	= '" + id +"']").closest("tr").fadeOut("fast");	
						}
					});
					return false;
				});
				
				$('list-ctsp').delegate('.sua-ctsp', 'click', function()
				{
					id = $(this).attr('data-id');
					$.ajax
					({
						
					});
				});
				
				$('#checkbox').change
				(
					function()
					{
						check = $('#checkbox').prop('checked');
						if(check)
						{
							$('#phanloai').css('display', 'block');
							$('#parent').css('opacity', '0.6');
							$('#soluongsp').closest("tr").hide();	
						}
						else
						{
							$('#phanloai').css('display', 'none');	
							$('#soluongsp').closest("tr").show();
							$('#parent').css('opacity', '1');
						}
					}
				);
				
				
				
            });
		
		</script>
        
        <style>

			#parent
			{
				width: 100%;
				height: 100%;	
				position: relative;
			}
			
			#phanloai
			{
				position: absolute;	
				width: 40%; border: solid 1px; padding: 30px;
				margin:auto;
				top: 2%; left: 35%;
				background: #CCC;
				display: none;
			}
			
			.error
			{
				font-color: #F00;
			}	
		
		</style>
        
    </head>

    <body>
    
    <form >
    
    	
    
    	<div id = 'parent'>
    	
        	<table>
            	<tr>
                	<td>Mã SP:</td>
                    <td><input type='text' name = 'masp'/></td>
                </tr>
                <tr>
                	<td>Tên SP:</td>
                    <td><input type='text' name = 'tensp'/></td>
                </tr>
                <tr>
                	<td>Thương hiệu:</td>
                    <td><input type='text' name = 'thuonghieu'/></td>
                </tr>
                <tr>
                	<td>Phân loại theo màu sắc:</td>
                	<td><input type = 'checkbox' id = 'checkbox'/></td>
                </tr>
                <tr>
                	<td>Số lượng:</td>
                    <td><input type='text' name = 'soluongsp' id = "soluongsp"/></td>
                </tr>
                <tr>
                	<td></td>
                    <td><input type='submit' value = 'Thêm' name = 'them'/></td>
                </tr>
            </table>

            
            
        	
        </div>
        
        <div id = 'phanloai' >
            
                <table id='nhaplieu'>
                
                    <tr>
                        <td>Màu sắc:</td>
                        <td><input type='text' name = 'mausac' class = 'mausac'/></td>
                        <td class = 'error'></td>
                    </tr>
                    
                    <tr>
                        <td>Số lượng:</td>
                        <td><input type='text' name = 'soluongctsp' class = 'soluongctsp'/></td>
                        <td class = 'error'></td>
                    </tr>
                    
                    <tr>
                    	<td></td>
                        <td><input value = 'Thêm' id = 'themctsp' name = 'themctsp' type="submit"/></td>
                    </tr>
                
                </table>
                
                <!--Chứa các record về màu sắc và số lượng-->
                <table id = 'list-ctsp' style="border-collapse: collapse 1px">
                
                </table>
    

            </div>
            

    
    </form>
    
    </body>
    
</html>