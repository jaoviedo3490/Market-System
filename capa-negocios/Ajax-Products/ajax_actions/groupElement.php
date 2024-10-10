<?php
include('../../../capa-datos/conexion.php');
include('../../receptor.php');
include_once('../../../capa-datos/ServiceError.php');


try {
    if (isset($_REQUEST['action'])) {
        $action = $_REQUEST['action'];
        $data_object = new Productos();
        $response_service = $data_object->CountData($action);

        if ($response_service['Success']) {
            // Si se encontró el recurso, pero no tiene datos significativos
            if (empty($response_service['Cantidad'])) {
                http_response_code(HttpStatusCode::OK); // 200 OK
                $response = array("StatusCode" => HttpStatusCode::OK, "Message" => "Operación exitosa, pero no se encontraron productos.");
            } else {
                http_response_code(HttpStatusCode::OK); // 200 OK
                $response = array("StatusCode" => HttpStatusCode::OK, "Message" => "Operación exitosa","cantidad"=>$response_service['Cantidad']);
            }
        } else {
            http_response_code(HttpStatusCode::NOT_FOUND); // 404 Not Found
            $response = array("StatusCode" => HttpStatusCode::NOT_FOUND, "Message" => $response_service['Message']);
        }
    } else {
        http_response_code(HttpStatusCode::BAD_REQUEST); // 400 Bad Request
        $response = array("StatusCode" => HttpStatusCode::BAD_REQUEST, "Message" => "Error al recibir los datos");
    }
} catch (Exception $e) {
    http_response_code(HttpStatusCode::INTERNAL_SERVER_ERROR); // 500 Internal Server Error
    $response = array("StatusCode" => HttpStatusCode::INTERNAL_SERVER_ERROR, "Message" => "Error interno del servidor - Error: " . $e->getMessage());
}

echo json_encode($response);
?>
