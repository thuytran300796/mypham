
        
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
				
				/*
				$('.rep-a').click(function()
				{
					mabl = $(this).attr('data-repa');
					$('.rep-form'+mabl).slideToggle();
				});
				*/
				$('.a-code').click(function()
				{
					$('.code').slideToggle();	
				});
				
				//chọn class .rep-a được bao bọc bởi #com-list
				$('#com-list').delegate('.rep-a', 'click', function()
				{
					mabl = $(this).attr('data-repa');
					$('.rep-form'+mabl).slideToggle();
				});
				
            });
			
			
		</script>
        

        
    </head>

    <body>
    
    	<div style = 'width: 100%; height: 100%;'>
    
    		<!--cart, search, logo-->
            <div class = 'top' > 
            	
                <a href='home.php'>
                <div class = 'logo' >
                    <span style="color:#088A68;  font-size: 48px; ">AZURA.vn</span>
                </div>
                </a>
                <form action="product.php" method='get'>
                <div class = 'search-icon'>
                    <input type='text' class = 'search-text' name='keyword' value="<?php if(isset($_GET['keyword'])) echo $_GET['keyword'] ?>" placeholder="Nhập sản phẩm cần tìm..."/>
                    <input type ='submit' class = 'search-submit' value=""/>
                </div>
                </form>
                
                <a href='cart.php'>
                    <div id = 'cart-icon' ><span>Giỏ hàng</span></div>
                </a>
                
                
                <div id = 'login-icon' >
                
                	<?php
									
										if(isset($_SESSION['user']))
										{
											echo "<span>Chào <a  style = 'font-style: italic' href = 'account.php?id=".$_SESSION['user']."'> ".$_SESSION['name']." </a> | <a href = 'config/config.php?check=logout&url=".$url."'> Đăng xuất </a></span>";
										}
										else if(!isset($_SESSION['user']))
										{
											echo "<span><a href = 'login.php?url=".$url."'> Đăng nhập </a> | <a href = 'login.php?url=".$url."'> Đăng ký </a></span>";
										}
									?>
                
                    
                    
                </div>

            </div>
            
            <div class = 'clear'></div>
            <!--
            <div class = 'logo2'>
            	Azura
            </div>
            -->
            <!--category-->
            <div id = 'category'> 
            
            	<ul class='menu'>
                	<li><a href='#'>DANH MỤC</a>
                    	<ul>
                        	<li><a href="product.php?dm=TD">Trang điểm</a>
                            	<ul>
                                	<li><a href='product.php?dm=TDMA'>Trang điểm mắt</a>
                                    	<ul>
                                            <li><a href='product.php?madm=PhanMat'>Phấn mắt</a></li>
                                            <li><a href='product.php?madm=KMAT'>Kẻ mắt</a></li>
                                            <li><a href='product.php?MASCARA'>Mascara</a></li>
                                            <li><a href='product.php?madm=KMAY'>Kẻ mày</a></li>
                                        </ul>
                                    </li>
                                    <li><a href='product.php?dm=TDM'>Trang điểm môi</a>
                                    	<ul>
                                            <li><a href='product.php?madm=SThoi'>Son thỏi</a></li>
                                            <li><a href='product.php?madm=SKem'>Son kem</a></li>
                                            <li><a href='product.php?madm=SonTint'>Son tint</a></li>
                                            <li><a href='product.php?madm=SD'>Son dưỡng</a></li>
                                        </ul>
                                    </li>
                                    <li><a href='product.php?dm=TDFace'>Trang điểm mặt</a>
                                    	<ul>
                                            <li><a href='product.php?madm=BB_CC'>BB Cream - CC Cream</a></li>
                                            <li><a href='product.php?madm=CKD'>Che khuyết điểm</a></li>
                                            <li><a href='product.php?madm=KemLot'>Kem lót</a></li>
                                            <li><a href='product.php?madm=PhanPhu'>Phấn phủ</a></li>
                                            <li><a href='product.php?madm=PhanMa'>Má hồng</a></li>
                                            <li><a href='product.php?madm=PhanNen'>Phấn nền</a></li>
                                            <li><a href='product.php?madm=KemNen'>Kem nền</a></li>
                                            <li><a href='product.php?madm=HL_TaoKhoi'>High Light - Tạo khối</a></li>
                                        </ul>
                                    </li>
                                </ul>
                            </li>
							<li><a href='product.php?dm=CST'>Chăm sóc tóc</a>
                            	<ul>
                                	<li><a href='product.php?dm=DauGoi'>Dầu gội</a>
                                    	<ul>
                                            <li><a href='product.php?madm=DGGau'>Dầu gội trị gàu</a></li>
                                            <li><a href='product.php?madm=DGRungToc'>Dầu gội trị rụng tóc</a></li>
                                            <li><a href='product.php?madm=DGKho'>Dầu gội cho tóc khô</a></li>
                                        </ul>
                                    </li>
                                    <li><a href='product.php?madm=DauXa'>Dầu xả</a></li>
                                </ul>
                            </li>
                            <li><a href='product.php?dm=CSD'>Chăm sóc da</a>
                            	<ul>
                                	<li><a href='product.php?madm=SRM'>Sữa rửa mặt</a></li>
                                    <li><a href='product.php?madm=KCN'>Kem chống nắng</a></li>
                                    <li><a href='product.php?madm=XitKhoang'>Xịt khoáng</a></li>
                                    <li><a href='product.php?madm=MatNa'>Mặt nạ</a></li>
                                    <li><a href='product.php?madm=KemDD'>Kem dưỡng da</a></li>
                                </ul>
                            </li>
                            <li><a href='product.php?madm=NH'>Nước hoa</a></li>
                        </ul>
                    </li>
                    <li><a href="product.php?type=khuyenmai">CHƯƠNG TRÌNH KHUYẾN MÃI</a></li>
                    <li><a href='product.php?type=hangmoi'>HÀNG MỚI VỀ</a></li>
                    <li><a href='product.php?type=banchay'>TOP SẢN PHẨM BÁN CHẠY</a></li>
                </ul>

                <div class='clear'></div>

            </div>
            
            <div class='clear'></div>
            
            <div class = 'wrapper'>