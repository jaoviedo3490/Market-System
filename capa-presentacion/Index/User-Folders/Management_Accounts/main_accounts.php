<?php
    if(!isset($_COOKIE['auth_token']))
        header('Location: ../../index.php');
        require_once('../../../../Services/Application-Services/functions.php');
        require_once('../../../../helpers/redis/RedisHelper.php');
        require_once('../../../../Services/Product-Services/ShowProducts.php');
        require_once('../../../../Services/Application-Services/internal_petition.php');
        include_once('../../../../capa-negocios/receptor.php');
        include_once('../../../../capa-datos/conexion.php');
        
        $Url = "http://localhost/Market-System/capa-negocios/Ajax-Products/ajax_actions/user_actions/Extract-Accounts.php";
        $Data = array("Estado"=>"Activa");
        $PostPetition = new internalPetitionPost($Url, $Data);
        $array_Accounts = $PostPetition->sendPost();
        //print_r($array_Accounts);
        switch ($array_Accounts['StatusCode']) {
            case HttpStatusCode::NOT_FOUND:
                $product_not_found = '<br><h3 id="header-" class="display-3">Sin productos registrados</h3>';
                $consol_data = array("StatusCode"=>$array_Accounts['StatusCode'],"Message"=>"Productos no encontrados");
                echo "<script>console.log(".json_encode($consol_data).")</script>";
                break;
            case HttpStatusCode::OK: 
                $consol_data = array("StatusCode"=>$array_Accounts['StatusCode'],"Message"=>"Productos consultados con exito");
                echo "<script>console.log(".json_encode($consol_data).")</script>";
                break;
            default:
                $consol_data = array("StatusCode"=>$array_Accounts['StatusCode'],"Message"=>"Error en la solicitud - Codigo Interno del error: ");
                echo "<script>console.log(".json_encode($consol_data).")</script>";
                break;
        }
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <meta name="vieport" content="width=device-width,initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="IE-EDGE">
        <script src='../../../../jquery/jquery.js'></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
        <script src='../../../../sweetalert/sweetalert.min.js'></script>
        <link rel="stylesheet" href="../../../../bootstrap.css">
        <link rel="stylesheet" href="acc.css">
        <script src='main_acc.js'></script>
        <script type='module' src='../../../Script/main.js'></script>
        <script src='../../../Script/Widgets/modal.js'></script>
    </head>
    <body>
        <header>
            <header>
                <header class="bg-secondary">
                    <div class="container" id='dark-mode'>
                        <nav class="navbar">
                            <div class="row">
                                <div class="col" style="margin-bottom:-6%;">
                                    <h4 class="display-6" style="font-family:sans-serif;text-decoration:none;color:black"><a href="#" style="color:black;text-decoration:none;"></a></h4>
                                </div>
        
                            </div>           
                            <div class="row"><a href="#" onClick="to_User_Route()">Menu Principal</a></div>
                        </nav>
                        <nav class="navbar-auto">
                            <div class="row">
                                <div class="col">
                                    <a href="#" onClick="Extract_Active_Accounts()" id='show_accounts' style="text-decoration:none;border-radius: 4%;
                                border-bottom:5px solid #466375;">Cuentas Activas</a>
                                </div>
                                <div  class="col">
                                    <a href="#" id='suspended_accounts' onClick='Extract_Suspended_Accounts()' style="text-decoration:none;">Cuentas Suspendidas</a>
                                </div>
                            </div>
                        </nav>
                        <hr>
                    </div>
                </header>
                <div class="container" id='n'>
                    <div class="row">
                        <div class="col">
                            <a href="#" id='create-account' onClick="Create_Account()" class='btn btn-primary' style="text-decoration: none;">Crear Registro unico +</a><hr>
                        </div>
                        <div class="col">
                            <a href="#" id='create-upload-massive' class='btn btn-primary' style="text-decoration: none;">Subir Registros Masivos +</a><hr>
                        </div>
                    </div>
                </div>
                <div class='container'>
                    <div class='row'>
                        <div class='col' id="table---">
                            <?php
                                if(empty($array_Accounts['Cuentas'])) echo '<br><h3 class="display-3" style="text-align:center">Sin cuentas registradas</h3>';
                                else{
                                    echo "<table id='tb' class='table table-striped table-bordered'>";
                                    echo "<tr>";
                                    echo "<td>ID</td>";
                                    echo "<td>Nombre</td>";
                                    echo "<td>Privilegios</td>";
                                    echo "<td>Estado</td>";
                                    echo "<td>Acciónes</td>";
                                    echo "</tr>";
                                    $contador = 0;
                                    foreach($array_Accounts['Cuentas'] as $dato){
                                        echo "<tr>";
                                        foreach($dato as $dat){
                                            echo "<td id='id_'>".$dat."</td>";
                                        }
                                        echo "<td value='2'><div class='form-group'>
                                            <div class='form-check form-switch'>
                                        <input class='form-check-input' type='checkbox' onClick='Suspend_Account(".$dato['ID'].")'  role='switch' id='flexSwitchCheckChecked_".$dato['ID']."' checked>
                                        <label class='form-check-label' for='flexSwitchCheckChecked'>Suspender</label>
                                        </div><td id='id_user' hidden>".$dat."</td></tr>";
                                        $contador++;
                                    }
                                    echo "</table>";
                                }
                            ?>
                        </div>
                    </div>
                </div>
            <div class='container'>
                <div class='row'>
                    <div class='col'>
                    </div>
                </div>
            </div>
    </body>
</html>