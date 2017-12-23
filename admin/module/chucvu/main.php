<?php

	if(isset($_REQUEST['ac']))
	{
		if(isset($_REQUEST['ac']))
		{
?>
<div id='left-ncc' style="width: 30%; height: 500px; border: solid 1px #ccc; border-radius: 3px; float: left; padding-top: 1%;">

<?php
	
			if($_REQUEST['ac'] == 'them')
			{
				require('module/chucvu/them.php');	
			}	
			else if($_REQUEST['ac'] == 'sua')
			{
				require('module/chucvu/sua.php');
			}
		}
	?>

</div>

<div style="width: 69%;  float: right; padding-top: 1%">
	<?php
		require('module/chucvu/lietke.php');
	?>
</div>
<?php
	}
	else
	{
?>


<div style="width: 80%;  margin: auto; padding-top: 1%">
	<?php
		require('module/chucvu/lietke.php');
	?>
</div>

<?php
	}
?>