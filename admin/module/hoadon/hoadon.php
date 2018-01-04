<script>

	$(document).ready(function(e) {
        $('#hoadon .tb-lietke').delegate('tr', 'click', function()
		{
			id = $(this).attr('data-id'); //alert(id);
			//alert(id);
			//$(this).after($('.ctsp'+id).hide());
			$(this).after($('.ctsp'+id).slideToggle());

		});
		
		$('#search-sub').click(function()
		{
			keyword = $('#keyword').val();
			$.ajax
			({
				url: "module/hoadon/xuly/xuly.php",
				type :"post",
				data: "ac=search_mahd&keyword="+keyword,
				async: true,
				success:function(kq)
				{
					$('#hoadon table').html(kq);	
				}	
			});
		});
		
		$('#loc').click(function()
		{
			ngaybd = $('#ngaybd').val();
			ngaykt = $('#ngaykt').val();
			$.ajax
			({
				url: "module/hoadon/xuly/xuly.php",
				type :"post",
				data: "ac=search_ngay&ngaybd="+ngaybd+"&ngaykt="+ngaykt,
				async: true,
				success:function(kq)
				{
					$('#hoadon table').html(kq);	
				}	
			});
		});
    });

</script>

<?php

	date_default_timezone_set('Asia/Ho_Chi_Minh');
	$ngaybd = $ngaykt = date('Y-m-d');
	$keyword = "";

	mysql_query("set names 'utf8'");
	$hoadon = mysql_query("
								select		hd.mahd, ngayxuat, hotennguoinhan, sdt, diachi, phivanchuyen, thue, hd.trangthai, km.makm, km.chietkhau, km.tiengiamgia, km.giatridonhang
								from		hoadon hd, khuyenmai km
								where		hd.makm = km.makm
								group by 	km.makm
							");
	
	mysql_query("set names 'utf8'");
	$cthd = mysql_query("select t1.mahd, t1.mactsp, t1.tensp, t1.mausac, t1.ngaysx, t1.hansudung, t1.soluong, t1.giaban, t2.makm, t2.chietkhau, t2.tiengiamgia
						from
						(	select	cthd.mahd, cthd.mactsp, tensp, ctsp.mausac, ctsp.ngaysx, ctsp.hansudung, cthd.soluong, ctsp.giaban, cthd.makm
							from	chitiethoadon cthd, chitietsanpham ctsp, hoadon hd, sanpham sp
							where	cthd.mactsp = ctsp.mactsp and hd.mahd = cthd.mahd and sp.masp = ctsp.masp 
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
	while($re_cthd = mysql_fetch_assoc($cthd))
	{
		$list_ctgh[$dem]['mahd'] = $re_cthd['mahd'];
		$list_ctgh[$dem]['mactsp'] = $re_cthd['mactsp'];
		$list_ctgh[$dem]['tensp'] = $re_cthd['tensp'];
		$list_ctgh[$dem]['mausac'] = $re_cthd['mausac'];
		$list_ctgh[$dem]['ngaysx'] = $re_cthd['ngaysx'];
		$list_ctgh[$dem]['hsd'] = $re_cthd['hansudung'];
		$list_ctgh[$dem]['soluong'] = $re_cthd['soluong'];
		$list_ctgh[$dem]['giaban'] = $re_cthd['giaban'];
		$list_ctgh[$dem]['makm'] = $re_cthd['makm'];
		$list_ctgh[$dem]['chietkhau'] = $re_cthd['chietkhau'];
		$list_ctgh[$dem]['tiengiamgia'] = $re_cthd['tiengiamgia'];
		$dem++;	
		$arr[] = "'".$re_cthd['mahd']."'";
	}
	//echo "<pre>"; print_r($list_ctgh); echo "</pre>";
	$string = implode(',', $arr);
	$voucher = mysql_query("select mahd, hd.maphieu, giatri from pmh_hd hd, phieumuahang pmh where hd.maphieu = pmh.maphieu");
	$list_voucher = array();
	$dem = 0;
	while($re_voucher = mysql_fetch_assoc($voucher))
	{
		$list_voucher[$dem]['mahd'] = $re_voucher['mahd'];
		$list_voucher[$dem]['maphieu'] = $re_voucher['maphieu'];
		$list_voucher[$dem]['giatri'] = $re_voucher['giatri'];
		$dem++;
	}

?>

<div style=" width: 100%; ">
<form>
	<input type='submit' class='sub' value="Tạo hóa đơn" style="float: right;"/>
    <input type='hidden' name='quanly' value="hoadon"/>
    <input type='hidden' name='ac' value="taohd"/>
</form>
</div>
<div class="clear"></div>

<div id='km-left'>

	<form>
	<div>
    	<p style="background: #088A68; border-radius: 3px; font-size: 16px; color: white; font-weight: bold; padding: 5px 5px;">Tìm kiếm</p>
        <br />
        <input type='text' id='keyword' value='<?php echo $keyword ?>' class="txt-sp"  placeholder='Nhập mã hóa đơn...'/>
        <input type='button' id='search-sub' class="sub" value="Tìm"/>
    </div>
	</form>

	<form>
	<div>
    	<p style="background: #088A68; border-radius: 3px; font-size: 16px; color: white; font-weight: bold; padding: 5px 5px;">Lọc theo</p>
        <br />
        Ngày bắt đầu: <input id='ngaybd' value="<?php echo $ngaybd ?>" type='date' class="txt-sp"/><br />
        Ngày kết thúc: <input id='ngaykt' value="<?php echo $ngaykt ?>" type='date' class="txt-sp"/>
        <input type='button' id='loc' value="Lọc" class="sub" />
    </div>
	</form>
</div>


<div id = 'hoadon'>


	<p class='title'>DANH SÁCH HÓA ĐƠN ĐÃ XUẤT</p><br />

	<table width="100%" class="tb-lietke" >
    
    	<tr>
            <th width="6%">Mã HĐ</th>
            <th width="9%">Ngày đặt</th>
            <th width="12%">Tên KH</th>
            <th width="18%">Địa chỉ giao hàng</th>
            <th width="8%">SĐT</th>
            <th width="7%">Tổng tiền</th>
            <th width="8%">Trạng thái</th>
            <!--<th width="8%">Xem chi tiết</th>-->
            <th width="5%">Hủy</th>
        </tr>
        
<?php
	while($re_hd = mysql_fetch_assoc($hoadon))
	{
		$item = array();
?>
		<tr data-id=<?php echo $re_hd['mahd'] ?>>
            <td><?php echo $re_hd['mahd'] ?></td>
            <td><?php echo date('d-m-Y', strtotime($re_hd['ngayxuat'])) ?></td>
            <td><?php echo $re_hd['hotennguoinhan'] ?></td>
            <td><?php echo $re_hd['diachi'] ?></td>
            <td><?php echo $re_hd['sdt'] ?></td>
            <td>
            	
        <?php
			$thanhtien = $tongtien = 0;
			
			for($i=0; $i<count($list_ctgh); $i++)
			{
				$giamgia = 0; $tien = 0;
				if($list_ctgh[$i]['mahd'] == $re_hd['mahd'])
				{
					$k = count($item);
					$item[$k]['mahd'] = $list_ctgh[$i]['mahd'];
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
					//echo $re_hd['mahd']." - ".$list_ctgh[$i]['mactsp']." - ".$tien."</br>";
				}
				
			}
			
			$giam_hd =  $check_km = 0;
			if($re_hd['chietkhau'] != "0")
			{
				if($re_hd['giatridonhang'] != 0)
				{
					$tongtien = $thanhtien >= $re_hd['giatridonhang'] ? ($thanhtien - ($thanhtien * ($re_hd['chietkhau']/100))) : $thanhtien;
					$giam_hd =  $thanhtien >= $re_hd['giatridonhang'] ? ($thanhtien * ($re_hd['chietkhau']/100)) : 0;
				}
				else
				{
					$tongtien = $thanhtien - ($thanhtien * ($re_hd['chietkhau']/100));
					$giam_hd = $thanhtien * ($re_hd['chietkhau']/100);
				}
				$check_km = 1;
				
			}
			else if($re_hd['tiengiamgia'] != "0")
			{
				if($re_hd['giatridonhang'] != 0)
				{
					$tongtien = $thanhtien >= $re_hd['giatridonhang'] ? ($thanhtien - $re_hd['tiengiamgia']) : $thanhtien;
					$giam_hd = 	$thanhtien >= $re_hd['giatridonhang'] ?  $re_hd['tiengiamgia'] : 0;
				}
				else
				{
					$tongtien = $thanhtien - $re_hd['tiengiamgia'];
					$giam_hd = 	$re_hd['tiengiamgia'] ;
				}
				$check_km = 2;
			}
			else
			{
				$tongtien = $thanhtien;	
			}
			//echo $tongtien."<br/>";
			$tien_voucher = 0;
			for($j = 0; $j<count($list_voucher); $j++)
			{
				if($re_hd['mahd'] == $list_voucher[$j]['mahd'])
				{
					$tongtien -= $list_voucher[$j]['giatri'];	
					$tien_voucher += $list_voucher[$j]['giatri'];	
				}
			}
			
			//công thêm phí vc, thuế, chiết khấu
			$thue = ( $re_hd['thue'] / 100) * $tongtien;
			$chietkhau = ($re_hd['chietkhau']/100) * $tongtien;
			$tongtien += $thue + $re_hd['phivanchuyen'] - $chietkhau;
			echo number_format($tongtien)." đ";
		?>        
            	
            </td>
            <td><?php echo $re_hd['trangthai'] == 0 ? "Đã hủy" : "Đã xuất" ?></td>
            <!--<td><a href='#'>Xem</a></td>-->
            <td><a href='#'>Hủy</a></td>
        </tr>
        
        <div  class='ctsp<?php echo $re_hd['mahd'] ?>' style="background: #EFFBF2; display: none; width: 1090%;   padding: 10px; ">
                
                <div style="width: 100%; height: 30px; line-height: 30px;">
                	<div class='ctsp-item' 	style='font-weight: bold; width: 25%' >Tên SP</div>
                	<div class='ctsp-item' 	style="font-weight: bold;" >Màu sắc</div>
                    <div class='ctsp-item'  style="font-weight: bold; text-align: left;" >Ngày SX</div>
                    <div class='ctsp-item'  style="font-weight: bold; text-align: left;" >Hạn SD</div>
                    <div class='ctsp-item'  style="font-weight: bold;text-align: center; width: 5%" >SL</div>
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
                    <div class='ctsp-item' style=" width: 5%"><?php echo $item[$key]['soluong'] ?></div>
                    <div class='ctsp-item'><?php echo number_format($item[$key]['giaban']) ?> đ</div>
                    <div class='ctsp-item'><?php echo $item[$key]['giamgia'] ?></div>
                </div>
                <div class="clear"></div>
                <?php
					}
					echo number_format($giam_hd) > 0 ? ("<div style='border-top: solid 1px #ccc; width: 100%; height: 30px; line-height: 30px; text-align: right'><span class='bold'>Giảm KM:</span> ".number_format($giam_hd)." đ</div>") : "";
					echo number_format($tien_voucher) > 0 ? "<div style='border-top: solid 1px #ccc;width: 100%; height: 30px; line-height: 30px; text-align: right'><span class='bold'>Phiếu mua hàng:</span> ".number_format($tien_voucher)." đ"."</div>" : "";
				?>
                 <div style='border-top: solid 1px #ccc; width: 100%; height: 30px; line-height: 30px; text-align: right'><span class='bold'>Chiết khấu: </span>
				 <?php
				 	if($re_hd['chietkhau'] ==  0)
						echo "0";
				 	else
						echo $re_hd['chietkhau']."% (-".number_format($chietkhau)." đ)";
				?>
                </div>
                <div style='border-top: solid 1px #ccc; width: 100%; height: 30px; line-height: 30px; text-align: right'><span class='bold'>VAT:</span> <?php echo $re_hd['thue'] ?> % ( <?php echo number_format($thue) ?> đ)</div>
                <div style='border-top: solid 1px #ccc; width: 100%; height: 30px; line-height: 30px; text-align: right'><span class='bold'>Phí vận chuyển:</span> <?php echo number_format($re_hd['phivanchuyen']) ?> đ</div>
                <div class="clear"></div>
        </div> <!-- end ctsp -->    	
<?php
	}
?>
    
    	</table>
	</div>
