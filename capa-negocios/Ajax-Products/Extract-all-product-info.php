<?php
include('../receptor.php');
include_once('../../capa-datos/conexion.php');
include_once(__DIR__ . '/../../capa-datos/ServiceError.php');
    try{
        $response = array("StatusCode"=>"","Message"=>"","Producto"=>array());
        //print_r($_REQUEST);
        
        if(isset($_POST['Producto'])){

            $producto = htmlspecialchars(trim($_POST['Producto']));
            $create_object = new Productos();
            $result = $create_object->Extract_All_Data_Object_Unit($producto );
            //echo json_encode($result);
            if($result['Success']){
               $response['StatusCode'] = HttpStatusCode::OK;
               $response['Message'] = "Operacion exitosa";
               $response['Producto'] = $result['Productos'];
               echo json_encode($response); 
            }else{
                switch($result['Message']){
                    case  HttpStatusCode::getMessage(500):
                        $response['StatusCode'] = $result['Message'];
                        $response['Message'] = "Error interno del servidor";
                        echo json_encode($response);
                        break;
                    case  HttpStatusCode::getMessage(404):
                        $response['StatusCode'] = $result['Message'];
                        $response['Message'] = "No se encontraron elementos";
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