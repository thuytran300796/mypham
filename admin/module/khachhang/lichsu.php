<?php

	$id = isset($_GET['id']) ? $_GET['id'] : NULL;

	mysql_query("set names 'utf8'");
	$hoadon = mysql_query("
								select		hd.mahd, hd.makh, ngayxuat, hotennguoinhan, sdt, diachi, phivanchuyen, hd.chietkhau as 'ckhd', thue, hd.trangthai, km.makm, km.chietkhau, km.tiengiamgia, km.giatridonhang
								from		hoadon hd, khuyenmai km
								where		hd.makm = km.makm and hd.trangthai = 1 and hd.makh = '$id' group by hd.mahd
							");
	
	mysql_query("set names 'utf8'");
	$cthd = mysql_query("select t1.mahd, t1.mactsp, t1.tensp, t1.thue, t1.quatang, t1.mausac, t1.ngaysx, t1.hansudung, t1.soluong, t1.giaban, t2.makm, t2.chietkhau, t2.tiengiamgia
						from
						(	select	cthd.mahd, cthd.mactsp, tensp, ctsp.mausac, ctsp.ngaysx, ctsp.hansudung, cthd.soluong, ctsp.giaban, sp.thue, quatang, cthd.makm
							from	chitiethoadon cthd, chitietsanpham ctsp, hoadon hd, sanpham sp
							where	cthd.mactsp = ctsp.mactsp and hd.mahd = cthd.mahd and sp.masp = ctsp.masp  and hd.makh = '$id'
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
		$list_ctgh[$dem]['quatang'] = $re_cthd['quatang'];
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

<script>

	$(document).ready(function(e) {
        //$('#hoadon .tb-lietke').delegate('tr', 'click', function()
		$('#hoadon .lietke-sp').delegate('.lietke-sp-tr', 'click', function()
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
					$('#hoadon .lietke-sp').html(kq);	
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
					$('#hoadon .lietke-sp').html(kq);	
				}	
			});
		});
		
		$('#hoadon .lietke-sp').delegate('.huy', 'click', function()
		{
				
			if(confirm("Bạn có chắc chắn muốn hủy?"))
			{
				id = $(this).attr('data-id'); $('.ctsp'+id).hide(); 
				price = $(this).attr('data-price');
				makh = $(this).attr('data-makh');
				$.ajax
				({
					url: "module/hoadon/xuly/giohang_xuly.php",
					data:"ac=huyhd&id="+id+"&price="+price+"&makh="+makh,
					type: "post",
					async: true,
					success:function(kq)
					{
						$("a[data-id='"+id+"']").closest('.lietke-sp-tr').hide();	
					}
				});		
				return false;
			}
		});
    });

</script>

<div id='hoadon' style="width: 100%">
	<p class='title'>DANH SÁCH HÓA ĐƠN ĐÃ ĐƯỢC MUA</p><br />
    
    <div class='lietke-sp'>
    
    	<div class = 'lietke-sp-th'>
        	<div style='width: 8%'>Mã HĐ</div>
            <div style='width: 11%'>Ngày xuất</div>
            <div style='width:17%'>Tên KH</div>
            <div style='width:25%'>Địa chỉ giao hàng</div>
            <div style='width:10%'>SĐT</div>
            <div style='width:11%'>Tổng tiền</div>
            <div style='width:8%'>Trạng thái</div>
            <div style='width:5%'>Hủy</div>
        </div>
        <div class="clear"></div>


        
<?php
	while($re_hd = mysql_fetch_assoc($hoadon))
	{
		$item = array();
?>
		<div class= 'lietke-sp-tr' data-id='<?php echo $re_hd['mahd'] ?>'>
        	<div class='lietke-sp-td' style='width: 7.5%;  text-align: left;'><?php echo $re_hd['mahd'] ?></div>
            <div class='lietke-sp-td' style='width: 10%; text-align: left;'><?php echo date('d-m-Y', strtotime($re_hd['ngayxuat'])) ?></div>
            <div class='lietke-sp-td' style='width: 17%; text-align: left;'><?php echo $re_hd['hotennguoinhan'] ?></div>
            <div class='lietke-sp-td' style='width: 24%; text-align: left;' ><?php echo $re_hd['diachi'] ?></div>
            <div class='lietke-sp-td' style='width: 9%; text-align: center;'><?php echo $re_hd['sdt'] ?></div>
		
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
					$item[$k]['quatang'] = $list_ctgh[$i]['quatang'];
					$item[$k]['giamgia'] = 0;
					if($list_ctgh[$i]['quatang'] != 1)
					{
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
					}
				}
				
			}
			//echo "thành tiền: ".$thanhtien;
			$giam_hd =  $check_km = 0;
			if($re_hd['chietkhau'] != "0")
			{
				if($re_hd['giatridonhang'] != 0)
				{
					$tongtien = $thanhtien >= $re_hd['giatridonhang'] ? ($thanhtien - ($thanhtien * ($re_hd['chietkhau']/100))) : $thanhtien;
					$giam_hd =  $thanhtien >= $re_hd['giatridonhang'] ? ($thanhtien * ($re_hd['chietkhau']/100)) : 0; //echo "Giảm: ".$giam_hd;
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
			//$thue = ( $re_hd['thue'] / 100) * $tongtien;
			//$chietkhau = ($re_hd['chietkhau']/100) * $tongtien;
			//$tongtien -=   $chietkhau; //chietkhau là tiền giảm giá hóa đơn của km
			//$ckhd = $tongtien*($re_hd['ckhd']/100);
			$ckhd = $re_hd['ckhd'];  
			$tongtien = $tongtien - $ckhd + $re_hd['phivanchuyen']; 
			//echo number_format($tongtien)." đ";
		?>        
            	
            <div class='lietke-sp-td' style='width: 11%; text-align: right;'><?php echo number_format($tongtien) ?> đ</div>
            <div class='lietke-sp-td' style='width: 8%; text-align: center;'><?php echo $re_hd['trangthai'] == 1 ? "Đã xuất" : "Đã hủy"?></div>
            <div class='lietke-sp-td' style='width: 4%; text-align: left;'><a  href='javascript:void(0)' class='huy' data-makh='<?php echo $re_hd['makh']  ?>' data-price='<?php echo $tongtien ?>' data-id='<?php echo $re_hd['mahd'] ?>'>Hủy</a></div>
            <div class="clear"></div>
        </div>
        
        <div  class='ctsp<?php echo $re_hd['mahd'] ?>' style="background: #EFFBF2; display: none; width: 98%;   padding: 10px; ">
                
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
                	<div class='ctsp-item' style="text-align: left; width: 25%"><?php echo $item[$key]['quatang'] == 0 ? $item[$key]['tensp'] : ($item[$key]['tensp']. " (Quà tặng)")?></div>
                	<div class='ctsp-item'><?php echo $item[$key]['mausac']==""?"Không":$item[$key]['mausac'] ?></div>
                    <div class='ctsp-item' style="text-align: left;"><?php echo date('d/m/Y', strtotime($item[$key]['ngaysx'])) ?></div>
                    <div class='ctsp-item' style="text-align: left;"><?php echo date('d/m/Y', strtotime($item[$key]['hsd'])) ?></div>
                    <div class='ctsp-item' style=" width: 5%"><?php echo $item[$key]['soluong'] ?></div>
                    <div class='ctsp-item'><?php echo $item[$key]['quatang'] == 0 ? number_format($item[$key]['giaban']) : 0 ?> đ</div>
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
				 	if($re_hd['ckhd'] ==  0)
						echo "0";
				 	else
					{
						//echo $re_hd['ckhd']."% (-".number_format( $tongtien*($re_hd['ckhd']/100))." đ)";
						echo number_format($re_hd['ckhd'])." đ";
					}
				?>
                </div>
                <div style='border-top: solid 1px #ccc; width: 100%; height: 30px; line-height: 30px; text-align: right'><span class='bold'>VAT:</span> <?php echo number_format($re_hd['thue']) ?> đ</div>
                <div style='border-top: solid 1px #ccc; width: 100%; height: 30px; line-height: 30px; text-align: right'><span class='bold'>Phí vận chuyển:</span> <?php echo number_format($re_hd['phivanchuyen']) ?> đ</div>
                <div class="clear"></div>
        </div> <!-- end ctsp -->    	
<?php
	}
?>
    
    	</div>
	</div>
