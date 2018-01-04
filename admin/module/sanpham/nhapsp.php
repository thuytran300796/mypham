<script>

	$(document).ready(function(e) {
        
		$('#keyword').keyup(function()
		{
			keyword = $('#keyword').val();
			//alert(keyword);
			
			if(keyword == "")
				$('.quick-result').css('display', 'none');
			else
			{
				$.ajax
				({
					url: "module/sanpham/xuly/xuly_nhapkho.php",
					type: "post",
					data: "keyword="+keyword,
					async: true,	
					success:function(kq)
					{
						$('.quick-result').css('display', 'block');
						$('.quick-result').html(kq);
					}
				});
				
				
			}
			
			return false;	
		});
		
		$('.quick-result').mouseleave(function()
		{
			$('.quick-result').hide();
		});
		
    });

</script>


<div style='width: 78%; height: 300px; border: solid 1px; float: left;'>

	<div class='quick-search'>
    	<form>
        	<input type='text' class="txt-sp" style="width: 400px;" id='keyword' name='keyword' placeholder="Nhập mã hoặc tên sản phẩm..."/>
            <input type='button' class="sub btn-search" name='btn_tim' placeholder="Tìm" value="Tìm"/>
            
            <ul class = "quick-result">
                
                	
                    <div class="clear"></div>
                    <li>
                    	<a href="#">
                        	<img src="../image/mypham/13006668_1266981196646176_2203810380917456767_n.jpg"/>
                        	<div>
                                <p>Áo khoác thêu hình quả cầu</p>
                                <p>Màu</p>
                                <p>Thương hiệu: </p>
                                <p>Nhà cung cấp: </p>
                            </div>
                        </a>
                    </li>
                    <div class="clear"></div>
            </ul>
            
            
        </form>
    </div>

	<tr>
    	<th>Mã sản phẩm</th>
        <th>Tên sản phẩm</th>
        <th>Màu sắc</th>
        <th>Ngày sản xuất</th>
        <th>Hạn sử dụng</th>
        <th>Số lượng</th>
        <th>Giá nhập</th>
    </tr>



</div>


<div style='width: 20%; height: 300px; border: solid 1px; float: right'>

	<table>
    
    	<tr>
        	<td>Mã phiếu nhập:</td>
            <td>P19</td>
        </tr>
        
        <tr>
        	<td>Tổng tiền:</td>
        </tr>
    
    </table>

</div>