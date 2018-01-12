<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
	<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
    	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <script src="js/jquery-1.12.4.js"></script>
        <link type="text/css" rel='stylesheet' href="style.css"/>
    	<title>Chi tiết đơn hàng</title>
		</script>

<?php
	session_start();
	ob_start();
	if(isset($_GET['id']))
	{
		$id = $_GET['id'];
		$url = "account.php?id=".$id;	
	}
	else
		header('location: home.php');
	
	
	include_once('module/header.php');
	include_once('config/config.php');
	

	$id = isset($_GET['id']) ?  $_GET['id'] : "";
	
	
	mysql_query("set names 'utf8'");
	$giohang = mysql_query("
								select		gh.magh, ngaydat, ngaygiao, hotennguoinhan, sdt, diachi, gh.trangthai, tensp, count(gh.magh) 'slsp'
								from		giohang gh, chitietgiohang ctgh, sanpham sp, chitietsanpham ctsp
								where		gh.magh = ctgh.magh and ctgh.mactsp = ctsp.mactsp and ctsp.masp = sp.masp and gh.magh = '$id'
								group by 	gh.magh
							");
	$re_giohang = mysql_fetch_assoc($giohang);
	
	
	
	mysql_query("set names 'utf8'");
	$sql = "select t1.magh, t1.mactsp, t1.tensp, t1.mausac, t1.duongdan, t1.soluong, t1.giaban, t2.makm, t2.chietkhau, t2.tiengiamgia, t1.quatang
						from
						(	select	ctgh.magh, ctgh.mactsp, tensp, ctsp.mausac, duongdan, ctgh.soluong, ctsp.giaban, ctgh.makm, quatang
							from	chitietgiohang ctgh, chitietsanpham ctsp,  hinhanh ha, sanpham sp
							where	ctgh.mactsp = ctsp.mactsp  and ctgh.magh = '$id' and ha.masp = sp.masp and sp.masp = ctsp.masp
							group by ctsp.mactsp
						)t1 left join
						(
							select	km.makm, km.chietkhau, km.tiengiamgia, km.masp
							from	khuyenmai km, ctsp_km ctkm
							where	km.makm = ctkm.makm and km.makm <> '000' and km.masp != ''
							group by	km.makm
						)t2 on t1.makm = t2.makm
						";
	$ctgh = mysql_query($sql);
	$list_ctgh = array();
	$dem = 0;
	$arr = array();
	$string = "";
	while($re_ctgh = mysql_fetch_assoc($ctgh))
	{
		$list_ctgh[$dem]['magh'] = $re_ctgh['magh'];
		$list_ctgh[$dem]['mactsp'] = $re_ctgh['mactsp'];
		$list_ctgh[$dem]['tensp'] = $re_ctgh['tensp'];
		$list_ctgh[$dem]['mausac'] = $re_ctgh['mausac'];
		$list_ctgh[$dem]['duongdan'] = $re_ctgh['duongdan'];
		$list_ctgh[$dem]['soluong'] = $re_ctgh['soluong'];
		$list_ctgh[$dem]['giaban'] = $re_ctgh['giaban'];
		$list_ctgh[$dem]['makm'] = $re_ctgh['makm'];
		$list_ctgh[$dem]['chietkhau'] = $re_ctgh['chietkhau'];
		$list_ctgh[$dem]['tiengiamgia'] = $re_ctgh['tiengiamgia'];
		$list_ctgh[$dem]['quatang'] = $re_ctgh['quatang'];
		$dem++;	
		$arr[] = "'".$re_ctgh['magh']."'";
	}
	//echo "<pre>";print_r($list_ctgh); echo "</pre>";
	
	$string = implode(',', $arr);
	$voucher = mysql_query("select magh, gh.maphieu, giatri from pmh_gh gh, phieumuahang pmh where gh.maphieu = pmh.maphieu and gh.magh in ($string)");
	$list_voucher = array();
	$dem = 0;
	while($re_voucher = mysql_fetch_assoc($voucher))
	{
		$list_voucher[$dem]['magh'] = $re_voucher['magh'];
		$list_voucher[$dem]['maphieu'] = $re_voucher['maphieu'];
		$list_voucher[$dem]['giatri'] = $re_voucher['giatri'];
		$dem++;
	}
	
	if(isset($_GET['huy']))
	{
		$kq = mysql_query("update giohang set trangthai = 2 where magh = '$id'");
		$ctgh = mysql_query($sql);
		while($re_ctgh = mysql_fetch_assoc($ctgh))
		{
			$kq = mysql_query("update chitietsanpham set soluong = soluong + ".$re_ctgh['soluong']." where mactsp = '".$re_ctgh['mactsp']."'");	
		}
		echo "<script>alert('Hủy giỏ hàng thành công!')</script>";
		$user = $_SESSION['user'];
		header('location: list_bill.php?id=$user');
	}
?>

<div id = "bill-info">
    
    	<p style = "color: #3CA937; font-weight: bold; font-size: 25px;">THÔNG TIN GIAO HÀNG</p>
    
		<table cellspacing="20px" style = "text-align: left">
        	<tr>
            	<td style = "font-weight: bold">Ngày đặt</td>
                <td><?php echo date('d-m-Y', strtotime($re_giohang['ngaydat'])) ?></td>
            </tr>
            
            <tr>
            	<td style = "font-weight: bold">Họ tên: </td>
                <td><?php echo $re_giohang['hotennguoinhan'] ?></td>
            </tr>
            
            <tr>
            	<td style = "font-weight: bold">Địa chỉ: </td>
                <td><?php echo $re_giohang['diachi'] ?></td>
            </tr>
            
            <tr>
            	<td style = "font-weight: bold">Số điện thoại: </td>
                <td><?php echo $re_giohang['sdt'] ?></td>
            </tr>
            
            <tr>
            	<td style = "font-weight: bold">Ngày giao: </td>
                <td><?php echo date('d-m-Y', strtotime($re_giohang['ngaygiao'])) ?></td>
            </tr>
            
            <tr>
            	<td style = "font-weight: bold">Trạng thái đơn hàng: </td>
                <td><?php echo $re_giohang['trangthai'] == 0 ? "Đặt hàng thành công" : ($re_giohang['trangthai'] == 1 ? "Đã xuất hóa đơn" : "Đã hủy") ?></td>
            </tr>
            
        </table>
    
</div>


<div id = "list-pro">
    
    	<p style = "color: #3CA937; font-weight: bold; font-size: 25px;">CHI TIẾT ĐƠN HÀNG</p>
        
        
    
    	<table class = "list-bill" border="1">
        	
            <tr>
            	<th width="20%">Mã SP</th>
                <th width="40%">Thông tin sản phẩm</th>
                <th width="10%">Số lượng</th>
                <th width="15%">Giá bán</th>
                <th width="15%">Thành tiền</th>
            </tr>
            
         <?php
		 	$tongtien = $tamtinh = $tienvoucher = 0;
		 	for($i=0; $i<count($list_ctgh); $i++)
			{
				$thanhtien = $giaban = 0;
		 ?>
            
            <tr>
            
            	<td style = "color: #3CA937; font-weight: bold; text-align: left; padding-left: 10px;"><?php echo $list_ctgh[$i]['mactsp'] ?></td>
            	<td>
                
                	<div id = "bill-pro">
                    
                    	<div id = "bill-pro-img">
                        
                        	<img src = "image/mypham/<?php echo $list_ctgh[$i]['duongdan'] ?>"/>
                        
                        </div>
                        
                        <div id = "bill-pro-info">
                            <a href='product-detail.php?id=<?php echo $list_ctgh[$i]['mactsp'] ?>'>
                                <p ><?php echo $list_ctgh[$i]['tensp'].($list_ctgh[$i]['quatang'] == 1 ? " (Quà tặng)" : "") ?></p>
                               	<?php  echo $list_ctgh[$i]['mausac'] != "" ? "<p>Màu sắc: ".$list_ctgh[$i]['mausac']."</p>" :  "" ?>
                            </a>
                        </div>
                    	<div class = "clear"></div>
                    </div>
                    
                
                    
                </td>
                <td><?php echo $list_ctgh[$i]['soluong'] ?></td>
                <td >
				<?php
				
				if($list_ctgh[$i]['quatang'] == 0)
				{
					if($list_ctgh[$i]['makm'] != "")
					{
						
						if($list_ctgh[$i]['chietkhau'] != 0)
						{
							$giamgia = $list_ctgh[$i]['chietkhau'];
							$giaban = $list_ctgh[$i]['giaban'] - ($list_ctgh[$i]['giaban'] * ($giamgia/100)) ;
							$thanhtien += $giaban * $list_ctgh[$i]['soluong'];
						}
						else if($list_ctgh[$i]['tiengiamgia'] != 0)
						{
							$giamgia = $list_ctgh[$i]['tiengiamgia'];
							$giaban = $list_ctgh[$i]['giaban'] - $giamgia;
							$thanhtien += $giaban* $list_ctgh[$i]['soluong'];
						}
						else
						{
							$giaban = $list_ctgh[$i]['giaban'];
							$thanhtien += $giaban* $list_ctgh[$i]['soluong'];
						}
					}
					else
					{
						$giaban = $list_ctgh[$i]['giaban'];
						$thanhtien += $giaban* $list_ctgh[$i]['soluong'];
					}
					$tamtinh += $thanhtien;
				}
				else
					$giaban = 0;
					echo number_format($giaban);
				?> 
                 
                 đ</td>
                <td style="text-align: right"><?php echo number_format($thanhtien); ?> đ</td>
            </tr>
            
       <?php
			}
		?>
     
            <tr>
            	<td colspan="4" style = "text-align: right; font-weight: bold;">Tiền sản phẩm:</td>
                <td style="text-align: right"><?php echo number_format($tamtinh) ?> đ</td>
            </tr>
            
            <tr>
            	<td colspan="4" style = "text-align: right; font-weight: bold;">Giảm giá:</td>
                <td style="text-align: right">
                
            <?php
			
				$ngaydat = date('Y-m-d', strtotime($re_giohang['ngaydat']));  $giamgia = 0;
				mysql_query("set names 'utf8'");
				$km_hd = mysql_query("select	km.makm, km.chietkhau, km.tiengiamgia, km.giatridonhang, ctkm.ngaybd, ctkm.ngaykt
									from	khuyenmai km, ctsp_km ctkm
									where	km.makm = ctkm.makm and km.makm <> '000' and km.masp = '' and ('$ngaydat' >= ctkm.ngaybd and '$ngaydat'<=ctkm.ngaykt)
									group by	km.makm");
									
				//echo "số km: ".mysql_num_rows($km_hd);
				while($re_km = mysql_fetch_assoc($km_hd))
				{
				
					if($re_km['chietkhau'] != "0")
					{
						if($re_km['giatridonhang'] != 0)
							$giamgia = $tamtinh >= $re_km['giatridonhang'] ? ($tamtinh * ($re_km['chietkhau']/100)) : 0;
						else
							$giamgia = $tamtinh * ($re_km['chietkhau']/100);
					}
					else if($re_km['tiengiamgia'] != "0")
					{
						if($re_km['giatridonhang'] != 0)
							$giamgia = $tamtinh >= $re_km['giatridonhang'] ? $re_km['tiengiamgia'] : 0;
						else
							$giamgia = $re_km['tiengiamgia'];
					}
					else
					{
						$giamgia = 0;	
					}
				}
				for($j = 0; $j<count($list_voucher); $j++)
				{
					if($re_giohang['magh'] == $list_voucher[$j]['magh'])
					{
						$tienvoucher += $list_voucher[$j]['giatri'];	
					}
				}
				echo number_format($giamgia);
			?>
                
                 đ</td>
            </tr>
            
            <tr>
            	<td colspan="4" style = "text-align: right; font-weight: bold;">Voucher áp dụng:</td>
                <td style="text-align: right"><?php echo number_format($tienvoucher) ?> đ</td>
            </tr>
            
            <tr>
            	<td colspan="4" style = "text-align: right; font-weight: bold;">Tạm tính:
                	<p><i>(Chưa bao gồm phí vận chuyển)</i></p>
                </td>
                <td style = "font-size: 22px; color: #090; font-weight: bold; text-align: right"><?php echo number_format($tamtinh - $giamgia - $tienvoucher) ?> đ</td>
            </tr>
        </table>
        <br />
    <?php
		if($re_giohang['trangthai'] == 0)
		{
	?>
        <form method="get">
        <div style="width: 20%; text-align: right; float: right ">
        	<input type='submit' name='huy' value = 'HỦY' class="btn-cart" onclick="return ConfirmDel();" />
            <input type='hidden' name='id' value = "<?php echo $id ?>"/>
        </div>
        </form>
    <?php
		}
	?>
</div>


<script>
	function ConfirmDel()
			{
				if(confirm("Bạn có chắn chắn muốn hủy không?"))
				{
					return true;
				}
				else
				{
					return false;	
				}
			}
</script>

<?php
	ob_flush();
	include_once('module/bottom.php');
	mysql_close($conn);
?>