<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
session_start();
require_once '../core/DBManagement.php';
require_once '../core/DBInspector.php';
require_once '../core/Configurator.php';

/* para quickboks */
require_once('../quickbooks/config.php');
require_once(PATH_SDK_ROOT . 'Core/ServiceContext.php');
require_once(PATH_SDK_ROOT . 'DataService/DataService.php');
require_once(PATH_SDK_ROOT . 'PlatformService/PlatformService.php');
require_once(PATH_SDK_ROOT . 'Utility/Configuration/ConfigurationManager.php');

	
	Configurator::getInstance();

function getCustomersQBO($id=NULL){
    if (isset($id) && $id != ""){
      
        $sql = "SELECT * FROM Customer";

    } else {

        $sql = "SELECT * FROM Customer";
    
    }

  //Specify QBO or QBD
$serviceType = IntuitServicesType::QBO;

// Get App Config
$realmId = ConfigurationManager::AppSettings('RealmID');
if (!$realmId)
  exit("Please add realm to App.Config before running this sample.\n");

$token = unserialize($_SESSION['token']);

// Prep Service Context
$requestValidator = new OAuthRequestValidator($token['oauth_token'],
                                              $token['oauth_token_secret'],
                                              ConfigurationManager::AppSettings('ConsumerKey'),
                                              ConfigurationManager::AppSettings('ConsumerSecret'));
$serviceContext = new ServiceContext($realmId, $serviceType, $requestValidator);
if (!$serviceContext)
  exit("Problem while initializing ServiceContext.\n");

//var_dump ($serviceContext);

// Prep Data Services
$dataService = new DataService($serviceContext);
if (!$dataService)
  exit("Problem while initializing DataService.\n");

//var_dump ($dataService);
// Run a query
$entities = $dataService->Query($sql);

// Echo some formatted output
$i = 0;

return json_encode($entities);

  
}

function makeLogo($extension) {
    
    return file_get_contents("../files/logo.".$extension);
    
}


function putCompany($company){
    
    
    $sql = "select count(rif) as r from empresa where rif='".$company['rif']."'";
    DBManagement::getInstance()->consultar($sql);
    $r = DBManagement::getInstance()->getResultSet();

    if ($r[0]['r'] == 0){
    
   $sql = "insert into empresa (rif, razon_social, direccion, logo, type_logo) values ('".$company['rif']."','".$company['razon']."','".$company['dir']."', ?, '".$company['logoType']."')";
   
   $var[] = makeLogo(explode('.', $company['logoExt'])[1]);


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
       $result['error'] = "NO SE PUDO REGISTRAR LA EMPRESA.";
   }
       
    
    
    } else {
        $result['error'] = "LA EMPRESA YA SE ENCUENTRA REGISTRADA.";
        
    }
    
    return json_encode($result);
}


function editCompany($company){
    
    
    $valores = "razon_social = '".$company['razon']."', direccion='".$company['dir']."', logo= ?, type_logo='".$company['logoType']."'";
    $rif = $company['rif'];
    $sql = "update empresa set $valores where rif = '".$rif."'";
    
   //$sql = "insert into empresa (rif, razon_social, direccion, logo, type_logo) values ('".$company['rif']."','".$company['razon']."','".$company['dir']."', ?, '".$company['logoType']."')";

   $var[] = makeLogo(explode('.', $company['logoExt'])[1]);


   DBManagement::getInstance()->insertar($sql, $var);
   //var_dump(DBManagement::getInstance()->getUltError());
   
   
   if(DBManagement::getInstance()->getCountRows() == 1){
       
      
           $result['result'] = "EMPRESA ACTUALIZADA";
     
       
   } else{
       $result['error'] = "NO SE PUDO ACTUALIZAR LA EMPRESA.";
   }
       
    
  
    
    return json_encode($result);
    
}


function deleteCompany($id=NULL){
    
    $sql = "delete from empresa where rif='".$id."'";
  

   DBManagement::getInstance()->insertar($sql);
   DBManagement::getInstance()->getResultSet();
   
   if(DBManagement::getInstance()->getCountRows() == 1){
           $sql = "delete from empresa_telefono where rif='".$id."'";
            DBManagement::getInstance()->insertar($sql);
   
       $result['result'] = 'EMPRESA ELIMINADA.';
   } else{
       $result['error'] = "NO SE PUDO ELIMINAR LA EMPRESA.";
   }
       
    return json_encode($result);
    
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