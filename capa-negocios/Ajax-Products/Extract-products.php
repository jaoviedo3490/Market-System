<?php
    include('../../capa-datos/conexion.php');
    include('../receptor.php');
    include_once('../../capa-datos/ServiceError.php');
    $response = array("StatusCode"=>HttpStatusCode::OK,"Message"=>"","Productos"=>array());

    try{
        if(isset($_POST['trigger'])){
            $data_object = new Productos();
            $dato = array();
            $dato = $data_object->Extract_All_Data_Object_();
            //print_r($dato);
            if($dato['Success']){
                switch($dato['Message']){
                    case HttpStatusCode::OK:
                        $response['StatusCode'] = $dato['Message'];
                        $response['Message'] = "Operacion Exitosa";
                        $response['Productos'] = $dato['Productos'];
                        echo json_encode($response);
                        break;
                    case HttpStatusCode::NOT_FOUND:
                        $response['StatusCode'] = $dato['Message'];
                        $response['Message'] = "No se encontraron registros";
                        echo json_encode($response);
                        break;
                    default:
                        $response['StatusCode'] = HttpStatusCode::BAD_REQUEST;
                        $response['Message'] = "Respuesta erronea del servidor: ".$dato['Message'];
                        echo json_encode($response);
                    break;
                }
            }else{
                switch($dato['Message']){
                    case HttpStatusCode::INTERNAL_SERVER_ERROR:
                        $response['StatusCode'] = $dato['Message'];
                        $response['Message'] = "Error interno del servidor";
                        echo json_encode($response);
                        break;
                    default:
                        $response['StatusCode'] = $dato['Message'];
                        $response['Message'] =  "Respuesta erronea del servidor: ".$dato['Message'];
                        echo json_encode($response);
                    break;
                }
            }
        }else{
            $response['StatusCode']=HttpStatusCode::BAD_REQUEST;
            $response['Message'] = "Error al recibir los datos";
            echo json_encode($response);
        }
    }catch(Exception $e){
        $response['StatusCode'] = HttpStatusCode::INTERNAL_SERVER_ERROR;
        $response['Message'] = "Error interno del servidor - Error: ".$e->getMessage();
        echo json_encode($response);
    }
?>