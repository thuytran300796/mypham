<?php

	if(!isset($_SESSION))
		session_start();

	if(isset($_GET['check']))//logout
	{
		if($_GET['check'] == 'logout')//khách
		{
			unset($_SESSION['user']);
			unset($_SESSION['name']);
			$url = $_REQUEST['url'];
			$arr = explode("?", $url);
			if($arr[0] == 'account.php')
				header('location: ../home.php');
			else
				header('location: ../'.$url.'');	
		}
		else if($_GET['check'] == 'logad')//admin-nv
		{
			unset($_SESSION['username']);
			unset($_SESSION['name']);
			header('location: ../login.php');
		}
	}

	$user = "root";
	$pass = "";
	$conn = mysql_connect("localhost", $user, $pass);
	mysql_select_db("mypham", $conn);

?>