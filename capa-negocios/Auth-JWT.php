
<?php

header("Access-Control-Allow-Origin: *");
include_once('C:/xampp/htdocs/Market-System/capa-datos/ServiceError.php');
require('C:/xampp/htdocs/Market-System/vendor/autoload.php');
use \Firebase\JWT\JWT;

    class Auth_Token{
        private $SecretKey;
        private $Algorithm;

        public function __construct($secretKey,$algorithm = 'HS256'){
            $this->SecretKey = $secretKey;
            $this->Algorithm = $algorithm;
        }


        public function GenerateToken($data){
            try{

                $payload = $data;
                return JWT::encode($payload,$this->SecretKey,$this->Algorithm);
                
            }catch(Exception $e){
                return [
                    "Status" => 'Error',
                    "Message"=> $e->getMessage()
                ];
            }
        }

        public function verifyToken($header){
            if(preg_match('/Bearer\s(\S+)/',$header,$matches)){

                $token = $matches[1];
                try{
                    $decoded = JWT::decode($token,$this->SecretKey,[$this->Algorithm]);
                        return [
                            "Status" => 'success', 
                            "Message" => "Token válido",
                        ];
                    
                    
                }catch(Exception $e){
                    return[
                        "Status"=>'error',//HttpStatusCode::OK,
                        "Message"=>"Token Invalido - ".$e->getMessage(),
                    ];
                }
            }else{
                return [
                    'Status'=>'error',
                    'Message'=>'Token no proporcionado'
                ];
            }
        }
    }
