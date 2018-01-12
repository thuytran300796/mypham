<?php

	require('../../../../config/config.php');

	if(isset($_POST['ac']))
	{
		$ac = $_POST['ac'];
		
		if($ac == 'search')
		{
			$keyword = mysql_escape_string($_POST['keyword']);
	
			
			
			mysql_query("set names 'utf8'");
			$kq = mysql_query("select makh, tenkh, diachi, sodienthoai, hinhdaidien
								from khachhang
								where tenkh LIKE '%$keyword%' OR makh LIKE '%$keyword%'");
								
			while($re_kq = mysql_fetch_assoc($kq))
			{
				echo "<li>";
				echo 	"<a href='javascript:void(0)' data-makh='".$re_kq['makh']."'>";
				echo 		"<img src='../image/khachhang/".$re_kq['hinhdaidien']."'/>";
				echo 		"<div>";
				echo 			"<p>".$re_kq['tenkh']."</p>";
				echo			"<p>".$re_kq['sodienthoai']."</p>";
				echo			"<p>".$re_kq['diachi']."</p>";
				echo 		"</div>";
				echo 	"</a>";
				echo "</li>";
				echo "<div class='clear'></div>";
			}	
		}
		else if($ac == 'get_kh')
		{
			if(isset($_POST['makh']))
				$makh = $_POST['makh'];
			else
				$makh = "";
			mysql_query("set names 'utf8'");
			$kq = mysql_query("	select makh, tenkh, diachi, sodienthoai, diemtichluy
								from khachhang
								where makh = '$makh'");	
			$re_kh = mysql_fetch_assoc($kq);
			echo json_encode(array("makh"=>"$re_kh[makh]", "ten"=>"$re_kh[tenkh]", "sdt"=>"$re_kh[sodienthoai]", "diachi"=>"$re_kh[diachi]", "diemtichluy"=>"$re_kh[diemtichluy]"));
		}
	}
	
	mysql_close($conn);
?>