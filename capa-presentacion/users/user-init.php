
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" 
          rel="stylesheet" 
          integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" 
          crossorigin="anonymous">
    <script src="../../jquery/jquery.js"></script>
    <link rel="stylesheet" href="../../bootstrap.css">
    <script type="module" src="../Script/app.js"></script>
    <script type="module" src="../Script/main.js"></script>
    <script src="../../sweetalert/sweetalert.min.js"></script>
</head>
<body><?php
        if (isset($_COOKIE['auth_token'])) {
            // Ejecutar la función después de que el DOM esté cargado y main.js haya sido importado
            echo "<script>
                    window.addEventListener('DOMContentLoaded', (event) => {
                        to_User_Route();
                    });
                  </script>";
        }
    ?><header>
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
                <h4>Iniciar Sesión</h4>
                
                    <div class="form-group">
                        <label class="form-label-input">Nombre</label>
                        <input class="form-control" type="text" id="nombre_" name="nombre" required>
                        <input type="hidden" value="INIT-SESION" name="oculto">
                    </div>
                    <div class="form-group">
                        <label class="form-label-input">Contraseña</label>
                        <input class="form-control" type="password" id="contraseña_" name="contraseña" required>
                    </div>
                    
                    <div class="form-group">
                        <input class="form-check-input" type="checkbox" id="pass_">
                        <label class="form-label-input">Mostrar Contraseña</label>
                    </div>
                    <div class="form-group">
                        <button class="btn btn-dark" id="btn-init-session" name="trigger-1" style="width:100%">Iniciar Sesión</button>
                    </div>
               
            </div>
        </div>
    </div>
</body>
</html>
