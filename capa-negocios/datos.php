<?php
include('backend.php');
    session_start();
    if(!isset($_SESSION['session'])){
        header('Location: ../index.php');
    }else{
        if(isset($_SESSION['name'])&&
            isset($_SESSION['id'])&&
                isset($_SESSION['priv'])){
                    $cuerpo  ="</nav></div></header>";
                    $cuerpo .= "<div class='container'>";
                    $cuerpo .="<h2 style='margin:7%;'>Error al Acceder a los permisos del usuario</h2><a href='../index.php'>Inicio</a>";
                    $cuerpo .="</div>";
                    echo $cuerpo; 
                }else{
                    header("Location: ../capa-presentacion/index/main.php");
                }
        
    }
?>