<?php
	ob_start();

	$loi = array();
	$loi['id'] = $loi['ten'] = $loi['diachi'] = $loi['sdt'] = $ten = $email= $diachi = $id = $sdt = $ghichu = NULL;
	$check = 1;
	
	$id = $_REQUEST['id'];
	//echo $id;
	mysql_query("SET NAMES 'utf8'");
	
	$re_ncc = mysql_query("select * from nhacungcap where mancc = '$id'");
	
	$dong = mysql_fetch_assoc($re_ncc);
	
	if(!isset($_POST['ok']))
	{
		$ten = $dong['TenNCC'];
		$diachi = $dong['DiaChi'];
		$sdt = $dong['SDT'];
		$email = $dong['Email'];
		$ghichu = $dong['GhiChu'];
		$trangthai = $dong['TrangThai'];
	}
	else
	{
			
		if(empty($_POST['ten']))
		{
			$loi['ten'] = "Vui lòng nhập tên nhà cung cấp!";
			$ten = "";
			$check = 0;
		}
		else
			$ten = $_POST['ten'];
			

		$diachi = $_POST['diachi'];
			
	
		$sdt = $_POST['sdt'];
		
		$email = $_POST['email'];
		$ghichu = $_POST['ghichu'];
			
		if($check == 1)
		{
		
			mysql_query("set names 'utf8'");

			$result = mysql_query("update nhacungcap set tenncc = '$ten', email = '$email', diachi = '$diachi', sdt = '$sdt', ghichu = '$ghichu' where MaNCC = '$id'");
			

			echo "<script>alert('Chỉnh sửa thành công!')</script>";
			header('location: admin.php?quanly=nhacc&ac=them');
		
			
		}

	}
	

?>

<p class="title">CẬP NHẬT THÔNG TIN NHÀ CUNG CẤP</p><br />


<form method="post">
            	<!--<input type='hidden' name='quanly' value='nhacc'/>-->
                <table>
                    <tr>
                        <td>Tên nhà cung cấp:</td>
                        <td><input type='text' name='ten' value='<?php echo $ten ?>'/></td>
                    </tr>
                    <?php
		
						if(!empty($loi['ten']))
						{
					?>
							<tr>
								<td></td>
								<td class = 'error'><?php echo $loi['ten']?></td>
							</tr>
					<?php
						}
					?>
                    <tr>
                        <td>Số điện thoại:</td>
                        <td><input type='text' name='sdt' value='<?php echo $sdt ?>'/></td>
                    </tr>
                    <tr>
                        <td>Email:</td>
                        <td><input type='text' name='email' value='<?php echo $email ?>'/></td>
                    </tr>
                    <tr>
                        <td>Địa chỉ:</td>
                        <td><textarea  name = 'diachi' ><?php echo $diachi ?></textarea></td>
                    </tr>
                    <tr>
                        <td>Ghi chú:</td>
                        <td><textarea  name = 'ghichu' ><?php echo $ghichu ?></textarea></td>
                    </tr>
                    <tr>
                    	<td></td>
                        <td><input type='submit'  class='pop-sub' value='Sửa' name = 'ok'/>
                        	<input type='submit' class="cancle" value='Thoát'/>
                      
                        </td>
                    </tr>
                </table>
            </form>
            
 <?php

	ob_flush();
 ?>