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
	
	$title = NULL;
	$sql = NULL;
	$list_sp = array();
	
	if(isset($_GET['madm']))
	{
		$madm = $_GET['madm'];
		mysql_query("SET NAMES 'utf8'");
		$dm = mysql_query("select tendm, mota from danhmuc where madm = '$madm'");
		$re_dm = mysql_fetch_assoc($dm);
		$title = $re_dm['tendm'];
		$sql = "select masp, tensp, giaban, giadexuat, thuonghieu, makm  from sanpham where trangthai = 1 and madm = '$madm' limit 0,12";
	}
	else if(isset($_GET['type']))
	{
		mysql_query("SET NAMES 'utf8'");
		$title = "HÀNG BÁN CHẠY";
		$sql = "SELECT	sp.masp, tensp, sp.giaban, giadexuat, thuonghieu, sp.makm, sum(cthd.SoLuong)
				from	sanpham sp, chitietsanpham ctsp, chitiethoadon cthd
				WHERE	sp.masp = ctsp.masp
					AND	ctsp.MaCTSP = cthd.MaCTSP
					and sp.trangthai = 1
				group by	sp.masp
				order by sum(cthd.SoLuong) desc
				limit 0,12";
	}
	else
		$madm = "";	

	mysql_query("SET NAMES 'utf8'");
	$sp = mysql_query($sql);
	
	
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
            <select>
                <option>Giá giảm dần</option>
                <option>Giá tăng dần</option>
                <option>Sản phẩm bán chạy nhất</option>
            </select>
         </div>
     </div>   
        <div class = 'list-item'>

		<?php
			while($re_sp = mysql_fetch_assoc($sp))
			{
				$ha = mysql_query("select duongdan from hinhanh where masp = '".$re_sp['masp']."' limit 0,1");
				$re_ha = mysql_fetch_assoc($ha);
		?>
                                <a href = 'product-detail.php?id=<?php echo $re_sp['masp'] ?>'>
                                    <div class = 'product-home'>
                                        <img src="image/mypham/<?php echo $re_ha['duongdan'] ?>"/>
                                        <p><span class = 'product-price-home'><?php echo number_format($re_sp['giaban']) ?> đ</span> <strike><?php if($re_sp['giadexuat'] == $re_sp['giaban'])  echo ""; else echo number_format($re_sp['giaban'])."đ"; ?></strike></p>
                                        <p class = 'text-highlight'><?php echo $re_sp['thuonghieu'] ?></p>
                                        <p class = 'product-name-home'><?php echo $re_sp['tensp'] ?></p>
                                    </div>
                                </a>
        <?php
			}
		?>		
        						<!--
                                <a href = '#'>
                                    <div class = 'product-home'>
                                        <img src="image/mypham/00328475-1_1_2.jpg"/>
                                        <p><span class = 'product-price-home'>195.000 VND</span> <strike>401.000 VND</strike></p>
                                        <p class = 'product-name-home'>Combo 2 Nước Xịt Khoáng Evoluderm 150ml Và 400ml</p>
                                    </div>
                                </a>-->
                                
     
                            <div class="clear"></div>
             
                </div>
        <div class="clear"></div>
    <!--</div>-->

</div>


<div class="clear"></div>


<?php
	include_once('module/bottom.php');
?>