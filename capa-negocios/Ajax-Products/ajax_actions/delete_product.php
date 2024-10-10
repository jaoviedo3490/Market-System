<?php
    include('../../../capa-datos/conexion.php');
    include('../../receptor.php');
    include_once('../../../capa-datos/ServiceError.php');
    $response = array("StatusCode"=>"","Message"=>"");
    try{

        if(isset($_REQUEST['id'])){
            $id = $_REQUEST['id'];
            $data_object = new Productos();
            $dato = array();
            $dato = $data_object->Delete_Product_SQL($id);
            if($dato['Success']){
                $response['StatusCode'] = HttpStatusCode::OK;
                $response['Message'] = "Operacion exitosa";
            }else{
                $response['StatusCode'] = HttpStatusCode::BAD_REQUEST;
                $response['Message'] = "Ocurrio un error al intentar eliminar el producto";
            }
        }else json_encode("Error al recibir los datos");
    }catch(Exception $e){
        $response["StatusCode"] = HttpStatusCode::INTERNAL_SERVER_ERROR;
        $response['Message'] = "Error interno del servidor - Error : ".$e->getMessage();
    }
echo json_encode($response);
    ?>