<?php

include_once('../../capa-negocios/receptor.php');
include_once('../../capa-datos/conexion.php');
include_once('../../capa-datos/ServiceError.php');
require_once('../../helpers/redis/RedisHelper.php');


if(!isset($_COOKIE['auth_token'])){
    header("Location: ../../../../capa-negocios/closed_session.php");
}else{
    $redis = new Redis("127.0.0.1",6379,'tcp');
    //var_dump($redis::existKey("User-Info"));
            $server = $redis::ConnectServer();
            if($server['Success']){
                $Priv = $redis::GetRedisCustomer('User-Info');
                if(!$redis::existKey("User-Info")){
                    $jquery = InyectionJS("Datos obtenidos de Redis corruptos o servicio inestable , inicie sesion nuevamente para corregir el problea","warning","Importante","../../index.php");
                }else{
                    if(isset($_GET['product'])){
                        $productos = $_GET['product'];
                        $array = array();
                        $consulta = new Productos();
                        @$array = $consulta->Extract_All_Data_Object_by_Category($_GET['product']);
                    }else{
                        $productos = "Productos para el hogar";
                    }
                   
                    //print_r($_GET['product']);
                }

            }else{
               $jquery = InyectionJS("El servidor redis , no responde","error","Importante","../../../../capa-negocios/closed_session.php");
            }
}

?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=EDGE">
    <script src="../../jquery/jquery.js"></script>
    <link rel="stylesheet" href="../../bootstrap.css">
    <script type="module" src="../Script/app.js">
    </script>
    <script type="module" src="../Script/main.js">
    </script>
    <script src="../../sweetalert/sweetalert.min.js">
    </script>
</head>

<body>
    <header class="bg-info">
        <div class="container">
            <nav class="navbar">
                <div class="row">
                    <div class="col" style="margin-bottom:-6%;">
                        <h4 class="display-6" id='categoria' style="font-family:sans-serif;text-decoration:none;color:white;"><?= $productos ?> para el Hogar</h4>
                    </div>

                </div>
            </nav>
            <hr>
        </div>
    </header>

    <footer>
        <div class="container-fluid">
            <div class="row">
                <div class="col">
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col">
                                <div class="container-fluid">
                                    <div class="row">
                                        <?php
                                        if (empty($array['Productos']) || !isset($_GET['product'])) echo "<h4 class='display-4' style='margin:5%;margin-left:15%;'>Sin Productos Registrados</h1><br><a style='margin-left:12%' href='#' onCLick='to_User_Route()'>Menu Principal</a>";
                                        else {
                                            foreach ($array['Productos'] as $dato) {
                                                //print_r($dato);
                                              
                                                echo "<div class='col' style='margin-top:2%'>";
                                                echo "<div class='card' style='width: 18rem;'>";
                                                echo "<img class='card-img-top'  src='../../resources/Limpieza.webp'  alt='Card image cap'>";
                                                echo "<div class='card-body'>";
                                                echo "<h5 id='Nombre' class='card-title'>".$dato['Nombre']."</h5>";
                                                echo "<button href='#' class='btn btn-outline-success' id='objeto' onClick='Extract_product_info(".$dato['ID'].",10)' style='margin-bottom:2%;width:100%'>Ver Detalles</button>";
                                                echo "</div>";
                                                echo "</div>";
                                                echo "</div>";
                                              
                                            }
                                        } ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <?php
                if (!empty($array['Productos'])) {
                    echo "<div class='col'>";
                    echo "<div class='container-fluid border border-dark rounded w-75' style='width:110%;heigth:150%;'>";
                    echo "<h5>Detalles del Producto</h5><br>";
                    echo "<h6>Nombre del Producto:</h6><p id='nombre-producto'></p>";
                    echo "<h6>Referencia del Producto:</h6><p id='referencia-producto'></p>";
                    echo "<h6>Precio del Producto: </h6><p id='precio-producto'></p>";
                    echo "<h6>Categoria del Producto: </h6><p id='categoria-producto'></p>";
                    echo "<h6>Unidades Disponibles: </h6><p id='stock-producto'></p>";
                    echo "<h6>Unidades Vendidas:</h6><p id='vendidas-producto'></p>";
                    echo "</div>";
                    echo "<p>";
                    echo "<a style='margin-left:12%' href='#' onCLick='to_User_Route()'>Menu Principal</a>";
                    echo "</p>";
                    echo "</div>";
                }
                ?>
            </div>
        </div>

    </footer>
</body>

</html>