<?php
	include '../tools/class_fpdf.php';
	include '../../common/general.php';
	

	
	function put_header($pdf,$tipo_fact){
		switch($tipo_fact){
			case "A":
				$pdf->Image('../files/logo.jpg',90,5,45,35,'');	
				$pdf->SetXY(15,10);
				$pdf->Multicell(70,5,utf8_decode('EMPRESA DATA'),'','',FALSE);
				$pdf->SetXY(15,15);
				$pdf->SetFont('Arial','',10);
				$pdf->Multicell(70,5,utf8_decode('EMPRESA DIRECCION'),'','',FALSE);
				$pdf->SetXY(15,20);
				$pdf->SetFont('Arial','',8);
				$pdf->Multicell(70,5,utf8_decode('EMPRESA TELEFONO'),'','',FALSE);
				break;
			case "B":
				$pdf->Image('../files/logo.jpg',155,5,45,35,'');
				$pdf->SetFont('Arial','B',12);
				$pdf->SetXY(15,10);
				$pdf->Multicell(70,5,utf8_decode('EMPRESA DATA'),'','',FALSE);
				$pdf->SetXY(15,15);
				$pdf->SetFont('Arial','',10);
				$pdf->Multicell(70,5,utf8_decode('EMPRESA DIRECCION'),'','',FALSE);
				$pdf->SetXY(15,20);
				$pdf->SetFont('Arial','',8);
				$pdf->Multicell(70,5,utf8_decode('EMPRESA TELEFONO'),'','',FALSE);
				break;
			default:
				$pdf->Image('../files/logo.jpg',15,5,45,35,'');	
				$pdf->SetXY(60,10);
				$pdf->SetFont('Arial','B',12);
				$pdf->Multicell(70,5,utf8_decode('EMPRESA DATA'),'','',FALSE);
				$pdf->SetXY(60,15);
				$pdf->SetFont('Arial','',10);
				$pdf->Multicell(70,5,utf8_decode('EMPRESA DIRECCION'),'','',FALSE);
				$pdf->SetXY(60,20);
				$pdf->SetFont('Arial','',8);
				$pdf->Multicell(70,5,utf8_decode('EMPRESA TELEFONO'),'','',FALSE);
				break;
		}
		
		
		
		$pdf->SetXY(15,35);
		$pdf->SetLineWidth(0.8);
		$pdf->Multicell(70,5,utf8_decode(''),'B','',FALSE);

		$pdf->SetLineWidth(0.1);
		$pdf->SetXY(85,35);
		$pdf->Multicell(30,5,utf8_decode('DATE'),1,'C',FALSE);
		$pdf->SetXY(115,35);
		$pdf->Multicell(30,5,utf8_decode('PAGE'),1,'C',FALSE);
		$pdf->SetXY(145,35);
		$pdf->Multicell(30,5,utf8_decode('ORDER #'),1,'C',FALSE);
		$pdf->SetXY(175,35);
		$pdf->Multicell(30,5,utf8_decode('INVOICE #'),1,'C',FALSE);
		
		$pdf->SetXY(85,40);
		$pdf->Multicell(30,5,utf8_decode(''),1,'C',FALSE);
		$pdf->SetXY(115,40);
		$pdf->Multicell(30,5,utf8_decode(''),1,'C',FALSE);
		$pdf->SetXY(145,40);
		$pdf->Multicell(30,5,utf8_decode(''),1,'C',FALSE);
		$pdf->SetXY(175,40);
		$pdf->Multicell(30,5,utf8_decode(''),1,'C',FALSE);
		
		$pdf->SetXY(15,50);
		$pdf->Multicell(85,20,utf8_decode('BILL TO:'),1,'',FALSE);
		
		$pdf->SetXY(120,50);
		$pdf->Multicell(85,20,utf8_decode('SHIP TO:'),1,'',FALSE);
	}
	
	function put_t_header($pdf){
		$pdf->SetXY(15,80);
		$pdf->Multicell(10,5,utf8_decode('QTY'),1,'',FALSE);
		$pdf->SetXY(25,80);
		$pdf->Multicell(140,5,utf8_decode('Description'),1,'C',FALSE);
		$pdf->SetXY(165,80);
		$pdf->Multicell(20,5,utf8_decode('UnitPrice'),1,'C',FALSE);
		$pdf->SetXY(185,80);
		$pdf->Multicell(20,5,utf8_decode('Total'),1,'C',FALSE);
	}
	
	$pdf = new PDF('P','mm','Letter');	
	$pdf->SetMargins(0,0,0,0);
	$pdf->SetAutoPageBreak(false, 0.0);
	$pdf->AddPage();
	$pdf->SetFont('Arial','',8);
	
	put_header($pdf,"A");
	put_t_header($pdf);
	
	$x_pos = 15;
	$y_pos = 85;	
	
	$t_items = 100;
	$c_item = 0;
	for($i=0;$i<=$t_items;$i++){
		
		if($c_item== 35){
			$pdf->AddPage();
			put_header($pdf);
			put_t_header($pdf);			
			$y_pos = 85;
			$c_item=0;
		}
		
		$pdf->SetXY($x_pos,$y_pos);
		$pdf->Multicell(10,5,utf8_decode(''),1,'',FALSE);
		
		$pdf->SetXY($x_pos + 10,$y_pos);
		$pdf->Multicell(140,5,utf8_decode(''),1,'C',FALSE);
		
		$pdf->SetXY($x_pos + 150,$y_pos);		
		$pdf->Multicell(20,5,utf8_decode(''),1,'C',FALSE);
		
		$pdf->SetXY($x_pos + 170,$y_pos);
		$pdf->Multicell(20,5,utf8_decode(''),1,'C',FALSE);
		$y_pos += 5;
		$c_item++;
	}
	
	
	
	$pdf->Output();
?>