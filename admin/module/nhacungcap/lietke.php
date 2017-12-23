<!--đi từ file admin-->
<?php  //require('module/nhacungcap/js/ncc.php'); ?>


<?php

	$keyword = "";	
	
	if(isset($_POST['search']))
	{
		$keyword = $_POST['keyword'];
		
		mysql_query("set names 'utf8'");
		$ncc = mysql_query("select * from nhacungcap where mancc like '%$keyword%' or tenncc like '%$keyword%'");
	}
	else
	{
		mysql_query("set names 'utf8'");
		$ncc = mysql_query("select * from nhacungcap");	
	}
?>

	
    
    <div id="nhacungcap">
    	
        <p class="title">DANH SÁCH CÁC NHÀ CUNG CẤP</p><br />
        
        <div>
        <form method='post'>
        	<input type='text' name ='keyword' value = '<?php echo $keyword ?>' class = 'txt-timkiem' placeholder='Nhập tên hoặc mã nhà cung cấp...' />
            <input type='submit' name = 'search' class = 'sub' value= 'Tìm kiếm'/>
        </form>
        </div>
	<br />
        <div class="clear"></div>
        <!--<p id='content'>ssssss</p>-->
    
        <table class = "tb-lietke"  border="1" >
        
            <tr>
                <th width="10%">Mã NCC</th>
                <th width="23%">Tên nhà cung cấp</th>
                <th width="26%">Địa chỉ</th>
                <th width="14%">Số điện thoại</th>
                <th width="16">Email</th>
                <th width="5%">Sửa</th>
                <th width="5%">Xóa</th>
            </tr>
           
        <?php
            while($re_ncc = mysql_fetch_assoc($ncc))
			{
		?>
                <tr>
                    <td><?php echo $re_ncc['MaNCC'] ?></td>
                    <td><?php echo $re_ncc['TenNCC'] ?></td>
                    <td><?php echo $re_ncc['DiaChi'] ?></td>
                    <td align="center"><?php echo $re_ncc['SDT'] ?></td>
                    <td><?php echo $re_ncc['Email'] ?></td>
                    <td align="center"><a href = "admin.php?quanly=nhacc&ac=sua&id=<?php echo $re_ncc['MaNCC'] ?>">Sửa</a></td>
                    <td align="center"><a onclick = "return ConfirmDel();" href = "admin.php?quanly=nhacc&ac=xoa&id=<?php echo $re_ncc['MaNCC'] ?>">Xóa</a></td>
                </tr>
        <?php
			}
		?>
            
        </table>
    
    </div>

<?php

?>