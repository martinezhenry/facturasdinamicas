<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

include '../../common/general.php';
	$obj_function = new coFunction();
	$obj_bdmysql = new coBdmysql();

function putPedido($pedido) {
    
    $mysqli = new mysqli(DBHOST3, DBUSER3, DBPASS3, DBNOM3);
    if (!$mysqli->connect_error){
						$where = "num_invoice= '" . $pedido['num_invoice'] . "'";
						$SQL = "SELECT COUNT(num_invoice) FROM PEDIDOS WHERE " . $where;
						$resul = $mysqli->query($SQL);
						$r = $resul->fetch_array(MYSQLI_ASSOC);
						if($r['COUNT(num_invoice)'] == 0){
							$campo = "num_invoice,num_orden,fecha_emision,cliente_rif,empresa_rif, sub_total, sale_tax, discount, freight, handling, restocking, total_sale";
							$valor = "'" . $pedido['num_invoice'] . "','" . $pedido['num_orden']. "',CURRENT_TIMESTAMP, '".$pedido['cliente_rif']."', '".$pedido['empresa_rif']."', '".$pedido['sub_total']."', '".$pedido['sale_tax']."', '".$pedido['discount']."', '".$pedido['freight']."', '".$pedido['handling']."', '".$pedido['restocking']."', '".$pedido['total_sale']."'";					
							$cliente_insert = $obj_bdmysql->insert("PEDIDOS", $campo, $valor, $mysqli);
							if($cliente_insert == 1){
                                                            
								$campo = "num_invoice,qty, descripcion,  precio_unit,  sub_total";						
                                                                
                                                                foreach ($pedido['detalle'] as $detalle) {
                                                                    
                                                                
								$valor = "'" . $detalle['num_invoice'] . "','" . $detalle['qty']. "', '".$detalle['descripcion']."', '".$detalle['precio_unit']."', '".$detalle['sub_total']."'";
								$cliente_insert = $obj_bdmysql->insert("DETALLE_PEDIDO", $campo, $valor, $mysqli);
								if($cliente_insert == 1){							
									$aResult['result'] = "PEDIDO CREADO";					
								}else{
									$aResult['error'] = "PEDIDO CREADO CON EXITO PERO, EL DETALLE NO FUE AGREGADO";
								}
                                                                }
							}else{
								$aResult['error'] = "CREACION DE PEDIDO FALLIDA!";
							}
						}else{
							$aResult['error'] = "PEDIDO EXISTENTE!";
						}
							
					}else{ $aResult['error'] = "NO SE PUDO CONECTAR A LA BASE DE DATOS!"; }
    
    
}