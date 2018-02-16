<?php 
namespace ProyectoInterconectividad\API;

require_once 'vendor/autoload.php';
require_once 'authorizationexception.php';

use Lcobucci\JWT\Parser;
use Lcobucci\JWT\ValidationData;
use Lcobucci\JWT\Signer\Hmac\Sha256;

use ProyectoInterconectividad\API\AuthorizationException;

class APIServer {
	private $token;
	private $error;
	private $success;
	
    private $errors = array("0" => "Debe autenticarse para usar el servicio",
	                        "1" => "Cabecera de Autorización no válida",
							"2" => "Token JWT no válido");
							
	private $secret = 'secret';
	
	function __construct() {
		$this->token = '';
		$this->error = '';
	}
	
	public function solicitarAutenticacion() {
		header('WWW-Authenticate: Bearer realm="EdalmavaUFPSO"');
		header('HTTP/1.0 401 Unauthorized');
		echo $this->errorJSON($this->errors['0']);		
	}
	
	private function errorJSON($msg) {
		return json_encode(array('ERROR' => $msg));
	}
	
	public function getError() {
		return $this->error;
	}
	
	public function getMsgError() {
		return $this->errorJSON($this->errors[$this->error]);
	}
	
	public function getToken() {
		return $this->token;		
	}
	
	private function verificarFormatHeaderAuth() {		
		$cab_auth = explode(" ", $_SERVER["HTTP_AUTHORIZATION"], 2);
		if (count($cab_auth) == 2 && strcasecmp($cab_auth[0], "Bearer") == 0) {			
			$this->token = $cab_auth[1];
			if ($this->validarToken()) return true;			
		} else {
			throw new \Exception($this->errors['1']);			
		}		
	}
	
	public function verificarHeaderAuth() {
		if (!empty($_SERVER["HTTP_AUTHORIZATION"])) {
			return $this->verificarFormatHeaderAuth();
		} else {
            throw new AuthorizationException($this->errors['0']);
		}
	}
	
	public function validarToken() {
		if (!empty($this->token)) {
		    $signer = new Sha256();
			$token = (new Parser())->parse((string) $this->token);
			$data = new ValidationData();
			if ($token->validate($data) && $token->verify($signer, $this->secret)) {				
				return true;
			} else {
				throw new \Exception($this->errors['2']);				
			}
		}
	}
}