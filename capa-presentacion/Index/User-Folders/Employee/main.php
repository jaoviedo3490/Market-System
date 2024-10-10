<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="IE=EDGE">
        <script src="../../jquery/jquery.js"></script>
        <link rel="stylesheet" href="../../bootstrap.css">
        <script src="../../app.js">
        </script>
        <script src="../../sweetalert/sweetalert.min.js"></script>
        <script src="main.js">
        </script>
        <script src="ajax.js">
        </script>
    </head>
    <body>
        <header class="bg-primary">
            <div class="container">
                <nav class="navbar">
                    <div class="row">
                        <div class="col" style="margin-bottom:-6%;">
                            <h4 class="display-6" style="font-family:sans-serif;text-decoration:none;color:white;"><a href="main.php" style="color:white;text-decoration:none;"><?=$_SESSION['priv']?></a></h4>
                        </div>

                    </div>           
                </nav>
                    <nav class="navbar-auto">
                    <div class="row">
                        <div  class="col">
                            <a href="#"  style="color:white;text-decoration:none;">Caja</a>
                        </div>
                        <div  class="col">
                            <a href="#"  id='perfil' style="color:white;text-decoration:none;">Mi Perfil</a>
                        </div>
                        <div class="col">
                            <a href="../../capa-negocios/closed_session.php" style="color:white;text-decoration:none;">Cerrar Sesion</a>
                        </div>
                    </div>
                    </nav>
                    </header><br>
                        <div class="container-fluid">
                            <div class="row">
                                <div class="col">
                                    <form>
                                        Nueva Factura
                                        <input class='form-control'type='text' placeholder='Ingrese codigo de producto o codigo de barras'>
                                        <br><br>
                                        <a href="#" class='btn btn-info'>Agregar Producto</a>
                                    </form>
                                </div><div class="col">
                                        Producto:
                                        <li>
                                            <ul>Producto 1<a style='margin-left:50%'>2000$</a></ul>
                                            <ul>Producto 2<a style='margin-left:50%'>2000$</a></ul>
                                            <ul>Producto 3<a style='margin-left:50%'>2000$</a></ul>
                                            <ul>Producto 4<a style='margin-left:50%'>2000$</a></ul>
                                            <ul>Producto 5<a style='margin-left:50%'>2000$</a></ul>
                                            <ul>Producto 6<a style='margin-left:50%'>2000$</a></ul>
                                            <ul>Producto 7<a style='margin-left:50%'>2000$</a></ul>
                                        </li>
                                        <h5>Precio Total</h5>
                                        <br>
                                        <br>
                                        <br>
                                        <br>
                                        <br>
                                    <a href='#' class='btn btn-success' style='width:100%'>Finalizar Compra</a>
                                </div>
                            </div>
                        </div>
    </body>
</html>