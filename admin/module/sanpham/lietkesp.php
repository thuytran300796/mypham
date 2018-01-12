<?php

	date_default_timezone_set('Asia/Ho_Chi_Minh');
	$date = date('Y-m-d');

	mysql_query("set names 'utf8'");
	$danhmuc = mysql_query("select madm, tendm from danhmuc");

	mysql_query("set names 'utf8'");
	$sp = mysql_query("	select sp.masp, sp.tensp, tenncc, sum(ctsp.SoLuong) as 'sl'
						from sanpham sp, chitietsanpham ctsp, nhacungcap ncc
						where sp.masp = ctsp.masp and ncc.mancc = sp.mancc and sp.trangthai = 1 and ctsp.TrangThai = 1
						group by sp.masp order by sp.ngaynhap desc");
	
	$ctsp = mysql_query("select sp.masp, ctsp.mactsp, mausac, ctsp.ngaysx, ctsp.hansudung, ctsp.soluong, ctsp.giaban, ctpn.gianhap
						from sanpham sp, chitietsanpham ctsp, chitietphieunhap ctpn
						where sp.masp = ctsp.masp and ctpn.mactsp = ctsp.mactsp and ctsp.trangthai = 1 and sp.trangthai = 1 group by ctsp.mactsp");
	
	$arr_ctsp = array();
	
	while($re_ctsp = mysql_fetch_assoc($ctsp))
	{
		$arr_ctsp[$re_ctsp['mactsp']]['masp'] = $re_ctsp['masp'];
		$arr_ctsp[$re_ctsp['mactsp']]['mausac'] = $re_ctsp['mausac'];
		$arr_ctsp[$re_ctsp['mactsp']]['ngaysx'] = $re_ctsp['ngaysx'];
		$arr_ctsp[$re_ctsp['mactsp']]['hansudung'] = $re_ctsp['hansudung'];
		$arr_ctsp[$re_ctsp['mactsp']]['soluong'] = $re_ctsp['soluong'];
		$arr_ctsp[$re_ctsp['mactsp']]['giaban'] = $re_ctsp['giaban'];
		$arr_ctsp[$re_ctsp['mactsp']]['gianhap'] = $re_ctsp['gianhap'];
	}
	
	//echo "<pre>"; print_r($arr_ctsp); echo "</pre>";
	
	if(isset($_GET['masp']))
	{
		$kq = mysql_query("update sanpham set trangthai = 0 where masp = '".$_GET['masp']."'");	
		$kq = mysql_query("update chitietsanpham set trangthai = 0 where masp = '".$_GET['masp']."'");	
		header('location: admin.php?quanly=sanpham');
	}
?>

<script>

	$(document).ready(function(e) {
        
		//$('#sp-right table').delegate('.get-sp', 'click', function()
		//$('#sp-right table tr').click(function()
		//$('#sp-right table tr').click(function()
		/*
		$('#sp-right table').delegate(' tr', 'click', function()
		{
			id = $(this).attr('data-id'); //alert(id);
			//alert(id);
			//$(this).after($('.ctsp'+id).hide());
			$(this).after($('.ctsp'+id).slideToggle());

		});
		*/
		
		$('#sp-right .lietke-sp').delegate('.lietke-sp-tr', 'click', function()
		{
			id = $(this).attr('data-id'); //alert(id);
			//alert(id);
			//$(this).after($('.ctsp'+id).hide());
			$(this).after($('.ctsp'+id).slideToggle());

		});

		$('#loaixem').change(function()
		{
			if($('#loaixem').val() == 'danhmuc')
				data = "ac=get_dm";
			else
				data = "ac=get_ncc";
			$.ajax
			({
				url: "module/sanpham/xuly/xuly_timkiem.php",
				type: "post",
				data: data,
				async: true,
				success:function(kq)
				{
					//alert(kq);
					$('#danhmuc').html(kq);	
				}
			});
		});
		
		$('#search-sp').click(function()
		{
			loaixem = $('#loaixem').val();
			danhmuc = $('#danhmuc').val();
			keyword = $('#keyword-sp').val(); //alert(keyword);
			data = "ac=search&loaixem="+loaixem+"&danhmuc="+danhmuc+"&keyword="+keyword;	
			
			$.ajax
			({
				url: "module/sanpham/xuly/xuly_timkiem.php",
				type: "post",
				data: data,
				async: true,
				success:function(kq)
				{
					//$('#sp-right table').html(kq);	
					$('#sp-right .lietke-sp').html(kq);	
				}
			});
			return false;
		});
		
		/*
		$('#loc-sp').click(function()
		{
			//alert($("input[name=loc]:checked").val());	
		});
		*/
		
		$('#hansudung').change(function()
		{
			data = "ac=loc&loai=saphethsd&hsd="+$('#hansudung').val();
			alert(data);
			$.ajax
			({
				url: "module/sanpham/xuly/xuly_timkiem.php",
				type: "post",
				data: data,
				async: true,
				success:function(kq)
				{
					$('#sp-right .lietke-sp').html(kq);	
				}
			});
			
			return false;	
		});
		
		$('input[name=loc]').on('change', function() {
			
			check = $(this).prop('checked');
			
			loc = check == true ? $("input[name=loc]:checked").val(): "";
		
			if(loc == 'saphethsd')
			{
				
				$('#sp-left span').show();
				$('#hansudung').show();	
				hsd = $('#hansudung').val();
				data = "ac=loc&loai="+loc+"&hsd="+hsd;
			}
			else
			{
				$('#sp-left span').hide();
				$('#hansudung').hide();	
				data = "ac=loc&loai="+loc;
				
			}

			$.ajax
				({
					url: "module/sanpham/xuly/xuly_timkiem.php",
					type: "post",
					data: data,
					async: true,
					success:function(kq)
					{
						$('#sp-right .lietke-sp').html(kq);	
					}
				});
			
			return false;
		});
	
    });

</script>

<!--
<div style=" width: 100%; ">
<form method="get">
	<input type='submit' class='sub' value="Nhập hàng mới" style="float: right;"/>
    <input type='hidden' name='quanly' value="sanpham"/>
    <input type='hidden' name='ac' value="themsp"/>
</form>
<form method="get">

    <input type='submit' class='sub' value="Nhập hàng cũ" style="float: right;"/>
    <input type='hidden' name='quanly' value="sanpham"/>
    <input type='hidden' name='ac' value="nhapsp"/>
</form>
</div>
<div class="clear"></div>
-->
<div id='category' style='width: 12.5%; float: right;'>
    	<ul class="menu" style="margin-left: 0px">
        	<li><a href='javascript:void(0)'>Nhập hàng</a>
            	<ul>
                	<li><a href='admin.php?quanly=sanpham&ac=themsp'>Nhập hàng mới</a></li>
                    <li><a href='admin.php?quanly=sanpham&ac=nhapsp' id="in">Nhập hàng cũ</a></li>
                </ul>
            </li>
        </ul>
</div>

<div class="clear"></div>
<br />
<div id='sp-left' >
	<form>
	<div>
    	<p style="background: #088A68; border-radius: 3px; font-size: 16px; color: white; font-weight: bold; padding: 5px 5px;">Tìm kiếm</p>
        <br />
        
        <select id='loaixem' class="cbb-sp">
        	<option value='danhmuc'>Tìm theo danh mục</option>
            <option value='ncc'>Tìm theo nhà cung cấp</option>
        </select>
        
        <select id='danhmuc' class="cbb-sp">
        	
       	<?php
			echo "<option value='all'>Tất cả</option>";	
			while($re_dm = mysql_fetch_assoc($danhmuc))
			{
				echo "<option value='".$re_dm['madm']."'>".$re_dm['tendm']."</option>";	
			}
		?>
        </select>
        
        <input type='text' id='keyword-sp' value='' class="txt-sp" placeholder='Nhập mã hoặc tên hàng'/>
        
        <input type='submit' id = 'search-sp' value='Tìm kiếm' class="sub" />
        
    </div>
	</form>
	<div>
    	<p style="background: #088A68; border-radius: 3px; font-size: 16px; color: white; font-weight: bold; padding: 5px 5px;">Lọc theo</p>
        <br />
        <input name='loc' value='hethang' type='checkbox'/> Hết hàng<br />
        <input name='loc' value='saphethsd' type='checkbox'/> Sắp hết hạn sử dụng<br />
                
        <span style="display: none;">Trước ngày</span>
        <input type='date' class='txt-sp' value='<?php echo $date?>' id='hansudung'  style="display: none;" />

        <input name='loc' value='hethsd' type='checkbox'/> Đã hết hạn sử dụng<br />
        <input name='loc' value='banchay' type='checkbox'/> Bán chạy nhất<br />
        <!--<input type='submit' id = 'loc-sp' value='Lọc' class="sub" style="width: 235px; background: #F90"/>-->
    </div>
</div>


<div id='sp-right'>


	<div class='lietke-sp'>
    
    	<div class = 'lietke-sp-th'>
        	<div style='width: 20%'>Mã sản phẩm</div>
            <div style='width:33%'>Tên sản phẩm</div>
            <div style='width:21%'>Nhà cung cấp</div>
            <div style='width:12%'>Số lượng hiện có</div>
            <div style='width:6%'>Sửa</div>
            <div style='width:6%'>Xóa</div>
        </div>
        <div class="clear"></div>
        
	<?php
		while($re_sp = mysql_fetch_assoc($sp))
		{
	?>
        <div class= 'lietke-sp-tr' data-id='<?php echo $re_sp['masp'] ?>'>
        	<div class='lietke-sp-td' style='width: 19%;  text-align: left; font-size: 11px'><?php echo $re_sp['masp'] ?></div>
            <div class='lietke-sp-td' style='width: 33%; text-align: left;'><?php echo $re_sp['tensp'] ?></div>
            <div class='lietke-sp-td' style='width: 21%; text-align: left;'><?php echo $re_sp['tenncc'] ?></div>
            <div class='lietke-sp-td' style='width: 11%; text-align: center;' ><?php echo $re_sp['sl'] ?></div>
            <div class='lietke-sp-td' style='width: 5%; text-align: center;'><a  href='admin.php?quanly=sanpham&ac=suasp&masp=<?php echo $re_sp['masp'] ?>'>Sửa</a></div>
            <div class='lietke-sp-td' style='width: 5%; text-align: center;'><a href='admin.php?quanly=sanpham&masp=<?php echo $re_sp['masp'] ?>' onclick="return ConfirmDel();">Xóa</a></div>
            <div class="clear"></div>
        </div>
        
        <div  class='ctsp<?php echo $re_sp['masp'] ?>' style="display: none; background: #EFFBF2; width: 98%;   padding: 10px; ">
                
                <div style="width: 100%; height: 30px; line-height: 30px;">
                	<div class='ctsp-item' 	style="font-weight: bold" >Màu sắc</div>
                    <div class='ctsp-item'  style="font-weight: bold; text-align: left;" >Ngày sản xuất</div>
                    <div class='ctsp-item'  style="font-weight: bold; text-align: left;" >Hạn sử dụng</div>
                    <div class='ctsp-item'  style="font-weight: bold;text-align: center;" >Số lượng</div>
                    <div class='ctsp-item'  style="font-weight: bold;text-align: center;" >Giá nhập</div>
                    <div class='ctsp-item'  style="font-weight: bold;text-align: center;" >Giá bán</div>
                </div>
                <div class="clear"></div>
                
                <?php
					foreach($arr_ctsp as $key => $value)
					{
						//echo "vô 1 <br/>";
						if($re_sp['masp'] == $arr_ctsp[$key]['masp'])
						{ 
				?>
                <div style="border-bottom: solid 1px #ccc; width: 100%">
                	<div class='ctsp-item'><?php echo $arr_ctsp[$key]['mausac']==""?"Không":$arr_ctsp[$key]['mausac'] ?></div>
                    <div class='ctsp-item' style="text-align: left;"><?php echo date('d/m/Y', strtotime($arr_ctsp[$key]['ngaysx'])) ?></div>
                    <div class='ctsp-item' style="text-align: left;"><?php echo date('d/m/Y', strtotime($arr_ctsp[$key]['hansudung'])) ?></div>
                    <div class='ctsp-item'><?php echo $arr_ctsp[$key]['soluong'] ?></div>
                    <div class='ctsp-item'><?php echo number_format($arr_ctsp[$key]['gianhap']) ?> đ</div>
                    <div class='ctsp-item'><?php echo number_format($arr_ctsp[$key]['giaban']) ?> đ</div>
                </div>
                <div class="clear"></div>
                <?php
						}
					}
				?>
                
                <div class="clear"></div>
        </div> <!-- end ctsp -->
    <?php
		}
	?>
    </div>

<!--
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
        <div  class='ctsp<?php echo $re_sp['masp'] ?>' style="display: none; background: #EFFBF2; width: 502%;   padding: 10px; ">
                
                <div style="width: 100%; height: 30px; line-height: 30px;">
                	<div class='ctsp-item' style="font-weight: bold" >Màu sắc</div>
                    <div class='ctsp-item'  style="font-weight: bold; text-align: left;" >Ngày sản xuất</div>
                    <div class='ctsp-item'  style="font-weight: bold; text-align: left;" >Hạn sử dụng</div>
                    <div class='ctsp-item'  style="font-weight: bold" >Số lượng</div>
                     <div class='ctsp-item'  style="font-weight: bold" >Giá bán</div>
                </div>
                <div class="clear"></div>
                
                <?php
					foreach($arr_ctsp as $key => $value)
					{
						//echo "vô 1 <br/>";
						if($re_sp['masp'] == $arr_ctsp[$key]['masp'])
						{ 
				?>
                <div style="border-bottom: solid 1px #ccc; width: 100%">
                	<div class='ctsp-item'><?php echo $arr_ctsp[$key]['mausac']==""?"Không":$arr_ctsp[$key]['mausac'] ?></div>
                    <div class='ctsp-item' style="text-align: left;"><?php echo date('d/m/Y', strtotime($arr_ctsp[$key]['ngaysx'])) ?></div>
                    <div class='ctsp-item' style="text-align: left;"><?php echo date('d/m/Y', strtotime($arr_ctsp[$key]['hansudung'])) ?></div>
                    <div class='ctsp-item'><?php echo $arr_ctsp[$key]['soluong'] ?></div>
                    <div class='ctsp-item'><?php echo number_format($arr_ctsp[$key]['giaban']) ?> đ</div>
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
-->

</div>