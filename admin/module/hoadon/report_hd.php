<?php

	$trigia = $_POST['voucher_trigia'];
	$soluong = $_POST['voucher_soluong'];
	$ngaybd = $_POST['voucher_bd'];
	$ngaykt = $_POST['voucher_kt'];
	date_default_timezone_set('Asia/Ho_Chi_Minh');
	$date = date('Y-m-d H:i:s');
	
	require('../../library/report/fpdf.php');
	
	require('../../../config/config.php');
	
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
			$this->Cell(30,10, 'Hóa đơn',0,1,'C');
			// Line break
			
			$this->Cell(0,10, 'AZURA Shop',0,1,'C');
			$this->SetFont('DejaVu','',12);
			$this->Ln(20);
			
		}
		
		function Footer()
		{
			$this->AddFont('DejaVu','','DejaVuSansCondensed.ttf',true);
			$this->SetFont('DejaVu','',15);
			
			$this->Cell(0,10, 'AZURA Shop',0,1,'C');
		}
	
	}
	
	$pdf = new PDF();
	$pdf->AliasNbPages();
	$pdf->AddPage();
	$pdf->AddFont('DejaVu','','DejaVuSansCondensed.ttf',true);
	$pdf->SetFont('DejaVu','',12);
	$pdf->Cell(30,10,'hóa đơn',1,1,'C');
	
	$pdf->SetFont('DejaVu','',11);
	$pdf->Cell(0,10, "ngày: {$date}", 0,1,'C');
	
	$pdf->Output();


	mysql_close($conn);
?>