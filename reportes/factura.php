<?php
	include '../tools/class_fpdf.php';
	include '../common/general.php';
        require_once '../core/DBManagement.php';
        require_once '../core/DBInspector.php';
        require_once '../core/Configurator.php';
        
        
        Configurator::getInstance();
	if (isset($_GET['f']) && isset($_GET['i'])){
        $tipo_fact = $_GET['f'];
        $invoice = $_GET['i'];
        $bill = '';
        $ship = '';
        $date ='';
        $page ='';
        $order ='';
        $rifEmp = '';
        $rifCli = '';
        $imgType = '';
        //$invoice;
        } else {
            header('location: ../');
            exit;
        }
        
        function getPedido($invoice){

            global $ship, $date, $order, $rifEmp;
            $sql = "select b.qty, b.descripcion, b.precio_unit, b.sub_total, a.num_orden,"
                 . " a.fecha_emision, a.cliente_rif, a.empresa_rif, a.sub_total, a.sale_tax,"
                 . " a.discount, a.freight, a.handling, a.restocking, a.total_sale  from pedidos a, detalle_pedido b where a.num_invoice=b.num_invoice"
                    . " and a.num_invoice = '".$invoice."'";
            
            DBManagement::getInstance()->consultar($sql);
            $r = DBManagement::getInstance()->getResultSet();
            
            
            if (is_array($r) && count($r)>0){
                //var_dump($r);
                
                getShip($r[0]['cliente_rif']);
                $date = $r[0]['fecha_emision'];
                $order = $r[0]['num_orden'];
                $rifEmp = $r[0]['empresa_rif'];
                $rifCli = $r[0]['cliente_rif'];
                
                return $r;
                
            } else {
                 header('location: ../');
                 exit;
            }
            
            
        }
        
        
        function getBill($rif) {
            global $bill, $imgType;
            $sql = "select a.RAZON_SOCIAL, a.DIRECCION, a.rif, b.TELEFONO, a.type_logo from empresa a, empresa_telefono b where a.rif=b.rif and a.rif='".$rif."' limit 1";
            DBManagement::getInstance()->consultar($sql);
            $r = DBManagement::getInstance()->getResultSet();
            
            if (is_array($r) && count($r)>0){

                $bill = $r[0]['RAZON_SOCIAL'] . ", " . $r[0]['rif']. "\n"; 
                $bill .= $r[0]['DIRECCION'] . "\n" . $r[0]['TELEFONO']. "\n";
                //echo $r[0]['type_logo'];
                $imgType = strtoupper(explode('/', $r[0]['type_logo'])[1]);
                 //echo $imgType;
                
            } else {
                 header('location: ../');
                 exit;
            }
            
            
        }
        
        function getShip($rif) {
            global $ship;
            $sql = "select a.RAZON_SOCIAL, a.DIRECCION, a.rif, b.TELEFONO from cliente a, cliente_telefono b where a.rif=b.rif and a.rif='".$rif."' limit 1";
            DBManagement::getInstance()->consultar($sql);
            $r = DBManagement::getInstance()->getResultSet();
            
            if (is_array($r) && count($r)>0){
                //var_dump($r);
                
                $ship = ''. $r[0]['RAZON_SOCIAL'] . ", " . $r[0]['rif']. "\t\t"; 
                $ship .= $r[0]['DIRECCION'] . "\t" . $r[0]['TELEFONO']. "";
                
            } else {
                 header('location: ../');
                 exit;
            }
            
        }
        
        
        function getImg($e) {
            
            $sql = "select logo, type_logo from empresa where rif='".$e."'";
    
            DBManagement::getInstance()->consultar($sql);
            $r = DBManagement::getInstance()->getResultSet();

            if (is_array($r) && count($r) > 0){

                //header("Content-type: ".$r[0]['type_logo']);
                echo $r[0]['logo'];


            } else {
                $r = FALSE;
                echo "";
            }

         }
	
	function put_header($pdf,$tipo_fact){
            global $ship, $date, $invoice, $page, $order, $rifEmp, $imgType;
           
		switch($tipo_fact){
			case "A":
				$pdf->Image('http://localhost/facturasdinamicas/tools/readImg.php?e='.$rifEmp,90,5,45,35,$imgType);	
                                //$pdf->MemImage('../tools/readImg.php?e='.$invoice, 50, 30);
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
		$pdf->Multicell(30,5,utf8_decode($date),1,'C',FALSE);
		$pdf->SetXY(115,40);
		$pdf->Multicell(30,5,utf8_decode($page),1,'C',FALSE);
		$pdf->SetXY(145,40);
		$pdf->Multicell(30,5,utf8_decode($order),1,'C',FALSE);
		$pdf->SetXY(175,40);
		$pdf->Multicell(30,5,utf8_decode($invoice),1,'C',FALSE);
		
		$pdf->SetXY(15,50);
                $pdf->SetFont('Arial','B',8);
                $pdf->Multicell(85,4,utf8_decode('BILL TO:'),0,'',FALSE);
                $pdf->SetFont('Arial','',8);
                $pdf->SetXY(15,54);
		$pdf->Multicell(85,4,utf8_decode('' . $ship),0,'',FALSE);
		$pdf->SetXY(120,50);
                $pdf->SetFont('Arial','B',8);
		$pdf->Multicell(85,4,utf8_decode('SHIP TO:'),0,'',FALSE);
                $pdf->SetFont('Arial','',8);
                $pdf->SetXY(120,54);
                $pdf->Multicell(85,4,utf8_decode('' . $ship),0,'',FALSE);
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
	
        
        $result = getPedido($invoice);
        getBill($rifEmp);
        // echo $imgType;
        
	$pdf = new PDF('P','mm','Letter');	
	$pdf->SetMargins(0,0,0,0);
	$pdf->SetAutoPageBreak(false, 0.0);
	$pdf->AddPage();
	$pdf->SetFont('Arial','',8);
	
	put_header($pdf,$tipo_fact);
	put_t_header($pdf);
	
	$x_pos = 15;
	$y_pos = 85;	
	
	$t_items = 100;
	$c_item = 0;
	for($i=0;$i<count($result);$i++){
		
		if($c_item== 35){
			$pdf->AddPage();
			put_header($pdf, $tipo_fact);
			put_t_header($pdf);			
			$y_pos = 85;
			$c_item=0;
		}
		
		$pdf->SetXY($x_pos,$y_pos);
		$pdf->Multicell(10,5,utf8_decode($result[$i]['qty']),1,'',FALSE);
		
		$pdf->SetXY($x_pos + 10,$y_pos);
		$pdf->Multicell(140,5,utf8_decode($result[$i]['descripcion']),1,'C',FALSE);
		
		$pdf->SetXY($x_pos + 150,$y_pos);		
		$pdf->Multicell(20,5,utf8_decode($result[$i]['precio_unit']),1,'C',FALSE);
		
		$pdf->SetXY($x_pos + 170,$y_pos);
		$pdf->Multicell(20,5,utf8_decode($result[$i]['sub_total']),1,'C',FALSE);
		$y_pos += 5;
		$c_item++;
	}
	
	
	
	$pdf->Output();
?>