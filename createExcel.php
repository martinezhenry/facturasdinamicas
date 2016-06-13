<?php

/** Error reporting */





error_reporting(E_ALL);
ini_set('display_errors', TRUE);
ini_set('display_startup_errors', TRUE);
date_default_timezone_set('America/Caracas');

define('EOL',(PHP_SAPI == 'cli') ? PHP_EOL : '<br />');



if (!isset($_POST['lines']) || !is_array($_POST['lines'])){
	header('location: ./?pag=accepted');

} else {

$lines = $_POST['lines'];
/** Include PHPExcel */
require_once dirname(__FILE__) . '/PHPExcel/Classes/PHPExcel.php';


// Create new PHPExcel object
//echo date('H:i:s') , " Create new PHPExcel object" , EOL;
$objPHPExcel = new PHPExcel();

// Set document properties
//echo date('H:i:s') , " Set document properties" , EOL;
$objPHPExcel->getProperties()->setCreator("Maarten Balliauw")
							 ->setLastModifiedBy("Maarten Balliauw")
							 ->setTitle("PHPExcel Test Document")
							 ->setSubject("PHPExcel Test Document")
							 ->setDescription("Test document for PHPExcel, generated using PHP classes.")
							 ->setKeywords("office PHPExcel php")
							 ->setCategory("Test result file");


// Add some data
//echo date('H:i:s') , " Add some data" , EOL;
$i = 1;

$objPHPExcel->setActiveSheetIndex(0)
	            ->setCellValue('A'.$i, 'Qty')
	            ->setCellValue('B'.$i, 'nroPart')
	            ->setCellValue('C'.$i, 'Description')
	            ->setCellValue('D'.$i, 'Price');

foreach ($lines as $key => $value) {
	# code...

$i++;
//var_dump(count($lines));
	if (strcmp($value['DetailType'], "SalesItemLineDetail") == 0){
		//var_dump($value['SalesItemLineDetail']);
		$objPHPExcel->setActiveSheetIndex(0)
	            ->setCellValue('A'.$i, $value['SalesItemLineDetail']['Qty'])
	           // ->setCellValue('B'.$i, $value['nroPart'])
	             ->setCellValue('B'.$i, '')
	            ->setCellValue('C'.$i, $value['Description'])
	            ->setCellValue('D'.$i, $value['SalesItemLineDetail']['UnitPrice']);
	}
}
/*
// Miscellaneous glyphs, UTF-8
$objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('A4', 'Miscellaneous glyphs')
            ->setCellValue('A5', 'éàèùâêîôûëïüÿäöüç');


$objPHPExcel->getActiveSheet()->setCellValue('A8',"Hello\nWorld");
$objPHPExcel->getActiveSheet()->getRowDimension(8)->setRowHeight(-1);
$objPHPExcel->getActiveSheet()->getStyle('A8')->getAlignment()->setWrapText(true);
*/

// Rename worksheet
//echo date('H:i:s') , " Rename worksheet" , EOL;
$objPHPExcel->getActiveSheet()->setTitle('Sheet1');


// Set active sheet index to the first sheet, so Excel opens this as the first sheet
$objPHPExcel->setActiveSheetIndex(0);


// Save Excel 2007 file
//echo date('H:i:s') , " Write to Excel2007 format" , EOL;
$callStartTime = microtime(true);

$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
$objWriter->save('files/productsQBO.xlsx');
$callEndTime = microtime(true);
$callTime = $callEndTime - $callStartTime;
echo json_encode(TRUE);
//echo date('H:i:s') , " File written to " , str_replace('.php', '.xlsx', pathinfo(__FILE__, PATHINFO_BASENAME)) , EOL;
//echo 'Call time to write Workbook was ' , sprintf('%.4f',$callTime) , " seconds" , EOL;
// Echo memory usage
//echo date('H:i:s') , ' Current memory usage: ' , (memory_get_usage(true) / 1024 / 1024) , " MB" , EOL;


// Save Excel 95 file
//echo date('H:i:s') , " Write to Excel5 format" , EOL;
/*$callStartTime = microtime(true);

$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
$objWriter->save(str_replace('.php', '.xls', __FILE__));
$callEndTime = microtime(true);
$callTime = $callEndTime - $callStartTime;

echo date('H:i:s') , " File written to " , str_replace('.php', '.xls', pathinfo(__FILE__, PATHINFO_BASENAME)) , EOL;
echo 'Call time to write Workbook was ' , sprintf('%.4f',$callTime) , " seconds" , EOL;
// Echo memory usage
echo date('H:i:s') , ' Current memory usage: ' , (memory_get_usage(true) / 1024 / 1024) , " MB" , EOL;


// Echo memory peak usage
echo date('H:i:s') , " Peak memory usage: " , (memory_get_peak_usage(true) / 1024 / 1024) , " MB" , EOL;

// Echo done
echo date('H:i:s') , " Done writing files" , EOL;
echo 'Files have been created in ' , getcwd() , EOL;
*/
}