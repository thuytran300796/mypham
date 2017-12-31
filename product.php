<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
	<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
    	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <script src="js/jquery-1.12.4.js"></script>
        <link type="text/css" rel='stylesheet' href="style.css"/>
    	<title>Sản phẩm</title>

<?php
	session_start();
	$url="product.php";
	include_once('module/header.php');
	include_once('config/config.php');
	
	date_default_timezone_set('Asia/Ho_Chi_Minh');
	$date = date('Y-m-d');
	
	$display = 12; //số sản phẩm trên 1 trang
	if(!isset($_GET['page']))
	{
		$current_page = 1;	
	}
	else
	{
		$current_page = $_GET['page'];	
	}
	$position = ($current_page - 1) * $display;
	
	$title = NULL; $sql= $madm = $type = $keyword = "";
	$sql = NULL;
	$list_sp = array();
	//$type = 'bt';
	
	if(isset($_GET['madm']))
	{
		$madm = $_GET['madm'];
		mysql_query("SET NAMES 'utf8'");
		$dm = mysql_query("select tendm, mota from danhmuc where madm = '$madm'");
		$re_dm = mysql_fetch_assoc($dm);
		$title = $re_dm['tendm'];
		
		$trang = mysql_query("	select	count(*) as 'sosp'
								from	sanpham sp, chitietsanpham ctsp
								where	sp.masp = ctsp.masp and sp.trangthai = 1 and ctsp.trangthai = 1 and sp.madm = '$madm'");
		
		$sql = "SELECT t1.masp, t1.mactsp, t1.tensp, t1.duongdan, t1.giaban, t1.thuonghieu, t1.mausac, t2.makm, t2.chietkhau, t2.tiengiamgia
				FROM
				(	select	sp.masp, ctsp.mactsp, tensp, duongdan, ctsp.giaban, thuonghieu, ctsp.mausac
					from	sanpham sp, chitietsanpham ctsp, hinhanh ha
					where 	ctsp.trangthai = 1 and sp.trangthai = 1  and sp.masp = ctsp.masp and sp.masp = ha.masp and sp.madm = '$madm'
					group by ctsp.mactsp 
					limit $position, $display
				)t1 left join
				(
					SELECT	km.makm, km.chietkhau, km.tiengiamgia, km.masp
					FROM	khuyenmai km, ctsp_km ctkm
					where	km.makm = ctkm.MaKM and km.trangthai = 1 and ('$date' >= ctkm.NgayBD and '$date' <= ctkm.NgayKT) and km.masp <> ''
					group by km.makm
					)t2 on t1.masp = t2.masp";
		
		//if(isset($_GET['price']))
			//$sql.="limit 0,12";
	}
	else if(isset($_GET['type']))
	{
		$type = $_GET['type'];
		mysql_query("SET NAMES 'utf8'");
		$title = "";
		/*$sql = "SELECT	sp.masp, tensp, sp.giaban, sp.giadexuat, thuonghieu, sp.makm, sum(cthd.SoLuong)
				from	sanpham sp, chitietsanpham ctsp, chitiethoadon cthd
				WHERE	sp.masp = ctsp.masp
					AND	ctsp.MaCTSP = cthd.MaCTSP
					and sp.trangthai = 1
				group by	sp.masp
				order by sum(cthd.SoLuong) desc
				limit 0,12";
		*/
		
		if($type ==  'banchay')
		{
			$trang = mysql_query("	select	count(*) as 'sosp'
									from	sanpham sp, chitietsanpham ctsp, chitiethoadon cthd
									where	sp.masp = ctsp.masp and cthd.mactsp = ctsp.mactsp and sp.trangthai = 1 and ctsp.trangthai = 1
									group by cthd.MaCTSP");
			
			$sql = "SELECT t1.masp, t1.mactsp, t1.tensp, t1.mausac, t1.soluong , t1.duongdan, t1.giaban, t1.thuonghieu,  t2.makm, t2.chietkhau, t2.tiengiamgia
					FROM
					(	select	sp.masp, ctsp.mactsp, tensp,sum(cthd.SoLuong) 'soluong', duongdan, ctsp.giaban, thuonghieu, ctsp.mausac
						from	sanpham sp, chitietsanpham ctsp, hinhanh ha, chitiethoadon cthd
						where 	ctsp.trangthai = 1 and sp.trangthai = 1  and sp.masp = ctsp.masp and sp.masp = ha.masp and cthd.MaCTSP = ctsp.MaCTSP
						group by cthd.MaCTSP
						order by sum(cthd.soluong) desc
						limit $position, $display
					)t1 left join
					(
						SELECT	km.makm, km.chietkhau, km.tiengiamgia, km.masp
						FROM	khuyenmai km, ctsp_km ctkm
						where	km.makm = ctkm.MaKM and km.trangthai = 1 and ('$date' >= ctkm.NgayBD and '$date' <= ctkm.NgayKT) and km.masp <> ''
						group by km.makm
					)t2 on t1.masp = t2.masp";
			$title = "HÀNG BÁN CHẠY";
		}
		else if($type == 'hangmoi')
		{
			$trang = mysql_query("	select	count(*) as 'sosp'
								from	sanpham sp, chitietsanpham ctsp
								where	sp.masp = ctsp.masp and sp.trangthai = 1 and ctsp.trangthai = 1");
			
			$sql = "SELECT t1.masp, t1.mactsp, t1.tensp, t1.duongdan, t1.giaban, t1.thuonghieu, t1.mausac, t2.makm, t2.chietkhau, t2.tiengiamgia
					FROM
					(	select	sp.masp, ctsp.mactsp, tensp, duongdan, ctsp.giaban, thuonghieu, ctsp.mausac
						from	sanpham sp, chitietsanpham ctsp, hinhanh ha
						where 	ctsp.trangthai = 1 and sp.trangthai = 1  and sp.masp = ctsp.masp and sp.masp = ha.masp
						group by ctsp.mactsp
						order by ngaynhap desc
						limit $position, $display
					)t1 left join
					(
						SELECT	km.makm, km.chietkhau, km.tiengiamgia, km.masp
						FROM	khuyenmai km, ctsp_km ctkm
						where	km.makm = ctkm.MaKM and km.trangthai = 1 and ('$date' >= ctkm.NgayBD and '$date' <= ctkm.NgayKT) and km.masp <> ''
						group by km.makm
					)t2 on t1.masp = t2.masp";
			$title = "HÀNG MỚI VỀ";
		}
		else if($type == 'khuyenmai')
		{
			$trang = mysql_query("	select	count(*) as 'sosp'
								from	sanpham sp, chitietsanpham ctsp, khuyenmai km
								where	sp.masp = ctsp.masp and km.masp = sp.masp and sp.trangthai = 1 and ctsp.trangthai = 1 and km.trangthai = 1 and km.masp<> '' and ('$date' >= ctkm.NgayBD and '$date' <= ctkm.NgayKT)");
			
			$sql = "SELECT t1.masp, t1.mactsp, t1.tensp, t1.duongdan, t1.giaban, t1.thuonghieu, t1.mausac, t2.makm, t2.chietkhau, t2.tiengiamgia
					FROM
					(	select	sp.masp, ctsp.mactsp, tensp, duongdan, ctsp.giaban, thuonghieu, ctsp.mausac
						from	sanpham sp, chitietsanpham ctsp, hinhanh ha
						where 	ctsp.trangthai = 1 and sp.trangthai = 1  and sp.masp = ctsp.masp and sp.masp = ha.masp
						group by ctsp.mactsp
						limit $position, $display
					)t1,
					(
						SELECT	km.makm, km.chietkhau, km.tiengiamgia, km.masp
						FROM	khuyenmai km, ctsp_km ctkm
						where	km.makm = ctkm.MaKM and km.trangthai = 1 and ('$date' >= ctkm.NgayBD and '$date' <= ctkm.NgayKT) and km.masp <> ''
						group by km.makm
					)t2 where t1.masp = t2.masp";
			$title = "CÁC SẢN PHẨM ĐANG ÁP DỤNG KHUYẾN MÃI";
		}
	}
	else if(isset($_GET['keyword']))
	{
		$type = 'search';
		$keyword = $_GET['keyword'];
		mysql_query("set names 'utf8'");
		$trang = mysql_query("select	count(*) as 'sosp'
								from	sanpham sp, chitietsanpham ctsp
								where	sp.masp = ctsp.masp and sp.trangthai = 1 and ctsp.trangthai = 1 and tensp like '%$keyword%'");
		$sql = "SELECT t1.masp, t1.mactsp, t1.tensp, t1.duongdan, t1.giaban, t1.thuonghieu, t1.mausac, t2.makm, t2.chietkhau, t2.tiengiamgia
					FROM
					(	select	sp.masp, ctsp.mactsp, tensp, duongdan, ctsp.giaban, thuonghieu, ctsp.mausac
						from	sanpham sp, chitietsanpham ctsp, hinhanh ha
						where 	ctsp.trangthai = 1 and sp.trangthai = 1  and sp.masp = ctsp.masp and sp.masp = ha.masp and tensp LIKE '%$keyword%'
						group by ctsp.mactsp
						limit $position, $display
					)t1 left join
					(
						SELECT	km.makm, km.chietkhau, km.tiengiamgia, km.masp
						FROM	khuyenmai km, ctsp_km ctkm
						where	km.makm = ctkm.MaKM and km.trangthai = 1 and ('$date' >= ctkm.NgayBD and '$date' <= ctkm.NgayKT) and km.masp <> ''
						group by km.makm
					)t2 on t1.masp = t2.masp";
		
	}
	else
		$madm = "";	

	mysql_query("SET NAMES 'utf8'");
	$sp = mysql_query($sql);
	if(isset($_GET['keyword']))
	{
		$title = "CÓ ".mysql_num_rows($sp)." KẾT QUẢ TÌM KIẾM";
	}
	$re_trang = mysql_fetch_assoc($trang);
	$total_page = ceil($re_trang['sosp']/$display);
	//echo "so trang:".$total_page;
?>


<div id="pro-left">
	<span style="font-weight: bold">TRANG ĐIỂM</span>
    <ul>
    	<li>
        	<a href='#'>Trang điểm mắt</a>
            <ul>
            	<li>
                    <a href='#'>Phấn mắt</a>
                </li>
                <li>
                    <a href='#'>Kẻ mắt</a>
                    <ul>
                        <li>
                            <a href='#'>Dạng nước</a>
                        </li>
                        <li>
                            <a href='#'>Dạng gel</a>
                        </li>
                    </ul>
                </li>
                <li>
                    <a href='#'>Kẻ chân mày</a>
                </li>
            </ul>
        </li>
        <li>
        	<a href='#'>Trang điểm môi</a>
            <ul>
            	<li>
                    <a href='#'>Son kem</a>
                </li>
                <li>
                    <a href='#'>Son thỏi</a>
                </li>
                <li>
                    <a href='#'>Son tint</a>
                </li>
            </ul>
        </li>
        <li>
        	<a href='#'>Trang điểm mặt</a>
        </li>
    </ul>
</div>


<div id="pro-right">
	<div class="pro-orderby">
    	<span class="title" style='float: left; line-height: 40px;'><?php echo $title ?></span>
        <div style='float: right'>
            Sắp xếp theo:
            <select id='orderby'>
            	<option value=''>------</option>
                <option value='giam'>Giá giảm dần</option>
                <option value='tang'>Giá tăng dần</option>
                <option value='banchay'>Sản phẩm bán chạy nhất</option>
            </select>
         </div>
         <input type='hidden' id='madm' value='<?php echo $madm ?>'/>
         <input type='hidden' id='type' value='<?php echo $type ?>'/>
         <input type='hidden' id='keyword' value='<?php echo $keyword ?>'/>
         <input type='hidden' id='position' value='<?php echo $position ?>'/>
     </div>   
        <div class = 'list-item'>

		<?php
			while($record = mysql_fetch_assoc($sp))
			{
		?>
            	<a href = 'product-detail.php?id=<?php echo $record['mactsp'] ?>'>
                <div class = 'product-home'>
                	<img src="image/mypham/<?php echo $record['duongdan'] ?>"/>
                    <p>
                 <?php
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
				?>
                   	 	<span class = 'product-price-home'><?php echo number_format($giaban) ?> đ</span>
                    	<strike><?php echo $giamgia == 0 ?  "" :  number_format($record['giaban'])."đ" ?></strike>
                	</p>
                    <p class = 'text-highlight'><?php echo $record['thuonghieu'] ?></p>
                <?php
					echo $record['mausac'] != "" ? "<p class='product-mausac'>Màu: ".$record['mausac']."</p>" : "";
				?>
                <?php
                    if($check_qt == 1)
						echo "<p>Có quà tặng</p>";
				?>
                    <p class = 'product-name-home'><?php echo $record['tensp'] ?></p>
                 </div>
              </a>
        <?php
			}
		?>		
             	<div class="clear"></div>
             
        	</div>
        <div class="clear"></div>
    <!--</div>-->
    
    <div class='phantrang' style='width: 350px; height: 30px; margin:auto;'>
    	
        <?php
			if($current_page == 1)
			{
				$page_start = 1;
				$page_end = 5;	
			}
			else
			{
				if($current_page - 2 > 0)
				{
					$page_start = $current_page - 2;
					$page_end = $current_page + 2 > $total_page ? $total_page : $current_page + 2;
				}
				else
				{
					$page_start = 1;
					$page_end = 5;	
				}
			}
			
			$url = "product.php?";
				//if($madm != "") $url .= "madm=".$madm;
				//if($type != "") $url .= "madm=".$madm;
				$url .= $madm != "" ? "madm=".$madm : "";
				$url .= $type != "" || $type !='search' ? "type=".$type : "";
				$url .= $keyword != "" ? "keyword=".$keyword : "";
		?>
        
        <ul>

        		
        	<?php
				if($current_page != 1)
				{
					echo "<li><a href='$url&page=".($current_page-1)."'> < </a></li>";
				}
				//echo $url;
				for($i=$page_start; $i<=$page_end; $i++)
				{
					if($i == $current_page)
						echo "<li><a style='color: #f90; font-weight: bold' href='$url&page=$i'>$i</a></li>";	
					else
						echo "<li><a href='$url&page=$i'>$i</a></li>";	
				}
				if($current_page != $page_end)
				{
					echo "<li><a href='$url&page=".($current_page+1)."'> > </a></li>";
				}
			?>
        </ul>
        
    </div>

</div>


<div class="clear"></div>

<script>

	$(document).ready(function(e) {
        
		$('#orderby').change(function()
		{
			//ban chay, khuyenmai, hangmoi,...
			type = $('#type').val(); //alert("type: "+type);
			madm = $('#madm').val();
			keyword = $('#keyword').val();
			sapxep = $('#orderby').val();
			position = $('#position').val();
			
			data = "type="+type+"&madm="+madm+"&keyword="+keyword+"&sapxep="+sapxep+"&position="+position;
			
			$.ajax
			({
				url: "js/xuly/product_xuly.php",
				type: "post",
				data: data,
				async: true,
				success:function(kq)
				{
					$('.list-item').html(kq);		
				},
				error: function (jqXHR, exception)
				{
					//alert("Lỗi rồi");
					 var msg = '';
					if (jqXHR.status === 0) {
						msg = 'Not connect.\n Verify Network.';
					} else if (jqXHR.status == 404) {
						msg = 'Requested page not found. [404]';
					} else if (jqXHR.status == 500) {
						msg = 'Internal Server Error [500].';
					} else if (exception === 'parsererror') {
						msg = 'Requested JSON parse failed.';
					} else if (exception === 'timeout') {
						msg = 'Time out error.';
					} else if (exception === 'abort') {
						msg = 'Ajax request aborted.';
					} else {
						msg = 'Uncaught Error.\n' + jqXHR.responseText;
					}
					alert(msg);
				}	
			});
		});
		
    });

</script>


<?php
	include_once('module/bottom.php');
?>