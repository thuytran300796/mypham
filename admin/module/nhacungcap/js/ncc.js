
$(document).ready(function(e) {
	
	$('#close-submit').click(function()
	{
		$('.popup').fadeOut();
	});
    
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
	
	$('#nhacungcap .tb-lietke').delegate('.edit-submit', 'click', function()
	{
		$('.popup div h3').html('Chỉnh sửa thông tin nhà cung cấp');
		
		$('.pop-sub').attr
		({
			value: "Sửa",
			id: "edit"
		});
		
		$('.popup-background').fadeIn('fast'); 
		id = $(this).attr('data-id');
		ajax('get_data', id);
	});
	
	$('#nhacungcap .tb-lietke').delegate('.del-submit', 'click', function()
	{	
		if(confirm("Bạn có chắc chắn muốn xóa không?"))
		{
			id = $(this).attr('data-id');
			ajax('del', id);
		}
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
			//id lấy từ hàm delegate('edit-submit')
			ajax('edit', id);	
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
			
		}
		else if(action == 'get_data')
		{
			data = "action=get_data&id="+id;	
		}
		else if(action == 'edit')
		{
			ten = $('#ten_ncc').val();
			sdt = $('#sdt_ncc').val();
			diachi = $('#diachi_ncc').val();
			email = $('#email_ncc').val();
			ghichu = $('#ghichu_ncc').val();
			data = "action=edit&id="+id+"&ten=" + ten + "&sdt=" + sdt + "&diachi=" + diachi + "&email=" + email + "&ghichu=" + ghichu;
		}
		else
		{
			data = "action=del&id="+id;	
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
						html = "<tr><td>"+kq.id+"</td><td>"+kq.ten+"</td><td>"+kq.diachi+"</td><td align='center'>"+kq.sdt+"</td><td>"+kq.email+"</td><td align='center'><a href='javascript:void(0)' class='edit-submit' data-id='"+kq.id+"'>Sửa</a></td><td align='center'><a href='javascript:void(0)' class='del-submit' data-id='"+kq.id+"'>Xóa</a></td></tr>";
						$('#nhacungcap table').append(html);
						$('#ten_ncc').val("");
						$('#sdt_ncc').val("");
						$('#diachi_ncc').val("");
						$('#email_ncc').val("");
						$('#ghichu_ncc').val("");
					}); 
				}
				else if(action =='get_data')
				{
					$('#ten_ncc').val(kq.ten);
					$('#sdt_ncc').val(kq.sdt);
					$('#diachi_ncc').val(kq.diachi);
					$('#email_ncc').val(kq.email);
					$('#ghichu_ncc').val(kq.ghichu);
				}
				else if(action == 'edit')
				{
					$('.popup-background').fadeOut('fast', function()
					{
						$("a[data-id='"+kq.id+"']").closest("#nhacungcap .tb-lietke tr").find("td:eq(1)").html(kq.ten);
						$("a[data-id='"+kq.id+"']").closest("#nhacungcap .tb-lietke tr").find("td:eq(2)").html(kq.diachi);
						$("a[data-id='"+kq.id+"']").closest("#nhacungcap .tb-lietke tr").find("td:eq(3)").html(kq.sdt);
						$("a[data-id='"+kq.id+"']").closest("#nhacungcap .tb-lietke tr").find("td:eq(4)").html(kq.email);
						$("a[data-id='"+kq.id+"']").closest("#nhacungcap .tb-lietke tr").find("td:eq(1)").html(kq.ghichu);
						$('#ten_ncc').val("");
						$('#sdt_ncc').val("");
						$('#diachi_ncc').val("");
						$('#email_ncc').val("");
						$('#ghichu_ncc').val("");
					});
				}
				else
				{
					$("a[data-id='"+kq.id+"']").closest("#nhacungcap .tb-lietke tr").fadeOut('fast');
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

