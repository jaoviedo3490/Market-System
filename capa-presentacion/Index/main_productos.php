<?php
include_once('../../capa-negocios/receptor.php');
include_once('../../capa-datos/conexion.php');
include_once('../../helpers/redis/RedisHelper.php');
include_once('../../capa-datos/ServiceError.php');
include_once('../../Services/Application-Services/internal_petition.php');

if (!isset($_COOKIE['auth_token']))
    header('Location: ../../index.php');

$jquery = "";
function InyectionJS($message,$button,$title,$route,$type){
    switch ($type) {
        case 1:
            return "<script>".
            "Swal.fire({".
                "title: '".$title."',".
                "text: '".$message."',".
                "icon: '".$button."',".
                "confirmButtonText: 'Aceptar'".
                "})"."</script>";
                break;
        case 2:
            return "<script>".
            "Swal.fire({".
                "title: '".$title."',".
                "text: '".$message."',".
                "icon: '".$button."',".
                "confirmButtonText: 'Aceptar'".
                "}).then(function(){".
                    "RenewCrentials()});".
                "</script>";
            break;
        default:break;
            }
            
    }
try{
    $jquery = '';
    $redis = new Redis("127.0.0.1",6379,'tcp');
            $server = $redis::ConnectServer();
         
            if($server['Success']){
                //print_r($redis::existKey("User-Info"));
                if(!$redis::existKey("User-Info")){
                    $jquery = InyectionJS("Datos obtenidos de Redis corruptos o servicio inestable , inicie sesion nuevamente para corregir el problea","warning","Importante","../../index.php",2);
                }else{
                    $Priv = $redis::GetRedisCustomer('User-Info');
                }
                
            }else{
                print_r("aqui es donde entra en juego los tokens , dando persintencia a la aplicacion si redis falla");
               $jquery = InyectionJS("El servidor redis no responde , ejecutando sistema de persintencia de tokens , espere un momento","error","Importante","../../index.php",1);
            }


    
    
    $consulta = new Productos();
    $array_Productos = array();
    $array_Productos = $consulta->Extract_All_Data_Object_();
    $url = "http://localhost/Market-System/capa-negocios/Ajax-Products/Extract-Products.php";
    $data =array("trigger"=>"trigger");
    $httpPost = new internalPetitionPost($url,$data);
  
    switch ($array_Productos['Message']) {
        case HttpStatusCode::NOT_FOUND;
            $product_not_found = '<br><h3 id="header-" class="display-3">Sin productos registrados</h3>';
            $consol_data = array("StatusCode"=>$array_Productos['Message'],"Message"=>"Productos no encontrados");
            echo "<script>console.log(".json_encode($consol_data).")</script>";
            break;
        case HttpStatusCode::OK: 
            $consol_data = array("StatusCode"=>$array_Productos['Message'],"Message"=>"Productos consultados con exito");
            echo "<script>console.log(".json_encode($consol_data).")</script>";
            break;
        default:
            $consol_data = array("StatusCode"=>$array_Productos['Message'],"Message"=>"Error en la solicitud - Codigo Interno del error: ");
            echo "<script>console.log(".json_encode($consol_data).")</script>";
            break;
    }
}catch(Exception $e){
    $jquery = InyectionJS($e->getMessage(),"error","Excepción encontrada","");
     error_log("Ocurrio un error al procesar la informacion - Error: ".$e->getMessage());
}
?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=EDGE">
    <script src='../../jquery/jquery.js'></script>
    <link rel="stylesheet" href="../../bootstrap.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
    <script  src="../../sweetalert/sweetalert.min.js"></script>
    <script type='module' src="../Script/app.js"></script>
    <script type='module' src='../Script/main.js'></script>
    <script src='../Script/Widgets/modal.js'></script>
    
</head>
<header class="bg-primary"><?php

echo '<script src="../../sweetalert/sweetalert.min.js"></script>';
echo '<script type="module" src="../Script/main.js"></script>'; // Este es tu archivo JavaScript principal.

                            if(!empty($jquery) || !$redis::existKey("User-Info")){
                                //$jquery = InyectionJS("Las variables en Redis han sido eliminadas, inicie sesion nuevamente para renovar las credenciales","error","Importante","../../index.php");
                                echo $jquery;
                            }
                        ?>
    <div class="container">
        <nav class="navbar">
            <div class="row">
                <div class="col" style="margin-bottom:-6%;">
                    <h4 class="display-6" style="font-family:sans-serif;text-decoration:none;color:white;"><a onClick="to_User_Route()" href="#" style="color:white;text-decoration:none;"><?= @$Priv['user_info']['Privilegios'] ?></a></h4>
                </div>

            </div>
        </nav>
        <nav class="navbar-auto">
            <div class="row">
                <div class="col p-auto">
                    <a href="#" id="opciones" style="color:white;text-decoration:none;">
                        <select id="options" name="opciones" class="btn btn-primary">
                            <option selected id='selected-option' hidden>Mas Opciones</option>
                            <option value="Crear-Producto" id="new-product">Crear Producto</option>
                            <option value="Editar/Eliminar-Products" id="update-product">Editar/Eliminar Producto</option>
                            <option value="Buscar palabra clave" id="search">Buscar palabra Clave</option>
                        </select></a>

                </div>
                <div class="col">
                    <a href="Management_Accounts/main_accounts.php" style="color:white;text-decoration:none;">Administrar Cuentas</a>
                </div>
                <div class="col">
                    <a href="#" id="caja" style="color:white;text-decoration:none;">Caja</a>
                </div>
                <div class="col">
                    <a href="#" id='perfil' style="color:white;text-decoration:none;">Mi Perfil</a>
                </div>
                <div class="col">
                    <a href="javascript:void(0)" onClick="closed_session()" style="color:white;text-decoration:none;">Cerrar Sesion</a>
                </div>
            </div>
        </nav>
        <hr>
    </div>
</header>
<div class="container-fluid" id="c">
    <div class="row">
        <div class='container'>
            <div class='row'>
                <div class='col'>
                    <h4>Editar / Eliminar Producto</h4>
                    <form id='search-form' hidden>
                        <input class='form-control' type='search' id='ñ' placeholder='Buscar Palabra Clave'>
                    </form>
                </div>
            </div>
        </div>
        <div class='container-fluid'>
            <div class='row'>
                <div class='col'>
                </div>
            </div>
        </div>
    </div>
</div>
<div class='container' id='bar-search'>
    <div class='row'>
        <div class='col'>
            <form>
                <input class='form form-control' type='search' id='busqueda' placeholder='Ingresa una palabra clave'>
            </form>
        </div>
    </div>
</div>
<div class="container" id='content-content'>
    <div class="row"><script>
        

        

$("#delete-product").on('click', function () {
        const productId = $(this).closest('tr').data('id');
        alert("desde onclick producto "+productId);
        delete_prod(productId);
    });
$("#Edit-Product").on("click",function(){
    const productId = $(this.closest('tr').data('id'));
    edit_product();
})

    $("#caja").click(function () {
        location.href = '../cash-process/main_cash.html';
    });

    $("#busqueda").keypress(function (event) {
        if (event.keyCode == 32) {
            location = 'main_productos.php';
        } else {
            $("#busqueda").keyup(function () {
               
                let search = $("#busqueda").val();
                if (search == '') {
                    //alert("aqui 3")
                    searchProduct(search,true);
                } else {
                    searchProduct(search);
                }
            });
        }
    });

    </script>
        <div class="col">
            <?php
            if (empty($array_Productos['Productos'])) echo @$product_not_found;
            else {

                echo "<br><br><table class='table table-bordered'>";
                //echo "<thead>";
                echo "<tr class='table-active'>";
                echo "<th class='col-sm-2'>ID</th>";
                echo "<th class='col-sm-2'>Nombre</th>";
                echo "<th class='col-sm-2'>Categorias</th>";
                echo "<th class='col-sm-2'>Acciónes</th>";
                echo "</tr>";
                echo "<thead>";
                echo "</table>";
                $contador = 0;
                echo "<table class='table table-hover table-bordered' table-striped>";
                foreach ($array_Productos['Productos'] as $dato) {
                    echo "<tr id='tabla'>";
                    foreach ($dato as $dat) {
                        echo "<td class='col-sm-2' id='tabla'>" . $dat . "</td>";
                    }
                    echo "<td class='col-sm-2' data-value='" . @$array_Productos['Productos'][$contador]['ID'] . "'><a style='margin-right:5px;'><img style='width:20%;heigth:20%;' id='Edit-Product' onclick='edit_product(".$array_Productos['Productos'][$contador]['ID'].")' src='../../resources/editar.png'/></a><img style='width:20%;heigth:20%;' id='delete-prod' onclick='delete_prod(".$array_Productos['Productos'][$contador]['ID'].")' src='../../resources/delete.png'/></td></tr>"; //delete_prod(".$array_Productos['Productos'][$contador]['ID'].")
                    $contador++;
                }
                echo "</table>";
            }
            ?>
        </div>
    </div>
</div>

<body>
    <footer id="elements-count" style='width:100%'>
    <script src='../Script/Widgets/slice.js'></script>
      <script> widget("All_object", "elements-count");
        </script>  
    </footer>
</body>

</html>