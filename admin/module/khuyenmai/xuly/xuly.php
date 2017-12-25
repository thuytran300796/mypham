<?php

	session_start();

	require('../../../../config/config.php');

	if($_POST['ac'] == 'get_qt')
	{
		$keyword = mysql_escape_string($_POST['keyword']);
		
		mysql_query("set names 'utf8'");
		$kq = mysql_query("	select ctsp.mactsp, sp.masp, sp.tensp, ctsp.mausac, thuonghieu, tenncc
							from sanpham sp, chitietsanpham ctsp, nhacungcap ncc
							where sp.masp = ctsp.masp and ncc.mancc = sp.mancc and sp.trangthai = 1 and ctsp.trangthai = 1 and ctsp.soluong > 0
							and tensp LIKE '%$keyword%'");
							
		while($re_kq = mysql_fetch_assoc($kq))
		{
			$hinhanh = mysql_query("select duongdan from hinhanh where masp = '".$re_kq['masp']."' limit 0,1");
			$re_ha = mysql_fetch_assoc($hinhanh);
			echo "<li>";
			echo 	"<a href='javascript:void(0)' class='ctsp-qt' data-ctspqt = '".$re_kq['mactsp']."'>";
			echo 		"<img src='../image/mypham/".$re_ha['duongdan']."'/>";
			echo 		"<div>";
			echo 			"<p>".$re_kq['tensp']."</p>";
			echo 			"<p>".$re_kq['mausac']."</p>";
			echo 			"<p>Thương hiệu: ".$re_kq['thuonghieu']."</p>";
			echo			"<p>Nhà cung cấp: ".$re_kq['tenncc']."</p>";
			echo 		"</div>";
			echo 	"</a>";
			echo "</li>";
			echo "<div class='clear'></div>";
		}
	}
	else if($_POST['ac'] == 'get_info')
	{
		$maqt = $_POST['maqt'];
		
		mysql_query("set names 'utf8'");
		$kq = mysql_query("	select ctsp.mactsp, sp.masp, sp.tensp, ctsp.mausac, thuonghieu, tenncc
							from sanpham sp, chitietsanpham ctsp, nhacungcap ncc
							where sp.masp = ctsp.masp and ncc.mancc = sp.mancc and sp.trangthai = 1 and ctsp.trangthai = 1 and ctsp.soluong > 0
							and ctsp.mactsp = '$maqt'");
		$re_kq = mysql_fetch_assoc($kq);
		
		$_SESSION['list-qt'][] = $re_kq['mactsp'];
		
		echo "<li>";
		echo	"<p>".$re_kq['tensp'].""; echo  $re_kq['mausac'] == "" ? "" : " - Màu sắc: ".$re_kq['mausac']."";
		echo	" <a href='javascript:void(0)'> - Xóa</a> </p>";
		echo "</li>";
	}
	mysql_close($conn);
?>