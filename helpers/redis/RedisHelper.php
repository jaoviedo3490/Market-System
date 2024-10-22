<?php
    require_once('C:/xampp/htdocs/Market-System/vendor/autoload.php');
    use Predis\Client;
class Redis{
    private static $response = array("Success" => false, "Message" => "");
    private static $server = '';
    private static $port = '';
    private static $scheme = '';
    private static $client;

  
    public function __construct($server_, $port_, $scheme_){
        self::$server = $server_;
        self::$port = $port_;
        self::$scheme = $scheme_;
    }

    
    public static function ConnectServer(){
        try {
            self::$client = new Client([
                'scheme' => self::$scheme,
                'host'   => self::$server,
                'port'   => self::$port,
                'options' => [
                    'retry_strategy' => function ($times) {
                        if ($times > 1) {
                            return false;
                        }
                        return 100 * pow(2, $times); 
                    },
                ],
            ]);
            self::$client->connect();
            self::$response['Success'] = true;
        } catch (Predis\Connection\ConnectionException $e) {
            self::$response['Message'] = "Error interno, No se pudo conectar a Redis: " . $e->getMessage();
            self::$response['Success'] = false;
        }

        return self::$response;
    }


  
    public static function CreateRedisCustomer($key, $value) {
        try {
         
            if (self::$client === null) {
                throw new Exception("El cliente Redis no se encuentra Inicializado");
            }

       
            if (is_array($value)) {
                $value = json_encode($value);
            }

            self::$client->setex($key, 14000, $value);  // Guardar con tiempo de expiración
            self::$response['Success'] = true;
            self::$response['Message'] = "Cliente Redis creado exitosamente";
        } catch (Exception $e) {
            self::$response['Message'] = "Ocurrió un error al crear el cliente Redis: " . $e->getMessage();
        }
        return self::$response;
    }

    public static function GetRedisCustomer($key) {
        try {
          
            if (self::$client === null) {
                throw new Exception("Cliente Redis no se encuentra Inicializado");
            }

            $value = self::$client->get($key); 

            if ($value !== null) {
                return json_decode($value, true); 
            } else {
                return self::$response['Message'] = "No se encuentra el valor";
            }
        } catch (Exception $e) {
            self::$response['Message'] = "Ocurrió un error al obtener el cliente Redis: " . $e->getMessage();
            return null;
        }
    }

   
    public static function DeleteRedisCustomer($key) {
        try {
           
            if (self::$client === null) {
                throw new Exception("Cliente Redis no se encuentra Inicializado");
            }

            $result = self::$client->del($key);
            if ($result > 0) {
                self::$response['Success'] = true;
                self::$response['Message'] = "Cliente eliminado exitosamente";
            } else {
                self::$response['Message'] = "Error al eliminar el cliente, no se encontró";
            }
        } catch (Exception $e) {
            self::$response['Message'] = "Ocurrió un error al eliminar el cliente Redis: " . $e->getMessage();
        }
        return self::$response;
    }

    public static function existKey($key){
        try{
            if(self::$client===null){
                self::ConnectServer();
            }
            $exists = self::$client->exists($key);
            return $exists===1;
        } catch(Exception $e){
            self::$response['Message'] = "Error al verificar si la clave existe: " . $e->getMessage();
            return false;
        }
    }
}

?>
