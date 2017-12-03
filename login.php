<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
	<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
    	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <script src="js/jquery-1.12.4.js"></script>
        <link type="text/css" rel='stylesheet' href="style.css"/>
    	<title>Đăng nhập - Đăng ký</title>

<?php
	include_once('module/header.php');
?>

<div id = "login-page" >
    <form action = "login.php" method = "post">
        <p class = "title-register">ĐĂNG NHẬP</p>               
        <label>Tên tài khoản:</label><br />
        <input class = "sign-input" type = "text" name = "id_dn" value = ""/><br />
        <label class = 'error'></label><br/><br/>
        
        <label>Mật khẩu:</label><br />
        <input class = "sign-input" type = "password" name = "pass_dn" value = ""/><br />
        <label class = 'error'></label><br/><br/>
        
        <input type = "submit" class = "btn-login" name = "login" value = "ĐĂNG NHẬP" style = "height: 60px; width: 62%"/>
        <input type = "hidden" name = "url" value = ""/>
    </form>
</div>
        
<div id = "signin-page" >
    <form action = "login.php" method = "post">
        <p class = "title-register">ĐĂNG KÝ</p>
        <label>Tên tài khoản:</label><br />
        <input class = "sign-input" type = "text" name = "id_dk" value = ""/><br />
        <label class = 'error'></label><br/><br/>
        
        <label>Mật khẩu:</label><br />
        <input class = "sign-input" type = "password" name = "pass_dk"/><br />
        <label class = 'error'></label><br/><br/>
        
        <label>Xác nhận mật khẩu:</label><br />
        <input class = "sign-input" type = "password" name = "confirm_pass"/><br />
        <label class = 'error'></label><br/><br/>
        
        <label>Họ tên:</label><br />
        <input class = "sign-input" type = "text" name = "name" value = ""/><br />
        <label class = 'error'></label><br/><br/>
        
        <label>Giới tính:</label><br />
        <select name = "gioitinh">
        	<option  value = '1' selected='selected'>Nam</option>
        	<option  value = '0'>Nữ</option>
        </select><br />
        
        <label>Ngày sinh:</label><br />
        <input class = "sign-input" type = "date" name = "ngaysinh" value = ""/><br />
        
        <label>Địa chỉ:</label><br />
        <textarea name = "diachi" rows="5" cols="31" style = "font-size: 20px" placeholder="Nhập địa chỉ mà bạn muốn được giao hàng..."></textarea><br /><br />
        
        <label>Số điện thoại:</label><br />
        <input class = "sign-input" type = "text" name = "sdt" value = ""/><br />
        <input type = "submit" class = "btn-login" value = "ĐĂNG KÝ" name = "signin" style = "height: 60px; width: 45%"/>
        
        <input type = "hidden" name = "url" value = ""/>
    </form>
</div>
    
        <div class = "clear"></div>



<?php
	include_once('module/bottom.php');
?>