$(document).ready(function(e) {
    
	$('#nhacc-add').click(function()
	{
		$('.popup div h3').html('Thêm nhà cung cấp');
		
		$('.pop-sub').attr
		({
			value: 'Thêm',
			id: 'add'
		});
		
		$('.popup-background').fadeIn('fast'); 
	});
	
	/*nhấn vô pop-sub thì nó sẽ xem là mình đang thêm hay sửa ncc*/
	$('.pop-sub').click(function()
	{
		action = $(this).attr('id');
		if(action == 'add')
		{
			ajax('add');
		}
		else
		{
			//id = $(this).
			ajax('edit');	
		}
		return false;
	});
	
	function ajax(action, id)
	{
		if(action == 'add')
		{
			ten = $('#ten_ncc').val();
			sdt = $('#sdt_ncc').val();
			diachi = $('#diachi_ncc').val();
			email = $('#email_ncc').val();
			ghichu = $('#ghichu_ncc').val();
			data = "action=add&ten=" + ten + "&sdt=" + sdt + "&diachi=" + diachi + "&email=" + email + "&ghichu=" + ghichu;
			//alert(data);
		}
		
		$.ajax
		({
			//gọi file ncc.php từ file ncc.js => cùng nằm trong 1 thư mục
			
			url: "module/nhacungcap/js/ncc.php",
			type: "post",
			data: data,
			dataType: "json",
			async: true,
			success:function(kq)
			{
				if(action == 'add')
				{
					$('.popup-background').fadeOut('fast', function()
					{
						//$('#content').html(kq.ten + " " + kq.diachi);
						$('#nhacungcap table').append("<tr><td>"+kq.id+"</td><td>"+kq.ten+"</td><td>"+kq.diachi+"</td><td align='center'>"+kq.sdt+"</td><td>"+kq.email+"</td><td align='center'><a href = 'admin.php?quanly=nhacc&ac=sua&id=NCC1'>Sửa</a></td><td align='center'><a href = '#'>Xóa</a></td></tr>");
						$('#ten_ncc').val("");
						$('#sdt_ncc').val("");
						$('#diachi_ncc').val("");
						$('#email_ncc').val("");
						$('#ghichu_ncc').val("");
					});
					
				}	
			}
			
		});
	}
	
});

