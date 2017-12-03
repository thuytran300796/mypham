<?php

	session_start();
	
	$action = $_POST['action'];

	switch($action)
	{
		case 'themctsp':
		{
			$mausac = $_POST['mausac'];
			$soluongctsp = $_POST['soluongctsp'];
			$check = 1;
			
			for($k=0; $k<strlen($soluongctsp); $k++)
			{
				if($soluongctsp[$k] < '0' || $soluongctsp[$k] > '9')
				{
					//echo "errorsl";
					echo json_encode(array("mausac"=>"$mausac","errorsl"=>"errorsl"));
					$check = 0;
					break;	
				}
			}
			if($check == 1)
			{
			
				if(!isset($_SESSION['list-mausac']))
					$_SESSION['list-mausac'] = NULL;
					
				$i = count($_SESSION['list-mausac']);
				
				$_SESSION['list-mausac'][$i]['mausac'] = $mausac; 
				$_SESSION['list-mausac'][$i]['soluong'] = $soluongctsp; 
				$_SESSION['list-mausac'][$i]['id'] = $i; 
				
				$id = "id".$i;
				
				echo json_encode(array("mausac" => "$mausac", "soluongctsp" => "$soluongctsp", "id" => "$id"));
				/*
				echo "<tr>";				
				echo "<td>".$mausac."</td>";
				echo "<td>".$soluongctsp."</td>";
				echo "<td><a  href='#' data-ctid='".$i."' class = 'del-ctsp'>Xóa</a></td>";
				echo "</tr>";	
				*/
			}
		}
		break;
		case 'delctsp':
		{
			$id = $_POST['id'];
			unset($_SESSION['list-mausac'][$id]);
		}
		break;
	}

?>