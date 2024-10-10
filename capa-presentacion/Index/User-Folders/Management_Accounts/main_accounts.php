<?php
    session_start();
    if(!isset($_SESSION['session']))
        header('Location: ../../index.php');
        include('../../../capa-negocios/receptor.php');
        include('../../../capa-datos/conexion.php');
    $datos = new usuarios();
    $array = array();
    $array = $datos->extract_all_users();    
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <meta name="vieport" content="width=device-width,initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="IE-EDGE">
        <script src='../../../jquery/jquery.js'></script>
        <script src='../../../sweetalert/sweetalert.min.js'></script>
        <link rel="stylesheet" href="../../../bootstrap.css">
        <link rel="stylesheet" href="acc.css">
        <script src='main_acc.js'></script>
    </head>
    <body>
        <header>
            <header>
                <header class="bg-secondary">
                    <div class="container" id='dark-mode'>
                        <nav class="navbar">
                            <div class="row">
                                <div class="col" style="margin-bottom:-6%;">
                                    <h4 class="display-6" style="font-family:sans-serif;text-decoration:none;color:black"><a href="main.php" style="color:black;text-decoration:none;"></a></h4>
                                </div>
        
                            </div>           
                            <div class="row"><a href="../main.php">Menu Principal</a></div>
                        </nav>
                        <nav class="navbar-auto">
                            <div class="row">
                                <div class="col">
                                    <a href="main_accounts.php" id='show_accounts' style="text-decoration:none;border-radius: 4%;
                                border-bottom:5px solid #466375;">Cuentas Activas</a>
                                </div>
                                <div  class="col">
                                    <a href="#" id='suspended_accounts' style="text-decoration:none;">Cuentas Suspendidas</a>
                                </div>
                            </div>
                        </nav>
                        <hr>
                    </div>
                </header>
                <div class="container" id='n'>
                    <div class="row">
                        <div class="col">
                            <a href="#" id='create-account' class='btn btn-primary' style="text-decoration: none;">Nueva Cuenta +</a><hr>
                        </div>
                    </div>
                </div>
                <div class='container'>
                    <div class='row'>
                        <div class='col' id="table---">
                            <?php
                                if(empty($array)||(empty($array[0]))) echo '<br><h3 class="display-3" style="text-align:center">Sin cuentas registradas</h3>';
                                else{
                                    echo "<table id='tb' class='table table-striped table-bordered'>";
                                    echo "<tr>";
                                    echo "<td>ID</td>";
                                    echo "<td>Nombre</td>";
                                    echo "<td>Privilegios</td>";
                                    echo "<td>Acciónes</td>";
                                    echo "</tr>";
                                    $contador = 0;
                                    foreach($array as $dato){
                                        echo "<tr>";
                                        foreach($dato as $dat){
                                            echo "<td id='id_'>".$dat."</td>";
                                        }
                                        echo "<td value='2' ><a href='#' id='suspend' value='3' onclick='click_()' style='margin-right:5px;' class='btn btn-info'>Suspender</a></td><td id='id_user' hidden>".$array[$contador][0]."</td></tr>";
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