<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
//VISTA DE ERRORES
//error_reporting(E_ALL);
//ini_set('display_errors','1');

//VALIDA SESSION
/**if(basename($_SERVER['PHP_SELF']) != 'start_sesion.php'){
    session_start();
    
    if (isset($_SESSION['valida_sesion'])){
        if($_SESSION["valida_sesion"]!=1){ header("location:/cat/common/stop_sesion.php"); }
    }else{ header("location:/cat/common/stop_sesion.php"); }
}*/
//CONSTANTES
define('FOOTER_DES', 'GADMIN');
define('EXP_REG_RGB', "/^rgb\(\s{0,1}[0-9]{0,3},\s{0,1}[0-9]{0,3},\s{0,1}[0-9]{0,3}\)/");
define('CANT_ART_PDF', '200');
//BD
define('DBHOST', '108.167.143.137'); 
define('DBUSER', 'v1131055_cat_us'); 
define('DBPASS', 'Clave123'); 
define('DBNOM', 'v1131055_cat');
//BD2
define('DBHOST2', '50.196.74.121');
define('DBUSER2', 'vzla');
define('DBPASS2', 'vzla5740tex');
define('DBNOM2', 'autodatasystem');
//BD3
/*define('DBHOST3', '108.167.143.137'); 
define('DBUSER3', 'v1131055_inv001'); 
define('DBPASS3', 'lW5Oa7NP0#$}'); 
define('DBNOM3', 'v1131055_invoices');
*/
define('DBHOST3', 'mysql.hostinger.es'); 
define('DBUSER3', 'u429736889_factu'); 
define('DBPASS3', 'facturas@'); 
define('DBNOM3', 'u429736889_factu');

//INCLUDES
//
//CONEXION BD
include 'bdMysql.php';
//FUNCIONES AUX
include 'function.php';
//ARCHIVOS COMUNES
include 'common.php';