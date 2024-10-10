<?php
    include('../receptor.php');
    include('../../capa-datos/conexion.php');
    if(isset($_REQUEST['Nombre'])&&isset($_REQUEST['Referencia'])
        &&isset($_REQUEST['Precio'])&&isset($_REQUEST['Stock'])&&isset($_REQUEST['Categoria'])){
        $Nombre_Product = $_REQUEST['Nombre'];
        $Referencia_Product = $_REQUEST['Referencia'];
        $Precio_Product = $_REQUEST['Precio'];
        $Stock_Product = $_REQUEST['Stock'];
        $Categoria = $_REQUEST['Categoria'];
        $create_obj = new Productos();
        $create_obj->Create_Product_SQL($Nombre_Product,$Precio_Product,$Referencia_Product,$Stock_Product,"",0,$Categoria);
                echo "La Operacion fue un Exito";
    }else{
        echo "¡Error al recibir los datos! ";
    }
    
?>