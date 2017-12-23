<!--đi từ file admin-->
<script type="text/javascript" src="module/nhacungcap/js/ncc.js"></script>
<?php /* require('module/nhacungcap/js/ncc.php'); */?>

<?php
	
	mysql_query("set names 'utf8'");
	$ncc = mysql_query("select * from nhacungcap");	
	
?>

<?php
	//require('js/ncc.php');
?>



	<div class='popup-background'>
    	<div class='popup'>
        	
            <!--<div class="clear"></div>
            <br />-->
            
            <div>
            	<h3></h3>
            </div>
            
           	<!--<form action="admin.php?quanly=nhacc" method="post">-->
            <form>
            	<!--<input type='hidden' name='quanly' value='nhacc'/>-->
                <table>
                    <tr>
                        <td>Tên nhà cung cấp:</td>
                        <td><input type='text' id='ten_ncc' value=''/></td>
                    </tr>
                    
                    <tr>
                        <td>Số điện thoại:</td>
                        <td><input type='text' id='sdt_ncc' value=''/></td>
                    </tr>
                    <tr>
                        <td>Email:</td>
                        <td><input type='text' id='email_ncc' value=''/></td>
                    </tr>
                    <tr>
                        <td>Địa chỉ:</td>
                        <td><textarea  id = 'diachi_ncc' ></textarea></td>
                    </tr>
                    <tr>
                        <td>Ghi chú:</td>
                        <td><textarea  id = 'ghichu_ncc' ></textarea></td>
                    </tr>
                    <tr>
                    	<td></td>
                        <td><input type='submit'  class='pop-sub' value='' />
                        	<input type='submit' class="cancle" value='Thoát'/>
                      
                        </td>
                    </tr>
                </table>
            </form>
        </div>
    </div>
    
    <div id="nhacungcap">
    	
        <p class="title">DANH SÁCH CÁC NHÀ CUNG CẤP</p>
        <input type='submit' name='add' value='Thêm' id="nhacc-add" class="btn-ad"/>
        <div class="clear"></div>
        <!--<p id='content'>ssssss</p>-->
    
        <table class = "tb-lietke"  border="1" >
        
            <tr>
                <th width="12%">Mã NCC</th>
                <th width="23%">Tên nhà cung cấp</th>
                <th width="26%">Địa chỉ</th>
                <th width="12%">Số điện thoại</th>
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
                    <td align="center"><a href = "#">Xóa</a></td>
                </tr>
        <?php
			}
		?>
            
        </table>
    
    </div>

