<?php
	
	
	
	$keyword = "";
	if(isset($_POST['keyword']))
	{
		$keyword = $_POST['keyword'];	
		mysql_query("set names 'utf8'");
		$kh = mysql_query("select * from khachhang where trangthai = 1 and tenkh LIKE '%$keyword%' or sodienthoai LIKE '%$keyword%'");	
	}
	else
	{
		mysql_query("set names 'utf8'");
		$kh = mysql_query("select * from khachhang where trangthai = 1");	
	}
?>

	
    
    <div id="khachhang" style="margin: auto;">
    	
        <p class="title">DANH SÁCH KHÁCH HÀNG</p><br />
        
        <div>
        <form method='post'>
        	<input type='text' name ='keyword' value = '<?php echo $keyword ?>' class = 'txt-timkiem' placeholder='Nhập tên hoặc mã khách hàng...' />
            <input type='submit' name = 'search' class = 'sub-timkiem' value= 'Tìm kiếm'/>
        </form>
        </div><br />
        
        <table class = "tb-lietke"  border="1" >
        
            <tr>
                <th width="10%">Mã KH</th>
                <th width="15%">Tên đăng nhập</th>
                <th width="17%">Họ tên</th>
                <th width="7%">Giới tính</th>
                <th width="8%">Ngày sinh</th>
                <th width="23%">Địa chỉ</th>
                <th width="10%">Số điện thoại</th>
                <th width="12%">Điểm tích lũy</th>
                <th width="7%">Sửa</th>
                <th width="7%">Xóa</th>
            </tr>
           
        <?php
            while($re_kh = mysql_fetch_assoc($kh))
			{
		?>
                <tr>
                    <td><?php echo "để đó" ?></td>
                    <td><?php echo $re_kh['MaKH'] ?></td>
                    <td><?php echo $re_kh['TenKH']?> </td>
                    <td><?php echo $re_kh['GioiTinh']==0?"Nữ":"Nam"?> </td>
                    <td><?php echo date('d/m/Y', strtotime($re_kh['NgaySinh']))?> </td>
                    <td><?php echo $re_kh['DiaChi']?> </td>
                    <td><?php echo $re_kh['SoDienThoai']?> </td>
                    <td><?php echo $re_kh['DiemTichLuy']?> </td>
                    <td align="center"><a href = "admin.php?quanly=chucvu&ac=sua&id=<?php echo $re_cv['MaKH'] ?>">Sửa</a></td>
                    <td align="center"><a href = "admin.php?quanly=chucvu&ac=xoa&id=<?php echo $re_cv['MaKH'] ?>">Xóa</a></td>
                </tr>
        <?php
			}
		?>
            
        </table>
    
    </div>