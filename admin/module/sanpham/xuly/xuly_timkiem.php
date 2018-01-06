<?php

	$ac = $_POST['ac'];
	
	require('../../../../config/config.php');
	
	if($ac == 'get_dm')
	{
		mysql_query("set names 'utf8'");
		$danhmuc = mysql_query("select madm, tendm from danhmuc");
		echo "<option value='all'>Tất cả</option>";	
		while($re_dm = mysql_fetch_assoc($danhmuc))
		{
			echo "<option value='".$re_dm['madm']."'>".$re_dm['tendm']."</option>";	
		}
	}
	else if($ac == 'get_ncc')
	{
		mysql_query("set names 'utf8'");
		$ncc = mysql_query("select mancc, tenncc from nhacungcap where trangthai = 1");
		//echo mysql_num_rows($ncc);
		echo "<option value='all'>Tất cả</option>";	
		while($re_ncc = mysql_fetch_assoc($ncc))
		{
			echo "<option value='".$re_ncc['mancc']."'>".$re_ncc['tenncc']."</option>";	
		}
	}
	else if($ac == 'search')
	{
		$loaixem = $_POST['loaixem'];
		$danhmuc = $_POST['danhmuc'];
		$keyword = $_POST['keyword'];
		
		$sql = $loaixem == 'ncc' ? ($danhmuc != 'all' ? " and SP.MaNCC = '".$danhmuc."' " : "") : ($danhmuc != 'all' ? " and MaDM = '".$danhmuc."' " : "");
		
		$q_sp = "select sp.masp, sp.tensp, tenncc, sum(ctsp.SoLuong) as 'sl'
				from sanpham sp, chitietsanpham ctsp, nhacungcap ncc
				where sp.masp = ctsp.masp and ncc.mancc = sp.mancc and sp.trangthai = 1 and ctsp.TrangThai = 1 and (sp.tensp LIKE '%$keyword%' OR sp.masp LIKE '%$keyword%' or ctsp.mactsp LIKE '%$keyword%')".$sql."
				group by sp.masp";
		
		$q_ctsp = "select sp.masp, ctsp.mactsp, mausac, ctsp.ngaysx, ctsp.hansudung, ctsp.soluong, ctsp.giaban, ctpn.gianhap
				from sanpham sp, chitietsanpham ctsp, chitietphieunhap ctpn
				where sp.masp = ctsp.masp and ctpn.mactsp = ctsp.mactsp and ctsp.trangthai = 1 and sp.trangthai = 1".$sql."";
		
		Load_SP($q_sp, $q_ctsp);
	}
	else if($ac == 'loc')
	{
		date_default_timezone_set('Asia/Ho_Chi_Minh');
		$date = date('Y-m-d');
		
		$loai = $_POST['loai'];
		
		if(isset($_POST['hsd']))
			$hsd = date('Y-m-d', strtotime($_POST['hsd']));
		
		if($loai == "")
			$sql = "";
		else
			$sql = $loai == 'hethang' ? " and ctsp.soluong <= 0" : ($loai == 'saphethsd' ? " and ctsp.hansudung <= '$hsd'" : " and '$date' >= ctsp.hansudung ");

		$q_ctsp = "select sp.masp, ctsp.mactsp, tensp, mausac, tenncc, ctsp.ngaysx, ctsp.hansudung, ctsp.soluong, ctsp.giaban
				from sanpham sp, chitietsanpham ctsp, nhacungcap ncc
				where sp.masp = ctsp.masp and ctsp.trangthai = 1 and ncc.mancc = sp.mancc and sp.trangthai = 1".$sql."";
		//echo $q_ctsp;
		Load_Loc("", $q_ctsp);
	}


	mysql_close($conn);
?>

<?php

	function Load_Loc($q_sp, $q_ctsp)
	{
		mysql_query("set names 'utf8'");
		$ctsp = mysql_query($q_ctsp);
		
		
		echo "<div class = 'lietke-sp-th'>";
		echo 	"<div style='width: 16%'>Mã sản phẩm</div>";
		echo 	"<div style='width: 20%'>Tên sản phẩm</div>";
		echo	"<div style='width: 14%'>Nhà cung cấp</div>";
		echo	"<div style='width: 8%'>Màu sắc</div>";
		echo	"<div style='width: 8%'>Ngày SX</div>";
		echo	"<div style='width: 8%'>Hạn SD</div>";
		echo 	"<div style='width: 5%'>SL</div>";
		echo 	"<div style='width: 8%'>Giá bán</div>";
		echo 	"<div style='width: 5%'>Sửa</div>";
		echo 	"<div style='width: 5%'>Xóa</div>";
		echo "</div>";
		echo "<div class='clear'></div>";
		
		while($re_ctsp = mysql_fetch_assoc($ctsp))
		{
			echo "<div class= 'lietke-sp-tr'>";
			echo 	"<div class='lietke-sp-td' style='width: 15%; text-align: left;'>".$re_ctsp['mactsp']."</div>";
			echo 	"<div class='lietke-sp-td' style='width: 19%; text-align: left;'>".$re_ctsp['tensp']."</div>";
			echo	"<div class='lietke-sp-td' style='width: 14%;'>".$re_ctsp['tenncc']."</div>";
			echo	"<div class='lietke-sp-td' style='width: 8%;'>".$re_ctsp['mausac']."</div>";
			echo	"<div class='lietke-sp-td' style='width: 7%;'>".date('d-m-Y', strtotime($re_ctsp['ngaysx']))."</div>";
			echo	"<div class='lietke-sp-td' style='width: 7%;'>".date('d-m-Y', strtotime($re_ctsp['hansudung']))."</div>";
			echo 	"<div class='lietke-sp-td' style='width: 4%; text-align: center'>".$re_ctsp['soluong']."</div>";
			echo 	"<div class='lietke-sp-td' style='width: 8%;'>".$re_ctsp['giaban']."</div>";
			echo 	"<div class='lietke-sp-td' style='width: 4%;'><a href='admin.php?quanly=sanpham&ac=suasp&masp=".$re_ctsp['masp']."' >Sửa</a></div>";
			echo 	"<div class='lietke-sp-td' style='width: 4%;'>Xóa</div>";
			echo 	"<div class='clear'></div>";
			echo "</div>";
		};
        
        echo "<div class='clear'></div>";
	}
?>

<?php

	function Load_SP($q_sp, $q_ctsp)
	{
		//echo $q_sp;
		//echo "<br/>".$q_ctsp;
		mysql_query("set names 'utf8'");
		$sp = mysql_query($q_sp);
		
		mysql_query("set names 'utf8'");
		$ctsp = mysql_query($q_ctsp);
		$arr_ctsp = array();
		while($re_ctsp = mysql_fetch_assoc($ctsp))
		{
			$arr_ctsp[$re_ctsp['mactsp']]['masp'] = $re_ctsp['masp'];
			$arr_ctsp[$re_ctsp['mactsp']]['mausac'] = $re_ctsp['mausac'];
			$arr_ctsp[$re_ctsp['mactsp']]['ngaysx'] = $re_ctsp['ngaysx'];
			$arr_ctsp[$re_ctsp['mactsp']]['hansudung'] = $re_ctsp['hansudung'];
			$arr_ctsp[$re_ctsp['mactsp']]['soluong'] = $re_ctsp['soluong'];
			$arr_ctsp[$re_ctsp['mactsp']]['giaban'] = $re_ctsp['giaban'];
			$arr_ctsp[$re_ctsp['mactsp']]['gianhap'] = $re_ctsp['gianhap'];
		}
		
		echo "<div class = 'lietke-sp-th'>";
        echo 	"<div style='width: 18%'>Mã sản phẩm</div>";
       	echo 	"<div style='width:35%'>Tên sản phẩm</div>";
        echo	"<div style='width:21%'>Nhà cung cấp</div>";
        echo 	"<div style='width:12%'>Số lượng hiện có</div>";
        echo 	"<div style='width:6%'>Sửa</div>";
        echo 	"<div style='width:6%'>Xóa</div>";
        echo "</div>";
        echo "<div class='clear'></div>";
        

		while($re_sp = mysql_fetch_assoc($sp))
		{
	
        echo "<div class= 'lietke-sp-tr' data-id='2".$re_sp['masp']."'>";
		echo 	"<div class='lietke-sp-td' style='width: 18%; text-align: left'>".$re_sp['masp']."</div>";
		echo 	"<div class='lietke-sp-td' style='width: 34%; text-align: left''>".$re_sp['tensp']."</div>";
		echo 	"<div class='lietke-sp-td' style='width: 21%; text-align: left''>".$re_sp['tenncc']."</div>";
		echo 	"<div class='lietke-sp-td' style='width: 12%; text-align: center;' >".$re_sp['sl']."</div>";
		echo 	"<div class='lietke-sp-td' style='width: 4%; text-align: center;'><a  href='admin.php?quanly=sanpham&ac=suasp&masp=".$re_ctsp['masp']."'>Sửa</a></div>";
		echo 	"<div class='lietke-sp-td' style='width: 4%; text-align: center;'><a href='#'>Xóa</a></div>";
		echo 	"<div class='clear'></div>";
		echo "</div>";
        
                
        echo "<div  class='ctsp2".$re_sp['masp']."' style='display: none; background: #EFFBF2; width: 98%;   padding: 10px; '>";
			echo	"<div style='width: 100%; height: 30px; line-height: 30px;'>";
			echo 		"<div class='ctsp-item'	style='text-align: center;font-weight: bold' >Màu sắc</div>";
			echo 		"<div class='ctsp-item' style='text-align: center;font-weight: bold; text-align: left;' >Ngày sản xuất</div>";
			echo 		"<div class='ctsp-item' style=' text-align: center;font-weight: bold; text-align: left;' >Hạn sử dụng</div>";
			echo 		"<div class='ctsp-item' style='text-align: center;font-weight: bold' >Số lượng</div>";
			echo 		"<div class='ctsp-item'  style='font-weight: bold' >Giá nhập</div>";
			echo 		"<div class='ctsp-item'  style='font-weight: bold' >Giá bán</div>";
			echo 	"</div>";
			echo 	"<div class='clear'></div>";
			foreach($arr_ctsp as $key => $value)
			{
				//echo "vô 2 <br/>";
				if($re_sp['masp'] == $arr_ctsp[$key]['masp'])
				{	      
				   
					echo "<div style='border-bottom: solid 1px #ccc; width: 100%'>";
					echo 	"<div class='ctsp-item' style='text-align: center;'>".($arr_ctsp[$key]['mausac'] == "" ? "Không" : $arr_ctsp[$key]['mausac'])."</div>";
					echo 	"<div class='ctsp-item' style='text-align: center;text-align: left;'>".date('d-m-Y', strtotime($arr_ctsp[$key]['ngaysx']))."</div>";
					echo 	"<div class='ctsp-item' style='text-align: center;text-align: left;'>".date('d-m-Y', strtotime($arr_ctsp[$key]['hansudung']))."</div>";
					echo 	"<div class='ctsp-item' style='text-align: center;'>".$arr_ctsp[$key]['soluong']."</div>";
					echo	"<div class='ctsp-item'>".number_format($arr_ctsp[$key]['gianhap'])." đ</div>";
					echo	"<div class='ctsp-item'>".number_format($arr_ctsp[$key]['giaban'])." đ</div>";
					echo "</div>";
					echo "<div class='clear'></div>";
				 
				}
			}
				
                
                echo "<div class='clear'></div>";
        echo "</div>";
    
		}
		
	}
	
	function Load_SP1($q_sp, $q_ctsp)
	{
		
		mysql_query("set names 'utf8'");
		$sp = mysql_query($q_sp);
		
		mysql_query("set names 'utf8'");
		$ctsp = mysql_query($q_ctsp);
		
		$arr_ctsp = array();
		
		while($re_ctsp = mysql_fetch_assoc($ctsp))
		{
			$arr_ctsp[$re_ctsp['mactsp']]['masp'] = $re_ctsp['masp'];
			$arr_ctsp[$re_ctsp['mactsp']]['mausac'] = $re_ctsp['mausac'];
			$arr_ctsp[$re_ctsp['mactsp']]['ngaysx'] = $re_ctsp['ngaysx'];
			$arr_ctsp[$re_ctsp['mactsp']]['hansudung'] = $re_ctsp['hansudung'];
			$arr_ctsp[$re_ctsp['mactsp']]['soluong'] = $re_ctsp['soluong'];
			$arr_ctsp[$re_ctsp['mactsp']]['giaban'] = $re_ctsp['giaban'];
		}
	
		
		echo "<table width='100%' style='border-collapse:collapse'>";
		echo "<tr>";
        echo "<th width='17%'>Mã sản phẩm</th>";
        echo "<th width='30%'>Tên sản phẩm</th>";
        echo "<th width='20%'>Nhà cung cấp</th>";
        echo "<th width='12%'>Số lượng hiện có</th>";
        echo "<th width='4%'>Sửa</th>";
        echo "<th width='4%'>Xóa</th>";
        echo "</tr>";
		
		while($re_sp = mysql_fetch_assoc($sp))
		{
		
			echo "<tr data-id='2".$re_sp['masp']."'>";
			echo "<td>".$re_sp['masp']."</td>";
			echo "<td>".$re_sp['tensp']."</td>";
			echo "<td>".$re_sp['tenncc']."</td>";
			echo "<td style='text-align: center'>".$re_sp['sl']."</td>";
			echo "<td style='text-align: center'><a href='admin.php?quanly=sanpham&ac=suasp&masp=".$re_sp['masp']."'>Sửa</a></td>";
			echo "<td style='text-align: center'><a href='#'>Xóa</a></td>";
			echo "</tr>";
			
			echo "<div  class='ctsp2".$re_sp['masp']."' style='display: none; background: #EFFBF2; width: 502%;   padding: 10px; '>";
			echo	"<div style='width: 100%; height: 30px; line-height: 30px;'>";
			echo 		"<div class='ctsp-item'	style='width: 20%; line-height: 30px; float: left; text-align: center;font-weight: bold' >Màu sắc</div>";
			echo 		"<div class='ctsp-item' style='width: 20%; line-height: 30px; float: left; text-align: center;font-weight: bold; text-align: left;' >Ngày sản xuất</div>";
			echo 		"<div class='ctsp-item' style='width: 20%; line-height: 30px; float: left; text-align: center;font-weight: bold; text-align: left;' >Hạn sử dụng</div>";
			echo 		"<div class='ctsp-item' style='width: 20%; line-height: 30px; float: left; text-align: center;font-weight: bold' >Số lượng</div>";
			echo 		"<div class='ctsp-item'  style='font-weight: bold' >Giá bán</div>";
			echo 	"</div>";
			echo 	"<div class='clear'></div>";
			foreach($arr_ctsp as $key => $value)
			{
				//echo "vô 2 <br/>";
				if($re_sp['masp'] == $arr_ctsp[$key]['masp'])
				{	      
				   
					echo "<div style='border-bottom: solid 1px #ccc; width: 100%'>";
					echo 	"<div class='ctsp-item' style='text-align: center;'>".($arr_ctsp[$key]['mausac'] == "" ? "Không" : $arr_ctsp[$key]['mausac'])."</div>";
					echo 	"<div class='ctsp-item' style='text-align: center;text-align: left;'>".date('d-m-Y', strtotime($arr_ctsp[$key]['ngaysx']))."</div>";
					echo 	"<div class='ctsp-item' style='text-align: center;text-align: left;'>".date('d-m-Y', strtotime($arr_ctsp[$key]['hansudung']))."</div>";
					echo 	"<div class='ctsp-item' style='text-align: center;'>".$arr_ctsp[$key]['soluong']."</div>";
					echo	"<div class='ctsp-item'>".number_format($arr_ctsp[$key]['giaban'])." đ</div>";
					echo "</div>";
					echo "<div class='clear'></div>";
				 
				}
			}
			
        	echo 	"<div class='clear'></div>";
        	echo "</div>";	
		}
		echo "</table>";
	}
	
?>