<?php


    require_once('../../../../Services/Application-Services/functions.php');
    require_once('../../../../helpers/redis/RedisHelper.php');
    require_once('../../../../Services/Product-Services/ShowProducts.php');
    require_once('../../../../Services/Application-Services/internal_petition.php');
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
        <script src="../../../../jquery/jquery.js"></script>
        <link rel="stylesheet" href="../../../../bootstrap.css">
        <script type='module' src="../../../Script/app.js">
        </script>
        <script src="../../../../sweetalert/sweetalert.min.js"></script>
        <script type='module' src='../../../Script/main.js'></script>
    </head>
    <body>
        <header class="bg-primary"><?php
                            if(!empty($jquery) || !$redis::existKey("User-Info")){
                                $jquery = InyectionJS("Las variables en Redis han sido eliminadas, inicie sesion nuevamente para renovar las credenciales","error","Importante","../../index.php");
                                echo $jquery;
                            }
                        ?>
            <div class="container">
                <nav class="navbar">
                    <div class="row">
                        <div class="col" style="margin-bottom:-6%;">
                            <h4 class="display-6" style="font-family:sans-serif;text-decoration:none;color:white;"><a href="main.php" style="color:white;text-decoration:none;"><?=$Priv['user_info']['Privilegios']?></a></h4>
                        </div>

                    </div>           
                </nav>
                <nav class="navbar-auto">
                    <div class="row">
                        <div  class="col p-auto">
                            <a href="#" id="opciones" style="color:white;text-decoration:none; ">
                            <select id="options" name="opciones" class="btn btn-primary">
                                <option selected hidden>Mas Opciones</option>
                                <option value="Crear-Producto" id="new-product">Crear Producto</option>
                                <option value="Editar/Eliminar-Products" id="update-product">Editar/Eliminar Producto</option>
                                <option value="Buscar palabra clave" id="search">Buscar palabra Clave</option>
                            </select></a>
                            
                        </div>
                        <div class="col">
                            <a href="Management_Accounts/main_accounts.php" style="color:white;text-decoration:none;">Administrar Cuentas</a>
                        </div>
                        <div  class="col">
                            <a href="#"  id='caja' style="color:white;text-decoration:none;">Caja</a>
                        </div>
                        <div  class="col">
                            <a href="#"  id='perfilo' style="color:white;text-decoration:none;">Mi Perfil</a>
                        </div>
                        <div class="col">
                            <a href="../../capa-negocios/closed_session.php" style="color:white;text-decoration:none;">Cerrar Sesion</a>
                        </div>
                    </div>
                </nav>
                <hr>
            </div>
        </header>
        <div class="container-fluid" id="c">
            <?php
                $data = array("Category"=>1);
                $url = "http://localhost/Market-System/capa-negocios/Ajax-Products/Extract-Category.php";          
                $httpPost = new internalPetitionPost($url,$data);
                $Categorias = $httpPost->sendPost();
                //print_r($Categorias);
            
                switch($Categorias['StatusCode']){
                    case 400: echo GenericAlert("Error","No llegaron los datos mi papacho","warning","Importante");break;
                    case 500: echo GenericAlert("Error","Error interno del servidor","warning","Importante");break;
                    default: echo GenericAlert("Error","No se espero haberte ayudado","warning","Importante");break;
                    
                }
            
                echo "<div class='container-fluid'><h4>Categorias</h1></div><div class='row'>";
                //print_r(json_encode($Categorias));
                foreach($Categorias['Categoria'] as $dato){
              
                        echo '
                        <div class="col-auto">
                            <div class="card" style="width: 18rem; margin:2px;">
                                <img class="card-img-top" src="../../../../resources/Limpieza.webp" alt="Card image cap">
                                <div class="card-body">
                                    <h5 class="card-title">'.$dato['Nombre'].'</h5>
                                    <p class="card-text"></p>
                                    <a href="../../producto.php?product='.$dato['Nombre'].'" class="btn btn-outline-info" style="width:100%">Ver Productos</a>
                                </div>
                            </div>
                    </div>';
                }echo "</div>";
            ?>
            
        </div>
    </body>
</html>