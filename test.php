<?php
	function Convert($arr)
	{	
		$str = "";
		foreach($arr as $key => $value)
		{
			$temp = unicode_convert($value);
			$temp = preg_replace('/\s+/', '', $temp);
			if($value == "")
				$str = $str."_NULL";
			else
				$str = $str."_".$temp;
		}
		
		return trim($str, '_');
	}

	
?>

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

<html>

	<head></head>
    
    
    <body>
    
    	<div style="width
    
    </body>

</html>