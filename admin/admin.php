

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
   	<head>
    	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <script src="../js/jquery-1.12.4.js"></script>
        <link type="text/css" rel='stylesheet' href="style.css"/>
    	<title>Trang quản trị</title>
        <script>
			$(document).ready(function(e) {
			
				$('.menu ul li:last').css('border-bottom', 'none');

			
				$('.menu li:first').css('background-image', 'url("image/menu2.png")');
				$('.menu li:first').css('background-position', '15% 50%');
				$('.menu li:first').css('background-repeat', 'no-repeat');
				$('.menu li:first').css('border-left', 'solid 1px white');
				
				/*
				$('.menu li').hover(function()
				{
					$(this).find('ul:first').show();
				}, function()
				{
					$(this).find('ul:first').hide();	
				});	
				*/

				$('.list-item-product ul li a:last .product-home').css('border-right', 'none');

				
				$('.arrow-left').click(function()
				{
					id = $(this).attr('data-id');
					
					$(".list-item-product[data-id = "+id+"] ul").animate({'margin-left': '+=100%'}, 1000, function(){
									
						$(".list-item-product[data-id = "+id+"] ul li:first").appendTo(".list-item-product[data-id = "+id+"] ul");
						$(".list-item-product[data-id = "+id+"] ul").css('margin-left', 0);	
											
					});
				});
				
				$('.arrow-right').click(function()
				{
					id = $(this).attr('data-id');
					
					$(".list-item-product[data-id = "+id+"] ul").animate({'margin-left': '-=100%'}, 1000, function(){
									
						$(".list-item-product[data-id = "+id+"] ul li:first").appendTo(".list-item-product[data-id = "+id+"] ul");
						$(".list-item-product[data-id = "+id+"] ul").css('margin-left', 0);	
											
					});	
				});
				
				$('#txt-soluong').keyup(function()
				{
					var s = $(this);
					if(isNaN(s.val()))
					{
						document.getElementById('txt-soluong').value = 1;	
					}
			
				});
				
				
				$('.rep-a').click(function()
				{
					$('.rep-form').slideToggle();
				});
				
				$('.a-code').click(function()
				{
					$('.code').slideToggle();	
				});
				
				$('.tb-lietke tr:even').css('background-color', '#F2F2F2');
				
            });
			
			
		</script>
    </head>
    
<?php
	ob_start();
	include_once('module/header.php');
	include_once('../module/function.php');
	include_once('../config/config.php');
?>

<?php
	
	if(isset($_REQUEST['quanly']))
	{
		$temp = $_REQUEST['quanly'];
		if($temp == 'sanpham')
			include_once('module/sanpham/main.php');
		else if($temp == 'nhacc')
			include_once('module/nhacungcap/main.php');
	}

?>
           


<?php
	ob_flush();
	include_once('module/bottom.php');
?>