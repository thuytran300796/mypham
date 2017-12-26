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
                <img style="float: right; padding-top: 5px; padding-right: 5px;" src="../image/close.PNG" id='close-submit'/>
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
    
    <div id="nhacungcap" style="width: 100%;">
    	
        <p class="title">DANH SÁCH CÁC NHÀ CUNG CẤP</p>
        
        <input type='submit' name='add' value='Thêm mới' id="nhacc-add" class="sub" style=" margin-left: 90.5%;"/>
        <div class="clear"></div>
        <!--<p id='content'>ssssss</p>-->
    
        <table class = "tb-lietke" width="100%"  border="1" >
        
            <tr>
                <th width="7%">Mã NCC</th>
                <th width="19%">Tên nhà cung cấp</th>
                <th width="25%">Địa chỉ</th>
                <th width="11%">Số điện thoại</th>
                <th width="15%">Email</th>
                <th width="15%">Ghi chú</th>
                <th width="4%">Sửa</th>
                <th width="4%">Xóa</th>
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
                    <td><?php echo $re_ncc['GhiChu'] ?></td>
                    <td align="center"><a href = "javascript:void(0)" class="edit-submit" data-id='<?php echo $re_ncc['MaNCC'] ?>'>Sửa</a></td>
                    <td align="center"><a href = "javascript:void(0)" class="del-submit" data-id='<?php echo $re_ncc['MaNCC'] ?>'>Xóa</a></td>
                </tr>
        <?php
			}
		?>
            
        </table>
    
    </div>
	<div class="clear"></div>
