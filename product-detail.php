<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
	<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
    	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <script src="js/jquery-1.12.4.js"></script>
        <link type="text/css" rel='stylesheet' href="style.css"/>
    	<title>Chi tiết sản phẩm</title>

<?php
	session_start();
	//$_SESSION['user'] = 'thuytran3007';
	//$_SESSION['username'] = 'Trân Phạm';
	//unset($_SESSION['user']);
	ob_start();
	
	if(isset($_GET['id']))
		$id = $_GET['id'];
		
	$url = "product-detail.php?id=$id";
	
	include_once('module/header.php');
	require('config/config.php');
	
	
	//else
		//header('location: home.php');
	//echo $id;
	$ha = mysql_query("select duongdan from hinhanh where masp = '".$id."'");
	
	$list_ha = array();
	$m = 0;
	while($re_ha = mysql_fetch_assoc($ha))
	{
		$list_ha[$m++] = $re_ha['duongdan'];
	}
	
	mysql_query("set names 'utf8'");
	$sp = mysql_query("select masp, tensp, donvitinh, mota, trongluong, thuonghieu, makm, giadexuat, giaban, madm, makm from sanpham where masp = '$id'");
	$re_sp = mysql_fetch_assoc($sp);
	
	mysql_query("set names 'utf8'");
	$binhluan = mysql_query("select mabl, bl.makh,tenkh, hinhdaidien, noidung, ngay, mablcha from binhluan bl, khachhang kh where masp = '$id' and bl.makh = kh.makh order by ngay desc" );
	//echo mysql_num_rows($binhluan);
?>


<script>

	$(document).ready(function(e) {
   
		$('.com-submit').click(function()
		{
			var noidung = $('.com-mess').val();
			
			var id = $('.com-submit').attr('data-id');

			var user = '<?php echo $_SESSION['user'] ?>';
			
			$.ajax
			({
				url: "js/xuly/comment_xuly.php",
				type: "post",
				data: "id=" + id + "&user=" + user + "&noidung=" + noidung,
				async: true,
				success:function(kq)
				{
					if($('#com-list li').length == 0)
					{
						$('#com-list').html(kq);
					}
					else
					{
						$('#com-list li:eq(0)').before(kq);	
					}
				}
				
				
			});
			$('.com-mess').val("");

			return false;
		});
		
    });

</script>

<input type='hidden' name='id' value='<?php echo $id ?>'/>

	<div class = 'wrap-left-protail'>
		
		<div class = 'product-content'>
		
			<div class = 'product-image'>

				<div class = 'img-big'>
					<img id = 'img-large' src="image/mypham/<?php echo $list_ha[0]  ?>"/>
				</div>
                <button class = 'arrow-left'  data-id = 'km'></button>
                <div class = 'img-sml'>
					<?php
						$dem = 1;
						foreach($list_ha as $key => $value)
						{
					?>
					<div class = 'img-sml-index'>
						<img id = 'img-small-<?php echo $dem?>' src="image/mypham/<?php echo $value ?>" onclick="document.getElementById('img-large').src = document.getElementById('img-small-<?php echo $dem ?>').src"/>
					</div>
					<?php
							$dem++;
						}
					?>
				</div>
                <button class = 'arrow-right'  data-id = 'km'></button>
                

			</div>
			
			<div class = 'product-normal'>
				<p class="product-name-detail"><?php echo $re_sp['tensp'] ?></p>
            <p>Thương hiệu: <span class="text-highlight"><?php echo $re_sp['thuonghieu'] ?></span></p>
            
                <p><span class = 'product-price-detail'><?php echo number_format($re_sp['giaban']) ?> đ</span> Đã bao gồm thuế VAT</p>
                <?php
					if($re_sp['giadexuat'] > $re_sp['giaban'])
					{
				?>
                <p>Giá thị trường: <strike><?php echo number_format($re_sp['giadexuat'])." đ" ?></strike></p>
                <p><?php echo "Tiết kiệm ".number_format($re_sp['giadexuat'] - $re_sp['giaban'])." đ" ?></p>
                <?php
					}
				?>
                
                <table cellspacing="10px">
                	<?php
						mysql_query("SET NAMES 'utf8'");
						$ctsp = mysql_query("select mactsp, masp, mausac from chitietsanpham where masp = '$id' and soluong > 0");
						$list_ctsp = array();
						$dem = 0;
						while($re_ctsp = mysql_fetch_assoc($ctsp))
						{
							$list_ctsp[$dem]['ctsp'] = $re_ctsp['mactsp'];
							$list_ctsp[$dem]['mausac'] = $re_ctsp['mausac'];
							$dem++;
						}
						
					?>
                    
                <form action = "cart.php" method="post">
                	<?php
						if(count($list_ctsp)==1 && $list_ctsp[0]['mausac'] == "")
						{
							echo "<input type='hidden' name='ctsp' value='".$list_ctsp[0]['ctsp']."'/>";
						}
						else
						{
					?>
                	<tr>
                    	<td><p>Chọn màu:</p></td>
                        <td><select  name='ctsp' class='cbb-pro'>
                        <?php
						
							for($i=0; $i<count($list_ctsp); $i++)
							{
						?>
                            <option value='<?php echo $list_ctsp[$i]['ctsp'] ?>'><?php echo $list_ctsp[$i]['mausac'] ?></option>
                        <?php
							}
						?>
                        </select></td>
                    </tr>
                    <?php
						}
					?>
          		
                    <tr>
                    	<td><p>Số lượng:</p></td>
                        <td><input type='text' value='1' name='soluong' id='txt-soluong' onKeyPress="check_soluong"/></td>
                    </tr>
                    
                    <tr>
                    	<td colspan="2"><input id='btn-add-cart' type='submit' value="Thêm vào giỏ hàng"/></td>
                    </tr>
                    <input type='hidden' name='id' value="<?php echo $id ?>"/>
                    <input type='hidden' name='tensp' value="<?php echo $re_sp['tensp'] ?>"/>
                    <input type='hidden' name='giaban' value="<?php echo $re_sp['giaban'] ?>"/>
                    <input type='hidden' name='makm' value="<?php echo $re_sp['makm'] ?>"/>
                    <input type='hidden' name='hinhanh' value="<?php echo $list_ha[0] ?>"/>
                </form>
                </table>
                
     			<hr />
                <?php
					if($re_sp['makm'] != '000')
					{
						$khuyenmai = mysql_query("select * from khuyenmai where makm = '".$re_sp['makm']."'");
						$re_km = mysql_fetch_assoc($re_km);
				?>
                <p class='title-general'>KHUYẾN MÃI</p>
             	<p><?php $re_km['mota'] ?></p>
                <?php
					}
				?>
			</div>
			
			<div class ='clear'></div>
		</div>
		
		<div class = 'product-info'>
			<?php
				echo $re_sp['mota'];
			?>
		</div>
		
        <!-- COMMENT -->
        <div id = 'comment'>
        
        	<p style='font-size: 18px; font-weight: bold; color: #F90;	'>KHÁCH HÀNG NHẬN XÉT</p>
    	<form  action="product-detail.php?id=<?php echo $id ?>">
            <fieldset>
            
                <legend>Viết nhận xét của bạn vào bên dưới</legend>
                    <textarea class='com-mess'></textarea>
                	<input type='hidden' name='id' value='<?php echo $id ?>'/>
                	<input type = 'submit' class='com-submit' data-id="<?php echo $id ?>" value="Gửi"/>
            </fieldset>
        </form> 
            <p style='font-size: 18px; font-weight: bold; color: #F90;	margin-top: 3%;'>CÁC NHẬN XÉT TRƯỚC ĐÓ</p>
          	<ul id='com-list'>
            	<?php
					while($re_bl = mysql_fetch_assoc($binhluan))
					{
				?>
                <li>
                	<div class='com-info'>
                    	<img src="image/khachhang/<?php echo $re_bl['hinhdaidien'] ?>"/>
                        <p><?php echo $re_bl['tenkh']." &nbsp;".$re_bl['ngay']." &nbsp;"; ?> </p>
                        <p><?php echo $re_bl['noidung']?></p>
                        <p><a href="javascript:void(0)" class="rep-a" data-repa='<?php echo $re_bl['mabl'] ?>'>Gửi trả lời</a></p>
                    </div>
                    <div class="clear"></div>
             		<!--các bình luận conn-->
                    <!--
                    <ul>
                    
                    	<li>
                        	<div class='com-info'>
                                <img src="image/khachhang/16700007_736167479867040_1149049724_n.jpg"/>
                                <p>Thủy Trân 30/11/2017 16:59:24</p>
                                <p>Màu son lên đẹp, đều màu và lâu trôi</p>
                            </div>
                            <div class="clear"></div>
                        </li>
                    
                    </ul>-->
                <form>
                    <fieldset style="margin-left: 75px; display: none" class="rep-form<?php echo $re_bl['mabl'] ?>">
            
                        <legend>Viết nhận xét của bạn vào bên dưới</legend>
                    	<!--<form>-->
                            <textarea class='re-mess'></textarea>
                        <!--</form>-->
                        <input type='submit' class = 're-submit'  value='Gửi'/>
                    </fieldset>
                </form>
                </li>
                <?php
					}
				?>
                <!--
                <li>
                	
                    <div class='com-info'>
                    	<img src="image/khachhang/16700007_736167479867040_1149049724_n.jpg"/>
                        <p>Thủy Trân 30/11/2017 16:59:24</p>
                        <p>son thì mình thấy cũng ok, nhưng chai chống nắng tặng kèm - ôi trời ơi da mình da dầu mà bôi lên da bị khô bông tróc hai bên cánh mũi, mình dùng xịt khoáng innisfree chữa cháy cũng bớt khô đc tí. Các bạn da khô cân nhắc kỹ trước khi dùng.
                        son thì mình thấy cũng ok, nhưng chai chống nắng tặng kèm - ôi trời ơi da mình da dầu mà bôi lên da bị khô bông tróc hai bên cánh mũi, mình dùng xịt khoáng innisfree chữa cháy cũng bớt khô đc tí. Các bạn da khô cân nhắc kỹ trước khi dùng
                        son thì mình thấy cũng ok, nhưng chai chống nắng tặng kèm - ôi trời ơi da mình da dầu mà bôi lên da bị khô bông tróc hai bên cánh mũi, mình dùng xịt khoáng innisfree chữa cháy cũng bớt khô đc tí. Các bạn da khô cân nhắc kỹ trước khi dùng.
                        son thì mình thấy cũng ok, nhưng chai chống nắng tặng kèm - ôi trời ơi da mình da dầu mà bôi lên da bị khô bông tróc hai bên cánh mũi, mình dùng xịt khoáng innisfree chữa cháy cũng bớt khô đc tí. Các bạn da khô cân nhắc kỹ trước khi dùng</p>
                        <p><a href="javascript:void(0)" class="rep-a">Gửi trả lời</a></p>
                    </div>
               <form>
                    <fieldset style="margin-left: 75px; display: none" class="rep-form">
            
                        <legend>Viết nhận xét của bạn vào bên dưới</legend>
                            <textarea class='re-mess'></textarea>
                        <input type='submit' class = 're-submit'  value='Gửi'/>
                    </fieldset>
				</form>
                    <div class="clear"></div>  
                </li> -->
                
            </ul>
        
        </div>
		
		<div class = 'clear'></div>
	</div>
    <!--END div left-->
	

	<div class = 'wrap-right-protail'>
	
    	<div class="list-pro">
        	
            <div class = 'list-item-title'>
            	SẢN PHẨM CÙNG THƯƠNG HIỆU
            </div>
            <?PHP
				$sp_thuonghieu = mysql_query("select masp, tensp, giaban, giadexuat, thuonghieu from sanpham where thuonghieu = '".$re_sp['thuonghieu']."' and masp not in ('".$re_sp['masp']."')");
				while($re_sp = mysql_fetch_assoc($sp_thuonghieu))
				{
					$ha = mysql_query("select duongdan from hinhanh where masp = '".$re_sp['masp']."' limit 0,1");
					$re_ha = mysql_fetch_assoc($ha);
			?>
          	<a href='<?php echo $re_sp['tensp']?>'>
           	<div class = 'pro-sml'>
                <img src="image/mypham/<?php echo $re_ha['duongdan']?>"/>
                <div>
                	<p><?php echo $re_sp['tensp']?></p>
                    <p class="text-highlight"><?php echo $re_sp['thuonghieu']?></p>
                    <p class="product-price-home"><?php echo number_format($re_sp['giaban'])?> đ</p>
                    <p><strike><?php if($re_sp['giadexuat'] == $re_sp['giaban'])  echo ""; else echo number_format($re_sp['giaban'])."đ"; ?></strike></p>
                </div>
            </div>
            </a>
            <?php
				}
			?>	
            
			
            <div class='pro-xemthem'>
            	<a href='#'>Xem thêm</a>
            </div>
        </div>
        
        <div class="list-pro">
        	
            <div class = 'list-item-title'>
            	TOP SẢN PHẨM BÁN CHẠY
            </div>
  			
            <?php
				$sql = "	select	sp.masp, tensp, sp.giaban, giadexuat, thuonghieu, sum(cthd.soluong) as 'tong'
							from	sanpham sp, chitietsanpham ctsp, chitiethoadon cthd
							where	sp.masp = ctsp.masp and ctsp.mactsp = cthd.mactsp and sp.trangthai = 1
							group by sp.masp
							order by sum(cthd.soluong) desc";
				mysql_query("set names 'utf8'");
				$banchay = mysql_query($sql);
				while($re_banchay = mysql_fetch_assoc($banchay))
				{
					$ha = mysql_query("select duongdan from hinhanh where masp = '".$re_banchay['masp']."' limit 0,1");
					$re_ha = mysql_fetch_assoc($ha);
			?>
            
           	<div class = 'pro-sml'>
                <img src="image/mypham/<?php echo $re_ha['duongdan'] ?>"/>
                <div>
                	<p><?php echo $re_banchay['tensp'] ?></p>
                    <p class="text-highlight"><?php echo $re_banchay['thuonghieu'] ?></p>
                    <p class="product-price-home"><?php echo number_format($re_banchay['giaban']) ?> đ</p>
                    <p><strike><?php if($re_banchay['giadexuat'] == $re_banchay['giaban'])  echo ""; else echo number_format($re_banchay['giadexuat'])."đ"; ?></strike></p>
                </div>
            </div>
            
            <?php
				}
			?>
            <div class='pro-xemthem'>
            	<a href='#'>Xem thêm</a>
            </div>
		
        </div>
	
	</div>
	
	<div class = 'clear'></div>
    
    
<?php
	include_once('module/bottom.php');
?>