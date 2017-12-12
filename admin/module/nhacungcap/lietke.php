<!--đi từ file admin-->
<script src="module/nhacungcap/js/ncc.js"></script>
<?php /* require('module/nhacungcap/js/ncc.php'); */?>



	<div class='popup-background'>
    	<div class='popup'>
        	
            <!--<div class="clear"></div>
            <br />-->
            
            <div>
            	<h3></h3>
            </div>
            
            <!--<form action="admin.php?quanly=nhacc" method="post">-->
            <form>
            	<input type='hidden' name='quanly' value='nhacc'/>
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
                        <td><textarea  id = 'diachi_ncc'></textarea></td>
                    </tr>
                    <tr>
                        <td>Ghi chú:</td>
                        <td><textarea  id = 'ghichu_ncc'></textarea></td>
                    </tr>
                    <tr>
                    	<td></td>
                        <td><input type='submit'  class='pop-sub' value=''/>
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
        
        <p id='content'></p>
    
        <table class = "tb-lietke" width="100%" border="1" >
        
            <tr>
                <th width="12%">Mã NCC</th>
                <th width="23%">Tên nhà cung cấp</th>
                <th width="26%">Địa chỉ</th>
                <th width="12%">Số điện thoại</th>
                <th width="12">Email</th>
                <th width="7%">Sửa</th>
                <th width="7%">Xóa</th>
            </tr>
           
        
            
                <tr>
                    <td>NCC1</td>
                    <td>Nhà phân phối Minh Vy</td>
                    <td>206 Nguyễn Văn Cừ, Cần Thơ</td>
                    <td align="center">0939 614 616</td>
                    <td>thuytran300796@gmail.com</td>
                    <td align="center"><a href = "admin.php?quanly=nhacc&ac=sua&id=NCC1">Sửa</a></td>
                    <td align="center"><a href = "#">Xóa</a></td>
                </tr>
           
            
        </table>
    
    </div>

