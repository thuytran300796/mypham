<?php
/*
	function Tao_MaHD()
	{
		require('config.php');
		
		$result = mysql_query('select Madh, Ngaydat  from Hoadon   order by Ngaydat desc limit 0, 1');
		
		if(mysql_num_rows($result) == 0)
		{
			return 'HD1';	
		}

		
		$dong = mysql_fetch_assoc($result);
		
		$temp = substr($dong['Madh'], 2);
		
		return 'HD'.++$temp;
		
	}*/
	
	function Tao_MaNCC()
	{
		//require('../config/config.php');
		
		$result = mysql_query("select MaNCC from NhaCungCap");
		
		if(mysql_num_rows($result) == 0)
			return 'NCC1';
			
		$dong = mysql_fetch_assoc($result);
		
		$number = substr($dong['MaNCC'], 3);
		
		while($dong = mysql_fetch_assoc($result))
		{
			$temp = substr($dong['MaNCC'], 3);
			if($number < $temp)
				$number = $temp;
		}
		return 'NCC'.++$number;
	}
	
	
	
	function Tao_MaNV()
	{
		require('../config/config.php');
		
		$result = mysql_query("select MaNV from NHANVIEN WHERE MaNV NOT IN('admin')");
		
		if(mysql_num_rows($result) == 0)
			return 'MaNV1';
			
		$dong = mysql_fetch_assoc($result);
		
		$number = substr($dong['MaNV'], 4);
		
		while($dong = mysql_fetch_assoc($result))
		{
			$temp = substr($dong['MaNV'], 4);
			if($number < $temp)
				$number = $temp;
		}
		return 'MaNV'.++$number;
	}


	
	function Tao_MaKM()
	{
		require('../config/config.php');
		
		$result = mysql_query('select MaKM from KhuyenMai');
		
		if(mysql_num_rows($result) == 0)
			return 'KM1';
			
		$dong = mysql_fetch_assoc($result);
		
		$number = substr($dong['MaKM'], 2);
		
		while($dong = mysql_fetch_assoc($result))
		{
			$temp = substr($dong['MaKM'], 2);
			if($number < $temp)
				$number = $temp;
		}
		return 'KM'.++$number;
	}
	
	function Tao_MaPN()
	{
		require('../config/config.php');
		
		$result = mysql_query('select MaPhieu from PhieuNhap');
		
		if(mysql_num_rows($result) == 0)
			return 'PN1';
			
		$dong = mysql_fetch_assoc($result);
		
		$number = substr($dong['MaPhieu'], 2);
		
		while($dong = mysql_fetch_assoc($result))
		{
			$temp = substr($dong['MaPhieu'], 2);
			if($number < $temp)
				$number = $temp;
		}
		return 'PN'.++$number;
	}
	
	function Tao_MaHA()
	{
		require('../config/config.php');
		
		$result = mysql_query('select MaHA from HinhAnh');
		
		if(mysql_num_rows($result) == 0)
			return 'HA1';
			
		$dong = mysql_fetch_assoc($result);
		
		$number = substr($dong['MaHA'], 2);
		
		while($dong = mysql_fetch_assoc($result))
		{
			$temp = substr($dong['MaHA'], 2);
			if($number < $temp)
				$number = $temp;
		}
		return 'HA'.++$number;
	}
	
	function Tao_MaGH()
	{
		require('../config/config.php');
		
		$result = mysql_query('Select MaGH from GioHang ');
		
		if(mysql_num_rows($result) == 0)
			return 'GH1';
			
		$dong = mysql_fetch_assoc($result);
		
		$number = substr($dong['MaGH'], 2);
		
		while($dong = mysql_fetch_assoc($result))
		{
			$temp = substr($dong['MaGH'], 2);
			if($number < $temp)
				$number = $temp;
		}
		return 'GH'.++$number;
	}
	

	function Tao_MaBL()
	{
		//require('');
		$result = mysql_query('Select MaBL from BinhLuan ');
		
		if(mysql_num_rows($result) == 0)
			return 'BL1';
			
		$dong = mysql_fetch_assoc($result);
		
		$number = substr($dong['MaBL'], 2);
		
		while($dong = mysql_fetch_assoc($result))
		{
			$temp = substr($dong['MaBL'], 2);
			if($number < $temp)
				$number = $temp;
		}
		return 'BL'.++$number;
		//mysql_close(
	}

?>