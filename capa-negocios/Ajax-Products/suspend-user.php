<?php
session_start();
    include('../../capa-datos/conexion.php');
    include('../receptor.php');
    if(!isset($_SESSION['session']))
        header('Location: ../../capa-presentacion/users/user-init.html');
    else {
        if(isset($_POST['trigger___'])){
            $cadena = "UPDATE usuarios set Estado='suspendida' WHERE ID =".$_POST['trigger___'].";";
            $con = new Conexion();
            $datos = ($con->getBD())->query($cadena);
            foreach($datos as $data){
                $this->_ID=$data['ID'];
                $this->_Nombre=$data['Nombre'];
                $this->_Contraseña=$data['Contraseña'];
                $this->_Privilegios=$data['Privilegios'];
            }
            echo json_encode($datos);
        }else{
            echo 'pos no se';
        }
    }
    
    
    
?>