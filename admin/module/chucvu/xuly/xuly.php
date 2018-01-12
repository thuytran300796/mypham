<?php
	function Tao_MaCV()
	{
		$result = mysql_query("select macv from chucvu where macv like 'CV%'");
			
		if(mysql_num_rows($result) == 0)
			return 'CV1';
		else
		{		
			$re_dong = mysql_fetch_assoc($result);
			
			$number = substr($re_dong['macv'], 2);
			
			while($re_dong = mysql_fetch_assoc($result))
			{
				$temp = substr($re_dong['macv'], 2);
				if($number < $temp)
					$number = $temp;
			}
			return 'CV'.++$number;
		}	
	}
?>

<?php
	require('../../../../config/config.php');
	$ac = isset($_POST['ac']) ?  $_POST['ac'] : "";
	
	if($ac == 'them')
	{
		$macv = Tao_MaCV();
		$tencv = $_POST['tencv']; $hesoluong = $_POST['hesoluong']; $phucap = $_POST['phucap'];
		mysql_query("set names 'utf8'");
		$kq = mysql_query("insert into chucvu values('$macv', '$tencv', $hesoluong, $phucap, 1)");
		echo "<tr><td>".$macv."</td><td>".$tencv."</td><td>".$hesoluong."</td><td>".$phucap."</td><td><a href='javascript:void(0)' data-id='".$macv."'>Xóa</a></td></tr>";
	}
	else if($ac == 'xoa')
	{
		$macv = $_POST['macv'];
		$kq = mysql_query("update chucvu set trangthai = 0 where macv = '$macv'");
	}echo $kq;
	mysql_close($conn);
?>