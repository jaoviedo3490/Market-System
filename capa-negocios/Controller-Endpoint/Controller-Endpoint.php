<?php
header('Access-Control-Allow-Origin: http://localhost'); // Permite solicitudes desde localhost
header('Access-Control-Allow-Methods: POST'); // Métodos permitidos
header('Access-Control-Allow-Headers: Content-Type, Authorization'); // Permitir encabezados específicos
header('Content-Type: application/json');

require_once('../Auth-JWT.php');

if (isset($_POST['json_controller'])) {
    // Intenta decodificar el JSON
    $json_controller = json_decode($_POST['json_controller'], true);
    
    // Comprobar si se produjo un error al decodificar
    if (json_last_error() !== JSON_ERROR_NONE) {
        echo json_encode(["Status" => "error", "Message" => "JSON inválido: " . json_last_error_msg()]);
        exit;
    }

    // Obtener encabezados
    $headers = getallheaders();
    if (!empty($headers['Authorization'])) {
        $tokenKey = "a2!@sdD43f%$w9eDs43nP82!wdkfj3@sd!E";
        $JWTInstance = new Auth_Token($tokenKey);
        
        // Verificar el token
        $resultToken = $JWTInstance->verifyToken($headers['Authorization']);
        
        // Verificar el estado del resultado
        if ($resultToken['Status'] === 'success') {
            echo json_encode(["Status" => "success", "Message" => "Token validado"]);
        } else {
            echo json_encode(["Status" => "error", "Message" => $resultToken['Message']]);
        }
    } else {
        echo json_encode(["Status" => "error", "Message" => "No se proporcionó el token"]);
    }
} else {
    echo json_encode(["Status" => "error", "Message" => "No se envió el json_controller"]);
}
?>
