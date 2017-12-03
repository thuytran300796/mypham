
        
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
                <form>
                <div class = 'search-icon'>
                    <input type='text' class = 'search-text' placeholder="Nhập sản phẩm cần tìm..."/>
                    <input type ='submit' class = 'search-submit' value=""/>
                </div>
                </form>
                
                <a href='cart.php'>
                    <div id = 'cart-icon' ><span>Giỏ hàng</span></div>
                </a>
                
                
                <div id = 'login-icon' >
                
                    <span><a href = 'login.php'> Đăng nhập </a> | <a href = 'login.php'> Đăng ký </a></span>
                    
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
                        	<li><a href='#'>Trang điểm</a>
                            	<ul>
                                	<li><a href='#'>Trang điểm mắt</a></li>
                                    <li><a href='#'>Trang điểm môi</a>
                                    	<ul>
                                            <li><a href='#'>Son lì</a>
												<ul>
													<li><a href='#'>Son lì x</a>
													<li><a href='#'>Son lì y</a>
												</ul>
											</li>
                                            <li><a href='#'>Son kem</a></li>
                                            <li><a href='#'>Son tint</a></li>
                                        </ul>
                                    </li>
                                    <li><a href='#'>Trang điểm mặt</a></li>
                                </ul>
                            </li>
							<li><a href='#'>Chăm sóc tóc</a>
                            	<ul>
                                	<li><a href='#'>Dầu gội</a>
                                    	<ul>
                                            <li><a href='#'>Dầu gội trị gàu</a></li>
                                            <li><a href='#'>Dầu gội trị rụng tóc</a></li>
                                            <li><a href='#'>Dầu gội cho tóc khô</a></li>
                                        </ul>
                                    </li>
                                    <li><a href='#'>Dầu xả</a></li>
                                </ul>
                            </li>
                            <li><a href='#'>Chăm sóc da</a></li>
                            <li><a href='#'>Nước hoa</a></li>
                            <li><a href='#'>Phụ kiện làm đẹp</a></li>
                        </ul>
                    </li>
                    <li><a href='#'>CHƯƠNG TRÌNH KHUYẾN MÃI</a></li>
                    <li><a href='#'>HÀNG MỚI VỀ</a></li>
                    <li><a href='#'>TOP SẢN PHẨM BÁN CHẠY</a></li>
                </ul>

                <div class='clear'></div>

            </div>
            
            <div class='clear'></div>
            
            <div class = 'wrapper'>