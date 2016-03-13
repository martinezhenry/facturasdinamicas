<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

function getCompanies($id=NULL){
    
   $sql = "";

   $data[] = array(
       
       'num' => 1,
       'razon' => 'Nodnet',
       'dir' => 'boleita',
       'tlf' => '55555555',
       'rif' => 'J-123456789',
       'id' => '1'
       
   );
   
   return json_encode($data);
    
}


function putCompany($id=NULL){
    
   $sql = "";
   
 
   
   return json_decode(true);
    
}


function editCompany($company){
    
   $sql = "";
   
 
   
   return json_decode(true);
    
}


function deleteCompany($id=NULL){
    
   $sql = "";
   
 
   
   return json_decode(true);
    
}



if (isset($_POST)){
$method = $_POST['method'];
if (isset($_POST['parameters'])){
	$parameters = $_POST['parameters'];
	foreach ($parameters as $key => $value) {
		$p[] = $value;
	}

	echo call_user_func_array($method, $p);

} else {
	echo ($method());
}
}