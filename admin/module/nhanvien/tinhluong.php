<script>

	$(document).ready(function(e) {
        
		$('#tinhluong-left input[type=text]').keyup(function()
		{
			if(isNaN($(this).val()))
			{
				$(this).val(0);	
			}
		});
		
		$('#tinhluong-left table').delegate('#chucvu', 'change', function()
		{
			macv = $(this).val(); 
			$.ajax
			({
				url: "module/nhanvien/xuly/luong_xuly.php",
				type: "post",
				data: "ac=get_cv&macv="+macv,
				async: true,	
				dataType: "json",
				success:function(kq)
				{
					//alert(kq.heso + " - " + kq.phucap);
					$('#heso').val(kq.heso);
					$('#phucap').val(kq.phucap);

				}		
			});
			return false;
		});
		
    });

</script>



<?php

	$manv = isset($_GET['manv']) ? $_GET['manv'] : "";

	$loi['songaycong'] = $loi['luongcb'] = $loi['thuong'] = $loi['phat'] = NULL;

	$heso = $phucap = $songaycong = $luongcb = $thuong = $phat = 0; $macv = "";
	
	if(isset($_POST['tinhluong']))
	{
		$check = 1;
		$macv = $_POST['chucvu'];
		$songaycong = $_POST['songaycong'];	$luongcb = $_POST['luongcb']; $thuong = $_POST['thuong'];	$phat = $_POST['phat'];	
		if($songaycong == 0)
		{
			$check = 0; $loi['songaycong'] = "Vui lòng nhập số ngày công";
		}
		if($luongcb == 0)
		{
			$check = 0; $loi['luongcb'] = "Vui lòng nhập lương cơ bản";
		}
		
		if($check == 1)
		{
			$maluong = Tao_MaLuong();
			date_default_timezone_set('Asia/Ho_Chi_Minh');
			$date = date('Y-m-d');
			mysql_query("set names 'utf8'");
			$kq = mysql_query("insert into chitietluong values('$maluong', '$manv', '$macv', '$date', $thuong, $phat, $songaycong, $luongcb)");
			echo "<script>alert('Thao tác thành công');</script>";
			//header('location: admin.php?quanly=nhanvien&ac=lietke');
		}
	}

	mysql_query("set names 'utf8'");
	$chucvu = mysql_query("select macv, tencv, hesoluong, phucap from chucvu where trangthai = 1");
	
	mysql_query("set names 'utf8'");
	$nhanvien = mysql_query("select nv.manv, tennv, ngay, hesoluong, phucap, maluong, songaycong, luongcoban, cv.macv, cv.tencv, thuong, phat from chucvu cv, nhanvien nv, chitietluong ctl
							where ctl.manv = '$manv' and ctl.manv = nv.manv and ctl.macv = cv.macv");
	mysql_query("set names 'utf8'");
	$kq = mysql_query("select manv, tennv from nhanvien where manv = '$manv'");
	$re_kq = mysql_fetch_assoc($kq);
?>
<?php
	function Tao_MaLuong()
	{
		mysql_query("set names 'utf8'");
		$result = mysql_query("select maluong from chitietluong");
		if(mysql_num_rows($result) == 0)
			return 'MaL1';
			
		$re_dong = mysql_fetch_assoc($result);
			
		$number = substr($re_dong['maluong'], 3);
			
		while($re_dong = mysql_fetch_assoc($result))
		{
			$temp = substr($re_dong['maluong'], 3);
			if($number < $temp)
				$number = $temp;
		}
		
		return 'MaL'.++$number;	
	}
?>

<div style="width: 73%; float: right; text-align: left;">
	<p>Nhân viên: <?php echo $re_kq['tennv'] ?></p>
</div>

<div class="clear"></div>
<div id='tinhluong-left'>
	<form method="post">
	<table>
    	<tr>
        	<td>Chức vụ:</td>
            <td>
            	<select class='cbb-sp' id='chucvu' name='chucvu'>
                	<?php
					$dem = 0;
						while($re_cv = mysql_fetch_assoc($chucvu))
						{
							if($dem++ == 0 && !isset($_POST['tinhluong']))
							{
									$heso = $re_cv['hesoluong']; $phucap = $re_cv['phucap'];
							}
							if($re_cv['macv'] == $macv)
							{
								echo "<option selected='selected' value='".$re_cv['macv']."'>".$re_cv['tencv']."</option>";	
								$heso = $re_cv['hesoluong']; $phucap = $re_cv['phucap'];	
							}
							else
								echo "<option value='".$re_cv['macv']."'>".$re_cv['tencv']."</option>";
						}
						
					?>
                </select>
            </td>
        </tr>
        <tr>
        	<td>Hệ số lương:</td>
            <td><input type='text' class="txt-sp" readonly="readonly" id='heso' name = "heso" value="<?php echo $heso ?>"/></td>
        </tr>
     
        <tr>
        	<td>Phụ cấp:</td>
            <td><input type='text ' class="txt-sp" readonly="readonly" id='phucap' name = "phucap" value="<?php echo $phucap ?>"/></td>
        </tr>
        <tr>
        	<td>Lương cơ bản:</td>
            <td><input type='text' class="txt-sp" name = "luongcb" value="<?php echo $luongcb ?>"/></td>
        </tr>
	<?php
		if($loi['luongcb'] != NULL)
		{
			echo "<tr>";
        	echo 	"<td colspan='2'><span class='error'>".$loi['luongcb']."</span></td>";
        	echo "</tr>";
		}
	?>
      
        <tr>
        	<td>Số ngày công:</td>
            <td><input type='text' class="txt-sp" name = "songaycong" value="<?php echo $songaycong ?>"/></td>
        </tr>
    <?php
		if($loi['songaycong'] != NULL)
		{
			echo "<tr>";
        	echo 	"<td colspan='2'><span class='error'>".$loi['songaycong']."</span></td>";
        	echo "</tr>";
		}
	?>
       
        <tr>
        	<td>Thưởng:</td>
            <td><input type='text' class="txt-sp" name = "thuong" value="<?php echo $thuong ?>"/></td>
        </tr>
        <tr>
        	<td>Phạt:</td>
            <td><input type='text' class="txt-sp" name = "phat" value="<?php echo $phat ?>"/></td>
        </tr>
        <tr>
            <td colspan="2"><input type='submit' style="width: 100%" class="sub" name = "tinhluong" value="TÍNH LƯƠNG"/></td>
        </tr>
    </table>
	</form>
</div>


<div id='tinhluong-right' style="width: 73%; float: right">

	<table width="100%" border="1" class="tb-lietke">
    	
        <tr>
        	<th width='9%'>Ngày</th>
            <th width='15%'>Tên NV</th>
            <th width='15%'>Chức vụ</th>
            <th width='6%'>Hệ số</th>
            <th width='10%'>Phụ cấp</th>
            <th width='9%'>Lương CB</th>
            <th width='8%'>Số ngày</th>
            <th width='9%'>Thưởng</th>
            <th width='9%'>Phạt</th>
            <th width='10%'>Tổng</th>
        </tr>
        
    <?php
		while($re_nv =mysql_fetch_assoc($nhanvien))
		{
				$tong = ($re_nv['songaycong'] * $re_nv['luongcoban']) * $re_nv['hesoluong'] + $re_nv['thuong'] - $re_nv['phat'] + $re_nv['phucap'];
	?>
    	<tr>
        	<td><?php echo date('d-m-Y', strtotime($re_nv['ngay'])) ?></td>
            <td><?php echo $re_nv['tennv'] ?></td>
            <td><?php echo $re_nv['tencv'] ?></td>
            <td><?php echo $re_nv['hesoluong'] ?></td>
            <td><?php echo number_format($re_nv['phucap']) ?></td>
            <td><?php echo number_format($re_nv['luongcoban']) ?></td>
            <td><?php echo $re_nv['songaycong'] ?></td>
            <td><?php echo number_format($re_nv['thuong']) ?></td>
            <td><?php echo number_format($re_nv['phat']) ?></td>
            <td><?php echo number_format($tong) ?></td>
        </tr>
    <?php	
		}
	?>
        
    </table>

</div>

<div class="clear"></div>