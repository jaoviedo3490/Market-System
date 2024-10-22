<?php

header('Access-Control-Allow-Origin: http//localhost'); // Permite solicitudes desde cualquier origen
header('Access-Control-Allow-Methods: POST, GET, OPTIONS'); // Métodos permitidos
header('Access-Control-Allow-Headers: Content-Type');
header('Content-Type: application/json');

function InyectionJS($message,$button,$title,$route){
    return "<script>".
                "Swal.fire({".
                    "title: '".$title."',".
                    "text: '".$message."',".
                    "icon: '".$button."',".
                    "confirmButtonText: 'Aceptar'".
                    "}).then(function(){".
                        "RenewCrentials()});".
                    "</script>";
}
include_once('../capa-datos/ServiceError.php');
include_once('../helpers/redis/RedisHelper.php');
  
    $response = array("StatusCode"=>"","Message"=>"");

        try{
                if(isset($_COOKIE['auth_token']) && !empty($_COOKIE['auth_token'])){
                    if(isset($_POST['delete'])){
                        switch($_POST['delete']){
                            case 1:
                                if(setcookie('auth_token',"",time()-3600,"/")){
                                    $response['StatusCode'] = HttpStatusCode::OK;
                                    $response['Message'] = "Sesion cerrada correctamente";
                                    echo json_encode($response);
                                }else{
                                    $response['StatusCode'] = HttpStatusCode::FORBBIDEN;
                                    $response['Message'] = "No se pudo eliminar las Cookies";
                                    echo json_encode($response);
                                }
                                
                                break;
                            case 2:
                                try{
                                    $jquery = '';
                                    $redis = new Redis("127.0.0.1",6379,'tcp');
                                            $server = $redis::ConnectServer();
                                            //print_r($server['Success']);
                                            if($server['Success']){
                                                if($redis::DeleteRedisCustomer('User-Info')){
                                                    $response['StatusCode'] = HttpStatusCode::OK;
                                                    $response['Message'] = "Sesion cerrada correctamente";
                                                    echo json_encode($response);
                                                }else{
                                                    $response['StatusCode'] = HttpStatusCode::INTERNAL_SERVER_ERROR;
                                                    $response['Message'] = "El servidor redis , no response";
                                                    echo json_encode($response);
                                                }
                                            }else{
                                                    $response['StatusCode'] = HttpStatusCode::NOT_IMPLEMENTED;
                                                    $response['Message'] = $server['Message'];
                                                    echo json_encode($response);
                                            }
                                        }catch(Exception $e){
                                            $response['StatusCode'] = HttpStatusCode::INTERNAL_SERVER_ERROR;
                                            $response['Message'] = "Ocurrio un error : ".$e->getMessage();
                                            echo json_encode($response);
                                            }
                                    break;
                                    default:
                                    $response['StatusCode'] = HttpStatusCode::BAD_REQUEST;
                                    $response['Message'] = "Opción no válida";
                                    echo json_encode($response);
                                    break;

                                }
                }else if(!isset($_COOKIE['auth_token'])){
                    $response['StatusCode'] = HttpStatusCode::UNAUTHORIZED;
                    $response['Message'] = "Error al validar el toker de sesion!!";
                    echo json_encode($response);
                }
            }else{
                echo "Error al validar la sesion";
            }
        }catch(Exception $e){
            $response['StatusCode'] = HttpStatusCode::INTERNAL_SERVER_ERROR;
            $response['Message'] = "Ocurrio un error : ".$e->getMessage();
            echo json_encode($response);
        }
    
?>