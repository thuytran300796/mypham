<script>
	$(document).ready(function(e) {
  		
		$('#manv').keyup(function()
		{
			$('#manv').next('.error').hide();
		});
		
		$('#matkhau').keyup(function()
		{
			$('#matkhau').next('.error').hide();
		});
		      
    });
</script>

<?php
	session_start();
	require('../config/config.php');
	
	$manv = $matkhau = "";
	$loi = array();
		$loi['manv'] = $loi['matkhau'] = "";
	if(isset($_POST['ok']))
	{echo "e";
		$manv = mysql_escape_string($_POST['manv']); $matkhau = mysql_escape_string($_POST['matkhau']);
		$check = 1;
		if($manv == "")
		{
			$loi['manv'] = "Vui lòng nhập mã nhân viên";
			$check = 0;
		}	
		
		if($matkhau == "")
		{
			$loi['matkhau'] = "Vui lòng nhập mật khẩu";	
			$check = 0;
		}
		
		if($check == 1)
		{
			mysql_query("set names 'utf8'");
			$result = mysql_query("select manv, tennv, trangthai from nhanvien where BINARY manv='$manv' and BINARY matkhau = '$matkhau'");
			
			if(mysql_num_rows($result) == 0)
			{
				$loi['matkhau'] = 'Sai tên đăng nhập hoặc mật khẩu';
				$check = 0;
			}	
			else
			{
				$dong = mysql_fetch_assoc($result);
				if($dong['trangthai'] == 0)
				{
					$loi['matkhau'] = 'Tài khoản này đã bị vô hiệu hóa';
					$check = 0;	
				}
				else
				{
					$_SESSION['user'] = $dong['manv'];
					$_SESSION['name'] = $dong['tennv'];
					header('location: admin.php');
				}
			}
		}
	}

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
    	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    	<title>Đăng nhập</title>
        <script src="../js/jquery-1.12.4.js"></script>
        <link type="text/css" rel='stylesheet' href="style.css"/>
    </head>
    
    <body>
    	<div style="width: 100%; height: 100%; background: #EFFBF2">

            <div style='width: 40%; height: 70px; margin:  auto; padding-top: 5%; font-size: 40px; text-align: center; font-weight: bold; color: #088A68'>
                AZURA SHOP
            </div>
        
        	<form method='post'>
            <div style=' width: 50%; margin: 3% auto; border: solid 1px; border-radius: 3px; padding-top: 20px;'>
                
                <p class="title">Thông Tin Tài Khoản</p><br />
                
                <table width="100%" cellspacing="20px" style="margin-left: 18%">
                    <tr>
                        <td width="20%">Mã nhân viên: </td>
                        <td><input type='text' class="txt-sp" style="height: 40px;"  name='manv' id='manv' value="<?php echo $manv; ?>"/></td>
                    </tr>
                    <tr>
                    	<td></td>
                        <td>
                        	<?php
								if($loi['manv'] != "")
									echo "<span class='error'>".$loi['manv']."</span>";
							?>
                        </td>
                        <td></td>
                    </tr>
                    <tr>
                        <td width="20%">Mật khẩu: </td>
                        <td><input type='password' class="txt-sp" style="height: 40px;" name='matkhau' id='matkhau' value="<?php echo $matkhau; ?>"/></td>
                    </tr>
                    <tr>
                    	<td></td>
                        <td>
                        	<?php
								if($loi['matkhau'] != "")
									echo "<span class='error'>".$loi['matkhau']."</span>";
							?>
                        </td>
                        <td></td>
                    </tr>
                    <tr>
                    	<td width="20%"></td>
                        <td><input type='submit' id='ok' name='ok' value='Đăng nhập' class="sub" style="width: 200px;"/></td>
                        <td></td>
                    </tr>
                </table>
                
            </div>
        	</form>
        </div>
    </body>
</html>

