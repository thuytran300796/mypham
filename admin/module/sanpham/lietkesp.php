<?php

	mysql_query("set names 'utf8'");
	$sp = mysql_query("	select sp.masp, sp.tensp, tenncc, sum(ctsp.SoLuong) as 'sl'
						from sanpham sp, chitietsanpham ctsp, nhacungcap ncc
						where sp.masp = ctsp.masp and ncc.mancc = sp.mancc and sp.trangthai = 1 and ctsp.TrangThai = 1
						group by sp.masp");
	
	$ctsp = mysql_query("select sp.masp, ctsp.mactsp, mausac, ctsp.ngaysx, ctsp.hansudung, ctsp.soluong
						from sanpham sp, chitietsanpham ctsp
						where sp.masp = ctsp.masp and ctsp.trangthai = 1 and sp.trangthai = 1");
	
	$arr_ctsp = array();
	
	while($re_ctsp = mysql_fetch_assoc($ctsp))
	{
		$arr_ctsp[$re_ctsp['mactsp']]['masp'] = $re_ctsp['masp'];
		$arr_ctsp[$re_ctsp['mactsp']]['mausac'] = $re_ctsp['mausac'];
		$arr_ctsp[$re_ctsp['mactsp']]['ngaysx'] = $re_ctsp['ngaysx'];
		$arr_ctsp[$re_ctsp['mactsp']]['hansudung'] = $re_ctsp['hansudung'];
		$arr_ctsp[$re_ctsp['mactsp']]['soluong'] = $re_ctsp['soluong'];
	}
	
	//echo "<pre>"; print_r($arr_ctsp); echo "</pre>";
?>

<script>

	$(document).ready(function(e) {
        
		//$('#sp-right table').delegate('.get-sp', 'click', function()
		//$('#sp-right table tr').click(function()
		$('#sp-right table tr').click(function()
		{
			
			//alert('a');
			id = $(this).attr('data-id');
			//alert(id);
			$(this).after($('.ctsp'+id).slideToggle());
			//$('.ctsp'+id).slideToggle();
		});
		
    });

</script>

<div style=" width: 100%; ">
<form method="get">
	<input type='submit' class='sub' value="Thêm mới" style="float: right;"/>
    <input type='hidden' name='quanly' value="sanpham"/>
    <input type='hidden' name='ac' value="themsp"/>
</form>
</div>
<div class="clear"></div>
<br />
<div id='sp-left' >

	<div>
    	<p style="background: #088A68; border-radius: 3px; font-size: 16px; color: white; font-weight: bold; padding: 5px 5px;">Tìm kiếm</p>
        <br />
        <input type='text' value='' class="txt-sp" style="width: 84%" placeholder='Nhập mã hoặc tên hàng'/>
    </div>
	
	<div>
    	<p style="background: #088A68; border-radius: 3px; font-size: 16px; color: white; font-weight: bold; padding: 5px 5px;">Lọc theo</p>
        <br />
        <input name='loc' type='radio'/> Hết hàng<br />
        <input name='loc' type='radio'/> Sắp hết hạn sử dụng
    </div>
</div>


<div id='sp-right'style='width: 79%; float: right;'>


	<table width="100%" style="border-collapse:collapse">
    
    	<tr>
        	<th width="17%">Mã sản phẩm</th>
            <th width="30%">Tên sản phẩm</th>
            <th width="20%">Nhà cung cấp</th>
            <th width="12%">Số lượng hiện có</th>
            <th width="4%">Sửa</th>
            <th width="4%">Xóa</th>
        </tr>
        
        <?php
			while($re_sp = mysql_fetch_assoc($sp))
			{
		?>
        <tr data-id='<?php echo $re_sp['masp'] ?>'>
        	<td><?php echo $re_sp['masp'] ?></td>
            <td><?php echo $re_sp['tensp'] ?></td>
            <td><?php echo $re_sp['tenncc'] ?></td>
            <td style="text-align: center"><?php echo $re_sp['sl'] ?></td>
            <td style="text-align: center"><a href='admin.php?quanly=sanpham&ac=suasp&masp=<?php echo $re_sp['masp'] ?>'>Sửa</a></td>
            <td style="text-align: center"><a href='#'>Xóa</a></td>
        </tr>
        <div  class='ctsp<?php echo $re_sp['masp'] ?>' style="display: none; background: #EFFBF2; width: 387%;   padding: 10px; ">
                
                <div style="width: 70%; height: 30px; line-height: 30px;">
                	<div class='ctsp-item' style="font-weight: bold" >Màu sắc</div>
                    <div class='ctsp-item'  style="font-weight: bold; text-align: left;" >Ngày sản xuất</div>
                    <div class='ctsp-item'  style="font-weight: bold; text-align: left;" >Hạn sử dụng</div>
                    <div class='ctsp-item'  style="font-weight: bold" >Số lượng</div>
                </div>
                <div class="clear"></div>
                
                <?php
					foreach($arr_ctsp as $key => $value)
					{
						if($re_sp['masp'] == $arr_ctsp[$key]['masp'])
						{ 
				?>
                <div style="border-bottom: solid 1px #ccc; width: 70%">
                	<div class='ctsp-item'><?php echo $arr_ctsp[$key]['mausac']==""?"Không":$arr_ctsp[$key]['mausac'] ?></div>
                    <div class='ctsp-item' style="text-align: left;"><?php echo date('d/m/Y', strtotime($arr_ctsp[$key]['ngaysx'])) ?></div>
                    <div class='ctsp-item' style="text-align: left;"><?php echo date('d/m/Y', strtotime($arr_ctsp[$key]['hansudung'])) ?></div>
                    <div class='ctsp-item'><?php echo $arr_ctsp[$key]['soluong'] ?></div>
                </div>
                <div class="clear"></div>
                <?php
						}
					}
				?>
                
                <div class="clear"></div>
        </div>
        <?php	
			}
		?>	
       
    
    </table>

</div>