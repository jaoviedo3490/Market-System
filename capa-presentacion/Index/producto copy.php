<?php
    @session_start();
    if(!isset($_SESSION['session']))
        header('Location: ../../index.php');
    
     
    include('../../capa-negocios/receptor.php');
    include('../../capa-datos/conexion.php');
    $consulta = new Productos();
    $array = $consulta->Extract_All_Products($_GET['product']);
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
        <script src="main.js">
        </script>
        <script src="ajax.js">
        </script>
    </head>
    <body>
        <header class="bg-info">
            <div class="container">
                <nav class="navbar">
                    <div class="row">
                        <div class="col" style="margin-bottom:-6%;">
                            <h4 class="display-6" style="font-family:sans-serif;text-decoration:none;color:white;">Productos <?=$_GET['product']?></h4>
                        </div>

                    </div>           
                </nav>
                <hr>
            </div>
        </header>
        
        <footer>
        <div class="container-fluid">
            <div class="row">
                <div class="col-auto">
                    <div class="container-fluid">
                        <div class="row-auto">
                            <div class="col-auto">
                                <div class="container-fluid">
                                    <div class="row">
                                    <?php
                                        if(empty($array)) echo "<h4 class='display-4' style='margin:5%;margin-left:15%;'>Sin Productos Registrados</h1>";
                                        else{
                                            for($k=0;$k<sizeof($array);$k+=1){
                                                        echo "<div class='col-auto'>";
                                                        echo "<div class='card' style='width: 18rem;'>";
                                                            echo "<img class='card-img-top'  src='../../resources/Limpieza.webp'  alt='Card image cap'>";
                                                            echo "<div class='card-body'>";
                                                                echo "<h5 class='card-title'>Poductos de Aseo Personal</h5>";
                                                                echo "<p class='card-text'>Some quick example text to build on the card title and make up the bulk of the cards content.</p>";
                                                                echo "<button class='btn btn-link' style='margin-bottom:2%;width:100%'>Ver Detalles</button>";
                                                            echo "</div>";
                                                        echo "</div>";    
                                                        echo "</div>";
                                                }
                                            }?>  
                                    </div>
                                </div>
                                
                            </div>
                        </div>
                    </div>
                </div><div class="col-auto">
                    <div class="container-fluid">
                        <h4>Detalles del Producto</h3>
                        <form>
                            <div class="container">
                                Nombre del Producto
                                <input type="text" class="form-control" disabled>
                            </div><div class="container">
                                Referencia
                                <input type="text" class="form-control" disabled>
                            </div><div class="container">
                                Precio
                                <input type="number" class="form-control" disabled>
                            </div><div class="container">
                               Unidades Disponibles
                                <input type="text" class="form-control" disabled>
                            </div><div class="container">
                                Unidades Vendidas
                                <input type="text" class="form-control" disabled>
                            </div><div class="container">
                                Nombre del Producto
                                <select class="form-control "disabled>
                                    <option>Categoria 1</option>
                                    <option>Categoria 2</option>
                                    <option>Categoria 3</option>
                                    <option>Categoria 4</option>
                                    <option>Categoria 5</option>
                                </select>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>    
        <div class="col-auto" style="margin:2%;">
                        <p>
                            <a href="main.php">Menu Principal</a>
                        </p>
                    </div>
        </footer>
    </body>
</html>