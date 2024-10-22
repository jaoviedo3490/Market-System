<?php

//include(__DIR__ . '/../../capa-negocios/receptor.php');
include_once(__DIR__ . '/../../capa-datos/ServiceError.php');

//echo "Pession ID: " . session_id();
header("Access-Control-Allow-Origin: *");


class showProducts{
    private $productModel;

    public function __construct(){
        $this->productModel = new Productos();
    }
    
    public function getProducts(){
        $response = array("Success" => false, "Message" => "","Categorias"=>array());
       
        try{
            $category = array();
            $category = $this->productModel->Extract_AllCategory();
            
            switch($category['Success']){
                case 0:
                 
                    switch($category['Message']){
                        case HttpStatusCode::INTERNAL_SERVER_ERROR;
                            $response['Message'] = HttpStatusCode::INTERNAL_SERVER_ERROR;
                            //echo json_encode($response);
                            break;
                        default:
                            $response["Message"] = HttpStatusCode::BAD_REQUEST;
                            //echo json_encode($response);
                        break;
                    }
                    break;
                case 1:
                    switch($category['Message']){
                        case HttpStatusCode::OK:
                            $response['Message'] = HttpStatusCode::OK;
                            $response['Success'] = true;
                            $response['Categorias'] = $category['Categoria'];
                            //echo json_encode($response);
                    break;
                default:
                    $response["StatusCode"] = HttpStatusCode::BAD_REQUEST;
                    $response['Message'] = "Respuesta incorrecta";
                    //echo json_encode($response);
                break;
            }
            
        }
        }catch(Exception $e){
            echo "chi... chinga tu madre";
            echo json_encode($response);
        }return $response;
    }
}
?>