<?php
include_once('../../capa-datos/ServiceError.php');
require_once('../../helpers/redis/RedisHelper.php');

header('Access-Control-Allow-Origin: *'); // Permite solicitudes desde cualquier origen
header('Access-Control-Allow-Methods: POST, GET, OPTIONS'); // Métodos permitidos
header('Access-Control-Allow-Headers: Content-Type');
header('Content-Type: application/json');

//phpinfo();

$redis = new Redis("127.0.0.1",6379,"tcp");
$responseRedis = $redis::ConnectServer();
if($responseRedis['Success']!=false){
  
    if($redis::existKey("User-Info")){
        if (!isset($_COOKIE['auth_token'])) {
            
            $response = array("StatusCode" => HttpStatusCode::UNAUTHORIZED, "Message" => "Error al validar los datos de la sesion");
            echo json_encode($response);
            
            //print_r($response);
            exit();
        } else if(isset($_COOKIE['auth_token'])){
            
            $response = array("StatusCode" => HttpStatusCode::OK);
            $json_redis = $redis::GetRedisCustomer('User-Info');
           
                switch ($json_redis['user_info']['Privilegios']) {
                    case "Administrador":
                        $response['RedirectURL'] = "http://localhost/Market-System/capa-presentacion/Index/User-Folders/Manager/main.php";
                        break;
                    case "empleado":
                        $response['RedirectURL'] = "http://localhost/Market-System/capa-presentacion/Index/User-Folders/Employee/main.php";
                        break;
                    default:
                        $response['RedirectURL'] = "../../capa-negocios/closed_session.php";
                        break;
                }
                echo json_encode($response);
                exit();
        }else{
            echo json_encode(array("StatusCode" => HttpStatusCode::INTERNAL_SERVER_ERROR, "Message" => "Error al valdar los datos en la sesion"));
        }
    }
        
}else{
    $response['StatusCode'] = HttpStatusCode::INTERNAL_SERVER_ERROR;
    $response['Message'] = $responseRedis['Message'];
    echo json_encode($response);
}



?>
