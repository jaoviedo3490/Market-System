<?php
include_once('../../capa-datos/ServiceError.php');
include('../../Services/User-Services/User-Authenticate.php');
include_once('../../helpers/redis/RedisHelper.php');

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST, GET, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");
header('Content-Type: application/json');


$response = array("StatusCode" => HttpStatusCode::BAD_REQUEST, "Message" => "¡Error al recibir los datos!");
//print_r($_POST);

$redis = new Redis("127.0.0.1",6379,"tcp");
$redis_connect = $redis->ConnectServer();
if($redis_connect['Success']){
    if (isset($_POST['nombre']) && isset($_POST['contraseña'])) {

        try {
            $Usuario = trim($_POST['nombre']);
            $Contraseña = trim($_POST['contraseña']);
            
            $authService = new Authenticate();
            $status_Operation = $authService->Authenticate($Usuario, $Contraseña);
    
            if ($status_Operation['Success']) {
                $response["StatusCode"] = HttpStatusCode::OK;
                $response["Message"] = "Autenticacion exitosa.";
                echo json_encode($response);
            } else {
                switch ($status_Operation['Message']) {
                    case "No Encontrado":
                        $response["StatusCode"] = HttpStatusCode::NOT_FOUND;
                        $response["Message"] = "Usuario no encontrado, verifique la existencia de la cuenta.";
                        echo json_encode($response);
                        break;
                    case "Contraseña incorrecta":
                        $response["StatusCode"] = HttpStatusCode::UNAUTHORIZED;
                        $response["Message"] = "Contraseña Incorrecta.";
                        echo json_encode($response);
                        break;
                    case "Usuario inactivo":
                        $response["StatusCode"] = HttpStatusCode::UNAUTHORIZED;
                        $response["Message"] = "Usuario Inactivo";
                        echo json_encode($response);
                        break;
                    case "SERVER_REDIS_NOT_RESPONSE":
                        $response["StatusCode"] = HttpStatusCode::INTERNAL_SERVER_ERROR;
                        $response["Message"] = "Error al conectar con el servidor Redis";//HttpStatusCode::getMessage(HttpStatusCode::INTERNAL_SERVER_ERROR) . " - Error: " ;
                        echo json_encode($response);
                        break;
                    case "COOKIE_NOT_CREATED":
                        $response['StatusCode'] = HttpStatusCode::INTERNAL_SERVER_ERROR;
                        $response['Message'] = "Error al crear la galleta , no te quieren bro ._.";
                        echo json_encode($response);
                        break;
                    default:
                        //print_r($status_Operation['Message']);
                        $response["StatusCode"] = HttpStatusCode::BAD_REQUEST;
                        $response["Message"] = "Error en la solicitud - respuesta del servidor erronea: ";
                        echo json_encode($response);
                        break;
                }
            }
        } catch (Exception $e) {
            $response["StatusCode"] = HttpStatusCode::INTERNAL_SERVER_ERROR;
            $response["Message"] = HttpStatusCode::getMessage(HttpStatusCode::INTERNAL_SERVER_ERROR) . " - Error: " . $e->getMessage();
            echo json_encode($response);
            error_log("Ocurrio un error en el controlador Init-Sesion.php: ".$e->getMessage());
        }
    }else{
        $response = array("StatusCode" => HttpStatusCode::BAD_REQUEST, "Message" => "¡Error al recibir los datos!");
        echo json_encode($response);
    }
}else{
    $response["StatusCode"] = HttpStatusCode::INTERNAL_SERVER_ERROR;
    $response["Message"] = "Error al conectar con el servidor Redis";
    echo json_encode($response);
}


?>
