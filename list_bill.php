<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
	<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
    	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <script src="js/jquery-1.12.4.js"></script>
        <link type="text/css" rel='stylesheet' href="style.css"/>
    	<title>Lịch sử mua hàng</title>
        
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
	
	if(isset($_SESSION['user']))
		$user = $_SESSION['user'];
	else
		$user = "";
	
	mysql_query("set names 'utf8'");
	$giohang = mysql_query("
								select		gh.magh, ngaydat, ngaygiao, gh.trangthai, tensp, count(gh.magh) 'slsp'
								from		giohang gh, chitietgiohang ctgh, sanpham sp, chitietsanpham ctsp
								where		gh.magh = ctgh.magh and ctgh.mactsp = ctsp.mactsp and ctsp.masp = sp.masp and MaKH = '$user'
								group by 	gh.magh
							");
	$soluong = mysql_num_rows($giohang);
	
	
	
	mysql_query("set names 'utf8'");
	$ctgh = mysql_query("select t1.magh, t1.mactsp, t1.soluong, t1.giaban, t2.makm, t2.chietkhau, t2.tiengiamgia
						from
						(	select	ctgh.magh, ctgh.mactsp, ctgh.soluong, ctsp.giaban, ctgh.makm
							from	chitietgiohang ctgh, chitietsanpham ctsp, giohang gh
							where	ctgh.mactsp = ctsp.mactsp and gh.magh = ctgh.magh and gh.makh = '$user'
						)t1 left join
						(
							select	km.makm, km.chietkhau, km.tiengiamgia, km.masp
							from	khuyenmai km, ctsp_km ctkm
							where	km.makm = ctkm.makm and km.makm <> '000' and km.masp != ''
							group by	km.makm
						)t2 on t1.makm = t2.makm
						");
	$list_ctgh = array();
	$dem = 0;
	$arr = array();
	$string = "";
	while($re_ctgh = mysql_fetch_assoc($ctgh))
	{
		$list_ctgh[$dem]['magh'] = $re_ctgh['magh'];
		$list_ctgh[$dem]['mactsp'] = $re_ctgh['mactsp'];
		$list_ctgh[$dem]['soluong'] = $re_ctgh['soluong'];
		$list_ctgh[$dem]['giaban'] = $re_ctgh['giaban'];
		$list_ctgh[$dem]['makm'] = $re_ctgh['makm'];
		$list_ctgh[$dem]['chietkhau'] = $re_ctgh['chietkhau'];
		$list_ctgh[$dem]['tiengiamgia'] = $re_ctgh['tiengiamgia'];
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
?>

<div id = "acc-left">
    	
        <ul>
        	<a href = "account.php?id=<?php echo $user ?>"><li>Thông tin tài khoản</li></a>
            <a href = "account.php?id=<?php echo $user ?>&type=doimk"><li>Đổi mật khẩu</li></a>
        	<a href = "list_bill.php?id=<?php echo $user ?>"><li>Lịch sử đơn hàng</li></a>
        </ul>

</div>

<div id = "acc-right">

	<p class="title" style="text-align: center">LỊCH SỬ MUA HÀNG</p><br />

	<table width="100%" border="1" id="tb-listbill">
    
    	<tr>
            <th width="10%">Mã GH</th>
            <th width="12%">Ngày đặt</th>
            <th width="34%">Sản phẩm</th>
            <th width="15%">Tổng tiền</th>
            <th width="12%">Ngày giao</th>
            <th width="17%">Trạng thái</th>
        </tr>
        
<?php
	while($re_gh = mysql_fetch_assoc($giohang))
	{
?>
		<tr>
            <td><a href='bill_detail.php?id=<?php echo $re_gh['magh']?>'><?php echo $re_gh['magh'] ?></a></td>
            <td><?php echo date('d-m-Y', strtotime($re_gh['ngaydat'])) ?></td>
            <td><?php echo $re_gh['slsp'] > 1 ? ($re_gh['tensp']." và ".($re_gh['slsp']-1)." sản phẩm khác") : $re_gh['tensp'] ?></td>
            <td>
            	
        <?php
			$thanhtien = $tongtien = 0;
			for($i=0; $i<count($list_ctgh); $i++)
			{
				$giamgia = 0; $tien = 0;
				if($list_ctgh[$i]['magh'] == $re_gh['magh'])
				{
					if($list_ctgh[$i]['makm'] != "")
					{
						if($list_ctgh[$i]['chietkhau'] != 0)
						{
							$giamgia = $list_ctgh[$i]['chietkhau'];
							$tien = $list_ctgh[$i]['giaban'] - ($list_ctgh[$i]['giaban'] * ($giamgia/100));
							$thanhtien += ($list_ctgh[$i]['giaban'] - ($list_ctgh[$i]['giaban'] * ($giamgia/100))) * $list_ctgh[$i]['soluong'];
						}
						else if($list_ctgh[$i]['tiengiamgia'] != 0)
						{
							$giamgia = $list_ctgh[$i]['tiengiamgia'];
							$tien = $list_ctgh[$i]['giaban'] - $giamgia;
							$thanhtien += ($list_ctgh[$i]['giaban'] - $giamgia)* $list_ctgh[$i]['soluong'];
						}
						//khi ko có km
						else
						{
							$tien = $list_ctgh[$i]['giaban'] - $giamgia;
							$thanhtien += ($list_ctgh[$i]['giaban'])* $list_ctgh[$i]['soluong'];
						}
					}
					else
					{
						$tien = $list_ctgh[$i]['giaban'] - $giamgia;
						$thanhtien += ($list_ctgh[$i]['giaban'])* $list_ctgh[$i]['soluong'];
					}
					//echo $re_gh['magh']." - ".$list_ctgh[$i]['mactsp']." - ".$tien."</br>";
				}
				
			}
			
			
			$ngaydat = date('Y-m-d', strtotime($re_ctgh['ngaydat']));
			mysql_query("set names 'utf8'");
			$km_hd = mysql_query("select	km.makm, km.chietkhau, km.tiengiamgia, km.giatridonhang, ctkm.ngaybd, ctkm.ngaykt
								from	khuyenmai km, ctsp_km ctkm
								where	km.makm = ctkm.makm and km.makm <> '000' and km.masp = '' and ('$ngaydat' >= ctkm.ngaybd and '$ngaydat'<=ctkm.ngaykt)
								group by	km.makm");
			$re_km = mysql_fetch_assoc($km_hd);
			if($re_km['chietkhau'] != "0")
			{
				if($re_km['giatridonhang'] != 0)
					$tongtien = $thanhtien >= $re_km['giatridonhang'] ? ($thanhtien - ($thanhtien * ($re_km['chietkhau']/100))) : $thanhtien;
				else
					$tongtien = $thanhtien - ($thanhtien * ($re_km['chietkhau']/100));
			}
			else if($re_km['tiengiamgia'] != "0")
			{
				if($re_km['giatridonhang'] != 0)
					$tongtien = $thanhtien >= $re_km['giatridonhang'] ? ($thanhtien - $re_km['tiengiamgia']) : $thanhtien;
				else
					$tongtien = $thanhtien - $re_km['tiengiamgia'];
			}
			else
			{
				$tongtien = $thanhtien;	
			}
			for($j = 0; $j<count($list_voucher); $j++)
			{
				if($re_gh['magh'] == $list_voucher[$j]['magh'])
				{
					$tongtien -= $list_voucher[$j]['giatri'];	
				}
			}
			echo number_format($tongtien)." đ";
		?>        
            	
            </td>
            <td><?php echo date('d-m-Y', strtotime($re_gh['ngaygiao'])) ?> </td>
            <td><?php echo $re_gh['trangthai'] == 0 ? "Đã hủy" : $re_gh['trangthai'] == 1 ? "Đặt hàng thành công" : "Đã xuất hóa đơn" ?></td>
        </tr>    	
<?php
	}
?>
    
    </table>

</div>

<?php
	ob_flush();
	include_once('module/bottom.php');
	mysql_close($conn);
?>