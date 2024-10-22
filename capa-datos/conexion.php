<?php

class Conexion
{
    protected $servidor = "127.0.0.1";
    protected $base = "market";
    protected $usuario = "root";
    protected $password = ""; // Cambia esto si es necesario
    protected $bd = null;

    public function getBD()
    {
        return $this->bd; // Devolvemos el objeto PDO directamente
    }

    public function __construct()
    {
        try {
            $this->bd = new PDO("mysql:host=$this->servidor;dbname=$this->base;", $this->usuario, $this->password);
            $this->bd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); // Establecemos el modo de error
        } catch (PDOException $ex) {
            error_log("Error de Conexión a la base de datos: " . $ex->getMessage());
            throw new Exception("Error de conexión a la base de datos.");
        }
    }
    public function getConnection(){
        return $this->bd;
    }
}


 
?>
