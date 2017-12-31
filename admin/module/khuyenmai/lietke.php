<?php
	mysql_query("set names 'utf8'");
	$km = mysql_query("	select	km.makm, km.masp, km.chietkhau, km.tiengiamgia, km.giatrivoucher, km.giatridonhang, mota, ctkm.ngaybd, ctkm.ngaykt
						from	khuyenmai km, ctsp_km ctkm
						where	km.makm = ctkm.makm and km.trangthai = 1
						group by km.makm");
	if(!$km)
		echo mysql_error();
		
	date_default_timezone_set('Asia/Ho_Chi_Minh');
	$date = date('Y-m-d');
	$ngaybd = $ngaykt = $voucher_bd = $voucher_kt = $date;
	
	$keyword = "";
	
	if(isset($_POST['loc']))
	{
		$ngaybd = $_POST['ngaybd']; $ngaykt = $_POST['ngaykt'];
		$km = mysql_query("	select	km.makm, km.masp, km.chietkhau, km.tiengiamgia, km.giatrivoucher, km.giatridonhang, mota, ctkm.ngaybd, ctkm.ngaykt
							from	khuyenmai km, ctsp_km ctkm
							where	km.makm = ctkm.makm and km.trangthai = 1
								and	(ctkm.ngaybd >= '$ngaybd' and ctkm.ngaykt <= '$ngaykt')
							group by km.makm");
	}
	
	if(isset($_POST['search']))
	{
		$keyword = mysql_escape_string($_POST['keyword']);
		$km = mysql_query("	select	km.makm, km.masp, km.chietkhau, km.tiengiamgia, km.giatrivoucher, km.giatridonhang, mota, ctkm.ngaybd, ctkm.ngaykt
							from	khuyenmai km, ctsp_km ctkm
							where	km.makm = ctkm.makm and km.trangthai = 1
								and	km.makm LIKE '%$keyword%'
							group by km.makm");
	}
?>




<div id='category' style='width: 12.5%; float: right;'>
    	<ul class="menu" style="margin-left: 0px">
        	<li><a href='javascript:void(0)'>Thêm mới</a>
            	<ul>
                	<li><a href='admin.php?quanly=khuyenmai&ac=them'>Tạo khuyến mãi</a></li>
                    <li><a href='javascript:void(0)' id="in">In phiếu mua hàng</a></li>
                </ul>
            </li>
        </ul>
</div>
<div class="clear"></div>

<script>
	
	$(document).ready(function(e) {
        
		$('#tb-km tr').click(function()
		{
			id = $(this).attr('data-id');	
			$(this).after($('.km'+id).slideToggle());
		});
		
		$('#voucher_soluong').keyup(function()
		{
			$('#voucher_soluong').next('.error').fadeOut();	
		});
		$('#voucher_trigia').keyup(function()
		{
			$('#voucher_trigia').next('.error').fadeOut();
		});
		
		$('#in_voucher').click(function()
		{
			check_pmh = 1;
			soluong = $('#voucher_soluong').val();
			if(soluong == "")
			{
				$('#voucher_soluong').next('.error').html("Vui lòng nhập số lượng phiếu cần in");
				$('#voucher_soluong').next('.error').fadeIn();	
				check_pmh = 0;
			}
			else
			{
				if(isNaN(soluong))
				{
					$('#voucher_soluong').next('.error').html("Chỉ được nhập từ 0 đến 9");
					$('#voucher_soluong').next('.error').fadeIn();	
					check_pmh = 0;
				}
				
			}
			
			trigia = $('#voucher_trigia').val();
			if(trigia == "")
			{
				$('#voucher_trigia').next('.error').html("Vui lòng nhập trị giá cho phiếu mua hàng");
				$('#voucher_trigia').next('.error').fadeIn();
				check_pmh = 0;	
			}
			else
			{
				if(isNaN(trigia))
				{
					$('#voucher_trigia').next('.error').html("Chỉ được nhập từ 0 đến 9");
					$('#voucher_trigia').next('.error').fadeIn();	
					check_pmh = 0;
				}
				
			}
			
			if(check_pmh == 1)
			{
				voucher_bd = $('#voucher_bd').val(); voucher_kt = $('#voucher_kt').val();
				$.ajax
				({
					url: "module/khuyenmai/xuly/xuly.php",
					data: "ac=in&trigia="+trigia+"&soluong="+soluong+"&voucher_bd="+voucher_bd+"&voucher_kt="+voucher_kt,
					type: "post",
					async: true,
					success:function(kq)
					{
						alert('Thêm thành công!');	
					}
				});
				$('#voucher_soluong').val(""); $('#voucher_trigia').val("");
				return false;
			}
		});
		
		$('#in').click(function()
		{
			$('#voucher').fadeIn();	
		});
		
		$('#close-submit').click(function()
		{
			$('#voucher').fadeOut();
		});
		
		//---------------------- XÓA KHUYẾN MÃI ----------------------------///
		$('#tb-km').delegate('.del-km', 'click', function()
		{
			if(confirm("Bạn có chắc chắn muốn xóa chương trình khuyến mãi này?"))
			{
				makm = $(this).attr('data-makm');	//alert(makm);
				$.ajax
				({
					url: "module/khuyenmai/xuly/xuly.php",
					type: "post",
					async: true,
					data: "ac=xoakm&makm="+makm,
					success:function()
					{
						$("a[data-makm='"+makm+"']").closest("tr").fadeOut('fast');
						alert('Xóa thành công!');
					}
				});
			}
			return false;
		});
		

    });
	
</script>

<form method="post">
<div id="km-left" style="width: 22%; float: left; font-size: 13px;">

	<div>
    	<p style="background: #088A68; border-radius: 3px; font-size: 16px; color: white; font-weight: bold; padding: 5px 5px;">Tìm kiếm</p>
        <br />
        <input type='text' name="keyword" value='<?php echo $keyword ?>' class="txt-sp" style="width: 50%" placeholder='Nhập mã khuyến mãi'/>
        <input type='submit' name="search" class="sub" style="width: 20%" value="Tìm"/>
    </div>
	

	<div>
    	<p style="background: #088A68; border-radius: 3px; font-size: 16px; color: white; font-weight: bold; padding: 5px 5px;">Lọc theo</p>
        <br />
        Ngày bắt đầu: <input name='ngaybd' value="<?php echo $ngaybd ?>" type='date' class="txt-sp"/><br />
        Ngày kết thúc: <input name='ngaykt' value="<?php echo $ngaykt ?>" type='date' class="txt-sp"/>
        <input type='submit' name="loc" value="Lọc" class="sub" style="width: 80%"/>
    </div>
    <input type="hidden" name="quanly" value="khuyenmai"/>
    <input type="hidden" name="ac" value="lietke"/>
</div>
</form>

<div style="width: 75%; float: right; font-size: 13px;">

	<table id='tb-km' width="100%" class="tb-lietke">
    	
        <tr>
        	<th width="62%">Hình thức khuyến mãi</th>
            <th width="18%">Thời hạn</th>
            <th width="5%">Sửa</th>
            <th width="5%">Xóa</th>
        </tr>
        
         <?php
			
			while($re_km = mysql_fetch_assoc($km))
			{
		?>
        
        <tr data-id="<?php echo $re_km['makm'] ?>">
        	<td>
				<p><?php echo $re_km['makm'] ?><p>
                <p>
                	<?php
						$hinhthuc = "";
						if($re_km['chietkhau'] != "0")
						{
							$hinhthuc = "Giảm ".$re_km['chietkhau']."% ";
						}
						else if($re_km['tiengiamgia'] != "0")
						{
							$hinhthuc = "Giảm ".number_format($re_km['tiengiamgia'])."đ ";	
						}
						else if($re_km['giatrivoucher'] != "0")
						{
							$hinhthuc = "Tặng phiếu mua hàng trị giá ".number_format($re_km['giatrivoucher'])."đ ";	
						}
						else if($re_km['chietkhau']==0 &&  $re_km['tiengiamgia']==0  && $re_km['giatrivoucher']==0)
						{
							$hinhthuc = "Tặng quà";	
						}
						echo $hinhthuc;
					?>
                
                	<?php
						$doituong = "";
						if($re_km['giatridonhang'] != "0")
						{
							$doituong = " cho hóa đơn có trị giá từ ".number_format($re_km['giatridonhang'])."đ";
						}
						else if($re_km['masp'] != "")
						{
							mysql_query("set names 'utf8'");
							$sp = mysql_query("select masp, tensp from sanpham where masp='".$re_km['masp']."'");
							$re_sp = mysql_fetch_assoc($sp);
							$doituong = " khi mua sản phẩm ".$re_sp['tensp']." ";
						}
						else
						{
							$doituong = " cho tất cả các hóa đơn";
						}
						echo $doituong;
					?>
                </p>
                <p>Ghi chú:
                	<?php echo $re_km['mota'] ?>
                </p>
            </td>
            <td>
				<p>Bắt đầu: <?php echo date('d/m/Y', strtotime($re_km['ngaybd'])) ?></p>
	            <p>Kết thúc: <?php echo date('d/m/Y', strtotime($re_km['ngaykt'])) ?></p>
            </td>
            <td><a href='admin.php?quanly=khuyenmai&ac=sua&makm=<?php echo $re_km['makm'] ?>' class="edit-km" data-makm="<?php echo $re_km['makm'] ?>">Sửa</a></td>
            <td><a href='javascript:void(0)' class="del-km" data-makm="<?php echo $re_km['makm'] ?>">Xóa</a></td>
        </tr>
        <?php
			if($re_km['chietkhau']==0 &&  $re_km['tiengiamgia']==0 && $re_km['giatrivoucher'] == 0)
			{
		?>
        	<div class='km<?php echo $re_km['makm'] ?>'  style="display: none; background: #EFFBF2; width: 142%;   padding: 10px; border: solid 1px; ">
            	<div style="width: 100%; height: 20px; line-height: 10px;">
                	<div class='ctsp-item' style="font-weight: bold; width: 35%" >Tên SP</div>
                	<div class='ctsp-item' style="font-weight: bold" >Màu sắc</div>
                    <div class='ctsp-item' style="font-weight: bold; text-align: left;" >Ngày sản xuất</div>
                    <div class='ctsp-item' style="font-weight: bold; text-align: left;" >Hạn sử dụng</div>
                </div>
                <div class="clear"></div>
                
                <?php

				
					mysql_query("set names 'utf8'");
					$ctsp = mysql_query("select ctsp.masp, ctsp.mactsp, tensp, ctsp.mausac, ctsp.ngaysx, ctsp.hansudung
										from 	chitietsanpham ctsp, sanpham sp, ctsp_km ctkm
										where	ctkm.makm = '".$re_km['makm']."' and ctkm.mactsp = ctsp.mactsp and ctsp.masp = sp.masp");
					while($re_ctsp = mysql_fetch_assoc($ctsp))
					{

				?>
                <div style="border-bottom: solid 1px #ccc; width: 100%">
                	<div class='ctsp-item' style="width: 35%; text-align: left;"><?php echo $re_ctsp['tensp'] ?></div>
                	<div class='ctsp-item'><?php echo $re_ctsp['mausac']==""?"Không":$re_ctsp['mausac'] ?></div>
                    <div class='ctsp-item' style="text-align: left;"><?php echo date('d/m/Y', strtotime($re_ctsp['ngaysx'])) ?></div>
                    <div class='ctsp-item' style="text-align: left;"><?php echo date('d/m/Y', strtotime($re_ctsp['hansudung'])) ?></div>
                </div>
                <div class="clear"></div>
                <?php
						
					}
				?>
                
                <div class="clear"></div>
            </div>
        <?php	
			}
		?>
        <?php
			}
		?>
    </table>
	
</div>
<div class="clear"></div>

<div class="popup" id='voucher' style="width: 40%;border: solid 1px; position: absolute; top: 20%; left: 32%;background: #EFF8FB;  margin: auto; display: none">

	<div>
    	<h3>In phiếu mua hàng</h3>
        <img style="float: right; padding-top: 5px; padding-right: 5px;" src="../image/close.PNG" id='close-submit'/>
    </div>
    
    
    	<table>
        	<tr>
            	<td>Ngày có hiệu lực:</td>
                <td><input value="<?php echo $voucher_bd ?>" type="date" id="voucher_bd" class="txt-sp" /></td>
            </tr>
            <tr>
            	<td>Ngày hết hạn:</td> 
                <td><input value="<?php echo $voucher_bd ?>" type="date" id="voucher_kt" class="txt-sp" /></td>
            </tr>
            <tr>
            	<td>Trị giá:</td>
                <td><input value="" type="text" id="voucher_trigia" class="txt-sp" style="width: 200px;"/>
                	<p class="error" style="display: none"></p>
                </td>
            </tr>
            <tr>
            	<td>Số lượng:</td>
                <td><input value="" type="text" id="voucher_soluong" class="txt-sp" style="width: 200px;"/>
                	<p class="error" style="display: none"></p>
                </td>
            </tr>
            <tr>
            	<td></td>
                <td><input value="In phiếu" type="button" id="in_voucher" class="sub" style="width: 220px;"/></td>
            </tr>
        </table>
    

</div>

<!--

 <table width="100%" class="tb-lietke">
    	
        <tr>
        	<th width="10%">Mã khuyến mãi</th>
            <th width="10%">Hình thức</th>
            <th width="25%">Đối tượng áp dụng</th>
            <th width="31%">Ghi chú</th>
            <th width="15%">Thời hạn</th>
            <th width="4%">Sửa</th>
            <th width="4%">Xóa</th>
        </tr>
        
       
        
        <?php
			
			while($re_km = mysql_fetch_assoc($km))
			{
		?>
        
        <tr>
        	<td><?php echo $re_km['makm'] ?></td>
            <td>
            	<?php
					if($re_km['chietkhau'] != "0")
					{
						$hinhthuc = "Giảm ".$re_km['chietkhau']."% ";
					}
					else if($re_km['tiengiamgia'] != "0")
					{
						$hinhthuc = "Giảm ".number_format($re_km['tiengiamgia'])."đ ";	
					}
					else if($re_km['slqt'] >= 2)
					{
						$hinhthuc = "Tặng quà";	
					}
					echo $hinhthuc;
				?>
            </td>
            <td>
            	<?php
					if($re_km['giatridonhang'] != "0")
					{
						$doituong = "Hóa đơn có trị giá từ ".number_format($re_km['giatridonhang'])."đ";
					}
					else if($re_km['masp'] != "")
					{
						mysql_query("set names 'utf8'");
						$sp = mysql_query("select masp, tensp from sanpham where masp='".$re_km['masp']."'");
						$re_sp = mysql_fetch_assoc($sp);
						$doituong = "Áp dụng cho sản phẩm ".$re_sp['tensp']." ";
					}
					else
					{
						$doituong = "Tất cả các hóa đơn";
					}
					echo $doituong;
				?>
            </td>
            <td style="text-align: center"><?php echo $re_km['mota'] ?></td>
            <td><?php echo date('d/m/Y', strtotime($re_km['ngaybd']))." - ".date('d/m/Y', strtotime($re_km['ngaykt'])) ?></td>
            <td><a href='#'>Sửa</a></td>
            <td><a href='#'>Xóa</a></td>
        </tr>
        <?php
			}
		?>
        
        
        
    </table>

->>