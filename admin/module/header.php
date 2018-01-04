    <body>
    
    	<div style = 'width: 100%; height: 100%;'>
    
    		<!--cart, search, logo-->
            <div class = 'top' > 
            	
                <a href='admin.php?quanly=hoadon&ac=lk_hd'>
                <div class = 'logo' >
                    <span style="color:#088A68; font-size: 36px; font-weight: bold;">AZURA.vn</span>
                </div>
                </a>
                
                <!--
                <form>
                <div class = 'search-icon'>
                    <input type='text' class = 'search-text' placeholder="Nhập sản phẩm cần tìm..."/>
                    <input type ='submit' class = 'search-submit' value=""/>
                </div>
                </form>
  				-->
                <div id = 'login-icon' >
                
                    <span><a href = 'login.php'><?php echo $_SESSION['name']; ?></a> | <a href = '../config/config.php?check=logad'> Đăng xuất </a></span>
                    
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
                	<li><a href='admin.php?quanly=hoadon&ac=lietke'>BÁN HÀNG</a>
                    	<ul>
                        	<li><a href='admin.php?quanly=hoadon&ac=lk_hd'>Các hóa đơn đã xuất</a></li>
                            <li><a href='admin.php?quanly=hoadon&ac=giohang'>Các giỏ hàng xử lý</a>
                        </ul>
                    </li>
                	<li><a href='admin.php?quanly=sanpham'>HÀNG HÓA</a>
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
                    <li><a href='admin.php?quanly=nhacc&ac=them'>NHÀ CUNG CẤP</a></li>
                    <li><a href='admin.php?quanly=khuyenmai&ac=lietke'>KHUYẾN MÃI</a></li>
                    <li><a href='#'>BÁO CÁO, THỐNG KÊ</a></li>
                    <li><a href='admin.php?quanly=nhanvien&ac=lietke'>NHÂN VIÊN</a>
                    	<ul>
                        	<li><a href='admin.php?quanly=chucvu'>Chức vụ</a></li>
                        </ul>
                    </li>
                    <li><a href='admin.php?quanly=khachhang'>KHÁCH HÀNG</a></li>
                </ul>

                <div class='clear'></div>

            </div>
            <!-- end top -->
            
            <div class='clear'></div>
            
            <div class = 'wrapper'>