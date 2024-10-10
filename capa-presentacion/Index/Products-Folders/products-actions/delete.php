<?php
    session_start();
    if(!isset($_SESSION['session']))
        header('Location: ../../../index.php');
        include('../../../capa-datos/conexion.php');

    $cadena = "DELETE FROM productos WHERE ID =".$_GET['var'].";";
    $con = new Conexion();
    $datos = ($con->getBD())->query($cadena);
    $datos == false ? header('Location: ../main_productos.php') : header('Location: ../main_productos.php');
?>