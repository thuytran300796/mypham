<?php
	
	session_start();

	require('../../config/config.php');
	$user = $_POST['user'];
	$noidung = $_POST['noidung'];
	$noidung = nl2br($noidung);
	$id = $_POST['id'];
	
	$result = mysql_query('Select MaBL from BinhLuan ');
		
	//tạo mã bình luận
	if(mysql_num_rows($result) == 0)
		$mabl =  'BL1';
	else
	{
		$dong = mysql_fetch_assoc($result);
			
		$number = substr($dong['MaBL'], 2);
			
		while($dong = mysql_fetch_assoc($result))
		{
			$temp = substr($dong['MaBL'], 2);
			if($number < $temp)
				$number = $temp;
		}
		$mabl =  'BL'.++$number;
	}
	
	date_default_timezone_set('Asia/Ho_Chi_Minh');
	$date = date('Y/m/d H:i:s');
	
	
	mysql_query("set names 'utf8'");
	$insert = mysql_query("INSERT INTO BinhLuan VALUES('$mabl', '$user', '$id', '$date', '$noidung')");
	mysql_query("set names 'utf8'");
	$ten = mysql_query("select tenkh, hinhdaidien from khachhang where makh = '$user'");
	$re_ten = mysql_fetch_assoc($ten);
	
	mysql_close($conn);
	
	echo "<li>";
    	echo "<div class='com-info'>";
        	echo "<img src='image/khachhang/".$re_ten['hinhdaidien']."'/>";
        	echo "<p>".$re_ten['tenkh']." &nbsp;$date &nbsp;</p>";
        	echo "<p>$noidung</p>";
        	//echo "<p><a href='javascript:void(0)' class='rep-a' data-repa='$mabl'>Gửi trả lời</a></p>";
        echo "</div>";
        echo "<div class='clear'></div>";
		
		echo "<form>";
                    echo "<fieldset style='margin-left: 75px; display: none' class='rep-form$mabl'>";
            
                    echo "<legend>Viết nhận xét của bạn vào bên dưới</legend>";
                            echo "<textarea class='re-mess'></textarea>";
                        	echo "<input type='submit' class = 're-submit'  value='Gửi'/>";
                    echo "</fieldset>";
        echo "</form>";
	echo "</li>";
?>