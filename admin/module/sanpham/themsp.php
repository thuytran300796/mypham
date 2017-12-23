<script>
	/*
	$(document).ready(function(e) {
        
		$('#checkbox').change(function()
		{
			check = $('#checkbox').prop('checked');
			if(check)
			{
				$('#giaban').closest('tr').hide();
				$('#gianhap').closest('tr').hide();
				$('#ngaysx').closest('tr').hide();
				$('#hsd').closest('tr').hide();
				$('#soluong').closest('tr').hide();
				$('#ncc').closest('tr').hide();
				$('#phanloai').show();
			}
			else
			{
				$('#giaban').closest('tr').show();
				$('#gianhap').closest('tr').hide();
				$('#ngaysx').closest('tr').show();
				$('#hsd').closest('tr').show();
				$('#soluong').closest('tr').show();	
				$('#ncc').closest('tr').show();
				$('#phanloai').hide();
			}
		});
		
		$('#themctsp').click(function()
		{
			mausac = $('.mausac').val();
			soluong = $('.soluongctsp').val();
			ngaysx = $('.soluongctsp').val();
			hsd = $('.hsd').val();
			giaban = $('.giaban').val();
			gianhap = $('.gianhap').val();
			ncc = $('.ncc').val();
			
			$.ajax
			({
				url: "module/sanpham/xuly/xuly.php",	
				type: "post",
				data: "ad=themctsp&mausac="+mausac+"&soluong="+soluong+"&ngaysx="+ngaysx+"&hsd="+hsd+"&giaban="+giaban+"&gianhap="+gianhap+"&ncc="+ncc,
				async: true,
				dataType: "json",
				success:function(kq)
				{
					
				}
			});
			
		});
		
		$('#soluong').keyup(function()
		{
			
		});
		
    });
	*/
</script>

<script>
	
	$(document).ready(function(e) {
   
		$('.btn-ctsp').click(function()
		{
			check = 1;
				
				mausac = $('#mausac').val();
				ngaysx = $('#ngaysx').val();
				hsd = $('#hsd').val();
				gianhap = $('#gianhap').val();
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
				
				if(gianhap == "")
				{
					$('#gianhap').next('.error').fadeIn();
					check = 0;	
				}
				
				if(giaban == "")
				{
					$('#giaban').next('.error').fadeIn();
					check = 0;	
				}
			
			if($('.btn-ctsp').attr('id') == 'themctsp')
			{
				//ajax('them');

				data = "ac=them&mausac="+mausac+"&ngaysx="+ngaysx+"&hsd="+hsd+"&gianhap="+gianhap+"&giaban="+giaban+"&soluong="+soluong;
				//alert(data);
				if(check)
				{
					$.ajax
					({
						url: "module/sanpham/xuly/xuly.php",
						type: "post",
						data: data,
						dataType: "json", 
						async: true,
						success:function(kq)
						{
							//alert(kq.mausac + " - " + kq.soluong);
							$('#ctsp table:eq(1)').append("<tr><td>"+kq.mausac+"</td><td>"+kq.ngaysx+"</td><td>"+kq.hsd+"</td><td>"+kq.soluong+"</td><td>"+kq.gianhap+"</td><td>"+kq.giaban+"</td><td><a href='javascript:void(0)' class='edit-ctsp' data-id="+kq.id+">Sửa</a></td><td><a href='javascript:void(0)' class='del-ctsp' data-id="+kq.id+">Xóa</a></td></tr>");
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
				data = "ac=sua&id="+id+"&mausac="+mausac+"&ngaysx="+ngaysx+"&hsd="+hsd+"&gianhap="+gianhap+"&giaban="+giaban+"&soluong="+soluong;
				//alert(data);
				if(check)
				{
					$.ajax
					({
						url: "module/sanpham/xuly/xuly.php",
						type: "post",
						data: data,
						//dataType: "json", 
						async: true,
						success:function()
						{
							$("a[data-id='"+id+"']").closest("tr").find("td:eq(0)").html(mausac);
							$("a[data-id='"+id+"']").closest("tr").find("td:eq(1)").html(ngaysx);
							$("a[data-id='"+id+"']").closest("tr").find("td:eq(2)").html(hsd);
							$("a[data-id='"+id+"']").closest("tr").find("td:eq(3)").html(soluong);
							$("a[data-id='"+id+"']").closest("tr").find("td:eq(4)").html(gianhap);
							$("a[data-id='"+id+"']").closest("tr").find("td:eq(5)").html(giaban);
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
				}
			}
			
			return false;
		});
		
		$('#ctsp table:eq(1)').delegate('.del-ctsp', 'click', function()
		{
			id = $(this).attr('data-id');
			$.ajax
			({
				url: "module/sanpham/xuly/xuly.php",
				type: "post",
				data: "ac=xoa&id="+id,
				async: true,
				success:function()
				{
					$("a[data-id='"+id+"']").closest("tr").fadeOut('fast');
				}
			});
			return false;
		});
		
		$('#ctsp table:eq(1)').delegate('.edit-ctsp', 'click', function(){
			$('.btn-ctsp').attr
			({
				value: "Chỉnh sửa",
				id: "suactsp"
			});
			id = $(this).attr('data-id');
			//alert(id);
			
			$.ajax
					({
						url: "module/sanpham/xuly/xuly.php",
						type: "post",
						data: "ac=get&id="+id,
						dataType: "json", 
						async: true,
						success:function(kq)
						{
							//alert(kq.mausac + " - " + kq.soluong);
							$('#mausac').val(kq.mausac);
							$('#soluong').val(kq.soluong);
							$('#gianhap').val(kq.gianhap);
							$('#giaban').val(kq.giaban);
							$('#ngaysx').val(kq.ngaysx);
							$('#hsd').val(kq.hsd);
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
		
		//window.onbeforeunload = function () {
			//return "Do you really want to close?";
			
			//if(myWindow.closed)
			//{
					
			//}
			
		//};
    });
	
	
	
</script>

<?php
	//unset($_SESSION['list-ctsp']);
	//unset($_FILES['file']);
	$loi = array();
	$loi['masp'] = $loi['tensp'] = $loi['dvt'] = $loi['trongluong'] = $loi['thuonghieu'] = $loi['quycach'] = $loi['thue'] = $loi['mausac'] = $loi['soluong'] = $loi['gianhap'] = $loi['giaban'] = $loi['ngaysx'] = $loi['hsd'] = $loi['file'] = NULL;
	
	$masp = $tensp = $dvt = $trongluong = $thuonghieu = $quycach = $thue = $mausac = $soluong = $gianhap = $giaban = $ngaysx = $hsd = NULL;
	$check_sp = $check_ctsp = 1; $mota = $mancc = $madm = NULL;
	if(isset($_POST['ok']))
	{
		if(isset($_SESSION['list-ctsp']))
			echo "Có";
		else
			echo "ko";
		//echo "<pre>"; echo $_SESSION['list-ctsp']; echo "</pre>";
		if(empty($_POST['masp']))
		{
			$loi['masp'] = "Vui lòng nhập mã sản phẩm";
			$check_sp = 0;
		}
		else
			$masp = $_POST['masp'];
			
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
			
		if(count($_FILES['file']['name'])==0)
		{
			if(empty($_FILES['file']['name'][0]))
			{
				$check_sp = 0;
				$loi['file'] = "Vui lòng chọn ít nhất 1 file ảnh";
				unset($_FILES['file']);
			}
		}
		/*
		else if(count($_FILES['file']['name']) > 3)
		{
			$check_sp = 0;
			$loi['file'] = "Chỉ được upload tối đa 3 ảnh";
			unset($_FILES['file']);
		}*/
		
			echo count($_FILES['file']);
			foreach($_FILES['file']['name'] as $i => $value)
			{
				$list_ext = array('jpeg', 'jpg', 'png', 'gif', 'bmp');
				$explode = explode('.', $_FILES['file']['name'][$i]);
				$ext = end($explode);
				if(!in_array($ext, $list_ext))
				{
					$loi['file'] = "Chỉ được upload file ảnh có các đuôi: jpeg, jpg, gif, bmp";
					$check_sp = 0;
					break;
				}
			}
		
			
		$mancc = $_POST['mancc']; $madm = $_POST['madm'];
		
		if($check_sp)
		{
			
			date_default_timezone_set('Asia/Ho_Chi_Minh');
			$date = date('Y/m/d H:i:s');
			
			mysql_query("set names 'utf8'");
			
			$sp = mysql_query("insert into sanpham(masp, tensp, donvitinh, trongluong, thuonghieu, quycachdonggoi, mota, ngaynhap, thue, mancc, madm, luotmua, trangthai) values('$masp', '$tensp', '$dvt', '$trongluong', '$thuonghieu', '$quycach', '$mota', '$date', $thue, '$mancc', '$madm', 0, 1) ");	
			
			foreach($_SESSION['list-ctsp'] as $key => $value)
			{
				$mactsp = mysql_query("select count(mactsp) as 'number' from chitietsanpham");
				$mactsp = mysql_fetch_assoc($mactsp);
				$mactsp =(int)$mactsp['number'] + 1;
				mysql_query("set names 'utf8'");
				$ctsp = mysql_query("insert into chitietsanpham(masp, mactsp, mausac, ngaysx, hansudung, soluong, giaban, trangthai) values('$masp', '$mactsp', '".$_SESSION['list-ctsp'][$key]['mausac']."', '".$_SESSION['list-ctsp'][$key]['ngaysx']."', '".$_SESSION['list-ctsp'][$key]['hsd']."', ".$_SESSION['list-ctsp'][$key]['soluong'].", ".$_SESSION['list-ctsp'][$key]['giaban'].", 1)");	
			}
			unset($_SESSION['list-ctsp']);
			
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

<p class="title">THÊM MỚI SẢN PHẨM</p> <br />

<form method="post"  enctype="multipart/form-data">
<div id='parent' style="width: 52%; height: 100%; border-right: solid 2px #ccc; float: left; position: relative;">
    <table>
    
        <tr>
            <td>Mã sản phẩm: </td>
            <td><input type='text' class='txt-sp' name="masp"/></td>
            <?php
				if($loi['masp'] != NULL)
					echo "<td class='error'>".$loi['masp']."</td>";
			?>
            
        </tr>
    
        <tr>
            <td>Tên sản phẩm: </td>
            <td><input type='text' class='txt-sp' name="tensp"/></td>
            <?php
				if($loi['tensp'] != NULL)
					echo "<td class='error'>".$loi['tensp']."</td>";
			?>
        </tr>
        
        <tr>
            <td>Đơn vị tính: </td>
            <td><input type='text' class='txt-sp' name="dvt"/></td>
            <?php
				if($loi['dvt'] != NULL)
					echo "<td class='error'>".$loi['dvt']."</td>";
			?>
        </tr>
        
        <tr>
            <td>Trọng lượng: </td>
            <td><input type='text' class='txt-sp' name="trongluong"/></td>
            <?php
				if($loi['trongluong'] != NULL)
					echo "<td class='error'>".$loi['trongluong']."</td>";
			?>
        </tr>
        
        <tr>
            <td>Thương hiệu: </td>
            <td><input type='text' class='txt-sp' name="thuonghieu"/></td>
            <?php
				if($loi['thuonghieu'] != NULL)
					echo "<td class='error'>".$loi['thuonghieu']."</td>";
			?>
        </tr>
        
        <tr>
            <td>Quy cách đóng gói: </td>
            <td><input type='text' class='txt-sp' name="quycach"/></td>
            <?php
				if($loi['quycach'] != NULL)
					echo "<td class='error'>".$loi['quycach']."</td>";
			?>
        </tr>
        
        <tr>
            <td>Mô tả: </td>
            <td><textarea class="txt-sp"></textarea></td>
           
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
							echo "<option value='".$re_ncc['mancc']."'>".$re_ncc['tenncc']."</option>";
						}
					?>	
                	
                </select>
                
            </td>
            <td><input value='+' id='themncc' type="button" class="sub" style="width: 90%; height: 38px; margin-left: -100%; text-align: center; font-size: 36px; line-height: 30px; font-weight: bold"/></td>
        </tr>
        
        <tr>
            <td>Thuế: </td>
            <td><input type='text' class='txt-sp' name="thue"/></td>
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
						$ncc = mysql_query("select madm, tendm from danhmuc");
						while($re_ncc = mysql_fetch_assoc($ncc))
						{
							echo "<option value='".$re_ncc['madm']."'>".$re_ncc['tendm']."</option>";
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
    </table>
</div>


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
        <tr>
            <td>Giá nhập: </td>
            <td><input type='text' class='txt-sp' id='gianhap' name='gianhap'/>  <span class='error'> Vui lòng nhập giá nhập</span></td>
            <td></td>
        </tr>
        
        <tr>
            <td>Giá bán: </td>
            <td><input type='text' class='txt-sp' id='giaban' name='giaban'/>  <span class='error'> Vui lòng nhập giá bán</span></td>
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
    
    <table border="1" class='tb-lietke'>
    	
        <tr>
        	<th>Màu sắc</th>
            
            <th>NSX</th>
            <th>HSD</th>
            
            <th>Số lượng</th>
            <th>Giá nhập</th>
            <th>Giá bán</th>
            <th>Sửa</th>
            <th>Xóa</th>
        </tr>
        
        <?php
		
			if(isset($_SESSION['list-ctsp']))
			{
				//echo count($_SESSION['list-ctsp']);
				foreach($_SESSION['list-ctsp'] as $key => $value)
				{
					//echo $key." ";
		?>
        		<tr>
                    <td><?php echo $_SESSION['list-ctsp'][$key]['mausac'] ?></td>
                    <td><?php echo $_SESSION['list-ctsp'][$key]['ngaysx'] ?></td>
                    <td><?php echo $_SESSION['list-ctsp'][$key]['hsd'] ?></td>
                    <td><?php echo $_SESSION['list-ctsp'][$key]['soluong'] ?></td>
                    <td><?php echo $_SESSION['list-ctsp'][$key]['gianhap'] ?></td>
                    <td><?php echo $_SESSION['list-ctsp'][$key]['giaban'] ?></td>
                    
                    <td><a href='javascript:void(0)' data-id=<?php echo $key ?> class='edit-ctsp'>Sửa</a></td>
                    <td><a href='javascript:void(0)' data-id=<?php echo $key ?> class='del-ctsp'>Xóa</a></td>
                </tr>
        <?php	
				}
			}
		
		?>
        
        
    </table>
    
</div>
<div class="clear"></div>
<div style='width: 100%; margin: auto; text-align: center; margin-top: 3%;'>
	<input type='submit' class='sub' name='ok' value='NHẬP HÀNG'/>
</div>

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

<!--popup-->
<!--
<div id='phanloai'>
	
    <table id='nhaplieu'>
                
		<tr>
        	<td>Màu sắc:</td>
            <td><input type='text' name = 'mausac' class = 'mausac txt-sp'/></td>
            <td class = 'error'></td>
        </tr>
        
        <tr>
            <td>Ngày sản xuất: </td>
            <td><input type = 'date'  class="ngaysx txt-sp"/></td>
            <td></td>
        </tr>
        
        <tr>
            <td>Hạn sử dụng: </td>
            <td><input type = 'date' class="hsd txt-sp" /></td>
            <td></td>
        </tr>
        
        <tr>
            <td>Giá bán: </td>
            <td><input type='text' class='giaban txt-sp' /></td>
            <td></td>
        </tr>
        
        <tr>
            <td>Giá nhập: </td>
            <td><input type='text' class='gianhap txt-sp' /></td>
            <td></td>
        </tr>
        
        <tr>
            <td>Nhà cung cấp: </td>
            <td>
            	<select class="ncc">
                	<?php
						mysql_query("set names 'utf8'");
						$ncc = mysql_query("select mancc, tenncc from nhacungcap where trangthai = 1");
						while($re_ncc = mysql_fetch_assoc($ncc))
						{
							echo "<option value='".$re_ncc['mancc']."'>".$re_ncc['tenncc']."</option>";
						}
					?>	
                	
                </select>
            </td>
            <td></td>
        </tr>
                            
        <tr>
            <td>Số lượng:</td>
           	<td><input type='text' name = 'soluongctsp' class = 'soluongctsp txt-sp'/></td>
            <td class = 'error'></td>
        </tr>
                    
        <tr>
            <td></td>
            <td><input value = 'Thêm' id = 'themctsp' class="sub" name = 'themctsp' type="submit"/></td>
        </tr>
                
    </table>
                
    <table id = 'list-ctsp' style="border-collapse: collapse 1px">
                
	</table>
    
</div>
-->