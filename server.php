<?php 
require_once 'apiserver.php';

use ProyectoInterconectividad\API\APIServer;

header('Content-Type: application/json; charset=UTF-8');
date_default_timezone_set('America/Bogota');
setlocale(LC_ALL, "es_CO@COP", "es_CO", "esp");

try {
    $api = new APIServer();
    if ($api->verificarHeaderAuth()) {	
		echo json_encode("OK...");		 
    } 
} catch(Exception $e) {
	echo json_encode(array("ERROR" => $e->getMessage()));
	exit;
} catch(AuthorizationException $e) {
	$api->solicitarAutenticacion();
	exit;
}