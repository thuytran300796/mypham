    <body>
    
    	<div style = 'width: 100%; height: 100%;'>
    
    		<!--cart, search, logo-->
            <div class = 'top' > 
            	
                <a href='admin.php'>
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
                
                    <span><a href = 'admin.php?quanly=doimk'><?php echo $_SESSION['name']; ?></a> | <a href = '../config/config.php?check=logad'> Đăng xuất </a></span>
                    
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
                	<li><a href='admin.php?quanly=hoadon&ac=taohd'>BÁN HÀNG</a>
                    	<ul>
                        	<li><a href='admin.php?quanly=hoadon&ac=lk_hd'>Các hóa đơn đã xuất</a></li>
                            <li><a href='admin.php?quanly=hoadon&ac=giohang'>Các giỏ hàng chưa xử lý</a>
                        </ul>
                    </li>
                	<li><a href='admin.php?quanly=sanpham'>HÀNG HÓA</a></li>
                    <li><a href='admin.php?quanly=nhacc&ac=them'>NHÀ CUNG CẤP</a></li>
                    <li><a href='admin.php?quanly=khuyenmai&ac=lietke'>KHUYẾN MÃI</a></li>
                    <li><a href='admin.php?quanly=thongke'>BÁO CÁO, THỐNG KÊ</a>
                    	<ul>
                        	<li><a href='admin.php?quanly=thongke&ac=sanpham'>Nhập - xuất - tồn</a></li>
                            <li><a href='admin.php?quanly=thongke&ac=thuchi'>Thu chi</a></li>
                        </ul>
                    </li>
                    <li><a href='admin.php?quanly=khachhang'>KHÁCH HÀNG</a></li>
               	<?php
			   		
					$str = substr($_SESSION['user'], 0, 2); 
					if($str != 'NV')
					{
			   	?>	
                    <li><a href='admin.php?quanly=nhanvien&ac=lietke'>NHÂN VIÊN</a>
                    	<ul>
                        	<li><a href='admin.php?quanly=chucvu'>Chức vụ</a></li>
                            <li><a href='admin.php?quanly=nhanvien&ac=luong'>Bảng lương</a></li>
                        </ul>
                    </li>
              	<?php
					}
				?>
                </ul>

                <div class='clear'></div>

            </div>
            <!-- end top -->
            
            <div class='clear'></div>
            
            <div class = 'wrapper'>