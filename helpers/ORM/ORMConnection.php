<?php
//print_r(realpath(__DIR__ . '/../../capa-datos/conexion.php'));
include_once(realpath(__DIR__ . '/../../capa-datos/conexion.php'));
include_once(realpath(__DIR__ . '/../../vendor/autoload.php'));

use RedBeanPHP\R;

class ORMRedBean extends Conexion{
    private $cadena;
    private $user;
    private $contraseña;

    public function __construct(){
        parent::__construct();
        $this->cadena = "mysql:host=".$this->servidor.";dbname=".$this->base.";";
        $this->user = $this->usuario;
        $this->contraseña = $this->password;
    }

    public function ORMInit(){
        $response = array("Success"=>"","Message"=>"");
        try{
             R::setup($this->cadena,$this->user,$this->contraseña);
             if(R::testConnection()){
                $response['Success'] = true;
                $response['Message'] = "Conexion del ORM exitosa";
                //echo json_encode($response);
             }else{
                $response['Success'] = false;
                $response['Message'] = "Conexion fallida del ORM";
                //echo json_encode($response);
             }
        }catch(Exeption $e){
            $response['Success'] = false;
            $response['Message'] = "Excepcion encontrada en la conexion del ORM: ".$e->getMessage();
            error_log("Excpecion encontrada en el metodo ORMInit: ".$e);
            //echo json_encode($response);
        }return $response;
    }
}


    $conex = new ORMRedBean();
    $result = $conex->ORMInit();  
