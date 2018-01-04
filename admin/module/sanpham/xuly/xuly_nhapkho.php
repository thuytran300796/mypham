<?php

	$keyword = mysql_escape_string($_POST['keyword']);
	
	require('../../../../config/config.php');
	
	mysql_query("set names 'utf8'");
	$kq = mysql_query("select ctsp.mactsp, sp.masp, sp.tensp, ctsp.mausac, ctsp.ngaysx, ctsp.hansudung, thuonghieu, tenncc, duongdan
						from sanpham sp, chitietsanpham ctsp, nhacungcap ncc, hinhanh ha
						where sp.masp = ctsp.masp and ncc.mancc = sp.mancc and sp.masp = ha.masp and sp.trangthai = 1 and ctsp.trangthai = 1
                        and tensp LIKE '%$keyword%'
						group by sp.masp");
						
	while($re_kq = mysql_fetch_assoc($kq))
	{
		$hinhanh = mysql_query("select duongdan from hinhanh where masp = '".$re_kq['masp']."' limit 0,1");
		$re_ha = mysql_fetch_assoc($hinhanh);
		echo "<li>";
		echo 	"<a href='javascript:void(0)' data-id='".$re_kq['mactsp']."'>";
        echo 		"<img src='../image/mypham/".$re_ha['duongdan']."'/>";
        echo 		"<div>";
        echo 			"<p>".$re_kq['tensp']."</p>";
        echo 			"<p>Màu sắc: ".$re_kq['mausac']."</p>";
        echo 			"<p>Date: ".date('d/m/Y', strtotime($re_kq['ngaysx']))." - ".date('d/m/Y', strtotime($re_kq['hansudung']))."</p>";
        echo 			"<p>Thương hiệu: ".$re_kq['thuonghieu']."</p>";
        echo			"<p>Nhà cung cấp: ".$re_kq['tenncc']."</p>";
        echo 		"</div>";
        echo 	"</a>";
        echo "</li>";
		echo "<div class='clear'></div>";
	}
	
	mysql_close($conn);
?>