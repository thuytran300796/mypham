<?php
	
	
	
	$keyword = "";
	if(isset($_POST['keyword']))
	{
		$keyword = $_POST['keyword'];	
		mysql_query("set names 'utf8'");
		$kh = mysql_query("select * from khachhang where trangthai = 1 and makh <> '' and (tenkh LIKE '%$keyword%' or sodienthoai LIKE '%$keyword%')");	
	}
	
	else
	{
		mysql_query("set names 'utf8'");
		$kh = mysql_query("select * from khachhang where trangthai = 1");	
	}
	
	if(isset($_GET['id']))
	{
		$id = $_GET['id'];	
	
		if(isset($_GET['ac']))
		{
			if($ac == 'reset')
			{
				$passmoi = rand(100, 1000);
				$mahoa = md5($passmoi);
				$kq = mysql_query("update khachhang set matkhau = '$mahoa' where makh = '$id'");	
				echo "<input id='matkhaumoi' type='hidden' value='$passmoi'/>";
				echo "<script>alert('Cấp lại mật khẩu thành công!Mật khẩu mới: ' + $('#matkhaumoi').val())</script>";
				//header('location: admin.php?quanly=khachhang');
			}
		}
		else
		{
			$kh = mysql_query("update khachhang set trangthai = 0 where makh = '$id'");
			header('location: admin.php?quanly=khachhang');
		}	

	}
?>

	
    
    <div id="khachhang" style="margin: auto;">
    	
        <p class="title">DANH SÁCH KHÁCH HÀNG</p><br />
        
        <div style="text-align: right;">
        <form method='post'>
        	<input type='text' name ='keyword' value = '<?php echo $keyword ?>' class = 'txt-timkiem' placeholder='Nhập tên hoặc số điện thoại khách hàng...' />
            <input type='submit' name = 'search' class = 'sub' value= 'Tìm kiếm'/>
        </form>
        </div><br />
        
        <table width="100%" class = "tb-lietke"  border="1" >
        
            <tr>
                <th width="10%">Tên đăng nhập</th>
                <th width="12%">Họ tên</th>
                <th width="5%">Giới tính</th>
                <th width="7%">Ngày sinh</th>
                <th width="16%">Địa chỉ</th>
                <th width="8%">Số điện thoại</th>
                <th width="7%">Điểm tích lũy</th>
                <th width="10%">Lịch sử mua hàng</th>
                <th width="10%">Cấp lại mật khẩu</th>
                <th width="7%">Vô hiệu hóa</th>
            </tr>
           
        <?php
            while($re_kh = mysql_fetch_assoc($kh))
			{
		?>
                <tr>
                    <td><?php echo $re_kh['MaKH'] ?></td>
                    <td><?php echo $re_kh['TenKH']?> </td>
                    <td align="center"><?php echo $re_kh['GioiTinh']==0?"Nữ":"Nam"?> </td>
                    <td align="center"><?php echo date('d/m/Y', strtotime($re_kh['NgaySinh']))?> </td>
                    <td><?php echo $re_kh['DiaChi']?> </td>
                    <td align="center"><?php echo $re_kh['SoDienThoai']?> </td>
                    <td align="center"><?php echo $re_kh['DiemTichLuy']?> </td>
                    <td align="center"><a href = "admin.php?quanly=khachhang&ac=lichsu&id=<?php echo $re_kh['MaKH'] ?>">Xem</a></td>
                    <td align="center"><a href = "admin.php?quanly=khachhang&ac=reset&id=<?php echo $re_kh['MaKH'] ?>">Cấp lại</a></td>
                    <td align="center"><a onclick="return ConfirmDel();" href = "admin.php?quanly=khachhang&ac=xoa&id=<?php echo $re_kh['MaKH'] ?>">Vô hiệu hóa</a></td>
                </tr>
        <?php
			}
		?>
            
        </table>
    
    </div>
