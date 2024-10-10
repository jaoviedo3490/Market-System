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
           
            $response['StatusCode'] = HttpStatusCode::OK;
            $response['Message'] = "Operacion Exitosa";
            $response['Productos'] = $dato['Productos'];
            echo json_encode($response);
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

    //echo json_encode($response);
?>