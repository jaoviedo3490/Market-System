<?php
include_once('../../capa-datos/conexion.php');
include_once('../receptor.php');
include_once(__DIR__ . '/../../capa-datos/ServiceError.php');
include_once('../../Services/Product-Services/ShowProducts.php');
try{
    if(isset($_POST['Category'])){
        $response = array('StatusCode'=>"","Message"=>"","Categoria"=>array());
        $Service = new showProducts();
        $Categorias = array();
        $Categorias = $Service->getProducts();
        if($Categorias['Success']){
            $response['StatusCode'] = HttpStatusCode::OK;
            $response['Categoria'] = $Categorias['Categorias'];
            echo json_encode($response);
        }else{
            switch($Categorias['Message']){
                case HttpStatusCode::NOT_FOUND:
                    $response['StatusCode'] = HtppStatusCode::NOT_FOUND;
                    $repsonse['Message'] = "No se encontraron productos en el inventario";
                    echo json_encode($response);
                    break;
                case HttpStatusCode::INTERNAL_SERVER_ERROR:
                    $response['StatusCode'] = HtppStatusCode::INTERNAL_SERVER_ERROR;
                    $repsonse['Message'] = $result['Message'];
                    echo json_encode($response);
                    break;
                default:
                    $response['StatusCode'] = HttpStatusCode::BAD_REQUEST;
                    $repsonse['Message'] = "Respuesta erronea del servidor: ";
                    echo json_encode($response);
                break;
            }
            echo json_encode($response);
        }
        
    }else{
        $response['Message'] = "Error al recibir el iniciador";
        echo json_encode($response);
    }

}catch(PDOException $pdo){
    $response['StatusCode'] = HttpStatusCode::INTERNAL_SERVER_ERROR;
    $response['Message'] = "Excepcion encontrada en el controlador: ".$e->getMessage();
    echo json_encode($repsonse);
}catch(Exception $e){
    $response['StatusCode'] = HttpStatusCode::INTERNAL_SERVER_ERROR;
    $response['Message'] = "Excepcion encontrada en el controlador: ".$e->getMessage();
    echo json_encode($repsonse);
}
?>