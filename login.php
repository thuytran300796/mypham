<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
	<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
    	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <script src="js/jquery-1.12.4.js"></script>
        <link type="text/css" rel='stylesheet' href="style.css"/>
    	<title>Đăng nhập - Đăng ký</title>

<?php


	session_start();
	//if(isset($_SESSION['user']))
		//echo $_SESSION['user'];
	
	ob_start();
	$url = NULL;
	$url = $_REQUEST['url'] ;
	
	require('config/config.php');
	require('module/header.php');
	
	
	//echo $url;
	
	$loi_dn = array();
	$loi_dn['id_dn'] = $loi['pass_dn'] = $id_dn = $pass_dn =  NULL;
	
	$loi_dk = array();
	$loi_dk['id_dk'] = $loi_dk['pass_dk'] = $loi_dk['confirm_pass'] = $loi_dk['name'] = $id_dk = $pass_dk = $confirm_pass = $name = $gioitinh = $diachi = $sdt = $ngaysinh = NULL;

	if(isset($_POST['login']))
	{
		$check = 1;	
		
		if(empty($_POST['id_dn']))
		{
			$loi_dn['id_dn'] = "Vui lòng nhập tên tài khoản đăng nhập";
			$id_dn = "";
			$check = 0;
		}
		else
		{
			$id_dn = $_POST['id_dn'];	
		}
		
		if(empty($_POST['pass_dn']))
		{
			$loi_dn['pass_dn'] = "Vui lòng nhập mật khẩu";
			$pass_dn = "";
			$check = 0;
		}
		else
		{
			$pass_dn = $_POST['pass_dn'];	
		}
		
		if($check)
		{
			$pass_md5 = md5($pass_dn);
			
			mysql_query("SET NAMES 'utf8'");
			$sql = "SELECT MaKH, MatKhau, TenKH, TrangThai FROM KhachHang WHERE BINARY MaKH = '".$id_dn."' and  BINARY MatKhau = '".$pass_md5."'";
			$check_acc = mysql_query("SELECT MaKH, MatKhau, TenKH, TrangThai FROM KhachHang WHERE BINARY MaKH = '".$id_dn."' and  BINARY MatKhau = '".$pass_md5."'");	
			//echo $sql;
			$re_acc = mysql_fetch_assoc($check_acc);
			if(mysql_num_rows($check_acc) == 1)
			{	
				if($re_acc['TrangThai'] == 0)
				{
					$loi_dn['pass_dn'] = 'Tài khoản này đã bị vô hiệu hóa';
					$check = 0; 	
				}
				else
				{
					mysql_query("SET NAMES 'utf8'");
					$check_acc = mysql_query("SELECT MaKH, MatKhau, TenKH, TrangThai FROM KhachHang WHERE BINARY MaKH = '".$id_dn."' and  BINARY MatKhau = '".$pass_md5."'");
					$kq = mysql_fetch_assoc($check_acc);
					//echo $kq['TaiKhoanKH'];
					$_SESSION['user'] = $kq['MaKH'];
					$_SESSION['name'] = $kq['TenKH'];
					header('location: '.$url.'');
				}
			}
			else
			{
				$loi_dn['pass_dn'] = "Tài khoản hoặc mật khẩu không đúng!";
				$check = 0;
			}
		}
	}
	
	if(isset($_POST['signin']))
	{
		$check = 1;	
		
		if(empty($_POST['id_dk']))
		{
			$loi_dk['id_dk'] = "Vui lòng nhập tên tài khoản đăng nhập";
			$id_dk = "";
			$check = 0;
		}
		else
		{
			$id_dk = $_POST['id_dk'];	
		}
		
		if(empty($_POST['pass_dk']))
		{
			$loi_dk['pass_dk'] = "Vui lòng nhập mật khẩu đăng nhập";
			$pass_dk = "";
			$check = 0;
		}
		else
		{
			$pass_dk = $_POST['pass_dk'];	
		}
		
		if(empty($_POST['confirm_pass']))
		{
			$loi_dk['confirm_pass'] = "Vui lòng xác nhận lại mật khẩu đăng nhập";
			$confirm_pass = "";
			$check = 0;
		}
		else
		{
			$confirm_pass = $_POST['confirm_pass'];	
		}
		
		if($check)
		{
			if($confirm_pass != $pass_dk)
			{
				$pass_dk = $confirm_pass = "";
				$loi_dk['pass_dk'] = "Mật khẩu không trùng khớp. Vui lòng kiểm tra lại";	
				$check = 0;
			}
		}
		
		if(empty($_POST['name']))
		{
			$loi_dk['name'] = "Vui lòng nhập tên của bạn";
			$name = "";
			$check = 0;
		}
		else
		{
			$name = $_POST['name'];	
		}
		
		$diachi = $_POST['diachi'];
		$sdt = $_POST['sdt'];
		$gioitinh = $_POST['gioitinh'];
		$ngaysinh = $_POST['ngaysinh'];
		
		if($check)
		{
			mysql_query("SET NAMES 'utf8'");
			$check_acc = mysql_query("SELECT MaKH FROM KhachHang WHERE BINARY MaKH = '$id_dk'");	
			if(!$check_acc)
				echo mysql_error();
			if(mysql_num_rows($check_acc) == 1)
			{
				$loi_dk['id_dk'] = "Tài khoản này đã tồn tại. Vui lòng chọn tên đăng nhập khác!";
				$check = 0; 	
			}
			else
			{
				mysql_query("SET NAMES 'utf8'");
				$pass_md5 = md5($pass_dk);
				$kq = mysql_query("INSERT INTO KhachHang(makh, tenkh, ngaysinh, gioitinh, sodienthoai, diachi,  matkhau, diemtichluy, trangthai) VALUES('$id_dk', '$name', '$ngaysinh', $gioitinh,  '$sdt', '$diachi', '$pass_md5', 0, 1)");	
				if(!$kq)
				{
					echo mysql_error();	
				}
				else
				{
					$_SESSION['user'] = $id_dk;
					$_SESSION['name'] = $name;
					header('location: home.php');	
				}
			}
		}
	}

?>


<div id = "login-page" >
    <form action = "login.php" method = "post">
        <p class = "title-register">ĐĂNG NHẬP</p>               
        <label>Tên tài khoản:</label><br />
        <input class = "sign-input" type = "text" name = "id_dn" value = ""/><br />
        <?php
				
					if(!empty($loi_dn['id_dn']))
						echo "<label class = 'error'>".$loi_dn['id_dn']."</label><br/><br/>";
				
				?>
        
        <label>Mật khẩu:</label><br />
        <input class = "sign-input" type = "password" name = "pass_dn" value = ""/><br />
        <?php
				
					if(!empty($loi_dn['pass_dn']))
						echo "<label class = 'error'>".$loi_dn['pass_dn']."</label><br/><br/>";
				
				?>
        <input type = "submit" class = "btn-login" name = "login" value = "ĐĂNG NHẬP" />
        <input type = "hidden" name = "url" value = "<?php echo $url ?>"/>
    </form>
</div>
        
<div id = "signin-page" >
    <form action = "login.php" method = "post">
        <p class = "title-register">ĐĂNG KÝ</p>
        <label>Tên tài khoản:</label><br />
        <input class = "sign-input" type = "text" name = "id_dk" value = "<?php echo $id_dk ?>"/><br />
        <?php
				
					if(!empty($loi_dk['id_dk']))
						echo "<label class = 'error'>".$loi_dk['id_dk']."</label><br/><br/>";
				
				?>
        
        <label>Mật khẩu:</label><br />
        <input class = "sign-input" type = "password" name = "pass_dk"/><br />
        <?php
				
					if(!empty($loi_dk['pass_dk']))
						echo "<label class = 'error'>".$loi_dk['pass_dk']."</label><br/><br/>";
				
				?>
        
        <label>Xác nhận mật khẩu:</label><br />
        <input class = "sign-input" type = "password" name = "confirm_pass"/><br />
        <?php
				
					if(!empty($loi_dk['confirm_pass']))
						echo "<label class = 'error'>".$loi_dk['confirm_pass']."</label><br/><br/>";
				
				?>
        
        <label>Họ tên:</label><br />
        <input class = "sign-input" type = "text" name = "name" value = "<?php echo $name ?>"/><br />
        <?php
				
					if(!empty($loi_dk['name']))
						echo "<label class = 'error'>".$loi_dk['name']."</label><br/><br/>";
				
				?>
        
        <label>Giới tính:</label><br />
        <select name = "gioitinh">
        	<?php
				
					if($gioitinh == 1 || $gioitinh == "")
					{
						echo "<option  value = '1' selected='selected'>Nam</option>";
                    	echo "<option  value = '0'>Nữ</option>";
					}
					else if($gioitinh == 0)
					{
						echo "<option  value = '1'>Nam</option>";
						echo "<option  value = '0' selected='selected'>Nữ</option>";
					}
				
				?>
        </select><br />
        
        <label>Ngày sinh:</label><br />
        <input class = "sign-input" type = "date" name = "ngaysinh" value = "<?php echo $ngaysinh ?>"/><br />
        
        <label>Số điện thoại:</label><br />
        <input class = "sign-input" type = "text" name = "sdt" value = "<?php echo $sdt ?>"/><br />
        
        <label>Địa chỉ:</label><br />
        <textarea name = "diachi" rows="5" cols="21" style = "font-size: 15px; padding: 10px" placeholder="Nhập địa chỉ mà bạn muốn được giao hàng..."><?php echo $diachi ?></textarea><br /><br />
        
        
        <input type = "submit" class = "btn-login" value = "ĐĂNG KÝ" name = "signin"/>
        
        <input type = "hidden" name = "url" value = "<?php echo $url ?>"/>
    </form>
</div>
    
        <div class = "clear"></div>



<?php
	ob_flush();
	include_once('module/bottom.php');
?>