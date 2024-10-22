<?php
include_once('../../capa-datos/ServiceError.php');
include('../../Services/User-Services/User-Authenticate.php');
include_once('../../helpers/redis/RedisHelper.php');

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST, GET, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");
header('Content-Type: application/json');

$response = array("StatusCode"=>"","Message"=>"");
//print_r($_POST['active']);
try{
    if(isset($_POST['Active'])){
        $Active = htmlspecialchars(trim($_POST['Active']));
            $Controller = new Usuarios();
            $result = $Controller->Active_User($Active);
            //print_r($result);
            if($result['Success']){
                switch($result['Message']){
                    case HttpStatusCode::OK:
                        $response['StatusCode'] = $result['Message'];
                        $response['Message'] = "Operacion completada exitosamente";
                        echo json_encode($response);
                        break;
                    case HttpStatusCode::NOT_FOUND:
                        $response['StatusCode'] = $result['Message'];
                        $response['Message'] = "Usuario no encontrado";
                        echo json_encode($response);
                        break;
                    default:
                        $response['StatusCode'] = HttpStatusCode::BAD_REQUEST;
                        $response['Message'] = "Respuesta erronea del servidor".$result['Message'];;
                        echo json_encode($response);
                    break;
                }
            }else{
                switch($result['Message']){
                    case HttpStatusCode::INTERNAL_SERVER_ERROR:
                        $response['StatusCode'] = $result['Message'];
                        $response['Message'] = "Error interno del servidor: ";
                        echo json_encode($response);
                        break;
                    ///case HttpStatusCode::BAD_REQUEST:break;
                    default:
                        $response['StatusCode'] = HttpStatusCode::BAD_REQUEST;
                        $response['Message'] = "Respuesta erronea del servidor".$result['Message'];;
                        echo json_encode($response);
                    break;
                }
            }
    }else{
        $response['StatusCode'] = HttpStatusCode::BAD_REQUEST;
        $response['Message'] = "Error al recibir los datos";
        echo json_encode($response);
    }
}catch(Exception $e){
    $response['StatusCode'] = HttpStatusCode::INTERNAL_SERVER_ERROR;
    $response['Message'] = "Error interno del servidor: ".$e->getMessage();
    echo json_encode($response);
    error_log("Excepcion encontrada en el Controlador: ".$e);
}



?>