

<script>
	
	$(document).ready(function(e) {
   
		
		$('.btn-ctsp').click(function()
		{
			check = 1;
				masp = $('#masp').val();
				mausac = $('#mausac').val();
				ngaysx = $('#ngaysx').val();
				hsd = $('#hsd').val();
				//gianhap = $('#gianhap').val();
				giaban = $('#giaban').val();
				
				soluong = $('#soluong').val();
				if(soluong == "")
				{
					$('#soluong').next('.error').fadeIn();
					check = 0;
				}
				
				if(ngaysx == "")
				{
					$('#ngaysx').next('.error').fadeIn();
					check = 0;	
				}
				
				if(hsd == "")
				{
					$('#hsd').next('.error').fadeIn();
					check = 0;	
				}
				/*
				if(gianhap == "")
				{
					$('#gianhap').next('.error').fadeIn();
					check = 0;	
				}
				*/
				if(giaban == "")
				{
					$('#giaban').next('.error').fadeIn();
					check = 0;	
				}
			
			if($('.btn-ctsp').attr('id') == 'themctsp')
			{
				//ajax('them');

				//data = "ac=them&mausac="+mausac+"&ngaysx="+ngaysx+"&hsd="+hsd+"&gianhap="+gianhap+"&giaban="+giaban+"&soluong="+soluong;
				data = "ac=them&masp="+masp+"&mausac="+mausac+"&ngaysx="+ngaysx+"&hsd="+hsd+"&giaban="+giaban+"&soluong="+soluong;
				//alert(data);
				if(check)
				{
					$.ajax
					({
						url: "module/sanpham/xuly/xuly_sua.php",
						type: "post",
						data: data,
						dataType: "json", 
						async: true,
						success:function(kq)
						{
							//alert(kq.mausac + " - " + kq.soluong);
							$('#ctsp table:eq(1)').append("<tr><td>"+kq.mausac+"</td><td>"+kq.ngaysx+"</td><td>"+kq.hsd+"</td><td>"+kq.soluong+"</td><td>"+kq.giaban+"</td><td><a href='javascript:void(0)' class='edit-ctsp' data-id="+kq.mactsp+">Sửa</a></td><td><a href='javascript:void(0)' class='del-ctsp' data-id="+kq.mactsp+">Xóa</a></td></tr>");
							//$('#text').html(kq);
						},
						error: function (jqXHR, exception)
						{
							//alert("Lỗi rồi");
							 var msg = '';
							if (jqXHR.status === 0) {
								msg = 'Not connect.\n Verify Network.';
							} else if (jqXHR.status == 404) {
								msg = 'Requested page not found. [404]';
							} else if (jqXHR.status == 500) {
								msg = 'Internal Server Error [500].';
							} else if (exception === 'parsererror') {
								msg = 'Requested JSON parse failed.';
							} else if (exception === 'timeout') {
								msg = 'Time out error.';
							} else if (exception === 'abort') {
								msg = 'Ajax request aborted.';
							} else {
								msg = 'Uncaught Error.\n' + jqXHR.responseText;
							}
							alert(msg);
						}	
					});	
					$('#giaban').val(""); $('#gianhap').val(""); $('#soluong').val(""); $('#ngaysx').val(""); $('#hsd').val(""); $('#mausac').val("");
				}
			}
			else if($('.btn-ctsp').attr('id') == 'suactsp')
			{
				//id lấy từ edit-ctsp.click giống như biến toàn cục được bao bọc trong $(document).ready()
				data = "ac=sua&id="+id+"&mausac="+mausac+"&ngaysx="+ngaysx+"&hsd="+hsd+"&giaban="+giaban+"&soluong="+soluong;
				//alert(data);
				if(check)
				{
					$.ajax
					({
						url: "module/sanpham/xuly/xuly_sua.php",
						type: "post",
						data: data,
						//dataType: "json", 
						async: true,
						success:function(kq)
						{
							//$('#text').html(kq);
							$("a[data-id='"+id+"']").closest("tr").find("td:eq(0)").html(mausac);
							$("a[data-id='"+id+"']").closest("tr").find("td:eq(1)").html(ngaysx);
							$("a[data-id='"+id+"']").closest("tr").find("td:eq(2)").html(hsd);
							$("a[data-id='"+id+"']").closest("tr").find("td:eq(3)").html(soluong);
							$("a[data-id='"+id+"']").closest("tr").find("td:eq(4)").html(giaban);
						},
						error: function (jqXHR, exception)
						{
							//alert("Lỗi rồi");
							 var msg = '';
							if (jqXHR.status === 0) {
								msg = 'Not connect.\n Verify Network.';
							} else if (jqXHR.status == 404) {
								msg = 'Requested page not found. [404]';
							} else if (jqXHR.status == 500) {
								msg = 'Internal Server Error [500].';
							} else if (exception === 'parsererror') {
								msg = 'Requested JSON parse failed.';
							} else if (exception === 'timeout') {
								msg = 'Time out error.';
							} else if (exception === 'abort') {
								msg = 'Ajax request aborted.';
							} else {
								msg = 'Uncaught Error.\n' + jqXHR.responseText;
							}
							alert(msg);
						}	
					});	
					//id = "";
					$('#giaban').val(""); $('#gianhap').val(""); $('#soluong').val(""); $('#ngaysx').val(""); $('#hsd').val(""); $('#mausac').val("");
					$('.btn-ctsp').attr
					({
						value: "Thêm",
						id: "themctsp"
					});
					$('.cancle').hide();
					$('#giaban').removeAttr('readonly');	
					$('#soluong').removeAttr('readonly');	
				}
			}
			
			return false;
		});
		
		$('#ctsp table:eq(1)').delegate('.del-ctsp', 'click', function()
		{
			if(confirm('Bạn có chắc chắn muốn xóa không'))
			{
				id = $(this).attr('data-id');
				$.ajax
				({
					url: "module/sanpham/xuly/xuly_sua.php",
					type: "post",
					data: "ac=xoa&id="+id,
					async: true,
					success:function()
					{
						$("a[data-id='"+id+"']").closest("tr").fadeOut('fast');
					}
				});
			}
			return false;
		});
		
		$('#ctsp table:eq(1)').delegate('.edit-ctsp', 'click', function(){
			$('#giaban').prop('readonly', 'true');	
			$('#soluong').prop('readonly', 'true');	
			$('.btn-ctsp').attr
			({
				value: "Chỉnh sửa",
				id: "suactsp"
			});
			id = $(this).attr('data-id');
			//alert(id);
			$.ajax
					({
						url: "module/sanpham/xuly/xuly_sua.php",
						type: "post",
						data: "ac=get&id="+id,
						dataType: "json", 
						async: true,
						success:function(kq)
						{
							//alert(kq.mausac + " - " + kq.soluong);
							//$('#gianhap').val(kq.gianhap);
							
							$('#mausac').val(kq.mausac);
							$('#soluong').val(kq.soluong);
							$('#giaban').val(kq.giaban);
							$('#ngaysx').val(kq.ngaysx);
							$('#hsd').val(kq.hsd);
							
							//$('#text').html(kq);
						},
						error: function (jqXHR, exception)
						{
							//alert("Lỗi rồi");
							 var msg = '';
							if (jqXHR.status === 0) {
								msg = 'Not connect.\n Verify Network.';
							} else if (jqXHR.status == 404) {
								msg = 'Requested page not found. [404]';
							} else if (jqXHR.status == 500) {
								msg = 'Internal Server Error [500].';
							} else if (exception === 'parsererror') {
								msg = 'Requested JSON parse failed.';
							} else if (exception === 'timeout') {
								msg = 'Time out error.';
							} else if (exception === 'abort') {
								msg = 'Ajax request aborted.';
							} else {
								msg = 'Uncaught Error.\n' + jqXHR.responseText;
							}
							alert(msg);
						}	
					});	
			$('.cancle').show();
			return false;
			
		});
		
		$('.cancle').click(function()
		{
			$('.btn-ctsp').attr
			({
				value: "Thêm",
				id: "themctsp"
			});
			$('#giaban').val(""); $('#gianhap').val(""); $('#soluong').val(""); $('#ngaysx').val(""); $('#hsd').val(""); $('#mausac').val("");
			$('.cancle').hide();
			$('#giaban').removeAttr('readonly');	
			$('#soluong').removeAttr('readonly');	
		});
		
		$('#ngaysx, #hsd').click(function()
		{
			$(this).next('.error').fadeOut();
		});
			
		$('#soluong, #giaban, #gianhap, #ten_ncc').keyup(function()
		{
			$(this).next('.error').fadeOut();
		})
		
		
		$('#themncc').click(function()
		{
			$('#pop-ncc').fadeIn();	
		});
		
		$('#close-submit').click(function()
		{
			$('#pop-ncc').fadeOut();
		});
		
		$('.pop-sub-ncc').click(function()
		{
			check_ncc  = 1;
			ten_ncc = $('#ten_ncc').val(); diachi_ncc = $('#diachi_ncc').val(); sdt_ncc=$('#sdt_ncc').val(); ghichu_ncc = $('#ghichu_ncc').val(); email_ncc = $('#email_ncc').val();
			if(ten_ncc == "")
			{
				$('#ten_ncc').next('.error').fadeIn();
				check_ncc = 0;	
			}
			

			//alert(data);
			if(check_ncc)
			{
				$.ajax
				({
					url: "module/sanpham/xuly/xuly.php",
					type: "post",
					data: "ac=themncc&ten="+ten_ncc+"&diachi="+diachi_ncc+"&sdt="+sdt_ncc+"&ghichu="+ghichu_ncc+"&email="+email_ncc,
					async: true,
					success:function(kq)
					{
						$('#ncc').html(kq);
					}
				});	
				$('#pop-ncc').hide();
				$('#ten_ncc').val("");
				$('#diachi_ncc').val("");
				$('#sdt_ncc').val("");
				$('#ghichu_ncc').val("");
				$('#email_ncc').val("");	
			}
			return false;
		});
		
		$('.del-hinh').click(function()
		{
			if(confirm('Bạn có chắn chắn muốn xóa không'))
			{
				maha = $(this).attr('data-id');
				//alert(maha);
				$.ajax
				({
					url: "module/sanpham/xuly/xuly_sua.php",
					type: "post",
					data: "ac=xoahinh&maha="+maha,
					async: true,
					success:function(kq)
					{
						$("a[data-id='"+maha+"']").closest("li").fadeOut('fast');
					}
				});	
			}
			return false;
		});
		
		$('#ctsp table:eq(1) tr').click(function()
		{
			
			//alert('a');
			id = $(this).attr('data-id');
			//alert(id);
			$(this).after($('.phieunhap'+id).slideToggle());
			//$('.ctsp'+id).slideToggle();
		});
		
    });
	
	
	
</script>

<?php
	//unset($_SESSION['list-ctsp']);
	//unset($_FILES['file']);
	
	$masp = $_GET['masp'];
	
	$loi = array();
	$loi['masp'] = $loi['tensp'] = $loi['dvt'] = $loi['trongluong'] = $loi['thuonghieu'] = $loi['quycach'] = $loi['thue'] = $loi['mausac'] = $loi['soluong'] = $loi['gianhap'] = $loi['giaban'] = $loi['ngaysx'] = $loi['hsd'] = $loi['file'] = NULL;
	
	$tensp = $dvt = $trongluong = $thuonghieu = $quycach = $thue = $mausac = $soluong = $gianhap = $giaban = $ngaysx = $hsd = NULL;
	$check_sp = $check_ctsp = 1; $mota = $mancc = $madm = NULL;
	if(isset($_POST['ok']))
	{
		if(isset($_SESSION['list-ctsp']))
			echo "Có";
		else
			echo "ko";
		//echo "<pre>"; echo $_SESSION['list-ctsp']; echo "</pre>";

		$mota = $_POST['mota'];
			
		if(empty($_POST['tensp']))
		{
			$loi['tensp'] = "Vui lòng nhập tên sản phẩm";
			$check_sp = 0;
		}
		else
			$tensp = $_POST['tensp'];
			
		if(empty($_POST['dvt']))
		{
			$loi['dvt'] = "Vui lòng nhập đơn vị tính";
			$check_sp = 0;
		}
		else
			$dvt = $_POST['dvt'];
		
		if(empty($_POST['trongluong']))
		{
			$loi['trongluong'] = "Vui lòng nhập trọng lượng";
			$check_sp = 0;
		}
		else
			$trongluong = $_POST['trongluong'];
		
		if(empty($_POST['thuonghieu']))
		{
			$loi['thuonghieu'] = "Vui lòng nhập thương hiệu";
			$check_sp = 0;
		}
		else
			$thuonghieu = $_POST['thuonghieu'];
		
		if(empty($_POST['quycach']))
		{
			$loi['quycach'] = "Vui lòng nhập quy cách đóng gói";
			$check_sp = 0;
		}
		else
			$quycach = $_POST['quycach'];
		
		if(empty($_POST['thue']))
		{
			$loi['thue'] = "Vui lòng nhập số thuế";
			$check_sp = 0;
		}
		else
			$thue = $_POST['thue'];
		
		/*
		if(count($_FILES['file']['name'])==1)
		//if(count($_FILES['file']['name'])==0)
		{
			if(empty($_FILES['file']['name'][0]))
			{
				$check_sp = 0;
				$loi['file'] = "Vui lòng chọn ít nhất 1 file ảnh";
				unset($_FILES['file']);
			}
		}*/
		/*
		else if(count($_FILES['file']['name']) > 3)
		{
			$check_sp = 0;
			$loi['file'] = "Chỉ được upload tối đa 3 ảnh";
			unset($_FILES['file']);
		}*/
		
		if(isset($_FILES['file']['name']) && $_FILES['file']['name'][0] != "")
		{
			echo count($_FILES['file']['name']);
			echo "<br/>".$_FILES['file']['name'][0];
			foreach($_FILES['file']['name'] as $i => $value)
			{
				$list_ext = array('jpeg', 'jpg', 'png', 'PNG', 'gif', 'bmp');
				$explode = explode('.', $_FILES['file']['name'][$i]);
				$ext = end($explode);
				if(!in_array($ext, $list_ext))
				{
					$loi['file'] = "Chỉ được upload file ảnh có các đuôi: jpeg, jpg, gif, bmp";
					$check_sp = 0;
					break;
				}
			}
		}
			
		$mancc = $_POST['mancc']; $madm = $_POST['madm'];
		
		if($check_sp)
		{
			mysql_query("set names 'utf8'");
			
			$sp = mysql_query("update sanpham set tensp = '$tensp', donvitinh = '$dvt', trongluong = '$trongluong', thuonghieu = '$thuonghieu', quycachdonggoi = '$quycach', mota = '$mota', thue = $thue, mancc = '$mancc', madm = '$madm' where masp = '$masp'");
			if(!$sp)
				echo mysql_error();
			//$sp = mysql_query("insert into sanpham(masp, tensp, donvitinh, trongluong, thuonghieu, quycachdonggoi, mota, thue, mancc, madm, luotmua, trangthai) values('$masp', '$tensp', '$dvt', '$trongluong', '$thuonghieu', '$quycach', '$mota', $thue, '$mancc', '$madm', 0, 1) ");	
			
			
			foreach($_FILES['file']['name'] as $i => $value)
			{
				$name = $_FILES['file']['name'][$i];
				$temp = $_FILES['file']['tmp_name'][$i];
				$url = "../image/mypham/".basename($name);
				move_uploaded_file($temp, $url);
				
				$ha = mysql_query("select maha from hinhanh");
				if(mysql_num_rows($ha) == 0)
					$maha =  'HA1';
				else
				{
					$re_ha = mysql_fetch_assoc($ha);
					$number = substr($re_ha['maha'], 2);
				
					while($dong = mysql_fetch_assoc($ha))
					{
						$temp = substr($dong['maha'], 2);
						if($number < $temp)
							$number = $temp;
					}
					$maha = 'HA'.++$number;
				}				

				$kq = mysql_query("INSERT INTO HinhAnh VALUES('$maha', '$name', '$masp')");
				if(!$kq)
					echo mysql_error()."<br/>";
			}
			
			unset($_FILES['file']);
		}
	}
	else
	{
		
		mysql_query("set names 'utf8'");
		$sp = mysql_query("select sp.masp, sp.tensp, sp.donvitinh, trongluong, quycachdonggoi, mota, thue, thuonghieu, sp.madm, sp.mancc from sanpham sp where sp.masp = '$masp'");
		$re_sp = mysql_fetch_assoc($sp);
		$tensp = $re_sp['tensp'];
		$dvt = $re_sp['donvitinh'];
		$thuonghieu = $re_sp['thuonghieu'];
		$trongluong = $re_sp['trongluong'];
		$quycach = $re_sp['quycachdonggoi'];
		$mota = $re_sp['mota'];
		$thue = $re_sp['thue'];
		$mancc = $re_sp['mancc'];
		$madm = $re_sp['madm'];
	}
	/*
	if(isset($_POST['themctsp']))
	{
		if(empty($_POST['soluong']))
		{
			$loi['soluong'] = "Vui lòng nhập số lượng";
			$check_ctsp = 0;
		}	
		else
			$soluong = $_POST['soluong'];
		
		if(empty($_POST['gianhap']))
		{
			$loi['gianhap'] = "Vui lòng nhập giá nhập";
			$check_ctsp = 0;	
		}
		else
			$gianhap = $_POST['gianhap'];
		
		if(empty($_POST['giaban']))
		{
			$loi['giaban'] = "Vui lòng nhập giá bán";
			$check_ctsp = 0;
		}
		else
			$giaban = $_POST['giaban'];
			
		if(empty($_POST['ngaysx']))
		{
			$loi['ngaysx'] = "Vui lòng chọn ngày sản xuất";
			$check_ctsp = 0;
		}
		else
			$giaban = $_POST['giaban'];
			
	}
	*/
?>

<p class="title">CẬP NHẬT THÔNG TIN SẢN PHẨM</p><br />

<form method="post"  enctype="multipart/form-data">
<div id='parent' style="width: 52%; height: 100%; float: left; position: relative; border-right: solid 2px #ccc">
    <table>
    
        <tr>
            <td>Mã sản phẩm: </td>
            <td><input type='text' class='txt-sp' name="masp" id='masp' value="<?php echo $masp ?>"/></td>
            <?php
				if($loi['masp'] != NULL)
					echo "<td class='error'>".$loi['masp']."</td>";
			?>
            
        </tr>
    
        <tr>
            <td>Tên sản phẩm: </td>
            <td><input type='text' class='txt-sp' name="tensp" value="<?php echo $tensp ?>"/></td>
            <?php
				if($loi['tensp'] != NULL)
					echo "<td class='error'>".$loi['tensp']."</td>";
			?>
        </tr>
        
        <tr>
            <td>Đơn vị tính: </td>
            <td><input type='text' class='txt-sp' name="dvt" value="<?php echo $dvt ?>"/></td>
            <?php
				if($loi['dvt'] != NULL)
					echo "<td class='error'>".$loi['dvt']."</td>";
			?>
        </tr>
        
        <tr>
            <td>Trọng lượng: </td>
            <td><input type='text' class='txt-sp' name="trongluong" value="<?php echo $trongluong ?>"/></td>
            <?php
				if($loi['trongluong'] != NULL)
					echo "<td class='error'>".$loi['trongluong']."</td>";
			?>
        </tr>
        
        <tr>
            <td>Thương hiệu: </td>
            <td><input type='text' class='txt-sp' name="thuonghieu" value="<?php echo $thuonghieu ?>"/></td>
            <?php
				if($loi['thuonghieu'] != NULL)
					echo "<td class='error'>".$loi['thuonghieu']."</td>";
			?>
        </tr>
        
        <tr>
            <td>Quy cách đóng gói: </td>
            <td><input type='text' class='txt-sp' name="quycach" value="<?php echo $quycach ?>"/></td>
            <?php
				if($loi['quycach'] != NULL)
					echo "<td class='error'>".$loi['quycach']."</td>";
			?>
        </tr>
        
        <tr>
            <td>Mô tả: </td>
            <td><textarea name="mota" class="txt-sp"><?php echo $mota ?></textarea></td>
           
        </tr>
        
        <!--
        <tr>
            <td>Phân loại theo màu sắc: </td>
            <td><input type = 'checkbox' id = 'checkbox'/></td>
        </tr>
        -->
        
        
        <tr>
            <td>Nhà cung cấp: </td>
            <td>
            	<select class="cbb-sp" id="ncc" name="mancc">
                	<?php
						mysql_query("set names 'utf8'");
						$ncc = mysql_query("select mancc, tenncc from nhacungcap where trangthai = 1");
						while($re_ncc = mysql_fetch_assoc($ncc))
						{
							if($re_ncc['mancc'] == $mancc)
								echo "<option selected='selected' value='".$re_ncc['mancc']."'>".$re_ncc['tenncc']."</option>";
							else
								echo "<option value='".$re_ncc['mancc']."'>".$re_ncc['tenncc']."</option>";
						}
					?>	
                	
                </select>
                
            </td>
            <td><input value='+' id='themncc' type="button" class="sub" style="width: 90%; height: 38px; margin-left: -100%; text-align: center; font-size: 36px; line-height: 30px; font-weight: bold"/></td>
        </tr>
        
        <tr>
            <td>Thuế: </td>
            <td><input type='text' class='txt-sp' name="thue" value="<?php echo $thue ?>"/> %</td>
            <?php
				if($loi['thue'] != NULL)
					echo "<td class='error'>".$loi['thue']."</td>";
			?>
        </tr>
    
        <tr>
            <td>Loại sản phẩm: </td>
            <td>
            	<select class="cbb-sp loaisp" name="madm">
                	<?php
						mysql_query("set names 'utf8'");
						$dm = mysql_query("select madm, tendm from danhmuc");
						while($re_dm = mysql_fetch_assoc($dm))
						{
							if($re_dm['madm'] == $madm)
								echo "<option selected='selected' value='".$re_dm['madm']."'>".$re_dm['tendm']."</option>";
							else
								echo "<option value='".$re_dm['madm']."'>".$re_dm['tendm']."</option>";
						}
					?>	
                	
                </select>
            </td>
            <td></td>
        </tr>
        
        <tr>
        	<td>Chọn hình ảnh:</td>
            <td><input type='file' name='file[]' multiple="multiple" /></td>
            <?php
				if($loi['file'] != NULL)
					echo "<td class='error'>".$loi['file']."</td>";
			?>
        </tr>
        
    	<!--
        <tr>
            <td>Khuyến mãi áp dụng: </td>
            <td><input type='text' class="txt-sp"/></td>
            <td></td>
        </tr>
    -->
    
    	<tr>
        	<td></td>
            <td>
            	<div style='width: 100%; margin: auto;  margin-top: 3%;'>
                    <input type='submit' class='sub' style="width: 88%" name='ok' value='LƯU'/>
                </div>
            </td>
        	
        </tr>
    </table>
    
    <?php
		$hinhanh = mysql_query("select maha, duongdan from hinhanh where masp = '$masp'");
	?>
    
    
    <div style="width: 100%;  margin-top:3%;">
    	
        <p class="title">HÌNH ẢNH CHO SẢN PHẨM</p><br />
    	<ul>
        <?php
			while($re_ha = mysql_fetch_assoc($hinhanh))
			{
		?>
        		<li><img src="../image/mypham/<?php echo $re_ha['duongdan'] ?>" />
                	<a  href='javascript:void(0)' class="del-hinh" data-id="<?php echo $re_ha['maha'] ?>">Xóa</a>
                </li>
        <?php
			}
		?>
        <div class="clear"></div>
        </ul>
    </div>
    
</div>

<?php
	
	mysql_query("set names 'utf8'");
	
	$ctsp = mysql_query("select ctsp.mactsp, ctsp.mausac, ctsp.ngaysx, ctsp.hansudung, ctsp.soluong, ctsp.giaban
						from chitietsanpham ctsp
						where  ctsp.trangthai = 1 and ctsp.masp = '$masp'");
?>

<div id='ctsp' style="width: 46%; height: 100%; float: right;">
	
    <table>
    
    	<tr>
            <td>Màu sắc: </td>
            <td><input type='text' class='txt-sp' id='mausac' name='mausac'/></td>
        </tr>    	
        
        <tr>
            <td>Ngày sản xuất: </td>
            <td><input type = 'date' class="txt-sp" id='ngaysx' name='ngaysx'/>  <span class='error'> Vui lòng nhập ngày sản xuất</span></td>
            <td></td>
        </tr>
        
        <tr>
            <td>Hạn sử dụng: </td>
            <td><input type = 'date' class="txt-sp" id='hsd' name='hsd'/>  <span class='error'> Vui lòng nhập hạn sử dụng</span></td>
            <td></td>
        </tr>
        
        <tr>
            <td>Số lượng: </td>
            <td><input type='text' class='txt-sp' id='soluong' name='soluong'/> <span class='error'> Vui lòng nhập số lượng</span></td>
            <td></td>
        </tr>
        <!--
        <tr>
            <td>Giá nhập: </td>
            <td><input type='text' class='txt-sp' id='gianhap' name='gianhap'/>  <span class='error'> Vui lòng nhập giá nhập</span></td>
            <td></td>
        </tr>
        -->
        <tr>
            <td>Giá bán: </td>
            <td><input  type='text' class='txt-sp' id='giaban' name='giaban'/>  <span class='error'> Vui lòng nhập giá bán</span></td>
            <td></td>
        </tr>
      
        <tr>
        	<td></td>
            <td><input type='button' value='Thêm ' name='themctsp' class="sub btn-ctsp" id='themctsp' style="width: 45%"/>
            	<input type='button' value='Hủy bỏ' class="sub cancle" style="width: 45%; display: none"/>
            </td>
            <td></td>
        </tr>
    	
    </table>
    
    <table class='tb-lietke'>
    	
        <tr>
        	<th>Màu sắc</th>
            
            <th>NSX</th>
            <th>HSD</th>
            <th>Số lượng</th>
            <th>Giá bán</th>
            <th>Sửa</th>
            <th>Xóa</th>
        </tr>
        
        <?php
		
			while($re_ctsp = mysql_fetch_assoc($ctsp))
			{
					//echo $key." ";
		?>
        		<tr data-id='<?php echo $re_ctsp['mactsp'] ?>'>
                    <td><?php echo $re_ctsp['mausac']==""?"Không":$re_ctsp['mausac'] ?></td>
                    <td><?php echo $re_ctsp['ngaysx'] ?></td>
                    <td><?php echo $re_ctsp['hansudung']?></td>
                    <td><?php echo $re_ctsp['soluong'] ?></td>
                    <td><?php echo number_format($re_ctsp['giaban']) ?></td>
                    
                    <td><a href='javascript:void(0)' data-id=<?php echo $re_ctsp['mactsp'] ?> class='edit-ctsp'>Sửa</a></td>
                    <td><a href='javascript:void(0)' data-id=<?php echo $re_ctsp['mactsp'] ?>  class='del-ctsp'>Xóa</a></td>
                </tr>
                <div  class='phieunhap<?php echo $re_ctsp['mactsp'] ?>' style="display: none; background: #EFFBF2; width: 250%;   padding: 10px; ">
                
                    <div style="width: 100%; height: 30px; line-height: 30px; font-weight: bold;">
                        <div class='ctsp-item'  >Mã phiếu</div>
                        <div class='ctsp-item'  style="text-align: left;" >Ngày nhập</div>
                        <div class='ctsp-item'  style="text-align: left;" >Số lượng nhập</div>
                        <div class='ctsp-item' >Giá nhập</div>
                    </div>
                    <div class="clear"></div>
                    
                    <?php
						mysql_query("set names 'utf8'");
						$phieunhap = mysql_query("select mactsp, maphieu, ngaynhap, soluong, gianhap from phieunhap where mactsp = '".$re_ctsp['mactsp']."'");
                        while($re_pn = mysql_fetch_assoc($phieunhap))
                        {

                    ?>
                    <div style="border-bottom: solid 1px #ccc; width: 100%">
                        <div class='ctsp-item'><a href='#'><?php echo $re_pn['maphieu'] ?></a></div>
                        <div class='ctsp-item' style="text-align: left;"><?php echo date('d/m/Y', strtotime($re_pn['ngaynhap'])) ?></div>
                        <div class='ctsp-item' style="text-align: left;"><?php echo $re_pn['soluong'] ?></div>
                        <div class='ctsp-item'><?php echo $re_pn['gianhap'] ?></div>
                    </div>
                    <div class="clear"></div>
                    <?php
                        }
                    ?>
                    
                    <div class="clear"></div>
        		</div>
				<div class="clear"></div>
        <?php	
			}
		?>
        
    </table>
    
</div>
<div class="clear"></div>


</form>



<div id='pop-ncc' class="popup" style="width: 50%; height: 500px; border: solid 1px; position: absolute; top: 15%; left: 35%;background: #EFF8FB; display: none; margin: auto;">

	<div>
    	<h3>Thêm nhà cung cấp</h3>
        <img style="float: right; padding-top: 5px; padding-right: 5px;" src="../image/close.PNG" id='close-submit'/>
    </div>

	<form>
            	<!--<input type='hidden' name='quanly' value='nhacc'/>-->
                <table>
                    <tr>
                        <td>Tên nhà cung cấp:</td>
                        <td><input type='text' id='ten_ncc' value=''/><span class="error" style="display: none">Vui lòng nhập tên</span></td>
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
                        <td><input type='button'  class='pop-sub-ncc' style="background: #F90" value='Thêm' />
                        </td>
                    </tr>
                </table>
            </form>
</div>



<div id='text'>
	aaaaaaaaa
</div>