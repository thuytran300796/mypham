<?php

	date_default_timezone_set('Asia/Ho_Chi_Minh');
	$date = date('Y-m-d');
	
	$sapxep = $_POST['sapxep'];
	$type = $_POST['type'];
	$madm = $_POST['madm'];
	$keyword = $_POST['keyword'];
	$position = $_POST['position'];
	if($type != "")
	{
		if($type=='banchay')
		{
			$select = "SELECT t1.masp, t1.mactsp, t1.tensp, t1.mausac, t1.duongdan, t1.giaban, t1.thuonghieu,  t2.makm, t2.chietkhau, t2.tiengiamgia
						FROM
					(	select	sp.masp, ctsp.mactsp, tensp,sum(cthd.SoLuong) 'soluong', duongdan, ctsp.giaban, thuonghieu, ctsp.mausac
						from	sanpham sp, chitietsanpham ctsp, hinhanh ha, chitiethoadon cthd
						where 	ctsp.trangthai = 1 and sp.trangthai = 1  and sp.masp = ctsp.masp and sp.masp = ha.masp and cthd.MaCTSP = ctsp.MaCTSP
						group by cthd.MaCTSP
						  ";
						
			//$orderby = $sapxep == 'giam' ?  " order by ctsp.giaban desc, " : " order by ctsp.giaban asc, ";
			$orderby = " order by sum(cthd.soluong) desc ";
						
			/*$limit = " sum(cthd.soluong) desc limit $position,2
					)t1 left join
					(
						SELECT	km.makm, km.chietkhau, km.tiengiamgia, km.masp
						FROM	khuyenmai km, ctsp_km ctkm
						where	km.makm = ctkm.MaKM and km.trangthai = 1 and ('$date' >= ctkm.NgayBD and '$date' <= ctkm.NgayKT) and km.masp <> ''
						group by km.makm
					)t2 on t1.masp = t2.masp";	
			*/
			$limit = "  limit $position,12
					)t1 left join
					(
						SELECT	km.makm, km.chietkhau, km.tiengiamgia, km.masp
						FROM	khuyenmai km, ctsp_km ctkm
						where	km.makm = ctkm.MaKM and km.trangthai = 1 and ('$date' >= ctkm.NgayBD and '$date' <= ctkm.NgayKT) and km.masp <> ''
						group by km.makm
					)t2 on t1.masp = t2.masp";
			$sql = $select.$orderby.$limit;
		}
		else if($type=='hangmoi')
		{
			$select = "SELECT t1.masp, t1.mactsp, t1.tensp, t1.duongdan, t1.giaban, t1.thuonghieu, t1.mausac, t2.makm, t2.chietkhau, t2.tiengiamgia
						FROM
					(	select	sp.masp, ctsp.mactsp, tensp, duongdan, ctsp.giaban, thuonghieu, ctsp.mausac
						from	sanpham sp, chitietsanpham ctsp, hinhanh ha
						where 	ctsp.trangthai = 1 and sp.trangthai = 1  and sp.masp = ctsp.masp and sp.masp = ha.masp
						group by ctsp.mactsp ";
						
			//$orderby = $sapxep == 'giam' ?  " order by ctsp.giaban desc, " : " order by ctsp.giaban asc, ";
			$orderby =  " order by ngaynhap desc ";
			/*$limit = " ngaynhap desc limit $position,2
					)t1 left join
					(
						SELECT	km.makm, km.chietkhau, km.tiengiamgia, km.masp
						FROM	khuyenmai km, ctsp_km ctkm
						where	km.makm = ctkm.MaKM and km.trangthai = 1 and ('$date' >= ctkm.NgayBD and '$date' <= ctkm.NgayKT) and km.masp <> ''
						group by km.makm
					)t2 on t1.masp = t2.masp";*/
			$limit = " limit $position,12
					)t1 left join
					(
						SELECT	km.makm, km.chietkhau, km.tiengiamgia, km.masp
						FROM	khuyenmai km, ctsp_km ctkm
						where	km.makm = ctkm.MaKM and km.trangthai = 1 and ('$date' >= ctkm.NgayBD and '$date' <= ctkm.NgayKT) and km.masp <> ''
						group by km.makm
					)t2 on t1.masp = t2.masp";		
			$sql = $select.$orderby.$limit;		
		}
		else if($type=='khuyenmai')
		{
			$select = "SELECT t1.masp, t1.mactsp, t1.tensp, t1.duongdan, t1.giaban, t1.thuonghieu, t1.mausac, t2.makm, t2.chietkhau, t2.tiengiamgia
						FROM
					(	select	sp.masp, ctsp.mactsp, tensp, duongdan, ctsp.giaban, thuonghieu, ctsp.mausac
						from	sanpham sp, chitietsanpham ctsp, hinhanh ha
						where 	ctsp.trangthai = 1 and sp.trangthai = 1  and sp.masp = ctsp.masp and sp.masp = ha.masp
						group by ctsp.mactsp ";
			
			//$orderby = $sapxep == 'giam' ?  " order by ctsp.giaban desc " : " order by ctsp.giaban asc ";
			$orderby = "  ";			
			$limit = " limit $position,12
					)t1,
					(
						SELECT	km.makm, km.chietkhau, km.tiengiamgia, km.masp
						FROM	khuyenmai km, ctsp_km ctkm
						where	km.makm = ctkm.MaKM and km.trangthai = 1 and ('$date' >= ctkm.NgayBD and '$date' <= ctkm.NgayKT) and km.masp <> ''
						group by km.makm
					)t2 where t1.masp = t2.masp ";
			$sql = $select.$orderby.$limit;		
		}
		else if($type=='search')
		{
			$select = "SELECT t1.masp, t1.mactsp, t1.tensp, t1.duongdan, t1.giaban, t1.thuonghieu, t1.mausac, t2.makm, t2.chietkhau, t2.tiengiamgia
				FROM
				(	select	sp.masp, ctsp.mactsp, tensp, duongdan, ctsp.giaban, thuonghieu, ctsp.mausac
					from	sanpham sp, chitietsanpham ctsp, hinhanh ha
					where 	ctsp.trangthai = 1  and sp.trangthai = 1  and sp.masp = ctsp.masp and sp.masp = ha.masp and tensp like '%$keyword%'
					group by ctsp.mactsp ";
			//$orderby = $sapxep == 'giam' ?  " order by ctsp.giaban desc " : " order by ctsp.giaban asc ";		
			$orderby = "  ";		
			$limit = " limit $position,12
					)t1 left join
					(
						SELECT	km.makm, km.chietkhau, km.tiengiamgia, km.masp
						FROM	khuyenmai km, ctsp_km ctkm
						where	km.makm = ctkm.MaKM and km.trangthai = 1 and ('$date' >= ctkm.NgayBD and '$date' <= ctkm.NgayKT) and km.masp <> ''
						group by km.makm
						)t2 on t1.masp = t2.masp";
			$sql = $select.$orderby.$limit;	
		}
	}
	else if($madm != "")
	{
		$select = "SELECT t1.masp, t1.mactsp, t1.tensp, t1.duongdan, t1.giaban, t1.thuonghieu, t1.mausac, t2.makm, t2.chietkhau, t2.tiengiamgia
				FROM
				(	select	sp.masp, ctsp.mactsp, tensp, duongdan, ctsp.giaban, thuonghieu, ctsp.mausac
					from	sanpham sp, chitietsanpham ctsp, hinhanh ha
					where 	ctsp.trangthai = 1 and sp.trangthai = 1  and sp.masp = ctsp.masp and sp.masp = ha.masp and sp.madm = '$madm'
					group by ctsp.mactsp ";
		//$orderby = $sapxep == 'giam' ?  " order by ctsp.giaban desc " : " order by ctsp.giaban asc ";			
		$orderby = "  ";	
		$limit = " limit $position,12
				)t1 left join
				(
					SELECT	km.makm, km.chietkhau, km.tiengiamgia, km.masp
					FROM	khuyenmai km, ctsp_km ctkm
					where	km.makm = ctkm.MaKM and km.trangthai = 1 and ('$date' >= ctkm.NgayBD and '$date' <= ctkm.NgayKT) and km.masp <> ''
					group by km.makm
					)t2 on t1.masp = t2.masp";
					
		$sql = $select.$orderby.$limit;	
	}

	//echo $sql;
	
	require('../../config/config.php');
	mysql_query("set names 'utf8'");
	
	$result = mysql_query($sql);
	$list = array();
	$dem = 0;
	while($record = mysql_fetch_assoc($result))
	{
		$list[$dem]['masp'] = $record['masp'];
		$list[$dem]['mactsp'] = $record['mactsp'];
		$list[$dem]['tensp'] = $record['tensp'];
		$list[$dem]['duongdan'] = $record['duongdan'];
		$list[$dem]['giaban'] = $record['giaban'];
		$list[$dem]['thuonghieu'] = $record['thuonghieu'];
		$list[$dem]['mausac'] = $record['mausac'];
		$list[$dem]['makm'] = $record['makm'];
		$list[$dem]['chietkhau'] = $record['chietkhau'];
		$list[$dem]['tiengiamgia'] = $record['tiengiamgia'];
		$dem++;
	}
	
	if($sapxep == 'giam')
	{
		for($i=0; $i<count($list)-1; $i++)
		{
			$giamgia = 0;
			if($list[$i]['chietkhau'] != 0)
			{
				$giamgia = $list[$i]['chietkhau'];
				$giaban_i = $list[$i]['giaban'] - ($list[$i]['giaban']*($giamgia/100));	
			}
			else if($list[$i]['tiengiamgia'] != 0)
			{
				$giamgia = $list[$i]['tiengiamgia'];
				$giaban_i = $list[$i]['giaban'] - $list[$i]['tiengiamgia'];	
			}
			else if($list[$i]['chietkhau'] == 0 && $list[$i]['tiengiamgia'] == 0)
			{
				$check_qt = 1;
				$giaban_i = $list[$i]['giaban'];	
			}//echo "<br/>--------------<br/>";
			for($j=$i+1; $j<count($list); $j++)
			{
				$giamgia = 0;
				
				if($list[$j]['chietkhau'] != 0)
				{
					$giamgia = $list[$j]['chietkhau'];
					$giaban_j = $list[$j]['giaban'] - ($list[$j]['giaban']*($giamgia/100));	
				}
				else if($list[$j]['tiengiamgia'] != 0)
				{
					$giamgia = $list[$j]['tiengiamgia'];
					$giaban_j = $list[$j]['giaban'] - $list[$j]['tiengiamgia'];	
				}
				else if($list[$j]['chietkhau'] == 0 && $list[$j]['tiengiamgia'] == 0)
				{
					$check_qt = 1;
					$giaban_j = $list[$j]['giaban'];	
				}
				
				
				//echo "<br/>".$giaban_i." - ".$giaban_j;
				if($giaban_i < $giaban_j)
				{
					$temp[0] = $list[$i];
					$list[$i] = $list[$j];
					$list[$j] = $temp[0];	
					$giaban_i = $giaban_j;
					//echo " - Đổi";
				}
			}
			
			//echo "<br/>Sắp xếp lại<br/>";
			//foreach($list as $key => $value)
			//{
				//echo $list[$key]['mactsp']. " - ".$list[$key]['giaban']."<br/>";
			//}
		}
	}
	else
	{
		for($i=0; $i<count($list)-1; $i++)
		{
			if($list[$i]['chietkhau'] != 0)
			{
				$giamgia = $list[$i]['chietkhau'];
				$giaban_i = $list[$i]['giaban'] - ($list[$i]['giaban']*($giamgia/100));	
			}
			else if($list[$i]['tiengiamgia'] != 0)
			{
				$giamgia = $list[$i]['tiengiamgia'];
				$giaban_i = $list[$i]['giaban'] - $list[$i]['tiengiamgia'];	
			}
			else if($list[$i]['chietkhau'] == 0 && $list[$i]['tiengiamgia'] == 0)
			{
				$check_qt = 1;
				$giaban_i = $list[$i]['giaban'];	
			}
			for($j=$i+1; $j<count($list); $j++)
			{
				if($list[$j]['chietkhau'] != 0)
				{
					$giamgia = $list[$j]['chietkhau'];
					$giaban_j = $list[$j]['giaban'] - ($list[$j]['giaban']*($giamgia/100));	
				}
				else if($list[$j]['tiengiamgia'] != 0)
				{
					$giamgia = $list[$j]['tiengiamgia'];
					$giaban_j = $list[$j]['giaban'] - $list[$j]['tiengiamgia'];	
				}
				else if($list[$j]['chietkhau'] == 0 && $list[$j]['tiengiamgia'] == 0)
				{
					$check_qt = 1;
					$giaban_j = $list[$j]['giaban'];	
				}
				
				if($giaban_i > $giaban_j)
				{
					$temp[0] = $list[$i];
					$list[$i] = $list[$j];
					$list[$j] = $temp[0];
					$giaban_i = $giaban_j;	
				}
			}
		}
	}
	 
	for($i=0; $i<count($list); $i++)
	{
		
		echo "<a href = 'product-detail.php?id=".$list[$i]['mactsp']."'>";
        echo "<div class = 'product-home'>";
		echo "<img src='image/mypham/".$list[$i]['duongdan']."'/>";
        echo "<p>";
       	
		$giamgia = $giaban = 0; $check_qt = 0;
		if($list[$i]['makm'] == "")
		{
			$giaban = $list[$i]['giaban'];
		}
		else
		{
			if($list[$i]['chietkhau'] != 0)
			{
				$giamgia = $list[$i]['chietkhau'];
				$giaban = $list[$i]['giaban'] - ($list[$i]['giaban']*($giamgia/100));	
			}
			else if($list[$i]['tiengiamgia'] != 0)
			{
				$giamgia = $list[$i]['tiengiamgia'];
				$giaban = $list[$i]['giaban'] - $list[$i]['tiengiamgia'];	
			}
			else if($list[$i]['chietkhau'] == 0 && $list[$i]['tiengiamgia'] == 0)
			{
				$check_qt = 1;
				$giaban = $list[$i]['giaban'];	
			}
		}
		
				
        echo "<span class = 'product-price-home'> ".number_format($giaban)."  đ</span>";
        echo "<strike>". ($giamgia == 0 ?  "" :  number_format($list[$i]['giaban'])." đ")."</strike>";
        echo "</p>";
        echo "<p class = 'text-highlight'>".$list[$i]['thuonghieu']." </p>";
        echo $list[$i]['mausac'] != "" ? "<p class='product-mausac'>Màu: ".$list[$i]['mausac']."</p>" : "";
		
		if($check_qt == 1)
			echo "<p>Có quà tặng</p>";
		else
			echo "<p class = 'product-name-home'>".$list[$i]['tensp']."</p>";
        echo "</div>";
        echo "</a>";
			
	}
	 
	/*
	
	while($record = mysql_fetch_assoc($result))
	{
		echo "<a href = 'product-detail.php?id=".$record['mactsp']."'>";
        echo "<div class = 'product-home'>";
		echo "<img src='image/mypham/".$record['duongdan']."'/>";
        echo "<p>";
       	
		$giamgia = $giaban = 0; $check_qt = 0;
		if($record['makm'] == "")
		{
			$giaban = $record['giaban'];
		}
		else
		{
			if($record['chietkhau'] != 0)
			{
				$giamgia = $record['chietkhau'];
				$giaban = $record['giaban'] - ($record['giaban']*($giamgia/100));	
			}
			else if($record['tiengiamgia'] != 0)
			{
				$giamgia = $record['tiengiamgia'];
				$giaban = $record['giaban'] - $record['tiengiamgia'];	
			}
			else if($record['chietkhau'] == 0 && $record['tiengiamgia'] == 0)
			{
				$check_qt = 1;
				$giaban = $record['giaban'];	
			}
		}
				
        echo "<span class = 'product-price-home'> ".number_format($giaban)."  đ</span>";
        echo "<strike>". ($giamgia == 0 ?  "" :  number_format($record['giaban'])." đ")."</strike>";
        echo "</p>";
        echo "<p class = 'text-highlight'>".$record['thuonghieu']." </p>";
        echo $record['mausac'] != "" ? "<p class='product-mausac'>Màu: ".$record['mausac']."</p>" : "";
		
		if($check_qt == 1)
			echo "<p>Có quà tặng</p>";
		else
			echo "<p class = 'product-name-home'>".$record['tensp']."</p>";
        echo "</div>";
        echo "</a>";
	}
	*/
?>