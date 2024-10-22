<?php
//echo "Pession ID: " . session_id();
header("Access-Control-Allow-Origin: *");

require('C:/xampp/htdocs/Market-System/vendor/autoload.php'); 
require('../../capa-negocios/Auth-JWT.php');
include('../../capa-negocios/receptor.php');
include_once('../../capa-datos/ServiceError.php');
require_once('../../helpers/redis/RedisHelper.php');


use \Firebase\JWT\JWT;
class Authenticate{
    private $userModel;
    private $tokenModel;

    public function __construct(){
        $this->userModel = new Usuarios();
        $this->tokenModel = new Token();
    }

    public function Authenticate($usuario, $contraseña) {
        $Message = "";
        try {
            $response = array("Success" => false, "Message" => "");
            $user = array(); 
    
         
            if (empty($usuario) || empty($contraseña)) {
                $response['Message'] = "Usuario o contraseñas vacíos!";
                return $response;
            }
    
       
            $user = $this->userModel->Extract_User_SQL($usuario);
            if ($user['Message'] == HttpStatusCode::OK) {
    
                if($user['Usuario']['Estado']!="Activa"){
                    $response['Message'] = "Usuario inactivo";

                }else if ($user['Usuario']['Contraseña'] == $contraseña) {
                    $response['Message'] = HttpStatusCode::getMessage(HttpStatusCode::OK);
                    $response['Success'] = true;
    
                    $userID = $user['Usuario']['ID'];
                    $user_role = $user['Usuario']['Privilegios'];
    
                   
                    $secretKey = 'a2!@sdD43f%$w9eDs43nP82!wdkfj3@sd!E';
                    $jwt_model = new Auth_Token($secretKey);
                    $issuedAt = time();
                    $expiration = $issuedAt + 3600;
                    $payload = [
                        'iss'=>"http://localhost",
                        'iat'=>$issuedAt,
                        'exp'=>$expiration,
                        'user'=>$userID,
                        'priv'=>$user_role
                    ];
                    $token = $jwt_model->GenerateToken($payload);
    
                    
                    $createdAt = date('Y-m-d H:i:s');
                    $expiresAt = date('Y-m-d H:i:s', strtotime('+1 hour'));

                    $tokenDB = $this->tokenModel->CreateBDToken($userID, $token,$expiresAt,$createdAt,$user_role);
    
                    if ($tokenDB['Success']) {
                         $redis = new Redis("127.0.0.1",6379,'tcp');
                         $result = $redis::ConnectServer();
                         
                         $redis_info = array("user_info"=>array("User-ID"=>$userID,"Nombre"=>$user['Usuario']['Nombre'],
                            "Contrasena"=>$user['Usuario']['Contraseña'],
                                "Privilegios"=>$user['Usuario']['Privilegios']));

                        if($result['Success']){
                            $redis::CreateRedisCustomer("User-Info",json_encode($redis_info));
                            if(!setcookie("auth_token", $token, time() + 14000, '/', '', false, true)){
                                $response['StatusCode'] = HttpStatusCode::BAD_REQUEST;
                                $response['Message'] = "COOKIE_NOT_CREATED";
                            }setcookie("auth_token", $token, time() + 14000, '/', '', false, true);
                        }else{
                            $response['StatusCode'] = HttpStatusCode::INTERNAL_SERVER_ERROR;
                            $response['Message'] = "SERVER_REDIS_NOT_RESPONSE";
                        }
                        
                    } else {
                        $response['Message'] = "Error al crear el Token en la base de datos";
                        error_log($response['Message']);
                    }
                } else {
                    $Message = "Contraseña incorrecta";
                    $response['Message'] = $Message;
                }
    
            } else if ($user['Message'] == HttpStatusCode::NOT_FOUND) {
                $Message = HttpStatusCode::getMessage(HttpStatusCode::NOT_FOUND);
                $response['Message'] = $Message;
            }
    
        } catch (Exception $e) {
            $response['Message'] = HttpStatusCode::getMessage(HttpStatusCode::INTERNAL_SERVER_ERROR) . " - Error: " . $e->getMessage();
        }
    
        return $response;
    }
    

}