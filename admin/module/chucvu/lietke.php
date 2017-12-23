<!--đi từ file admin-->
<?php  //require('module/nhacungcap/js/ncc.php'); ?>

<?php
	
	
	
?>

<?php
	
	mysql_query("set names 'utf8'");
	$chucvu = mysql_query("select * from chucvu");	
	
?>

	
    
    <div id="nhacungcap">
    	
        <p class="title">CHỨC VỤ</p><br />
        <br />
        
        <table class = "tb-lietke"  border="1" >
        
            <tr>
                <th width="15%">Mã chức vụ</th>
                <th width="25%">Tên chức vụ</th>
                <th width="25%">Hệ số lương</th>
                <th width="15%">Phụ cấp</th>
                <th width="7%">Sửa</th>
                <th width="7%">Xóa</th>
            </tr>
           
        <?php
            while($re_cv = mysql_fetch_assoc($chucvu))
			{
		?>
                <tr>
                    <td><?php echo $re_cv['MaCV'] ?></td>
                    <td><?php echo $re_cv['TenCV'] ?></td>
                    <td><?php echo $re_cv['HeSoLuong']?> </td>
                    <td><?php echo number_format($re_cv['PhuCap']) ?> đ</td>
                    <td align="center"><a href = "admin.php?quanly=chucvu&ac=sua&id=<?php echo $re_cv['MaCV'] ?>">Sửa</a></td>
                    <td align="center"><a href = "admin.php?quanly=chucvu&ac=xoa&id=<?php echo $re_cv['MaCV'] ?>">Xóa</a></td>
                </tr>
        <?php
			}
		?>
            
        </table>
    
    </div>
