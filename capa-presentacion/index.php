<?php
session_start();
include('../capa-datos/conexion.php');
if(isset($_SESSION['session'])){
    header("Location: ../capa-presentacion/Index/User-Route.php");
}
    ?>
<!DOCTYPE html>
<html>
    <head>
        <title>Market System</title>
        <meta charset="UTF-8" content="width=device-width, initial-scale=1.0">
        <meta name="viewport">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <link href="../bootstrap.css" rel="stylesheet">
        <script src='../jquery/jquery.js'></script>
        <script src='../sweetalert/sweetalert.min.js'></script>
        <script src="app.js"></script>
        <link rel="stylesheet" href="bootstrap.css">
    </head>
    <body>
        <header class="bg-white">
            <div class="container-fluid m-auto">
                <nav class="nav">
                    <div class="row justify-content-end"  style="margin-left:5%;">
                        <div class="col">
                            <a href="index.php" class="display-5" style="text-decoration:none;font-family:
                                Lucida Sans Unicode;color:#4580C8;">Market System</a>
                        </div>
                    </div>           
                    <div class="row" style="margin-left:50%;">
                        <div class="col" >
                            
                                <img src="../resources/users.svg" alt="user-init" width="50" height="50" class="img-fluid"/>
                                <a href="../capa-presentacion/users/user-init.html" style="text-decoration:none;color:black;font-family: 
                                    'Lucida Sans Regular', 'Lucida Grande', Geneva, Verdana, sans-serif; margin-top:10%;">Iniciar Sesion</a>
                        </div>
                    </div>
                </nav>
                <hr>
            </div>
        </header>
        <div class="container-fluid bg-light">
            <div class="row">
                <div class="col">
                    <?php  if(!isset($_SESSION['session'])) echo"<h1 class='display-2' style='margin:5%;margin-left:20%;'>".
                    "No ha iniciado sesion</h1>"; ?>
                </div>
            </div>
        </div>
        <footer style="margin-top:20%;" class="bg-light">
            <hr>
            <div class="container-fluid">
                <div class="row">
                    <div class="col">
                        <p class="lead">Derechos reservados</p>
                    </div>
                </div>
            </div>
        </footer>
    </body>
</html>