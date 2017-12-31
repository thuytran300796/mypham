<?php
	
	$list = array();
	
	$list[0]['masp'] = 'SP1';
	$list[0]['tensp'] = 'Son kem 3 màu';
	$list[1]['masp'] = 'SP2';
	$list[1]['tensp'] = 'Chì kẻ mày';
	$temp[0] = $list[1];
	$list[1]['tensp'] = 'abc';
	echo "<pre>"; print_r($temp[0]);echo"</pre>";
	
?>