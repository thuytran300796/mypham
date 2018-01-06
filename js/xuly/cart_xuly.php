<?php

	session_start();
	
	if(isset($_POST['ac']))
	{
		$ac = $_POST['ac'];
		
		if($ac == 'soluong')
		{
			$soluongmoi = $_POST['soluongmoi'];
			$ctsp = $_POST['ctsp'];
			$_SESSION['cart'][$ctsp]['soluong'] = $soluongmoi;
		
			echo $_SESSION['cart'][$ctsp]['soluong'];		
		}
		else if($ac == 'chonqt_sp')
		{
			$maqt = $_POST['maqt'];
			$mactsp = $_POST['mactsp'];
			if(array_key_exists ($mactsp,$_SESSION['cart']))
			{
				$_SESSION['cart'][$mactsp]['maqt'] = $maqt;
				echo $_SESSION['cart'][$mactsp]['maqt'];
			}
		}
		else if($ac == 'chonqt_hd')
		{
			$maqt = $_POST['maqt_hd'];
			if(isset($_SESSION['cart']))
			{
				if(array_key_exists ('QT000', $_SESSION['cart']))
				{
					$_SESSION['cart']['QT000']['maqt'] = $maqt;
					echo $_SESSION['cart']['QT000']['maqt'];
				}
				else
				{
					$_SESSION['cart']['QT000']['soluong'] = 1;
					$_SESSION['cart']['QT000']['giaban'] = 0;
					$_SESSION['cart']['QT000']['makm'] = '000';
					$_SESSION['cart']['QT000']['maqt'] = $maqt;
					$_SESSION['cart']['QT000']['chietkhau'] = 0;
					$_SESSION['cart']['QT000']['tiengiamgia'] = 0;
				}
			}
		}
	}
?>