<?php
	ob_start();
	
	$loi = array();
	$loi['id'] = $loi['ten'] = $loi['diachi'] = $loi['sdt'] = $ten = $email= $diachi = $id = $sdt = $ghichu = NULL;
	$check = 1;
	if(isset($_POST['ok']))
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
			$result = mysql_query("select MaNCC from NhaCungCap");
			
			if(mysql_num_rows($result) == 0)
				$id = 'NCC1';
			else
			{		
				$re_dong = mysql_fetch_assoc($result);
				
				$number = substr($re_dong['MaNCC'], 3);
				
				while($re_dong = mysql_fetch_assoc($result))
				{
					$temp = substr($re_dong['MaNCC'], 3);
					if($number < $temp)
						$number = $temp;
				}
				$id = 'NCC'.++$number;
			}
		
				mysql_query("set names 'utf8'");
				$result = mysql_query("insert into nhacungcap values ('$id', '$ten', '$diachi', '$sdt', '$email', '$ghichu', 1)");
				header('location: admin.php?quanly=nhacc&ac=them');
		
			mysql_close($conn);
		}

	}
	ob_flush();

?>

<p class="title">THÊM NHÀ CUNG CẤP</p><br />

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
                        <td><input type='submit'  class='pop-sub' value='Thêm' name = 'ok'/>
                        	<input type='submit' class="cancle" value='Thoát'/>
                      
                        </td>
                    </tr>
                </table>
            </form>