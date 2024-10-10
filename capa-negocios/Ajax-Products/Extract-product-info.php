<?php
    include('../../capa-datos/conexion.php');
    include('../receptor.php');
    include_once('../../capa-datos/ServiceError.php');
    if(isset($_REQUEST['search'])){
        try{
            $response = array("StatusCode"=>"","Message"=>"","Producto"=>array(),"respuesta"=>"");
            $busqueda = $_REQUEST['search'];
            $data_object = new Productos();
            $dato = array();
            $dato = $data_object->Extract_All_Data_Object($busqueda);
            if($dato['Success']){
                $response['StatusCode'] = HttpStatusCode::OK;
                $response['Message'] = "";
                $response["Producto"] = $dato['Productos'];
                $response['respuesta'] = $_REQUEST['search'];
                echo json_encode($response);
            }else{
                switch($dato['Message']){
                    case HttpStatusCode::NOT_FOUND:
                        $response['StatusCode'] = HtppStatusCode::NOT_FOUND;
                        $repsonse['Message'] = "No se encontraron productos en el inventario";
                        echo json_encode($response);
                        break;
                    case HttpStatusCode::INTERNAL_SERVER_ERROR:
                        $response['StatusCode'] = HtppStatusCode::NOT_FOUND;
                        $repsonse['Message'] = "No se encontraron productos en el inventario";
                        echo json_encode($response);
                        break;
                    default:break;
                }
            }
        }catch(Exception $e){
            error_log("Ocurrio un error en el controlador Extract-Product-Info.php: ". $e->getMessage());
            $repsonse['StatusCode']=HttpStatusCode::INTERNAL_SERVER_ERROR;
            $repsonse['Message'] = HttpStatusCode::getMessage(HttpStatusCode::INTERNAL_SERVER_ERROR) . " - Error: " . $e->getMessage();
            echo json_encode($response);
        }
    }else {
        $response['StatusCode']=HttpStatusCode::BAD_REQUEST;
        $response['Message'] = "Error al recibir los datos";
        echo json_encode($response);
    }
    ?>