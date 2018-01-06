<?php

	require('../../../../config/config.php');

if(isset($_POST['ac']))
{
	$ac = $_POST['ac'];
	
	if($ac == 'search')
	{
		$keyword = mysql_escape_string($_POST['keyword']);
		mysql_query("set names 'utf8'");
		$kq = mysql_query("select ctsp.mactsp, sp.masp, sp.tensp, ctsp.mausac, ctsp.ngaysx, ctsp.hansudung, thuonghieu, tenncc, duongdan, ctsp.giaban
							from sanpham sp, chitietsanpham ctsp, nhacungcap ncc, hinhanh ha
							where sp.masp = ctsp.masp and ncc.mancc = sp.mancc and sp.masp = ha.masp and sp.trangthai = 1 and ctsp.trangthai = 1
							and (tensp LIKE '%$keyword%' or sp.masp LIKE '%$keyword%' or ctsp.mactsp LIKE '%$keyword%')
							group by ctsp.mactsp");
				
		while($re_kq = mysql_fetch_assoc($kq))
		{
			echo "<li>";
			echo 	"<a href='javascript:void(0)' data-id='".$re_kq['mactsp']."'>";
			echo 		"<img src='../image/mypham/".$re_kq['duongdan']."'/>";
			echo 		"<div style='background: none'>";
			echo 			"<p>".$re_kq['tensp']."</p>";
			echo 			"<p>Màu sắc: ".$re_kq['mausac']."</p>";
			echo 			"<p>Date: ".date('d/m/Y', strtotime($re_kq['ngaysx']))." - ".date('d/m/Y', strtotime($re_kq['hansudung']))."</p>";
			echo 			"<p>Thương hiệu: ".$re_kq['thuonghieu']."</p>";
			echo			"<p>Nhà cung cấp: ".$re_kq['tenncc']."</p>";
			echo			"<p>Giá bán: ".$re_kq['giaban']."</p>";
			echo 		"</div>";
			echo 	"</a>";
			echo "</li>";
			echo "<div class='clear' style='background: none'></div>";
		}	
	}
	else if($ac == 'get_sp')
	{
		$id = isset($_POST['id']) ? $_POST['id'] : "";
		echo $id;
		mysql_query("set names 'utf8'");
		
		$sp = mysql_query("	select ctsp.mactsp, sp.masp, sp.tensp, sp.thue, ctsp.mausac, ctsp.ngaysx, ctsp.hansudung, thuonghieu, tenncc, duongdan, ctsp.giaban
							from sanpham sp, chitietsanpham ctsp, nhacungcap ncc, hinhanh ha
							where sp.masp = ctsp.masp and ncc.mancc = sp.mancc and sp.masp = ha.masp and sp.trangthai = 1 and ctsp.trangthai = 1
							and ctsp.mactsp = '$id'
							group by sp.masp");
		$re_sp = mysql_fetch_assoc($sp);
		
		if(!isset($_SESSION['cart_ad']))
			$_SESSION['cart_ad'] = NULL;
			
		if(isset($_POST['id']))
		{
			//echo "có";
			if($_POST['id'] == "")
				return false;
			$ctsp = $_POST['id'] ;
			if(!isset($_SESSION['cart_ad'][$ctsp]))
			{
				$_SESSION['cart_ad'][$ctsp]['soluong'] = 1;
				$_SESSION['cart_ad'][$ctsp]['giaban'] = $re_sp['giaban'];
				$_SESSION['cart_ad'][$ctsp]['masp'] = $re_sp['masp'];
				$_SESSION['cart_ad'][$ctsp]['tensp'] = $re_sp['tensp'];
				$_SESSION['cart_ad'][$ctsp]['thue'] = $re_sp['thue'];
				$_SESSION['cart_ad'][$ctsp]['maqt'] = "";  
				$_SESSION['cart_ad'][$ctsp]['mausac'] = $re_sp['mausac'];
				$_SESSION['cart_ad'][$ctsp]['makm'] = "";
				$_SESSION['cart_ad'][$ctsp]['chietkhau'] = "";
				$_SESSION['cart_ad'][$ctsp]['tiengiamgia'] = "";
			}
			
			if(isset($_SESSION['cart_ad']))
			{
				date_default_timezone_set('Asia/Ho_Chi_Minh');
				$date = date('Y-m-d');
					
			
				
			
				foreach($_SESSION['cart_ad'] as $key => $value)
				{
					$arr_id[] = "'$key'";
				}
				$string = implode(',', $arr_id);
				echo "mactsp: ".$string;
				mysql_query("set names 'utf8'");
					//lấy giá cả, khuyến mãi
				$sp_km = mysql_query("select km.makm, km.mota, km.masp, ctsp.mactsp, ctsp.giaban, km.giatrivoucher, km.giatridonhang, km.chietkhau, km.tiengiamgia, ctkm.id, ctkm.ngaybd, ctkm.ngaykt, ctkm.mactsp as 'maqt'
									from 	khuyenmai km, ctsp_km ctkm, sanpham sp, chitietsanpham ctsp
									where 	km.makm = ctkm.MaKM and km.masp = sp.masp and ctsp.MaSP = sp.MaSP
										and ctsp.MaCTSP = '$id' and km.trangthai = 1 
										and ('$date' >= ctkm.ngaybd and '$date' <= ctkm.ngaykt)");
				echo "slkm: ".mysql_num_rows($sp_km);
				$dem = 0;
				
				$list_qt = array();
				
				if(mysql_num_rows($sp_km) > 0)
				{
					$re_sp = mysql_fetch_assoc($sp_km);
					
					$_SESSION['cart_ad'][$ctsp]['makm'] = $re_sp['makm'];
					$_SESSION['cart_ad'][$ctsp]['chietkhau'] = $re_sp['chietkhau'];
					$_SESSION['cart_ad'][$ctsp]['tiengiamgia'] = $re_sp['tiengiamgia'];
					$_SESSION['cart_ad'][$ctsp]['mactkm'] = $re_sp['id'];
					$_SESSION['cart_ad'][$ctsp]['maqt'] = $re_sp['maqt'];
					$list_qt[$dem++] = $re_sp['maqt'];
					//echo "z1ô";
					while($re_sp = mysql_fetch_assoc($sp_km))
					{
						echo "zô";
						$list_qt[$dem] = $re_sp['maqt'];
						$dem++;	
							
		
							if(isset($_GET['mactsp']) && isset($_GET['maqt']))
							{
								if($_GET['mactsp'] == $re_sp['mactsp'])
								{
									//dùng để kiểm tra sự cố tình nhập mã qt trên đường dẫn - nếu ko có thì ko add
									if($re_sp['maqt'] == $_GET['maqt'])
										$_SESSION['cart_ad'][$_GET['mactsp']]['maqt'] = $_GET['maqt'];
								}
							}
							
					}
					foreach($_SESSION['cart_ad'] as $key => $value)
					{
						$check_qt = 0;
						foreach($list_qt as $key_km => $value_km)
						{
							if($_SESSION['cart_ad'][$key]['maqt'] == $list_qt[$key_km])
							{
								$check_qt = 1;
								break;
							}
						}
						if(!$check_qt)
							$_SESSION['cart_ad'][$key]['maqt'] = "";
					}
		
				}
				else
				{
					//foreach($_SESSION['cart_ad'] as $key => $value)
						$_SESSION['cart_ad'][$key]['maqt'] = "";
					
				}
				
			
		}
		
		$arr_qt = array();
		foreach($list_qt as $key_qt => $value_qt)
		{
			$giamgia = $chietkhau = 0;
			//nếu mà $key sp trong giỏ hàng có trong $list_qt
			//if($list_qt[$key_qt]['mactsp'] == $key )
			//{
				if($list_qt[$key_qt] != "")
					$arr_qt[] = "'".$list_qt[$key_qt]."'";
			//}
		}
		$string_qt = count($arr_qt) > 0 ? implode(',', $arr_qt) : "''"; 
		mysql_query("set names 'utf8'");
		$quatang = mysql_query("select ctsp.mactsp, tensp, ctsp.mausac, duongdan from sanpham sp, chitietsanpham ctsp, hinhanh ha where sp.masp = ctsp.masp and sp.masp = ha.masp and ctsp.mactsp in ($string_qt)");
	
		//echo "<pre>"; print_r($_SESSION['cart_ad']);echo "</pre>";
		//echo "<pre>"; print_r($list_qt);echo "</pre>";	
	?>
			<tr data-id=<?php echo $key ?>>
					<td><a href='javascript:void(0)' class='del' data-id='<?php echo $ctsp ?>'><img src='../image/del.png' /></a></td>
					<td><?php echo $ctsp ?></td>
					<td><p><b><?php echo  $_SESSION['cart_ad'][$ctsp]['tensp']?></b></p>
                    	<p><?php echo $_SESSION['cart_ad'][$ctsp]['mausac'] != "" ? ("<p>Màu sắc: ".$_SESSION['cart_ad'][$ctsp]['mausac']."</p>") : "" ?></p>
						<div class='product-km' style="width: 100%; float: left;">
								<?php echo ($string_qt != "''" ?   "<p style='color: #000; font-size: 12px;'>Chọn một trong số các quà tặng sau:</p>" : ""); echo $string_qt?>
								<ul>
								
									<!--
										<li title="Chì kẻ mày">
											<a href="product-detail.php?id=SP1">
													<img style='width: 70px; height: 70px;' src='../image/mypham/master_brow_liner_gy-1_1.jpg'/>
											</a>
										</li>
									-->
									<?php
										while($re_qt = mysql_fetch_assoc($quatang))
										{
											if($re_qt['mactsp'] == $_SESSION['cart_ad'][$key]['maqt'] || $_SESSION['cart_ad'][$key]['maqt'] == "")
											{
												$_SESSION['cart_ad'][$key]['maqt'] = $re_qt['mactsp'];
									?>
											
											<li style='border: solid 2px #0CC;' title="<?php echo $re_qt['tensp'].($re_qt['mausac'] != "" ? " - Màu sắc: ".$re_qt['mausac'] : "") ?>">
									<?php
											}
											else
											{
									?>
											<li  title="<?php echo $re_qt['tensp'].($re_qt['mausac'] != "" ? " - Màu sắc: ".$re_qt['mausac'] : "") ?>">
									<?php
											}
									?>
												<a href='javascript:void(0)' class='choose-qt' data-maqt='<?php echo $re_qt['mactsp'] ?>'>
													<img style='width: 70px; height: 70px;' src='../image/mypham/<?php echo $re_qt['duongdan'] ?>'/>
												</a>
											</li>
									<?php
										}
									?>
								</ul>
								<div class="clear"></div>
					   </div>
					</td>
					<td align="center"><input type='submit' class='btn-sub' data-id='<?php echo $ctsp ?>' value='-' />
						<input type="text" readonly="readonly" class="txt-soluong txt-soluong-<?php echo $ctsp ?> " value="1"/>
						<input type='submit' class='btn-plus' data-id='<?php echo $ctsp ?>' value='+' /></td>
					<td align="right">
                        <?php
							$giamgia = 0;
							if($_SESSION['cart_ad'][$ctsp]['chietkhau'] != 0)
							{
								$giamgia = ($_SESSION['cart_ad'][$ctsp]['chietkhau']/100) * $_SESSION['cart_ad'][$ctsp]['giaban'];
							}
							else if($_SESSION['cart_ad'][$ctsp]['tiengiamgia'] != 0)
							{
								$giamgia = $_SESSION['cart_ad'][$ctsp]['tiengiamgia'] 	;
							}
							if($giamgia > 0)
							{
								echo "<p>".number_format($_SESSION['cart_ad'][$ctsp]['giaban'] - $giamgia)." đ</p>";
								echo "<p><strike>".number_format($_SESSION['cart_ad'][$ctsp]['giaban'])." đ<strike></p>";
							}
							else
								echo "<p>".number_format($_SESSION['cart_ad'][$ctsp]['giaban'])." đ</p>";
						?>
                    </td>
				</tr>
<?php		
  		}
	} //end case get_sp
	else if($ac == 'soluong')
	{
		$ctsp = $_POST['id'];
		$_SESSION['cart_ad'][$ctsp]['soluong'] = $_POST['soluongmoi'];
		HamTinhTien();
	}
	else if($ac == 'del')
	{
		$ctsp = $_POST['id'];
		if(isset($_SESSION['cart_ad'][$ctsp]))
			unset($_SESSION['cart_ad'][$ctsp]);
		if(count($_SESSION['cart_ad']) == 0)
			unset($_SESSION['cart_ad']);	
		else if(count($_SESSION['cart_ad']) == 1)
		{
			if(isset($_SESSION['cart_ad']['QT000'])	)
				unset($_SESSION['cart_ad']);
		}
		HamTinhTien();
	}
	else if($ac == 'qt')
	{
		$maqt = $_POST['maqt'];
		$mactsp = $_POST['mactsp'];
		$_SESSION['cart_ad'][$mactsp]['maqt'] = $maqt;
		echo $_SESSION['cart_ad'][$mactsp]['maqt'];
	}
	else if($ac == 'tinhtien')
	{
		HamTinhTien();
	}
	else if($ac == 'chonqt')
	{
		$maqt = $_POST['maqt_hd'];
		if(isset($_SESSION['cart_ad']))
		{
			if(array_key_exists ('QT000', $_SESSION['cart_ad']))
			{
				$_SESSION['cart_ad']['QT000']['maqt'] = $maqt;
				echo $_SESSION['cart_ad']['QT000']['maqt'];
			}
			else
			{
				$_SESSION['cart_ad']['QT000']['soluong'] = 1;
				$_SESSION['cart_ad']['QT000']['giaban'] = 0;
				$_SESSION['cart_ad']['QT000']['makm'] = '000';
				$_SESSION['cart_ad']['QT000']['maqt'] = $maqt;
				$_SESSION['cart_ad']['QT000']['chietkhau'] = 0;
				$_SESSION['cart_ad']['QT000']['tiengiamgia'] = 0;
			}
		}
	}
}
?>

<?php

	function HamTinhTien()
	{
		$tiensp = 0;
		$thue = 0;
		if(isset($_SESSION['cart_ad']))
		{	
			
			foreach($_SESSION['cart_ad'] as $key => $value)
			{
				$giamgia = 0;
				if($_SESSION['cart_ad'][$key]['chietkhau'] != 0)
				{
					$giamgia = ($_SESSION['cart_ad'][$key]['chietkhau']/100) * $_SESSION['cart_ad'][$key]['giaban'];
				}
				else if($_SESSION['cart_ad'][$key]['tiengiamgia'] != 0)
				{
					$giamgia = $_SESSION['cart_ad'][$key]['tiengiamgia'] 	;
				}
				if($giamgia > 0)
				{
					$tiensp += ($_SESSION['cart_ad'][$key]['giaban'] - $giamgia) * $_SESSION['cart_ad'][$key]['soluong'];
					$thue += (int)(($_SESSION['cart_ad'][$key]['giaban'] - $giamgia)/(100+$_SESSION['cart_ad'][$key]['thue'] /$_SESSION['cart_ad'][$key]['thue'])) * $_SESSION['cart_ad'][$key]['soluong'];
				}
				else
				{
					$tiensp += ($_SESSION['cart_ad'][$key]['giaban'] * $_SESSION['cart_ad'][$key]['soluong']);
					$thue += (int)($_SESSION['cart_ad'][$key]['giaban']/(100+$_SESSION['cart_ad'][$key]['thue'] /$_SESSION['cart_ad'][$key]['thue'])) * $_SESSION['cart_ad'][$key]['soluong'];
				}
				
			}
		}
		echo  json_encode(array("tiensp"=>"$tiensp", "thue"=>"$thue"));
	}

?>

<?php
	mysql_close($conn);
?>
