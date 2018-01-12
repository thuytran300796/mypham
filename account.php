<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
	<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
    	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <script src="js/jquery-1.12.4.js"></script>
        <link type="text/css" rel='stylesheet' href="style.css"/>
    	<title>Tài khoản của tôi</title>
        
</script>

<?php
	session_start();
	ob_start();
	if(isset($_GET['id']))
	{
		$id = $_GET['id'];
		$url = "account.php?id=".$id;	
	}
	else
		header('location: home.php');
	
	
	include_once('module/header.php');
	include_once('config/config.php');
?>

<?php

	if(isset($_SESSION['user']))
	{
		$user = $_SESSION['user'];
		
		
		$loi = array();
		$loi['ten'] = $loi['hinh'] = NULL;
		$ten = $diachi = $sdt = $gioitinh = $ngaysinh = $hinh = NULL;
		
		if(!isset($_POST['ok']))
		{
		
			mysql_query("SET NAMES 'utf8'");
			$kh = mysql_query("SELECT * FROM KhachHang WHERE MaKH = '$user'");
			$re_kh = mysql_fetch_assoc($kh);
			
			$ten = $re_kh['TenKH'];
			$diachi = $re_kh['DiaChi'];
			$sdt = $re_kh['SoDienThoai'];
			$gioitinh = $re_kh['GioiTinh'];
			$ngaysinh = $re_kh['NgaySinh'];
			$diemtichluy = $re_kh['DiemTichLuy'];
			$hinhdaidien = $re_kh['HinhDaiDien'];
		}
		else
		{
			$check = 1;
			if(empty($_POST['ten']))
			{
				$ten = "";
				$loi['ten'] = "Vui lòng nhập họ tên";
				$check = 0;
			}
			else
			{
				$ten = $_POST['ten'];
			}
			
			$gioitinh = $_POST['gioitinh'];
			$sdt = $_POST['sdt'];
			$diachi = $_POST['diachi'];	
			$ngaysinh = $_POST['ngaysinh'];
			$diemtichluy = $_POST['diemtichluy'];
			if($_FILES['hinh']['size'] != 0)
			{
				$file_size = $_FILES["hinh"]["size"];
				//echo "size: ".$file_size;
				if($file_size > 1024 * 1024 * 2)
				{
					echo "File được chọn phải nhỏ hơn 2MB </br>";
					return;
				}
				
				$file_type = $_FILES["hinh"]["type"];
				//echo "ko: ".basename($_FILES["hinh"]["name"]);
				
				if($file_type == "image/jpeg" || $file_type == "image/png")
				{
					$duongdan = "image/khachhang/";
					move_uploaded_file($_FILES["hinh"]["tmp_name"], "$duongdan".$_FILES["hinh"]["name"]);
				}
				else
				{
					$loi['hinh']= 'Vui lòng chọn tập tin có dạng "jpg" hoặc "png" </br>';
					$check = 0;
				}
			}
			
			
			
			if($check)
			{
				mysql_query("SET NAMES 'utf8'");
				if($_FILES['hinh']['size'] != 0)
					$kq = mysql_query("UPDATE KhachHang SET TenKH = N'$ten', DiaChi = N'$diachi', GioiTinh = $gioitinh, SoDienThoai = '$sdt', NgaySinh = '$ngaysinh', HinhDaiDien = '".$_FILES["hinh"]["name"]."'  WHERE MaKH = '$user'");	
				else
					$kq = mysql_query("UPDATE KhachHang SET TenKH = N'$ten', DiaChi = N'$diachi', GioiTinh = $gioitinh, SoDienThoai = '$sdt', NgaySinh = '$ngaysinh'  WHERE MaKH = '$user'");	
				$_SESSION['name'] = $ten;
				$hinhdaidien = $_FILES["hinh"]["name"];
				//header('location: account.php?id='.$id);
				echo "<script> alert('Cập nhật thành công!'); </script>";	
			}
		}
	}

?>

<div id = "acc-left">
    	
        <ul>
        	<a href = "account.php?id=<?php echo $user ?>"><li>Thông tin tài khoản</li></a>
            <a href = "account.php?id=<?php echo $user ?>&type=doimk"><li>Đổi mật khẩu</li></a>
        	<a href = "list_bill.php?id=<?php echo $user ?>"><li>Lịch sử đơn hàng</li></a>
        </ul>

</div>

<div id = "acc-right">

	<div id="avatar" >
    <?php //echo $hinhdaidien ?>
    	<img src="image/khachhang/<?php echo $hinhdaidien ?>"/>
   		<p>Ảnh đại diện</p>
    </div>

<?php
	if(!isset($_GET['type']))
	{
?>
	<form method = "post"  enctype="multipart/form-data">
    		
            <p style = "color: #3CA937; font-weight: bold; font-size: 25px;">Cập nhật thông tin tài khoản</p>
            
            <table class = "info_account" cellspacing="20px" width="100%">
            
            	<tr>
                	<td width="20%" style = "font-weight: bold;">Tên tài khoản:</td>
                    <td><input type = "text" name = "id" value = "<?php echo $user ?>" readonly/></td>
                </tr>
            
            	<tr>
                	<td width="20%" style = "font-weight: bold">Họ và tên:</td>
                    <td><input type = "text" name = "ten" value = "<?php echo $ten ?>"/></td>
                </tr>
                
                <?php
					if(!empty($loi['ten']))
					{
						echo "<tr>";
						echo "<td></td>";
						echo "<td class = 'error'>".$loi['ten']."</td>";
						echo "</tr>";		
					}
				?>
                
                <tr>
                	<td width="20%" style = "font-weight: bold">Giới tính:</td>
                	<td>
                        <select name = "gioitinh" style="width: 280px">
                        <?php
							if($gioitinh == 1)
							{
								echo "<option value = '1' selected='selected'>Nam</option>";
                            	echo "<option value = '0'>Nữ</option>";
							}
							else
							{
								echo "<option value = '1'>Nam</option>";
                            	echo "<option value = '0' selected='selected'>Nữ</option>";
							}
						?>
                            
                        </select><br />
                    </td>
                </tr>
                
                <tr>
                	<td width="20%" style = "font-weight: bold">Ngày sinh:</td>
                    <td><input type = "date" name = "ngaysinh" value = "<?php echo $ngaysinh ?>"/></td>
                </tr>

                <tr>
                	<td style = "font-weight: bold">Số điện thoại:</td>
                    <td><input type = "text" name = "sdt" value = "<?php echo $sdt ?>"/></td>
                </tr>
                
                <tr>
                	<td style = "font-weight: bold">Địa chỉ:</td>
                    <td><textarea name = "diachi" rows="5" cols="31" style = "font-size: 20px" placeholder="Nhập địa chỉ mà bạn muốn được giao hàng..."><?php echo $diachi ?></textarea><br /></td>
                </tr>
                
                <tr>
                	<td style = "font-weight: bold">Điểm tích lũy:</td>
                    <td><input type = "text" readonly="readonly" name = "diemtichluy" value = "<?php echo $diemtichluy ?>"/></td>
                </tr>
                
                <tr>
                	<td style = "font-weight: bold">Chọn hình đại diện:</td>
                    <td><input type='file' name='hinh' multiple="multiple"/></td>
                </tr>
                <?php
					if(!empty($loi['hinh']))
					{
						echo "<tr>";
						echo "<td></td>";
						echo "<td class = 'error'>".$loi['hinh']."</td>";
						echo "</tr>";		
					}
				?>
                <tr>
                	<td></td>
                    <td><input type = "submit" name = 'ok' class = "btn-cart" value = "CẬP NHẬT" style = "height: 60px"/>
                    	
                    </td>
                </tr>
                
            </table>
            <input type = "hidden" name = "id" value = "<?php echo $user ?>"/>
        </form>
<?php
	}
	else
	{
		if($_GET['type'] == 'doimk')
		{
			include_once('account/pass.php');

		}
	}
?>
</div>

<br /><br />

<?php
	ob_flush();
	include_once('module/bottom.php');
?>