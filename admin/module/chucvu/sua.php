<?php
	ob_start();

	$loi = array();
	$loi['ten'] = $loi['luong'] = $loi['phucap'] = $ten = $luong = $phucap = NULL;
	$check = 1;
	
	$id = $_REQUEST['id'];
	
	mysql_query("SET NAMES 'utf8'");
	
	$re_ncc = mysql_query("select * from chucvu where macv = '$id'");
	
	$dong = mysql_fetch_assoc($re_ncc);
	
	if(!isset($_POST['ok']))
	{
		$ten = $dong['TenCV'];
		$luong = $dong['HeSoLuong'];
		$phucap = $dong['PhuCap'];
	}
	else
	{
			
		if(empty($_POST['ten']))
		{
			$loi['ten'] = "Vui lòng nhập tên của chức vụ!";
			$ten = "";
			$check = 0;
		}
		else
			$ten = $_POST['ten'];
			
		
		if(empty($_POST['luong']))
		{
			$loi['luong'] = "Vui lòng nhập hệ số lương cho chức vụ!";
			$luong = "";
			$check = 0;
		}
		else
		{
			if(is_double($_POST['luong']))
			{
				$loi['luong'] = "Chỉ được nhập các ký tự từ 0 đến 9";
				$check = 0;
			}
			else
				$luong = $_POST['luong'];
		}
		
		if(empty($_POST['phucap']))
		{
			$phucap = 0;
		}
		else
		{
			if(is_double($_POST['phucap']))
			{
				$loi['phucap'] = "Chỉ được nhập các ký tự từ 0 đến 9";
				$check = 0;
			}
			else
				$phucap = $_POST['phucap'];
		}
			

			
		if($check == 1)
		{
			mysql_query("set names 'utf8'");
			$result = mysql_query("update chucvu set tencv = '$ten', HeSoLuong = $luong, phucap = $phucap where macv = '$id'");
			header('location: admin.php?quanly=chucvu');
		
			//mysql_close($conn);
		}

	}
	ob_flush();

?>

<p class="title">CẬP NHẬT THÔNG TIN CHỨC VỤ</p><br />


<form method="post">
            	<!--<input type='hidden' name='quanly' value='nhacc'/>-->
                <table>
                    <tr>
                        <td>Tên nhà cung cấp:</td>
                        <td><input type='text' name='ten' value='<?php echo $ten ?>'/></td>
                    </tr>
                    <?php
		
						if(!empty($loi['ten']))
						{
					?>
							<tr>
								<td></td>
								<td class = 'error'><?php echo $loi['ten']?></td>
							</tr>
					<?php
						}
					?>
                    <tr>
                        <td>Hệ số lương:</td>
                        <td><input type='text' name='luong' value='<?php echo $luong ?>'/></td>
                    </tr>
                    <?php
		
						if(!empty($loi['luong']))
						{
					?>
							<tr>
								<td></td>
								<td class = 'error'><?php echo $loi['luong']?></td>
							</tr>
					<?php
						}
					?>
                    <tr>
                        <td>Phụ cấp:</td>
                        <td><input type='text' name='phucap' value='<?php echo $phucap ?>'/></td>
                    </tr>
                
                    <tr>
                    	<td></td>
                        <td><input type='submit'  class='pop-sub' value='Sửa' name = 'ok'/>
                        	<input type='submit' class="cancle" value='Thoát'/>
                      
                        </td>
                    </tr>
                </table>
            </form>
