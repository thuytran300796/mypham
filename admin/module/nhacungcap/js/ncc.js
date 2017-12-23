
$(document).ready(function(e) {
    
	$('#nhacc-add').click(function()
	{
		$('.popup div h3').html('Thêm nhà cung cấp');
		
		$('.pop-sub').attr
		({
			value: "Thêm",
			id: "add"
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
		//alert(action); //$('.popup-background').stop().fadeOut('fast');
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

				//$('.popup-background').stop().fadeOut('fast');
				//$('#nhacungcap .tb-lietke').append("<tr><td>"+kq.id+"</td><td>"+kq.ten+"</td><td>"+kq.diachi+"</td><td align='center'>"+kq.sdt+"</td><td>"+kq.email+"</td><td align='center'><a href = 'admin.php?quanly=nhacc&ac=sua&id=NCC1'>Sửa</a></td><td align='center'><a href = '#'>Xóa</a></td></tr>");
				data = jQuery.parseJSON(kq);
				if(action == 'add')
				{
					//alert('hihi');
					//$('#content').html("trân");
					//window.location.href = "admin.php?quanly=nhacc";

					 
					$('.popup-background').fadeOut('fast', function()
					{
						//$('#content').html(kq.ten + " " + kq.diachi);
						html = "<tr><td>"+kq.id+"</td><td>"+data.ten+"</td><td>"+data.diachi+"</td><td align='center'>"+data.sdt+"</td><td>"+data.email+"</td><td align='center'><a href = 'admin.php?quanly=nhacc&ac=sua&id=NCC1'>Sửa</a></td><td align='center'><a href = '#'>Xóa</a></td></tr>";
						$('#nhacungcap table').append(html);
						$('#ten_ncc').val("");
						$('#sdt_ncc').val("");
						$('#diachi_ncc').val("");
						$('#email_ncc').val("");
						$('#ghichu_ncc').val("");
					}); 
				}
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
	}
	
});

