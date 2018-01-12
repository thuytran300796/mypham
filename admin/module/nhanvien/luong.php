<script>

	$(document).ready(function(e) {
        
		$('#ngaybd, #ngaykt').change(function()
		{
			ngaybd = $('#ngaybd').val();
			ngaykt = $('#ngaykt').val();
			keyword = $('#keyword').val();
			$.ajax
			({
				url: "module/nhanvien/xuly/xuly.php",
				type: "post",
				data: "ac=xemluong&ngaybd="+ngaybd+"&ngaykt="+ngaykt+"&keyword="+keyword,
				async: true,
				success:function(kq)
				{
					$('#luong .tb-lietke').html(kq);	
				}
			});
		});
		$('#keyword').keyup(function()
		{
			ngaybd = $('#ngaybd').val();
			ngaykt = $('#ngaykt').val();
			keyword = $('#keyword').val();
			$.ajax
			({
				url: "module/nhanvien/xuly/xuly.php",
				type: "post",
				data: "ac=xemluong&ngaybd="+ngaybd+"&ngaykt="+ngaykt+"&keyword="+keyword,
				async: true,
				success:function(kq)
				{
					$('#luong .tb-lietke').html(kq);	
				}
			});
		});
		
    });

</script>

<style type='text/css' media="print">
	#category, #in, .top, #keyword, .bottom
	{
		display: none;
	}
	
	#tb-in
	{
		width: 595px; height: 842px;
		font-size: 13pt;	
	}
	
</style>

<?php

	date_default_timezone_set('Asia/Ho_Chi_Minh');
	$ngaybd = $ngaykt = $date = date('Y-m-d');

	mysql_query("set names 'utf8'");
	$luong = mysql_query("	select	ngay, nv.manv, tennv, hesoluong, phucap, songaycong, thuong, phat, luongcoban
							from	nhanvien nv, chucvu cv, chitietluong ctl
							where	nv.manv = ctl.manv and ctl.macv = cv.macv order by ngay desc");
?>


<div style='width: 100%; float: right;'><p class='title'>BẢNG LƯƠNG</p></div>
<div class="clear"></div>

<div id='luong'>
<BR />

	<div style="width: 100%">
    	<form method="post">
   
            Từ: <input type='date' class="txt-sp date" style="width: 100px;" id='ngaybd' name='ngaybd' value='<?php echo $ngaybd ?>'/>
            đến: <input type='date' class="txt-sp date" style="width: 100px;" id='ngaykt' name='ngaykt' value='<?php echo $ngaykt ?>'/><span style="font-size: 13px"> (mm/dd/YYYY)</span>
			<input type='text' class="txt-sp" style="width: 300px;" value = '' id='keyword' name='keyword' placeholder="Nhập tên hoặc mã nhân viên cần xem.."/>
		</form>
        <!--
        <form method="get">
        	<input type='submit' class='sub' value='Thêm mới' style="float: right"/>
            <input type='hidden' name='quanly' value='nhanvien'/>
            <input type='hidden' name='ac' value='tinhluong'/>
        </form>
        -->
        <br />
    </div>
	
    <br />
	
    <div id='tb-in'>
	<table class="tb-lietke" width="100%" border="1">
    	<tr>
        	<th width='8%'>Ngày</th>
            <th width='8%'>Mã NV</th>
            <th width='15%'>Tên NV</th>
            <th width='8%'>HS lương</th>
            <th width='10%'>Phụ cấp</th>
            <th width='10%'>Lương CB</th>
            <th width='8%'>Số ngày công</th>
            <th width='10%'>Thưởng</th>
            <th width='10%'>Phạt</th>
            <th width='10%'>Tổng</th>
        </tr>
    <?php
		while($re_luong = mysql_fetch_assoc($luong))
		{
			$tong = ($re_luong['songaycong'] * $re_luong['luongcoban']) * $re_luong['hesoluong'] + $re_luong['thuong'] - $re_luong['phat'] + $re_luong['phucap'];
	?>		
		<tr>
        	<td><?php echo date('d-m-Y', strtotime($re_luong['ngay'])) ?></td>
            <td><?php echo $re_luong['manv'] ?></td>
            <td><?php echo $re_luong['tennv'] ?></td>
            <td><?php echo $re_luong['hesoluong'] ?></td>
            <td><?php echo number_format($re_luong['phucap']) ?></td>
            <td><?php echo number_format($re_luong['luongcoban']) ?></td>
            <td><?php echo $re_luong['songaycong'] ?></td>
            <td><?php echo number_format($re_luong['thuong']) ?></td>
            <td><?php echo number_format($re_luong['phat']) ?></td>
            <td><?php echo number_format($tong) ?></td>
        </tr>
        
    <?php	
		}
	?>

    </table>
    
    </div>
    <br /><br />
    <input type='button' id='in' value='In' style="width: 100px; float: right" class="sub" onclick="window.print()"/>

</div>