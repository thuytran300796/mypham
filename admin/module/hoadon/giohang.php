<script>

	$(document).ready(function(e) {
        $('#giohang .tb-lietke').delegate('tr', 'click', function()
		{
			id = $(this).attr('data-id'); //alert(id);
			//alert(id);
			//$(this).after($('.ctsp'+id).hide());
			$(this).after($('.ctsp'+id).slideToggle());

		});
    });

</script>

<?php

	mysql_query("set names 'utf8'");
	$giohang = mysql_query("
								select		gh.magh, ngaydat, ngaygiao, hotennguoinhan, sdt, diachi, gh.trangthai, tensp, count(gh.magh) 'slsp'
								from		giohang gh, chitietgiohang ctgh, sanpham sp, chitietsanpham ctsp
								where		gh.magh = ctgh.magh and ctgh.mactsp = ctsp.mactsp and ctsp.masp = sp.masp and gh.trangthai = 0
								group by 	gh.magh
							");
	
	mysql_query("set names 'utf8'");
	$ctgh = mysql_query("select t1.magh, t1.mactsp, t1.tensp, t1.mausac, t1.ngaysx, t1.hansudung, t1.soluong, t1.giaban, t2.makm, t2.chietkhau, t2.tiengiamgia
						from
						(	select	ctgh.magh, ctgh.mactsp, tensp, ctsp.mausac, ctsp.ngaysx, ctsp.hansudung, ctgh.soluong, ctsp.giaban, ctgh.makm
							from	chitietgiohang ctgh, chitietsanpham ctsp, giohang gh, sanpham sp
							where	ctgh.mactsp = ctsp.mactsp and gh.magh = ctgh.magh and sp.masp = ctsp.masp and gh.trangthai = 0
						)t1 left join
						(
							select	km.makm, km.chietkhau, km.tiengiamgia, km.masp
							from	khuyenmai km, ctsp_km ctkm
							where	km.makm = ctkm.makm and km.makm <> '000' and km.masp <> ''
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
		$list_ctgh[$dem]['tensp'] = $re_ctgh['tensp'];
		$list_ctgh[$dem]['mausac'] = $re_ctgh['mausac'];
		$list_ctgh[$dem]['ngaysx'] = $re_ctgh['ngaysx'];
		$list_ctgh[$dem]['hsd'] = $re_ctgh['hansudung'];
		$list_ctgh[$dem]['soluong'] = $re_ctgh['soluong'];
		$list_ctgh[$dem]['giaban'] = $re_ctgh['giaban'];
		$list_ctgh[$dem]['makm'] = $re_ctgh['makm'];
		$list_ctgh[$dem]['chietkhau'] = $re_ctgh['chietkhau'];
		$list_ctgh[$dem]['tiengiamgia'] = $re_ctgh['tiengiamgia'];
		$dem++;	
		$arr[] = "'".$re_ctgh['magh']."'";
	}
	//echo "<pre>"; print_r($list_ctgh); echo "</pre>";
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

<div id='giohang'>

<p class='title'>DANH SÁCH CÁC GIỎ HÀNG CHƯA XUẤT HÓA ĐƠN</p><br />

<table width="100%" class="tb-lietke" >
    
    	<tr>
            <th width="7%">Mã GH</th>
            <th width="7%">Ngày đặt</th>
            <th width="15%">Tên KH</th>
            <th width="18%">Địa chỉ giao hàng</th>
            <th width="9%">SĐT</th>
            <th width="7">Tổng tiền</th>
            <th width="7%">Ngày giao</th>
            <th width="10%">Trạng thái</th>
            <th width="8%">Xem chi tiết</th>
            <th width="5%">Xuất</th>
            <th width="5%">Hủy</th>
        </tr>
        
<?php
	while($re_gh = mysql_fetch_assoc($giohang))
	{
		$item = array();
?>
		<tr data-id=<?php echo $re_gh['magh'] ?>>
            <td><?php echo $re_gh['magh'] ?></td>
            <td ><?php echo date('d-m-Y', strtotime($re_gh['ngaydat'])) ?></td>
            <td><?php echo $re_gh['hotennguoinhan'] ?></td>
            <td><?php echo $re_gh['diachi'] ?></td>
            <td  ><?php echo $re_gh['sdt'] ?></td>
            <td  >
            	
        <?php
			$thanhtien = $tongtien = 0;
			
			for($i=0; $i<count($list_ctgh); $i++)
			{
				$giamgia = 0; $tien = 0;
				if($list_ctgh[$i]['magh'] == $re_gh['magh'])
				{
					$k = count($item);
					$item[$k]['magh'] = $list_ctgh[$i]['magh'];
					$item[$k]['mactsp'] = $list_ctgh[$i]['mactsp'];
					$item[$k]['tensp'] = $list_ctgh[$i]['tensp'];
					$item[$k]['mausac'] = $list_ctgh[$i]['mausac'];
					$item[$k]['ngaysx'] = $list_ctgh[$i]['ngaysx'];
					$item[$k]['hsd'] = $list_ctgh[$i]['hsd'];
					$item[$k]['giaban'] = $list_ctgh[$i]['giaban'];
					$item[$k]['soluong'] = $list_ctgh[$i]['soluong'];
					if($list_ctgh[$i]['makm'] != "")
					{
						if($list_ctgh[$i]['chietkhau'] != 0)
						{
							$giamgia = $list_ctgh[$i]['chietkhau'];
							$tien = $list_ctgh[$i]['giaban'] - ($list_ctgh[$i]['giaban'] * ($giamgia/100));
							$thanhtien += ($list_ctgh[$i]['giaban'] - ($list_ctgh[$i]['giaban'] * ($giamgia/100))) * $list_ctgh[$i]['soluong'];
							$item[$k]['giamgia'] = $giamgia." %";
						}
						else if($list_ctgh[$i]['tiengiamgia'] != 0)
						{
							$giamgia = $list_ctgh[$i]['tiengiamgia'];
							$tien = $list_ctgh[$i]['giaban'] - $giamgia;
							$thanhtien += ($list_ctgh[$i]['giaban'] - $giamgia)* $list_ctgh[$i]['soluong'];
							$item[$k]['giamgia'] = $giamgia." đ";
						}
						//khi ko có km
						else
						{
							$tien = $list_ctgh[$i]['giaban'] - $giamgia;
							$thanhtien += ($list_ctgh[$i]['giaban'])* $list_ctgh[$i]['soluong'];
							$item[$k]['giamgia'] = "Quà tặng";
						}
					}
					else
					{
						$tien = $list_ctgh[$i]['giaban'] - $giamgia;
						$thanhtien += ($list_ctgh[$i]['giaban'])* $list_ctgh[$i]['soluong'];
						$item[$k]['giamgia'] = 0;
					}
					//echo $re_gh['magh']." - ".$list_ctgh[$i]['mactsp']." - ".$tien."</br>";
					//echo $thanhtien;
				}
				
			}
			
			
			$ngaydat = date('Y-m-d', strtotime($re_ctgh['ngaydat']));
			mysql_query("set names 'utf8'");
			$km_hd = mysql_query("select	km.makm, km.chietkhau, km.tiengiamgia, km.giatridonhang, ctkm.ngaybd, ctkm.ngaykt
								from	khuyenmai km, ctsp_km ctkm
								where	km.makm = ctkm.makm and km.makm <> '000' and km.masp = '' and ('$ngaydat' >= ctkm.ngaybd and '$ngaydat'<=ctkm.ngaykt)
								group by	km.makm");
			$re_km = mysql_fetch_assoc($km_hd);
			$giam_hd =  $check_km = 0;
			if($re_km['chietkhau'] != "0")
			{
				if($re_km['giatridonhang'] != 0)
				{
					$tongtien = $thanhtien >= $re_km['giatridonhang'] ? ($thanhtien - ($thanhtien * ($re_km['chietkhau']/100))) : $thanhtien;
					$giam_hd =  $thanhtien >= $re_km['giatridonhang'] ? ($thanhtien * ($re_km['chietkhau']/100)) : 0;
				}
				else
				{
					$tongtien = $thanhtien - ($thanhtien * ($re_km['chietkhau']/100));
					$giam_hd = $thanhtien * ($re_km['chietkhau']/100);
				}
				$check_km = 1;
			}
			else if($re_km['tiengiamgia'] != "0")
			{
				if($re_km['giatridonhang'] != 0)
				{
					$tongtien = $thanhtien >= $re_km['giatridonhang'] ? ($thanhtien - $re_km['tiengiamgia']) : $thanhtien;
					$giam_hd = 	$thanhtien >= $re_km['giatridonhang'] ?  $re_km['tiengiamgia'] : 0;
				}
				else
				{
					$tongtien = $thanhtien - $re_km['tiengiamgia'];
					$giam_hd = 	$re_km['tiengiamgia'] ;
				}
				$check_km = 2;
			}
			else
			{
				$tongtien = $thanhtien;	
			}
			$tien_voucher = 0;
			for($j = 0; $j<count($list_voucher); $j++)
			{
				if($re_gh['magh'] == $list_voucher[$j]['magh'])
				{
					$tongtien -= $list_voucher[$j]['giatri'];	
					$tien_voucher += $list_voucher[$j]['giatri'];	
				}
			}
			echo number_format($tongtien)." đ";
		?>        
            	
            </td>
            <td><?php echo date('d-m-Y', strtotime($re_gh['ngaygiao'])) ?> </td>
            <td ><?php echo $re_gh['trangthai'] == 0 ? "Đã hủy" : $re_gh['trangthai'] == 1 ? "Chưa xuất" : "Đã xuất hóa đơn" ?></td>
            <td ><a href='#'>Xem</a></td>
            <td ><a href='#'>Xuất</a></td>
            <td ><a href='#'>Hủy</a></td>
        </tr>
        
        <div  class='ctsp<?php echo $re_gh['magh'] ?>' style="background: #EFFBF2; display: none; width: 1345%;   padding: 10px; ">
                
                <div style="width: 100%; height: 30px; line-height: 30px;">
                	<div class='ctsp-item' 	style="font-weight: bold; width: 25%" >Tên SP</div>
                	<div class='ctsp-item' 	style="font-weight: bold;" >Màu sắc</div>
                    <div class='ctsp-item'  style="font-weight: bold; text-align: left;" >Ngày sản xuất</div>
                    <div class='ctsp-item'  style="font-weight: bold; text-align: left;" >Hạn sử dụng</div>
                    <div class='ctsp-item'  style="font-weight: bold;text-align: center;" >Số lượng</div>
                    <div class='ctsp-item'  style="font-weight: bold;text-align: center;" >Giá bán</div>
                    <div class='ctsp-item'  style="font-weight: bold;text-align: center;" >Giảm giá/Quà tặng</div>
                </div>
                <div class="clear"></div>
                
                <?php
					foreach($item as $key => $value)
					{
					
				?>
                <div style="border-bottom: solid 1px #ccc; width: 100%">
                	<div class='ctsp-item' style="text-align: left; width: 25%"><?php echo $item[$key]['tensp'] ?></div>
                	<div class='ctsp-item'><?php echo $item[$key]['mausac']==""?"Không":$item[$key]['mausac'] ?></div>
                    <div class='ctsp-item' style="text-align: left;"><?php echo date('d/m/Y', strtotime($item[$key]['ngaysx'])) ?></div>
                    <div class='ctsp-item' style="text-align: left;"><?php echo date('d/m/Y', strtotime($item[$key]['hsd'])) ?></div>
                    <div class='ctsp-item'><?php echo $item[$key]['soluong'] ?></div>
                    <div class='ctsp-item'><?php echo number_format($item[$key]['giaban']) ?> đ</div>
                    <div class='ctsp-item'><?php echo $item[$key]['giamgia'] ?></div>
                </div>
                <div class="clear"></div>
                <?php
					}
					echo number_format($giam_hd) > 0 ? "<div style='border-top: solid 1px #ccc; width: 100%; text-align: right'>Giảm giá: ".number_format($giamgia)."".$check_km == 1 ? ". %." : ". đ."."</div>" : "";
					echo number_format($tien_voucher) > 0 ? "<div style='border-top: solid 1px #ccc; width: 100%; text-align: right'>Phiếu mua hàng: ".number_format($tien_voucher)." đ</div>" : "";
				?>
                 
                
                <div class="clear"></div>
        </div> <!-- end ctsp -->    	
<?php
	}
?>
    
    </table>
</div>