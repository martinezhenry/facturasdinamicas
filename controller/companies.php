<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

require_once '../core/DBManagement.php';
require_once '../core/DBInspector.php';
require_once '../core/Configurator.php';
	
	Configurator::getInstance();

function getCompanies($id=NULL){
    if (isset($id)){
   $sql = "select a.rif, b.telefono as tlf, a.direccion as dir, a.razon_social as razon, a.rif as id from empresa a, empresa_telefono b where"
           . " a.rif = b.rif and a.rif = '".$id."' limit 1";
    } else {
        $sql = "select a.rif, b.telefono as tlf, a.direccion as dir, a.razon_social as razon, a.rif as id, max(b.fecha_valor) from empresa a, empresa_telefono b where"
           . " a.rif = b.rif group by a.rif, b.telefono, a.direccion, a.razon_social";
    }

  
   DBManagement::getInstance()->consultar($sql);
   $r = DBManagement::getInstance()->getResultSet();
   
   if (is_array($r) && count($r) > 0){
       
       $r;
       
       
   } else {
       $r = FALSE;
   }

   /*$data[] = array(
       
      // 'num' => 1,
       'razon' => 'Nodnet',
       'dir' => 'boleita',
       'tlf' => '55555555',
       'rif' => 'J-123456789',
       'id' => '1'
     );*/
   
   return json_encode($r);
    
}

function makeLogo($extension) {
    
    return file_get_contents("../files/logo.".$extension);
    
}


function putCompany($company){
    
   $sql = "insert into empresa (rif, razon_social, direccion, logo, type_logo) values ('".$company['rif']."','".$company['razon']."','".$company['dir']."', ?, '".$company['logoType']."')";
   
   $var[] = makeLogo(explode('.', $company['logoExt'])[1]);
   //echo $sql;

   DBManagement::getInstance()->insertar($sql, $var);
   DBManagement::getInstance()->getResultSet();
   
   if(DBManagement::getInstance()->getCountRows() == 1){
       
       $sql = "insert into empresa_telefono (rif, telefono) values ('".$company['rif']."', '".$company['tlf']."')";
        
       DBManagement::getInstance()->insertar($sql);
       DBManagement::getInstance()->getResultSet();
       if(DBManagement::getInstance()->getCountRows() == 1){
           $result['result'] = "EMPRESA CREADA";
       } else {
           
          $result['result'] = "EMPRESA CREADA. PERO NO SE PUDO REGISTRAR EL TELEFONO.";

       }
       
   } else{
       $result['error'] = "NO SE PUEDO REGISTRAR LA EMPRESA.";
   }
       
    return json_encode($result);
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