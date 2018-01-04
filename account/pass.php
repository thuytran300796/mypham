<?php
	$loimk = array();
	$loimk['pass_hientai'] = $loimk['pass_moi'] = $loimk['confirm_pass'] = NULL;
	
	if(isset($_POST['doimk']))
	{
		$checkmk = 1;
		
		if(empty($_POST['pass_hientai']))
		{
			$checkmk = 0;
			$loimk['pass_hientai'] = "Vui lòng nhập mật khẩu hiện tại";
		}
		
		if(empty($_POST['pass_moi']))
		{
			$checkmk = 0;
			$loimk['pass_moi'] = "Vui lòng nhập mật khẩu mới";	
		}
		
		if(empty($_POST['confirm_pass']))
		{
			$checkmk = 0;
			$loimk['confirm_pass'] = "Vui lòng xác nhận mật khẩu mới";	
		}
		
		if($checkmk == 1)
		{
		
			if($_POST['pass_moi'] != $_POST['confirm_pass'])
			{
				$checkmk = 0;
				$loimk['confirm_pass'] = "Mật khẩu không trùng khớp. Vui lòng kiểm tra lại!";	
			}
			
			mysql_query("SET NAMES 'utf8'");
			
			$kq = mysql_query("SELECT MatKhau FROM KhachHang WHERE MaKH = '".$_SESSION['user']."'");
			
			$re_kq = mysql_fetch_assoc($kq);
			
			if($re_kq['MatKhau'] != md5($_POST['pass_hientai']))
			{
				$checkmk = 0;
				$loimk['pass_hientai'] = "Mật khẩu hiện tại không đúng";
			}
		}
		
		if($checkmk)
		{
			mysql_query("SET NAMES 'utf8'");
			$pass_md5 = md5($_POST['pass_moi']);
			$kq = mysql_query("UPDATE KhachHang SET MatKhau = N'$pass_md5' WHERE MaKH = '".$_SESSION['user']."'");
			echo "<script> alert('Đổi mật khẩu thành công!'); </script>";	
		}
	}
?>

<form method = "post">
        
        	<p style = "color: #3CA937; font-weight: bold; font-size: 25px;">Đổi mật khẩu</p>
            
            <table class = "info_account" cellspacing="20px" width="100%">
            	
                <tr>
                	<td width="25%" style = "font-weight: bold">Mật khẩu hiện tại:</td>
                    <td><input type = "password" name = "pass_hientai" value = ""/></td>
                </tr>
                
                <?php
					if(!empty($loimk['pass_hientai']))
					{
						echo "<tr>";
						echo "<td></td>";
						echo "<td class = 'error'>".$loimk['pass_hientai']."</td>";
						echo "</tr>";		
					}
				?>
                
                <tr>
                	<td width="25%" style = "font-weight: bold">Mật khẩu mới:</td>
                    <td><input type = "password" name = "pass_moi" value = ""/></td>
                </tr>
                
                 <?php
					if(!empty($loimk['pass_moi']))
					{
						echo "<tr>";
						echo "<td></td>";
						echo "<td class = 'error'>".$loimk['pass_moi']."</td>";
						echo "</tr>";		
					}
				?>
                
                <tr>
                	<td width="25%" style = "font-weight: bold">Xác nhận mật khẩu mới:</td>
                    <td><input type = "password" name = "confirm_pass" value = ""/></td>
                </tr>
				
                 <?php
					if(!empty($loimk['confirm_pass']))
					{
						echo "<tr>";
						echo "<td></td>";
						echo "<td class = 'error'>".$loimk['confirm_pass']."</td>";
						echo "</tr>";		
					}
				?>
            
            	<tr>
                	<td></td>
                    <td><input type = "submit" name = 'doimk' class = "btn-cart" value = "CẬP NHẬT" style = "height: 60px"/></td>
                </tr>
            
            </table>
            <input type = "hidden" name = "id" value = "<?php echo $user ?>"/>
</form>