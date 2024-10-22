<?php
include('../receptor.php');
include_once('../../capa-datos/conexion.php');
include_once(__DIR__ . '/../../capa-datos/ServiceError.php');
    try{
        $response = array("StatusCode"=>"","Message"=>"","Repetidos"=>array());
        //print_r($_REQUEST);
        //$datos = json_decode(file_get_contents('php://input'),true);
        if(isset($_POST['Producto'])){
            //print_r($_POST['Producto']);
            //print_r(json_decode(htmlspecialchars(trim($_POST['Producto']))));

            $producto = json_decode(trim($_POST['Producto']),true);

            //$producto = $datos;
            if(json_last_error() != JSON_ERROR_NONE){
                //print_r(json_last_error_msg());
                $response['StatusCode'] = HttpStatusCode::BAD_REQUEST;
                $response['Message'] = "Error al procesar el json de la peticion: ".json_last_error_msg();
                echo json_encode($response);
            }
            $create_object = new Productos();
            $result = $create_object->Update_Product($producto['id'] , $producto['Productos']);
            //print_r($producto['id']);
            //print_r($result);
            if($result['Success']){
               $response['StatusCode'] = HttpStatusCode::OK;
               $response['Message'] = "Operacion exitosa";
              // $response['Producto'] = $result['Productos'];
               echo json_encode($response); 
            }else{
                switch($result['Message']){
                    case  HttpStatusCode::INTERNAL_SERVER_ERROR:
                        $response['StatusCode'] = $result['Message'];
                        $response['Message'] = "Error interno del servidor";
                        echo json_encode($response);
                        break;
                    case  HttpStatusCode::NOT_FOUND:
                        $response['StatusCode'] = $result['Message'];
                        $response['Message'] = "No se encontraron elementos";
                        echo json_encode($response);
                        break;
                    case HttpStatusCode::FORBBIDEN:
                        $response['StatusCode'] = $result['Message'];
                        $response['Message'] = "Algunos campos ya existen en la base de datos en otros registros";
                        $response['Repetidos'] = $result['Producto_Repetido'];
                        echo json_encode($response);
                        break;
                    default:
                        $response['StatusCode'] = HttpStatusCode::BAD_REQUEST;
                        $response['Message'] = "Error en la solicitud";
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
    }
?>