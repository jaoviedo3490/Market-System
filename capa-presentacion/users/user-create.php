<?php 
session_start();
    if(!isset($_SESSION['session'])){
        header("Location: ../../index.php");
    }
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="IE=EDGE">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" 
                rel="stylesheet"    
                    integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" 
                        crossorigin="anonymous">
        <script src="https://code.jquery.com/jquery-3.6.0.js" 
                        integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk=" 
                            crossorigin="anonymous"></script>
        <link rel="stylesheet" href="../../bootstrap.css">
        <script src="../../app.js">
        </script>
    </head>
    <body>
        <header>
            <nav class="navbar navbar-expand-lg">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col">
                            <a href="../../index.php" class="display-6" style="font-family:sans-serif;text-decoration:none;">Market System</a>
                        </div>
                    </div>
                </div>
            </nav>
        </header>
        <div class="container-fluid w-25">
            <div class="row">
                <div class="col" id="form-1a">
                    <h4>Crea tu cuenta</h4>
                    <form method="POST" id="formulario-1b">
                        <div class="form-group">
                            <label class="form-label-input">Nombre:</label>
                            <input class="form-control" type="text" id="nombre" name="nombre" required>
                            
                        </div>
                        <div class="form-group">
                            <label class="form-label-input">Ingresa una Contraseña:</label>
                            <input class="form-control" type="password" id="contraseña_" name="pass" required>
                            <input type="hiden" value="CREATTE-SESION" name="oculto" hidden>
                        </div>
                        <div class="form-group">
                            <label class="form-label-input">Ingresa tu contraseña para confirmar:</label>
                            <input class="form-control" type="password" id="contraseña" name="pass" required>
                        </div>
                        <div class="form-group">
                            <input class="form-check-input" type="checkbox" id="pass__">
                            <label class="form-label-input">Mostrar Contraseña</label>
                        </div>
                        <div class="form-group">
                            <button class="btn btn-dark" id="btn-btn-create" name="trigger-1">Crear Cuenta</button>
                        </div>
                    </form>
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col">
                                Ya tienes una cuenta? Pulsa <a href="user-init.html">aqui</a> para iniciar sesion
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>