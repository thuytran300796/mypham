

<script>

	$(document).ready(function(e) {
        $('#loaixem').change(function()
		{
			if($('#loaixem').val() == 'danhmuc')
				data = "ac=get_dm";
			else
				data = "ac=get_ncc";
			$.ajax
			({
				url: "module/sanpham/xuly/xuly_timkiem.php",
				type: "post",
				data: data,
				async: true,
				success:function(kq)
				{
					//alert(kq);
					$('#danhmuc').html(kq);	
				}
			});
		});
    });

</script>

<?php
	
	date_default_timezone_set('Asia/Ho_Chi_Minh');
	$ngaybd = $ngaykt = $date = date('Y-m-d');
	
	
	$sql = "";
	$loaixem = "danhmuc";
	$danhmuc = "all";
	
	
	
	if(isset($_POST['xem']))
	{
		$ngaybd = $_POST['ngaybd']; $ngaykt = $_POST['ngaykt'];
		$danhmuc =  $_POST['danhmuc'];
		$loaixem = $_POST['loaixem'];
		
		$sql = $loaixem == 'ncc' ? ($danhmuc != 'all' ? " and SP.MaNCC = '".$danhmuc."' " : "") : ($danhmuc != 'all' ? " and MaDM = '".$danhmuc."' " : "");
	}	
	
	if($loaixem == 'danhmuc')
	{
		$sql_dm_ncc = "select madm, tendm from danhmuc"	;
		//$sql_dm_ncc .= $danhmuc != 'all' ? " where madm = '$danhmuc'" : "";
	}
	else
	{
		$sql_dm_ncc = "select mancc as 'madm', tenncc as 'tendm' from nhacungcap" ;
		//$sql_dm_ncc .= $danhmuc != 'all' ? " where mancc = '$danhmuc'" : "";	
	}

	
	mysql_query("set names 'utf8'");
	$list_dm_ncc = mysql_query($sql_dm_ncc);
	
	mysql_query("set names 'utf8'");
	$sanpham = mysql_query("select	ctsp.mactsp, tensp, mausac, ctsp.ngaysx, ctsp.hansudung, ctsp.soluong, tenncc
							from	sanpham sp, chitietsanpham ctsp, nhacungcap ncc
							where	sp.masp = ctsp.masp and ncc.mancc = sp.mancc
							and	sp.trangthai = 1 and ctsp.trangthai = 1.".$sql."
							");
	$hoadon = mysql_query("select	cthd.mactsp, sum(cthd.soluong) 'slxuat'
							from	chitiethoadon cthd, hoadon hd
							where	cthd.mahd = hd.mahd and hd.trangthai = 1 and (date(hd.ngayxuat) >= '$ngaybd' and date(hd.ngayxuat) <= '$ngaykt')
							group by cthd.mactsp
							");
	$nhapkho = 	mysql_query("select	ctpn.mactsp, sum(ctpn.soluong) 'slnhap'
							from	chitietphieunhap ctpn, phieunhap pn
							where	ctpn.maphieu = pn.maphieu and (date(pn.ngaynhap) >= '$ngaybd' and date(pn.ngaynhap) <= '$ngaykt')
							group by ctpn.mactsp
							");
	/*$tongnhap = mysql_query("select	ctpn.mactsp, sum(ctpn.soluong) 'slnhap', date(pn.ngaynhap) 'ngaynhap'
							from	chitietphieunhap ctpn, phieunhap pn
							where	ctpn.maphieu = pn.maphieu
							group by ctpn.mactsp, pn.maphieu
                            order by ctpn.mactsp, pn.ngaynhap desc
							");
	*/
	$tongnhap = mysql_query("select	ctpn.mactsp, sum(ctpn.soluong) 'slnhap'
							from	chitietphieunhap ctpn, phieunhap pn
							where	ctpn.maphieu = pn.maphieu and date(ngaynhap) <= '$ngaykt'
							group by ctpn.mactsp                            
							");
	$tonghd = mysql_query("	select	cthd.mactsp, sum(cthd.soluong) 'slxuat'
							from	chitiethoadon cthd, hoadon hd
							where	cthd.mahd = hd.mahd and date(ngayxuat) <= '$ngaykt' and hd.trangthai = 1
							group by cthd.mactsp   ");
	$list_nk = array();
	while($re_pn = mysql_fetch_assoc($nhapkho))
	{
		$list_nk[$re_pn['mactsp']] = $re_pn['slnhap'];
	}
	$list_hd = array();
	while($re_hd = mysql_fetch_assoc($hoadon))
	{
		$list_hd[$re_hd['mactsp']] = $re_hd['slxuat'];
	}
	
	$list_tongnhap = array();
	$dem = 0;
	while($re_tn = mysql_fetch_assoc($tongnhap))
	{
		//$list_tongnhap[$dem]['mactsp'] = $re_tn['mactsp'];
		//$list_tongnhap[$dem]['ngaynhap'] = $re_tn['ngaynhap'];
		$list_tongnhap[$re_tn['mactsp']] = $re_tn['slnhap'];
		//$dem++;
	}
	
	$list_tongxuat = array();
	//$dem = 0;
	while($re_tx = mysql_fetch_assoc($tonghd))
	{
		//$list_tongnhap[$dem]['ngaynhap'] = $re_tn['ngaynhap'];
		$list_tongxuat[$re_tx['mactsp']] = $re_tx['slxuat'];
		//$dem++;
	}
?>


<div style='width: 78%; float: right;'><p class='title'>THỐNG KÊ XUẤT NHẬP TỒN</p></div>
<div class="clear"></div>
<BR />


<div id='sp-left' style="width: 20%">
	<form method="post">
    
        <div>
           <table width="100%">
           		<tr>
                	<td style="padding: 10px">Từ: </td>
                    <td align="right"><input type='date' class="txt-sp date" name='ngaybd' value='<?php echo $ngaybd ?>'/></td>
                </tr>
                <tr>
                	<td style="padding: 10px">đến: </td>
                    <td align="right"><input type='date' class="txt-sp date" name='ngaykt' value='<?php echo $ngaykt ?>'/></td>
                </tr>
           </table>
            
            <select name='loaixem' id='loaixem' class="cbb-sp" style="width: 235px">
            <?php
				if($loaixem == "danhmuc")
				{
					echo "<option value='danhmuc' selected='selected'>Xem theo danh mục</option>";
					echo "<option value='ncc'>Xem theo nhà cung cấp</option>";
				}
				else
				{
					echo "<option value='ncc' selected='selected'>Xem theo nhà cung cấp</option>";
					echo "<option value='danhmuc' >Xem theo danh mục</option>";
				}
			?>
                
                
            </select>
            
            <select name='danhmuc' id='danhmuc' class="cbb-sp" style="width: 235px">
                
            <?php
                echo "<option value='all'>Tất cả</option>";	
                while($re_dm = mysql_fetch_assoc($list_dm_ncc))
                {
					if($danhmuc == $re_dm['madm'])
                    	echo "<option selected='selected' value='".$re_dm['madm']."'>".$re_dm['tendm']."</option>";	
					else
						echo "<option value='".$re_dm['madm']."'>".$re_dm['tendm']."</option>";	
                }
            ?>
            </select>
            <input type='submit' id = 'search-sp' name='xem' value='Xem' class="sub"  style="width: 235px"/>
        </div>
	</form>
</div>

<div id='tksp-right'>
<table class="tb-lietke" width="100%" border="1">
	
    <tr>
    	<th width="15%">Mã SP</th>
        <th width="18%">Tên SP</th>
        <th width="12%">Nhà cung cấp</th>
        <th width="10%">Màu sắc</th>
        <th width="10%">Ngày SX</th>
        <th width="10%">Hạn SD</th>
        <th width="5%">Nhập</th>
        <th width="5%">Xuất</th>
        <th width="5%">Tồn</th>
    </tr>
    
<?php
	while($re_sp = mysql_fetch_assoc($sanpham))
	{
		$slnhap = $slxuat = $slton = 0;
		if(array_key_exists($re_sp['mactsp'], $list_nk))
			$slnhap = $list_nk[$re_sp['mactsp']];
		if(array_key_exists($re_sp['mactsp'], $list_hd))
			$slxuat = $list_hd[$re_sp['mactsp']];
			
		//nếu nó có bán ra đc cái nào thì
		if(array_key_exists($re_sp['mactsp'], $list_tongxuat) )
			$slton = $list_tongnhap[$re_sp['mactsp']] - $list_tongxuat[$re_sp['mactsp']];
		else
			$slton = $list_tongnhap[$re_sp['mactsp']] - $slxuat;
			
			
?>
    <tr>
    	<td width="15%" style="text-align:left"><?php echo $re_sp['mactsp'] ?></td>
        <td width="18%" style="text-align:left"><?php echo $re_sp['tensp'] ?></td>
        <td width="12%"><?php echo $re_sp['tenncc'] ?></td>
        <td width="10%"><?php echo $re_sp['mausac'] ?></td>
        <td width="10%"><?php echo date('d-m-Y', strtotime($re_sp['ngaysx'])) ?></td>
        <td width="10%"><?php echo date('d-m-Y', strtotime($re_sp['hansudung'])) ?></td>
        <td width="5%"><?php echo $slnhap ?></td>
        <td width="5%"><?php echo $slxuat ?></td>
        <td width="5%"><?php echo $slton ?></td>
    </tr>
<?php
	}
?>
</table>
</div>

<?php


?>