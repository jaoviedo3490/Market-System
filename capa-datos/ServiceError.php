<?php



class HttpStatusCode{
    public const OK = 200;
    public const CREATED = 201;
    public const NOT_CONTENT = 204;
    public const BAD_REQUEST = 400;
    public const UNAUTHORIZED = 401;
    public const FORBBIDEN = 403;
    public const NOT_FOUND = 404;
    public const INTERNAL_SERVER_ERROR = 500;
    public const NOT_IMPLEMENTED = 501;


    public static function getMessage(int $code){
        switch($code){
            case self::OK: return "Ok";
            case self::CREATED: return "Creado con Exito";
            case self::NOT_CONTENT: return "Sin Contenido";
            case self::BAD_REQUEST: return "Respuesta Incorrecta";
            case self::UNAUTHORIZED: return "No Autorizado";
            case self::FORBBIDEN: return "Olvidado";
            case self::NOT_FOUND: return "No Encontrado";
            case self::INTERNAL_SERVER_ERROR: return "Error Interno del Servidor";
            case self::NOT_IMPLEMENTED: return "No Implementado";
        }
    }
}
?>