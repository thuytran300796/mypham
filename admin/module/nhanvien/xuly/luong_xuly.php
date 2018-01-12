<?php

	require('../../../../config/config.php');
	
	$ac = isset($_POST['ac']) ? $_POST['ac'] : "";

	if($ac == 'search')
	{
		$keyword = mysql_escape_string($_POST['keyword']);
		mysql_query("set names 'utf8'");
		$kq = mysql_query("select manv, tennv, sodienthoai from nhanvien where (manv like '%$keyword%' or tennv like '%$keyword%' or sodienthoai like '%$keyword%') and trangthai = 1");
							
		while($re_kq = mysql_fetch_assoc($kq))
		{
			echo "<li>";
			echo 	"<a href='javascript:void(0)' data-id='".$re_kq['manv']."'>";
			echo 		"<p>".$re_kq['manv']." - ".$re_kq['tennv']." - ".$re_kq['sodienthoai']."</p>";
			echo 	"</a>";
			echo "</li>";
			echo "<div class='clear' style='background: none'></div>";
		}	
	}
	else if($ac == 'get_cv')
	{
		$macv = isset($_POST['macv']) ? $_POST['macv'] : "";
		//$manv = isset($_POST['manv']) ? $_POST['manv'] : "";
		
		mysql_query("set names 'utf8'");
		$chucvu = mysql_query("select macv, tencv, hesoluong, phucap from chucvu where macv = '$macv'");
		$re_cv = mysql_fetch_assoc($chucvu);
		//$_SESSION['luong'][$manv]['macv'] = $macv;
		//$_SESSION['luong'][$id]['heso'] = $re_cv['hesoluong'];
		//$_SESSION['luong'][$id]['phucap'] = $re_cv['phucap'];
		echo json_encode(array("heso"=>"$re_cv[hesoluong]", "phucap"=>"$re_cv[phucap]"));
	}
	else if($ac == 'get_nv')
	{
		$id = isset($_POST['id']) ? $_POST['id'] : "";
		mysql_query("set names 'utf8'");
		$kq = mysql_query("select manv, tennv from nhanvien where manv = '$id'");
		$re_kq = mysql_fetch_assoc($kq);
		
		if(!isset($_SESSION['nhapkho']))
			$_SESSION['nhapkho'] = NULL;
		$_SESSION['luong'][$id]['tennv'] = $re_kq['tennv']; 
		
		mysql_query("set names 'utf8'");
		$chucvu = mysql_query("select macv, tencv, hesoluong, phucap from chucvu");
		$heso = $phucap = $dem = 0;
		
		
		
		echo "<tr>";
        echo 	"<td><img src='../image/del.png' /></td>";
        echo 	"<td>$id</td>";
        echo 	"<td>".$re_kq['tennv']."</td>";
        echo 	"<td><select class='cbb-sp' id='chucvu' data-id='$id'>";
       		while($re_cv = mysql_fetch_assoc($chucvu))
			{
				if($dem++ == 0)
				{
					$heso = $re_cv['hesoluong']; $phucap = $re_cv['phucap'];	
					$_SESSION['luong'][$id]['heso'] = $heso;
					$_SESSION['luong'][$id]['phucap'] = $phucap;
				}
		 		echo 	"<option value='".$re_cv['macv']."'>".$re_cv['tencv']."</option>";	
			}
        echo 	"</select>";
        echo 	"</td>";
 		echo 	"<td><input class='txt-sp heso$id' readonly='readonly' id='heso' type='text' value='$heso'/></td>";
 		echo 	"<td><input class='txt-sp phucap$id' readonly='readonly' id='phucap' type='text' value='$phucap'/></td>";
        echo 	"<td><input class='txt-sp' id='songaycong' type='text' value='0'/></td>";
        echo 	"<td><input class='txt-sp' id='luongcb' type='text' value='0'/></td>";
        echo 	"<td><input class='txt-sp' id='thuong' type='text' value='0'/></td>";
        echo 	"<td><input class='txt-sp' id='phat' type='text' value='0'/></td>";
        echo 	"<td><input class='txt-sp tong$id' readonly='readonly' id='tong' type='text' value='0'/></td>";
 		echo "</tr>";

	}
	else if($ac=='songaycong')
	{
		$manv = isset($_POST['manv']) ? $_POST['manv'] : "";
		$_SESSION['luong'][$manv]['songaycong'] = $_POST['value'];
		$tong = ($_SESSION['luong'][$manv]['songaycong'] * $_SESSION['luong'][$manv]['luongcb']) * $_SESSION['luong'][$manv]['heso'] + $_SESSION['luong'][$manv]['phucap'] + $_SESSION['luong'][$manv]['thuong'] - $_SESSION['luong'][$manv]['phat'];
		echo $tong;
	}
	else if($ac=='luongcb')
	{
		$manv = isset($_POST['manv']) ? $_POST['manv'] : "";
		$_SESSION['luong'][$manv]['luongcb'] = $_POST['value'];
		$tong = ($_SESSION['luong'][$manv]['songaycong'] * $_SESSION['luong'][$manv]['luongcb']) * $_SESSION['luong'][$manv]['heso'] + $_SESSION['luong'][$manv]['phucap'] + $_SESSION['luong'][$manv]['thuong'] - $_SESSION['luong'][$manv]['phat'];
		echo $tong;
	}
	else if($ac=='thuong')
	{
		$manv = isset($_POST['manv']) ? $_POST['manv'] : "";
		$_SESSION['luong'][$manv]['thuong'] = $_POST['value'];
		$tong = ($_SESSION['luong'][$manv]['songaycong'] * $_SESSION['luong'][$manv]['luongcb']) * $_SESSION['luong'][$manv]['heso'] + $_SESSION['luong'][$manv]['phucap'] + $_SESSION['luong'][$manv]['thuong'] - $_SESSION['luong'][$manv]['phat'];
		echo $tong;
	}
	else if($ac=='phat')
	{
		$manv = isset($_POST['manv']) ? $_POST['manv'] : "";
		$_SESSION['luong'][$manv]['phat'] = $_POST['value'];
		$tong = ($_SESSION['luong'][$manv]['songaycong'] * $_SESSION['luong'][$manv]['luongcb']) * $_SESSION['luong'][$manv]['heso'] + $_SESSION['luong'][$manv]['phucap'] + $_SESSION['luong'][$manv]['thuong'] - $_SESSION['luong'][$manv]['phat'];
		echo $tong;
	}














	mysql_close($conn);
?>