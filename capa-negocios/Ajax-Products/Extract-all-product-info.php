<?php
include('../receptor.php');
include('../../capa-datos/conexion.php');
    if(isset($_POST['Producto'])){
        $producto = $_POST['Producto'];
        $create_object = new Productos();
        echo json_encode($create_object->Extract_All_Data_Object_Unit($producto ));
    }else{ echo 'Datos incorrectos';}
?>