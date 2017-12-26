<!--<div id='left-ncc' style="width: 30%; height: 500px; border: solid 1px #ccc; border-radius: 3px; float: left; padding-top: 1%;">

	<?php
	/*
		if(isset($_REQUEST['ac']))
		{
			if($_REQUEST['ac'] == 'them')
			{
				require('module/nhacungcap/them.php');	
			}	
			else if($_REQUEST['ac'] == 'sua')
			{
				require('module/nhacungcap/sua.php');
			}
			else if($_REQUEST['ac'] == 'xoa')
			{
				$id = $_GET['id'];
				mysql_query("delete from nhacungcap where mancc = '$id'");
				header('location: admin.php?quanly=nhacc&ac=them');
			}
		}
		*/
	?>
	
	
    

</div>
-->

<!--<div style="width: 69%;  float: right; padding-top: 1%">-->
<div style="width: 95%;  margin: auto; padding-top: 1%">
	<?php
    
        include_once('module/nhacungcap/lietke_ajax.php');
    ?>

</div>
