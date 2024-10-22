<?php
use RedBeanPHP\R;
$autoloadPath = realpath(__DIR__ . '/../vendor/autoload.php');
$ormConn = realpath(__DIR__.'/../helpers/ORM/ORMConnection.php');
$conexion = realpath(__DIR__.'/../capa-datos/conexion.php');
$Service = realpath(__DIR__.'/../capa-datos/ServiceError.php');


include_once($Service);
include_once($conexion);
require_once($ormConn);
require_once(realpath(__DIR__ . '/../vendor/autoload.php'));



    class Usuarios{
        private $_ID;
        private $_Nombre;
        private $_Contraseña;
        private $_Privilegios;
        
        public function Create_Users_SQL($Nombre, $Contraseña, $Privilegios) {
            $con = new Conexion();
            $response = array("Success"=>false , "Message"=>"");
            try{

                $cadena = "INSERT INTO Usuarios (Nombre, Contraseña, Privilegios) VALUES (?, ?, ?)";
                $datos = ($con->getBD())->prepare($cadena);
            
                if ($datos) {
                 
                    $datos->bind_param("sss", $Nombre, $Contraseña, $Privilegios);
               
                    if ($datos->execute()) {
                        $response['Success'] = true;
                    } else {
                        $response["Message"] = "Error en la ejecución de la consulta: " . $datos->error;
                        error_log($response["Message"]);
                        throw new Exception($response["Message"]);
                    }
            
                
                    $datos->close();
                } else {
                    $response["Message"]  = "Error en la preparación de la consulta: " . $con->getBD()->error;
                    error_log($response["Message"]);
                    throw new Exception($response["Message"]);
                }
            
             
                $con->getBD()->close();
               
            }catch(Exception $e){
                $response['Message'] = "Ha ocurrido un error en el método Create_Users_SQL: " . $e->getMessage();
                error_log($response['Message']);
            }finally{
                $con->getDB()->close();
            }

            return $response;
        }






        
        public function Extract_Users_SQL($ID){
            $response = array("Success"=>false , "Message"=>"");
            try{
                $value_bool = false;
                $MsgError = "";

                $cadena = "SELECT * FROM Usuarios WHERE ID = ?";
                $datos = ($con->getBD()->prepare($cadena));

                if($datos){
                    $datos->bind_param("i",$ID);
                    if($datos->execute()){
                        $response['Success'] = true;
                        $result = $datos->get_result();
                        while($data = $result->fetch_assoc()){
                            $this->_ID=$data['ID'];
                            $this->_Nombre=$data['Nombre'];
                            $this->_Contraseña=$data['Contraseña'];
                            $this->_Privilegios=$data['Privilegios'];
                            $this->_Estado=$data['Estado'];
                        }
                    }else{
                        $response['Message'] = "Error wn la ejecucion de la consulta: ".$datos->error;
                        error_log($MsgError);
                        throw new Exception($MsgError);
                    }
                    $datos->close();
                }else{
                    $response['Message'] = "Error en la prepacion de la consulta: ".$con->getDB()->error;
                    error_log($response['Message']);
                    throw new Exception($response['Message']);
                }
                $con->getDB()->close();
                
            }catch(Exception $e){
                $response['Message'] = "Ha ocurrido un error en el método Extract_Users_SQL: " . $e->getMessage();
                error_log($response['Message']);
            }finally{
                $con->getDB()->close();
            }
            return $response;
        }






        public function Extract_User_SQL($dato) {
            $user = array();
            $response = array("Success" => false, "Message" => "", "Usuario" => array());
            
            $con = new Conexion();  
        
            try {
            
                $cadena = "SELECT * FROM Usuarios WHERE Nombre = ?";
                try{
                    $datos = ($con->getBD())->prepare($cadena);
                }catch(PDOException $pdo){
                    $response['Message'] = "Ha ocurrido un error al conectarse a la base de datos " . $pdo->getMessage();
                    error_log($response['Message']);
                }
                

        
                if ($datos) {
                 
                    if ($datos->execute([$dato])) {
                        $response['Success'] = true;
                        
                     
                        $result = $datos->fetchAll(PDO::FETCH_ASSOC);
                        
                        if (count($result) > 0) {
                            $response['Message'] = HttpStatusCode::OK;
                            foreach ($result as $data) {
                                $user['ID'] = $data['id'];
                                $user['Nombre'] = $data['Nombre'];
                                $user['Contraseña'] = $data['contrasena']; 
                                $user['Privilegios'] = $data['Privilegios'];
                                $user['Estado'] = $data['estado'];

                               
                            }
                            $response['Usuario'] = $user;
                        } else {
                            $response['Message'] = HttpStatusCode::NOT_FOUND;
                        }
                    } else {
                        $response['Message'] = "Error en la ejecución de la consulta: " . implode(", ", $datos->errorInfo());
                        error_log($response['Message']);
                    }
                } else {
                    $response['Message'] = "Error en la preparación de la consulta: " . implode(", ", $con->getBD()->errorInfo());
                    error_log($response['Message']);
                }
            }catch (PDOException $pdo) {
                $response['Message'] = "Ha ocurrido un error al conectarse a la base de datos " . $pdo->getMessage();
                error_log($response['Message']);
            } 
            catch (Exception $e) {
                $response['Message'] = "Ha ocurrido un error en el método Extract_User_SQL: " . $e->getMessage();
                error_log($response['Message']);
            } finally {
                $con = null;
            }
        
            return $response;
        }
        




        
        public function Delete_Users_SQL($ID){
            $con = new Conexion();
            $response = array("Success"=>false , "Message"=>"");
            try{

                $cadena = "DELETE FROM usuarios WHERE ID = ?";
                $datos = ($con->getBD())->prepare($cadena);
            
                if ($datos) {
                 
                    $datos->bind_param("i", $ID);
               
                    if ($datos->execute()) {
                        $response['Success'] = true;
                    } else {
                        $response['Message'] = "Error en la ejecución de la consulta: " . $datos->error;
                        error_log($response['Message']);
                        throw new Exception($response['Message']);
                    }
            
                
                    $datos->close();
                } else {
                    $response['Message']  = "Error en la preparación de la consulta: " . $con->getBD()->error;
                    error_log($response['Message']);
                    throw new Exception($response['Message'] );
                }
            
             
                $con->getBD()->close();
               
            }catch(Exception $e){
                $response['Message'] = "Ha ocurrido un error en el método Delete_Users_SQL: " . $e->getMessage();
                error_log($response['Message']);
            }finally{
                $con->getDB()->close();
            }
            return $response;
        }




        public function Update_Users_SQL($NOMBRE,$CONTRASENA,$PRIVILEGIOS,$ID){

            $con = new Conexion();
            $response = array("Success"=>false , "Message"=>"");
            try{

                $cadena = "UPDATE Usuarios SET Nombre = ? , Contraseña = ? , Privilegios = ? WHERE ID = ?";
                $datos = ($con->getBD())->prepare($cadena);
            
                if ($datos) {
                 
                    $datos->bind_param("sssi", $NOMBRE, $CONTRASENA, $PRIVILEGIOS,$ID);
               
                    if ($datos->execute()) {
                        $response['Success'] = true;
                    } else {
                        $response['Message'] = "Error en la ejecución de la consulta: " . $datos->error;
                        error_log($response['Message']);
                        throw new Exception($response['Message']);
                    }
            
                
                    $datos->close();
                } else {
                    $response['Message'] = "Error en la preparación de la consulta: " . $con->getBD()->error;
                    error_log($response['Message']);
                    throw new Exception($response['Message']);
                }
            
             
                $con->getBD()->close();
               
            }catch(Exception $e){
                $response['Message'] = "Ha ocurrido un error en el método Update_Users_SQL: " . $e->getMessage();
                error_log($response['Message']);
            }finally{
                $con->getDB()->close();
            }
         return $response;
        }




//------------------------------------------------------------------------

        public function extract_all_users(){
            
            $con = new Conexion();
           
            $users = array();
            $response = array("Success"=>false,"Message"=>"","Usuarios"=>array());

            try{

                $cadena = "SELECT * FROM usuarios WHERE Privilegios = 'Empleado'";
                $datos = ($con->getBD())->prepare($cadena);
                //$response['Message'] = $cadena;
                if($datos){
                    if($datos->execute()){
                        $response['Success'] = true;
                        $response['Message'] = HttpStatusCode::OK;
                        $result = $datos->fetchAll(PDO::FETCH_ASSOC);
                        if(count($result)>0){
                            foreach($result as $data){
                                $users[] = array(
                                    "ID" => $data['ID'],
                                    "Nombre"=>$data['Nombre'],
                                    "Privilegios"=>$data['Privilegios'],
                                    "Estado"=>$data['Estado']
                                );
                            }
                        }else{
                            $response['Message'] = HttpStatusCode::NOT_FOUND;
                        }
                        
                        $response['Usuarios'] = $users;
                    }else{
                        $response['Message'] = "Ocurrio un error en la Ejecucion de la consulta: ".$datos->error;
                        error_log($response['Message']);
                        throw new Exception($response['Message']);
                    }

                    $datos=null;
                }else{
                    $response['Message'] = "Ocurrio un error en la Preparacion de la consulta: ".$datos->error;
                    error_log($response);
                    throw new Exception($response);
                }
                $con=null;
            }catch(Exception $e){
                $response['Message'] = 'Excepcion encontrada en el metodo extract_all_users: '.$e->getMessage();
                error_log($response['Message']);
            }finally{
                $con=null;
            }
            return $response;
            
        }

//---------------------------------------------------------------------------------------------------

public function extract_all_users_by_status($Estado){

    $response = array("Success"=>false , "Message"=>"" , "Usuarios"=>array());
    $Productos = array();
    try{
        @$cadena = "SELECT ID , Nombre , Privilegios , Estado FROM usuarios WHERE Privilegios = 'Empleado' AND Estado = ?";

        $Productos = R::getAll($cadena,[$Estado]);
        if(!empty($Productos)){
            $response['Success']=true;
            $response['Message']=HttpStatusCode::OK;
            $response['Usuarios'] = $Productos;
        }else{
            $response['Success']=true;
            $response['Message']=HttpStatusCode::NOT_FOUND;
        }
    }catch(Exception $e){
        $response['Message'] = "Excepcion encontrada: ".$e->getMessage();
        $response['StatusCode'] = HttpStatusCode::INTERNAL_SERVER_ERROR;
        error_log("Excepcion encontrada en el metodo extract_all_users_by_status(): ".$e);
    }
    return $response;
}
 //------------------------------------------------------------------------------------------------------------    

 public function Suspend_User($id){
    $response = array("Success"=>false,"Message"=>"");
    try{
        $user_suspend = R::load('usuarios',$id);
        //print_r($user_suspend);
        if($user_suspend->id>0){
            $user_suspend->estado = 'Suspendida';
            R::store($user_suspend);
            $response['Success'] = true;
            $response['Message'] = HttpStatusCode::OK;
        }else{
            $response['Success'] = true;
            $response['Message'] = HttpStatusCode::NOT_FOUND;
        }
    }catch(Exception $e){
        $response['Message'] = "Excepcion encontrada: ".$e->getMessage();
        error_log("Excepcion encontrada en el metodo Suspend_User(): ".$e);
    }
    return $response;
}
//------------------------------------------------------------------------------------------------------------    

public function Active_User($id){
    $response = array("Success"=>false,"Message"=>"");
    try{
        $user_suspend = R::load('usuarios',$id);
        //print_r($user_suspend);
        if($user_suspend->id>0){
            $user_suspend->estado = 'Activa';
            R::store($user_suspend);
            $response['Success'] = true;
            $response['Message'] = HttpStatusCode::OK;
        }else{
            $response['Success'] = true;
            $response['Message'] = HttpStatusCode::NOT_FOUND;
        }
    }catch(Exception $e){
        $response['Message'] = "Excepcion encontrada: ".$e->getMessage();
        error_log("Excepcion encontrada en el metodo Suspend_User(): ".$e);
    }
    return $response;
}

//-----------------------------------------------------------------------------------------------------------------
        public function getID(){ return $this->_ID; }
        public function getNombre() { return $this->_Nombre; }
        public function getContraseña() { return $this->_Contraseña; }
        public function getPrivilegios() { return $this->_Privilegios; }
        public function setID($id){ $this->ID = $id;}
        public function setNombre($nombre) { $this->_Nombre = $nombre;}
        public function setContraseña($contraseña){ $this->_Contraseña = $contraseña; }
        public function setPrivilegios($privilegios){ $this->_Privilegios = $privilegios; }
    }
    class Productos{
        private $_ID;
        private $_Nombre;
        private $_Precio;
        private $_Stock;
        private $_Referencia;
        private $_Vendidos;
        private $_Categoria;
        private $_Imagen;

        public function __contruct(){
            $ORMObject = new ORMRedBean();
            $ORMObject->ORMInit();
        }
        public function Create_Product_SQL($Nombre,$Precio,$Referencia,$Stock,$Ruta,$Vendidos,$Categoria){
            $con = new Conexion();
            $response = array("Success"=>false,"Message"=>"");

           try{
                $cadena = "INSERT INTO Productos(Nombre,Precio,Referencia,Stock,Imagen,Vendidos,Categoria)VALUES(?,?,?,?,?,?,?)";
                $datos = ($con->getBD())->prepare($cadena);

                if($datos){

                    if($datos->execute([$Nombre,$Precio,$Referencia,$Stock,$Ruta,$Vendidos,$Categoria])){
                        $response['Success'] = true;
                    }else{
                        $response['Message'] = "Ocurrio un error en la Ejecucion de la consulta: ".$datos->error;
                        error_log($response['Message']);
                        throw new Exception($response['Message']);
                    }
                    $datos = null;
                }else{
                    $response['Message'] = "Ocurrio un error en la Preparacion de la consulta: ".$datos->error;
                    error_log($response['Message']);
                    throw new Exception($response['Message']);
                }
                $con->getDB()->close();
           }catch(Exception $e){
                $response['Message'] = "Excepcion econtrada en el metodo Create_Product_SQL: ".$e->getMessage();
                error_log($response['Message']);
                throw new Exception($response['Message']);
           }finally{
                $con->getDB()->close();
           }
           return $response;
        }





        public function Delete_Product_SQL($ID){
            
            $con = new Conexion();
            $response = array("Success"=>false , "Message"=>"");
            try{

                $cadena = "DELETE FROM Productos WHERE ID = ?";
                $datos = ($con->getBD())->prepare($cadena);
            
                if ($datos) {
               
                    if ($datos->execute([$ID])) {
                        $response['Success'] = true;
                    } else {
                        $response['Message'] = "Error en la ejecución de la consulta: " . $datos->error;
                        error_log($response['Message']);
                        throw new Exception($response['Message']);
                    }
            
                
                    $datos=null;
                } else {
                    $response['Message']  = "Error en la preparación de la consulta: " . $con->getBD()->error;
                    error_log($response['Message']);
                    throw new Exception($response['Message'] );
                }
            
             
                $con=null;
               
            }catch(Exception $e){
                $response['Message'] = "Ha ocurrido un error en el método Delete_Product_SQL: " . $e->getMessage();
                error_log($response['Message']);
            }finally{
                $con=null;
            }
            return $response;
        }





        /*public function Update_Product($id, array $Producto) {
            $response = array("Success" => false, "Message" => "","Producto_Repetido" => array());
        
            try {
                $product = R::load('productos', $id);
                if (!$product) {
                    $response['Message'] = HttpStatusCode::NOT_FOUND;
                    return $response;
                }
        
                // Combinar las condiciones de búsqueda en una sola consulta
                $duplicate = R::findOne('productos', '(nombre = :nombre OR referencia = :referencia OR codigo_de_barras = :codigo_de_barras)
                    AND id <> :id', [':nombre' => $Producto['Nombre'],
                        ':referencia' => $Producto['Referencia'],
                            ':codigo_de_barras' => $Producto['Codigo_de_Barras'],':id' => $id]);
                            //print_r($duplicate);
        
                if (!$duplicate) {
                    $product->nombre = $Producto['Nombre'];
                    $product->referencia = $Producto['Referencia'];
                    $product->codigo_de_barras = $Producto['Codigo_de_Barras'];
                    R::store($product);
                    $response['Message'] = HttpStatusCode::OK;
                    $response['Success'] = true;
                } else {
                    $response["Success"] = false;
                    $response['Message'] = HttpStatusCode::FORBBIDEN;
                    $response['Producto_Repetido'][] = $duplicate;
                }
            } catch (Exception $e) {
                $response['Success'] = false;
                $response['Message'] = "Error al actualizar producto: " . $e->getMessage();
                // Loggear la excepción con más detalle, incluyendo la consulta SQL y los parámetros
                error_log("UpdateProduct: " . $e->getMessage() . " - SQL: " . $e->getTraceAsString());
            }
        
            return $response;
        }*/

        public function Update_Product($id , array $Producto){
            $response = array("Success"=>false , "Message"=>"" , "Producto_Repetido"=>array());
            try{
                $Productos = R::load('productos',$id);
                //print_r($Productos);
                //print_r($Producto);
                //print_r($id);
                if(!empty($Productos)){
                    //$params = [$Producto['Nombre'], $id, $Producto['Referencia'], $id, $Productos['Codigo_de_Barras'], $id];
                    $Repeat_Product['Nombre'] = R::findOne('productos', "nombre = :nombre AND id <> :id", [":nombre"=>$Producto['Nombre'],":id"=>$id]);
                    $Repeat_Product['Referencia'] = R::findOne('productos', "referencia = :referencia AND id <> :id", [":referencia"=>$Producto['Referencia'],":id"=>$id]);
                    $Repeat_Product['Codigo_de_Barras'] = R::findOne('productos', "codigo_de_barras = :codigo_de_barras AND id <> :id", [":codigo_de_barras"=>$Productos['Codigo_de_barras'],":id"=>$id]);

                   if(is_null($Repeat_Product['Nombre']) 
                        && is_null($Repeat_Product['Referencia'])
                            && is_null($Repeat_Product['Codigo_de_Barras'])){

                                $Productos->nombre = $Producto['Nombre'];
                                $Productos->referencia = $Producto['Referencia'];
                                $Productos->codigo_de_barras = $Producto['Codigo_de_barras'];

                                R::store($Productos);
                                $response['Message'] = HttpStatusCode::OK;
                                $response['Success'] = true;
                        
                   }else{
                        $response["Success"] = false;
                        $response['Message'] = HttpStatusCode::FORBBIDEN;
                        $i = 0;
                        foreach($Repeat_Product as $Clave => $valor){
                        
                            if(!is_null($valor)) $response['Producto_Repetido'][$i] = $Clave;
                            $i++;
                            
                        }
                   }
                }else{
                    $response['Success'] = false;
                    $response['Message'] = HttpStatusCode::NOT_FOUND;
                }
            }catch(Exception $e){
                $response['Success'] = false;
                $response['Message'] = "Excepcion encontrada: ".$e;
                //$response['StatusCode'] = HttpStatusCode::INTERNAL_SERVER_ERROR;
                error_log("Excepcion encontrada en el metodo allCategory(): ".$e);
            }
            return $response;
            
        }


        public function Extract_AllCategory(){
            $response = array("Success"=>false , "Message"=>"" , "Categoria"=>array());
            $Categorias = array();
            try{
                $Categorias = R::findAll('Categoria');
                if(count($Categorias)>0){
                    $response['Success']=true;
                    $response['Message']=HttpStatusCode::OK;
                    $response['Categoria'] = $Categorias;
                }else{
                    $response['Message']=HttpStatusCode::NOT_FOUND;
                }
            }catch(Exception $e){
                $response['Message'] = "Excepcion encontrada: ".$e->getMessage();
                $response['StatusCode'] = HttpStatusCode::INTERNAL_SERVER_ERROR;
                error_log("Excepcion encontrada en el metodo allCategory(): ".$e);
            }
            return $response;
        }

        

        public function Extract_All_Data_Object_by_Category($dato){

            $response = array("Success"=>false , "Message"=>"" , "Productos"=>array());
            $Productos = array();
            try{
                @$cadena = "SELECT p.Nombre as 'Nombre', p.ID as 'ID' , c.Nombre as 'Categoria' , p.Precio as 'Precio' , p.Stock as 'Stock', p.Referencia as 'Referencia' , p.Vendidos as 'Vendidos' ".
                    "FROM Productos p inner join Categoria c on p.CategoriaID = c.id WHERE c.Nombre = ?";

                $Productos = R::getAll($cadena,[$dato]);
                if(!empty($Productos)){
                    $response['Success']=true;
                    $response['Message']=HttpStatusCode::OK;
                    $response['Productos'] = $Productos;
                }else{
                    $response['Success']=true;
                    $response['Message']=HttpStatusCode::NOT_FOUND;
                }
            }catch(Exception $e){
                $response['Message'] = "Excepcion encontrada: ".$e->getMessage();
                $response['StatusCode'] = HttpStatusCode::INTERNAL_SERVER_ERROR;
                error_log("Excepcion encontrada en el metodo Extract_All_Data_Object_by_Category(): ".$e);
            }
            return $response;
        }






        public function Extract_All_Data_Object($dato){

            $response = array("Success"=>false , "Message"=>"" , "Productos"=>array());
            $Productos = array();
            try{
                @$cadena = "SELECT p.Stock as 'Stock' , p.Vendidos as 'Vendidos' , p.Referencia as 'Referencia' , p.Precio as 'Precio' ".
                                ", p.ID as 'ID', p.Nombre as 'Nombre', c.Nombre as 'Categoria' FROM Productos p inner join Categoria c on p.CategoriaID = c.ID WHERE p.ID = ?";
        
                $Productos = R::getAll($cadena,[$dato]);
                if(!empty($Productos)){
                    $response['Success']=true;
                    $response['Message']=HttpStatusCode::OK;
                    $response['Productos'] = $Productos;
                }else{
                    $response['Success']=true;
                    $response['Message']=HttpStatusCode::NOT_FOUND;
                }
            }catch(Exception $e){
                $response['Message'] = "Excepcion encontrada: ".$e->getMessage();
                $response['StatusCode'] = HttpStatusCode::INTERNAL_SERVER_ERROR;
                error_log("Excepcion encontrada en el metodo Extract_All_Data_Object(): ".$e);
            }
            return $response;
        }

      

//-----------------------------------------------------------------------
//Modelo que realiza la busqueda de los productos en la barra de busqueda
//$dato = producto a buscar
public function Extract_All_Data_Object_Unit($dato){

    $response = array("Success"=>false , "Message"=>"" , "Productos"=>array());
    $Productos = array();
    try{
        @$cadena = "SELECT p.Stock as 'Stock' , p.Vendidos as 'Vendidos' , p.Referencia as 'Referencia' , p.Precio as 'Precio' ".
                ", p.ID as 'ID', p.Nombre as 'Nombre', c.Nombre as 'Categoria' FROM Productos p inner join Categoria c on p.CategoriaID = c.ID WHERE p.ID = ?";

        $Productos = R::getAll($cadena,[$dato]);
        if(!empty($Productos)){
            $response['Success']=true;
            $response['Message']=HttpStatusCode::OK;
            $response['Productos'] = $Productos;
        }else{
            $response['Success']=true;
            $response['Message']=HttpStatusCode::NOT_FOUND;
        }
    }catch(Exception $e){
        $response['Message'] = "Excepcion encontrada: ".$e->getMessage();
        $response['StatusCode'] = HttpStatusCode::INTERNAL_SERVER_ERROR;
        error_log("Excepcion encontrada en el metodo Extract_All_Data_Object_Unit(): ".$e);
    }
    return $response;
}
    
//-----------------------------------------------------------------------------------------------------------


public function Extract_All_Data_Object_Search($dato){

    $response = array("Success"=>false , "Message"=>"" , "Productos"=>array());
    $Productos = array();
    try{
        @$cadena = "SELECT p.Stock as 'Stock' , p.Vendidos as 'Vendidos' , p.Referencia as 'Referencia' , p.Precio as 'Precio' ".
                ", p.ID as 'ID', p.Nombre as 'Nombre', c.Nombre as 'Categoria' FROM Productos p inner join Categoria c on p.CategoriaID = c.ID WHERE p.Nombre LIKE ?";

        $Productos = R::getAll($cadena,['%'.$dato.'%']);
        if(!empty($Productos)){
            $response['Success']=true;
            $response['Message']=HttpStatusCode::OK;
            $response['Productos'] = $Productos;
        }else{
            $response['Success']=true;
            $response['Message']=HttpStatusCode::NOT_FOUND;
        }
    }catch(Exception $e){
        $response['Message'] = "Excepcion encontrada: ".$e->getMessage();
        $response['StatusCode'] = HttpStatusCode::INTERNAL_SERVER_ERROR;
        error_log("Excepcion encontrada en el metodo Extract_All_Data_Object_Unit(): ".$e);
    }
    return $response;
}

//-------------------------------------------------------------------------------------------------------------
//Modelo que extrae todos los productos de todas las categorias ordenados por el id

public function Extract_All_Data_Object_(){

    $response = array("Success"=>false , "Message"=>"" , "Productos"=>array());
    $Productos = array();
    try{
        @$cadena = "SELECT p.ID as 'ID', p.Nombre as 'Nombre', c.Nombre as 'Categoria' FROM Productos p inner join Categoria c on p.CategoriaID = c.ID ORDER BY p.ID";

        $Productos = R::getAll($cadena);
        if(!empty($Productos)){
            $response['Success']=true;
            $response['Message']=HttpStatusCode::OK;
            $response['Productos'] = $Productos;
        }else{
            $response['Success']=true;
            $response['Message']=HttpStatusCode::NOT_FOUND;
        }
    }catch(Exception $e){
        $response['Message'] = "Excepcion encontrada: ".$e->getMessage();
        $response['StatusCode'] = HttpStatusCode::INTERNAL_SERVER_ERROR;
        error_log("Excepcion encontrada en el metodo Extract_All_Data_Object_(): ".$e);
    }
    return $response;
}

        
  

   //------------------------------------------------------------------------------------------------------------    
   //modelo que obtiene la cantidad de registros afectados por la consulta

        public function CountData($dato) {
            $con = new Conexion();
            $response = array("Success" => false, "Message" => "", "Cantidad" => "");
        
            try {
                // Selecciona la cadena SQL según el valor de $dato
                $cadena = ($dato == "All_object") 
                    ? "SELECT COUNT(*) AS CONTEO FROM Productos" 
                    : "SELECT COUNT(*) AS CONTEO FROM Productos WHERE Categoria LIKE ? OR Referencia LIKE ?";
        
                // Prepara la consulta
                $datos = ($con->getBD())->prepare($cadena);
        
                if ($datos) {
                    // Si $dato no es "All_object", usa el valor de búsqueda
                    if ($dato != "All_object") {
                        $searchTerm = "%" . $dato . "%";
                        $executionResult = $datos->execute([$searchTerm, $searchTerm]);
                    } else {
                        $executionResult = $datos->execute();
                    }
        
                    if ($executionResult) {
                        $response['Success'] = true;
                        $result = $datos->fetch(PDO::FETCH_ASSOC);
        
                        // Verifica si se obtuvo un resultado
                        if ($result && isset($result['CONTEO'])) {
                            $response['Message'] = HttpStatusCode::OK;
                            $response['Cantidad'] = $result['CONTEO'];
                        } else {
                            $response['Message'] = "No se encontraron resultados.";
                        }
                    } else {
                        $response['Message'] = "Error en la ejecución de la consulta.";
                        error_log($response['Message']);
                    }
                } else {
                    $response['Message'] = "Error en la preparación de la consulta.";
                    error_log($response['Message']);
                }
            } catch (Exception $e) {
                $response['Message'] = "Excepción encontrada en el método CountData: " . $e->getMessage();
                error_log($response['Message']);
            }
        
            return $response;
        }
        
    }




    class Token{
        public function __contruct(){
        }

        public function CreateBDToken($user_id, $token,$Expires_at,$Created_at,$user_role) {
            $response = array("Success" => false, "Message" => "");

            try {
        
                $con = new Conexion();
                $db = $con->getBD();
               
                
                $cadena = "INSERT INTO SESSIONS (USER_ID, TOKEN, CREATED_AT, EXPIRES_AT,USER_ROL) VALUES (?, ? ,? ,? , ?)";
                $stmt = $db->prepare($cadena); 
                
                if ($stmt) {
                    
                    
                    if ($stmt->execute([$user_id, $token,$Created_at,$Expires_at,$user_role])) {
                        
                        $response['Success'] = true;
                    } else {
                        
                      
                        $response['Message'] = "Ocurrio un error en la ejecución de la consulta: " . implode(", ", $stmt->errorInfo());
                        error_log($response['Message']);
                    }
                   
                } else {
                    $response['Message'] = "Ocurrio un error en la preparación de la consulta.";
                    error_log($response['Message']);
                }
            } catch (PDOException $e) {
                //echo json_encode($user_id."|". $token."|".$Expires_at."|".$Created_at."|".$user_role."|Exception: ".$e);
                $response['Success'] = false;
                $response['Message'] = "Ha ocurrido un error en el método CreateBDToken: " . $e->getMessage();
                error_log($response['Message']);
            }

            return $response;
        }

        public function Extract_Token_Information($user_id){
            $response = array("Success"=>false,"Message"=>"");

            try{
                $con = new Conexion();
                $cadena = "SELECT Nombre , Privilegios , Estado from Usuario WHERE ID = ?";

                $datos->$con->getDB()->prepare($cadena);
                if($datos){

                    if($datos->execute([$user_id])){
                        $response['Success']=true;
                        $result = $datos->fetchAll(PDO::FETCH_ASSOC);
                        
                        if (count($result) > 0) {
                            $response['Message'] = HttpStatusCode::OK;
                            foreach ($result as $data) {
                               
                                $user['Nombre'] = $data['Nombre'];
                                $user['Privilegios'] = $data['Privilegios'];
                                $user['Estado'] = $data['Estado'];
                            }
                    }{
                        $response['Message'] = HttpStatusCode::NOT_FOUND;
                    }
                }else{
                    $response['Message']="Ocurrio un error en la ejecucion de la consulta".implode(", ", $datos->errorInfo());
                    error_log($response['Message']);
                }
            }else{
                $response['Message'] = "Ocurrio un error en la preparacion de la consulta";
                error_log($response['Message']);
            }

            }catch(Exception $e){
                $response['Message'] = 'Excepcion encontrada en el metodo Extract_Token_Information: '.$e->getMessage();
                error_log($response['Message']);
            }

        }

    }
?>
