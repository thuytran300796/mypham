<?php

	require('../../config/config.php');
	
	date_default_timezone_set('Asia/Ho_Chi_Minh');
	$date = date('Y-m-d');

	if(isset($_POST['ac']))
	{
		$ac = $_POST['ac'];
		
		if($ac == 'them')
		{
			$maphieu = $_POST['maphieu'];
			if(!isset($_SESSION['voucher']))
				$_SESSION['voucher'] = NULL;
			
			if(!isset($_SESSION['voucher'][$maphieu]))
			{
				$result = mysql_query("select maphieu, giatri, ngaybd, ngaykt, trangthai from phieumuahang where BINARY maphieu = '$maphieu'");	
				if(mysql_num_rows($result) == 0)
				{
					echo json_encode(array("maphieu"=>"", "giatri"=>"","error"=>"Voucher không tồn tại!"));
				}
				else
				{
					$dong = mysql_fetch_assoc($result);
					if($date < $dong['ngaybd'] || $date > $dong['ngaykt'])
					{	
						echo json_encode(array("maphieu"=>"", "giatri"=>"","error"=>"Thời gian áp dụng cho voucher chưa hợp lệ!"));
					}
					else if($dong['trangthai'] == 1)
					{
						echo json_encode(array("maphieu"=>"", "giatri"=>"","error"=>"Voucher này đã được sử dụng!"));	
					}
					else
					{
						$tienhd = $_POST['tienhd'];
						$chietkhau_hd = $giamgia_hd = 0;
						//kiểm tra coi có khuyến mãi nào ko? nếu có thì ko dc xài voucher
						$khuyenmai = mysql_query("select km.makm, km.mota, ctsp.giaban, km.giatrivoucher, km.giatridonhang, km.chietkhau, km.tiengiamgia, ctkm.id, ctkm.ngaybd, ctkm.ngaykt, ctkm.mactsp as 'maqt'
												from 	khuyenmai km, ctsp_km ctkm, chitietsanpham ctsp
												where 	km.makm = ctkm.MaKM  and  ctsp.MaCTSP = ctkm.mactsp and km.trangthai = 1 
													and ('$date' >= ctkm.ngaybd and '$date' <= ctkm.ngaykt)
													and km.masp = ''");
						$check = 1; //đc sd voucher
						//nếu có km
						if(mysql_num_rows($khuyenmai) > 0)
						{
							while($re_km = mysql_fetch_assoc($khuyenmai))
							{
								$check = 0;
								if($re_km['chietkhau'] != "0" || $re_km['tiengiamgia'] != "0")
								{
									//nếu đơn hàng hiện tại thỏa điều kiện áp dụng km thì sẽ ko đc sd voucher
									if($tienhd >= $re_km['giatridonhang'])
									{
										//echo json_encode(array("maphieu"=>"", "giatri"=>"","error"=>"Voucher sẽ không được sử dụng khi có đang có chương trình khuyến mãi!"));	
										$check = 1;
									}
								}
								else if($re_km['maqt'] != "")
								{
									//echo json_encode(array("maphieu"=>"", "giatri"=>"","error"=>"Voucher sẽ không được sử dụng khi có đang có chương trình khuyến mãi!"));
									$check = 1;
								}	
							}
							if($check)
								echo json_encode(array("maphieu"=>"", "giatri"=>"","error"=>"Voucher sẽ không được sử dụng khi có đang có chương trình khuyến mãi!"));
							else
							{
								$_SESSION['voucher'][$maphieu]['giatri'] = $dong['giatri'];	
								$_SESSION['voucher'][$maphieu]['ngaybd'] = $dong['ngaybd'];
								$_SESSION['voucher'][$maphieu]['ngaykt'] = $dong['ngaykt'];
								$tonggiam = 0;
								foreach($_SESSION['voucher'] as $key => $value)
									$tonggiam += (float)$_SESSION['voucher'][$key]['giatri'];
								//$tamtinh = $tienhd - $tonggiam < 0 ? 0 : $tienhd - $tonggiam;
								$tamtinh = $tienhd - $dong['giatri'] < 0 ? 0 : $tienhd - $dong['giatri'];
								//$_SESSION['voucher'][$maphieu]['giamgia'] = $dong['giatri'];	
								echo json_encode(array("maphieu"=>"$maphieu", "giatri"=>"$dong[giatri]", "tonggiam"=>"$tonggiam", "tamtinh"=>"$tamtinh"));
							}
						}
						//nếu ko có km
						else
						{
							$_SESSION['voucher'][$maphieu]['giatri'] = $dong['giatri'];	
							$_SESSION['voucher'][$maphieu]['ngaybd'] = $dong['ngaybd'];
							$_SESSION['voucher'][$maphieu]['ngaykt'] = $dong['ngaykt'];
							$tonggiam = 0;
							foreach($_SESSION['voucher'] as $key => $value)
								$tonggiam += (float)$_SESSION['voucher'][$key]['giatri'];
							//$tamtinh = $tienhd - $tonggiam < 0 ? 0 : $tienhd - $tonggiam;
							$tamtinh = $tienhd - $dong['giatri'] < 0 ? 0 : $tienhd - $dong['giatri'];
							//$_SESSION['voucher'][$maphieu]['giamgia'] = $dong['giatri'];	
							echo json_encode(array("maphieu"=>"$maphieu", "giatri"=>"$dong[giatri]", "tonggiam"=>"$tonggiam", "tamtinh"=>"$tamtinh"));
						}
					}
					
					
				}
			}
			else
			{
				echo json_encode(array("maphieu"=>"", "giatri"=>"","error"=>"Mỗi voucher chỉ được sử dụng một lần!"));	
			}
		}
		else if($ac == 'xoa')
		{
			$maphieu = $_POST['maphieu'];
			$result = mysql_query("select maphieu, giatri, ngaybd, ngaykt, trangthai from phieumuahang where BINARY maphieu = '$maphieu'");
			$dong = mysql_fetch_assoc($result);
			
			$tonggiam = 0;
			foreach($_SESSION['voucher'] as $key => $value)
				$tonggiam += (float)$_SESSION['voucher'][$key]['giatri']; //100 
			
			$tienhd = $_POST['tienhd']; //0
			$tiensp = $_POST['tiensp']; //93
			
			$tienhd = $tienhd <= 0 ? ($tiensp - $tonggiam + $dong['giatri']) : $tienhd + $dong['giatri'];

			//xóa voucher
			$tonggiam -= $dong['giatri'];unset($_SESSION['voucher'][$maphieu]); $soluong = count($_SESSION['voucher']);
			
			echo json_encode(array("soluong"=>"$soluong", "tonggiam"=>"$tonggiam", "tienhd"=>"$tienhd"));
			
			if(count($_SESSION['voucher']) == 0)
				unset($_SESSION['voucher']);
			
		}
	}

	mysql_close($conn);
?>