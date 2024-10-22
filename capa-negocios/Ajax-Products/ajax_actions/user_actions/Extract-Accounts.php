<?php
    include_once('../../../../capa-datos/conexion.php');
    include('../../../receptor.php');
    include_once('../../../../capa-datos/ServiceError.php');
    $response = array("StatusCode"=>"","Message"=>"","Cuentas"=>array());
    try{

        if(isset($_POST['Estado'])){

            $data_object = new Usuarios();
            $dato = array();
            $Estado = htmlspecialchars(trim($_POST['Estado']));
            $dato = $data_object->extract_all_users_by_status($Estado);
            if($dato['Success']){
               switch($dato['Message']){
                    case HttpStatusCode::OK:
                        $response['StatusCode'] = HttpStatusCode::OK;
                        $response['Message'] = "Operacion exitosa";
                        $response['Cuentas'] = $dato['Usuarios'];
                        echo json_encode($response);
                        break;
                    case HttpStatusCode::NOT_FOUND:
                        $response['StatusCode'] = HttpStatusCode::OK;
                        $response['Message'] = "No se encontraron cuentas";
                        //$response['Cuentas'] = $dato['Usuarios'];
                        echo json_encode($response);
                        break;
                    default:
                        $response['StatusCode'] = $dato['Message']." desde el back";
                        $response['Message'] = "";
                        //$response['Cuentas'] = $dato['Usuarios'];
                        echo json_encode($response);
                    break;
               }
            }else{
                switch($dato['Message']){
                    case HttpStatusCode::INTERNAL_SERVER_ERROR:
                        $response['StatusCode']= HttpStatusCode::getMessage(HttpStatusCode::INTERNAL_SERVER_ERROR);
                        $response['Message'] = "Error al recibir los datos";
                        echo json_encode($response);
                        break;
                    default:
                        $response['StatusCode']= HttpStatusCode::getMessage(HttpStatusCode::FORBBIDEN);
                        $response['Message'] = "Prohibido!";
                        echo json_encode($response);
                    break;
                }
            }
        }else{
            $response['StatusCode']= HttpStatusCode::BAD_REQUEST;
            $response['Message'] = "Error al recibir los datos";
            echo json_encode($response);

        }
    }catch(Exception $e){
        $response["StatusCode"] = HttpStatusCode::INTERNAL_SERVER_ERROR;
        $response['Message'] = "Error interno del servidor - Error : ".$e->getMessage();
        echo json_encode($response);
    }
        
?>