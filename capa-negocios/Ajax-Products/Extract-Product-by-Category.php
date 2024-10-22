<?php
include_once('../../capa-datos/conexion.php');
include_once('../receptor.php');
include_once(__DIR__ . '/../../capa-datos/ServiceError.php');
include_once('../../Services/Product-Services/ShowProducts.php');
    try{
        $response = array("StatusCode"=>"","Message"=>"","Productos"=>array());
        if(isset($_GET['product'])){
            $categoria = htmlspecialchars(trim($_GET['product']));
            print_r($categoria);
            $result = new Productos();
            $Producto = $result->Extract_All_Data_Object_by_Category($categoria);
            if($Producto['Success']){
                switch($Producto['Message']){
                    case HttpStatusCode::OK:
                            $response['StatusCode'] = $Producto['Message'];
                            $response['Message'] = "Operacion exitosa";
                            $response['Productos'] = $Producto['Productos'];
                            echo json_encode($response);
                        break;
                    case HttpStatusCode::NOT_FOUND:
                            $response['StatusCode'] = $response['Message'];
                            $response['Message'] = "No se encontraron registros";
                            echo json_encode($response);
                        break;
                    default:
                            $response['StatusCode'] = HttpStatusCode::BAD_REQUEST;
                            $response['Message'] = "Respuesta erronea del servidor: ".$Producto['Message'];
                            echo json_encode($response);
                        break;
                }
            }else{
                switch($Producto['Message']){
                    case HttpStatusCode::INTERNAL_SERVER_ERROR:
                        $response['StatusCode'] = $Producto['Message'];
                        $response['Message'] = "Error interno del servidor";
                        echo json_encode($response);
                        break;
                    default:
                        $response['StatusCode'] = HttpStatusCode::BAD_REQUEST;
                        $response['Message'] = "Respuesta erronea del servidor: ".$Producto['Message'];
                        echo json_encode($response);
                    break;
                }
            }
        }else{
            $response['StatusCode'] = HttpStatusCode::BAD_REQUEST;
            $response['Message'] = "Error al recibir los datos";  
            echo json_encode($response);
        }
    }catch(Excepcion $e){
        $response['StatusCode'] = HttpStatusCode::INTERNAL_SERVER_ERROR;
        $response['Message'] = "Error interno del servidor - Error: ".$e->getMessage();
        echo json_encode($response);
    }
    
    
    
?>