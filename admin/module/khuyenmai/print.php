

<?php

	require('../../library/report/fpdf.php');
	
	require('../../../config/config.php');
	
	function tao_mapmh()
	{
		$result = mysql_query("select MaPhieu from PhieuMuaHang ");
		
		if(mysql_num_rows($result) == 0)
			return  'PMH1';
		else
		{
			$dong = mysql_fetch_assoc($result);
			
			$number = substr($dong['MaPhieu'], 3);
			
			while($dong = mysql_fetch_assoc($result))
			{
				$temp = substr($dong['MaPhieu'], 3);
				if($number < $temp)
					$number = $temp;
			}
			return 'PMH'.++$number;
		}
	}

	$list = array();
	$soluong = $_POST['voucher_soluong'];
	$voucher_bd = $_POST['voucher_bd']; $voucher_kt = $_POST['voucher_kt'];
	$trigia = $_POST['voucher_trigia'];
	for($i=0; $i<$soluong; $i++)
	{
		$maphieu = tao_mapmh();
		mysql_query("set names 'ut8f'");
		$pmh = mysql_query("insert into phieumuahang(maphieu, ngaybd, ngaykt, giatri, trangthai) values('$maphieu', '$voucher_bd', '$voucher_kt', $trigia, 0)");	
		$list[$maphieu]['ngaybd'] = date('d/m/Y', strtotime($voucher_bd));
		$list[$maphieu]['ngaykt'] = date('d/m/Y', strtotime($voucher_kt));
		$list[$maphieu]['giatri'] = $trigia;
	}
	
	
	
	class PDF extends tFPDF
	{
		function Header()
		{
		    // Logo
			//$this->Image('logo.png',10,6,30);
			// Arial bold 15
			$this->AddFont('DejaVu','','DejaVuSansCondensed.ttf',true);
			$this->SetFont('DejaVu','',15);

			// Move to the right
			$this->Cell(80);
			// Title
			$this->Cell(30,10, 'DANH SÁCH PHIẾU MUA HÀNG',0,1,'C');
			// Line break
			
			$this->Cell(0,10, 'AZURA Shop',0,1,'C');
			$this->SetFont('DejaVu','',12);
			$this->Ln(10);
			
		}
		
		function Footer()
		{

		}
	
	}
	
	$pdf = new PDF();
	$pdf->Cell(80);
	$pdf->AliasNbPages();
	$pdf->AddPage();
	$pdf->AddFont('DejaVu','','DejaVuSansCondensed.ttf',true);
	$pdf->SetFont('DejaVu','',12);
	
	$pdf->Cell(10,10,'STT', 1, 0, 'C'); 
	$pdf->Cell(45,10,'Mã phiếu', 1, 0, 'C'); 
	$pdf->Cell(45,10,'Ngày bắt đầu', 1, 0, 'C'); 
	$pdf->Cell(45,10,'Ngày kết thúc', 1, 0, 'C'); 
	$pdf->Cell(45,10,'Trị giá', 1, 1, 'C'); 
		
	$dem = 1;
	foreach($list as $key => $value)
	{
		$pdf->Cell(10,10,$dem, 1, 0, 'C'); 
		$pdf->Cell(45,10,$key, 1, 0, 'C'); 
		$pdf->Cell(45,10,$list[$key]['ngaybd'], 1, 0, 'C'); 
		$pdf->Cell(45,10,$list[$key]['ngaykt'], 1, 0, 'C'); 
		$pdf->Cell(45,10,$list[$key]['giatri'], 1, 1, 'C'); 
		$dem++;
	}	
	//$pdf->Cell(30,10, "ngày: {$ngay}", 0,1,'C');
	$pdf->Cell(0,10,'', 0, 1, 'C'); 
	$pdf->Output("");

	mysql_close($conn);
?>