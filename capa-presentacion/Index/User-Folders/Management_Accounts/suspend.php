<?php
    include('../../../capa-datos/conexion.php');
    include('../../../capa-negocios/receptor.php');

    $dato = new Usuarios();
    if(isset($_POST['trigger_'])){
        $array = array();
        $array = $dato->extract_all_suspend_users();
        echo json_encode($array);
    }else echo "Error al crear el objeto";

    

?>