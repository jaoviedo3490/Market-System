<?php
include_once('C:/xampp/htdocs/Market-System/capa-datos/ServiceError.php');
include_once('C:/xampp/htdocs/Market-System/capa-datos/conexion.php');


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
                                $user['ID'] = $data['ID'];
                                $user['Nombre'] = $data['Nombre'];
                                $user['Contraseña'] = $data['Contraseña']; 
                                $user['Privilegios'] = $data['Privilegios'];
                                $user['Estado'] = $data['Estado'];

                               
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





        public function extract_all_users($Estado){
            
            $con = new Conexion();
           
            $users = array();
            $response = array("Success"=>false,"Message"=>"","Usuario"=>array());

            try{

                $cadena = "SELECT * FROM usuarios WHERE Privilegios LIKE 'Empleado' AND Estado LIKE ?";
                $datos = ($con->getBD())->prepare($cadena);

                if($datos){

                    $searchTherm = "%".$Estado."%";
                    $datos->bind_param("s",$searchTherm);

                    if($datos->execute()){
                        $response['Success'] = true;
                        $result = $datos->get_result();

                        while($data = $result->fetch_assoc()){
                            $users[] = array(
                                "ID" => $data['ID'],
                                "Nombre"=>$data['Nombre'],
                                "Privilegios"=>$data['Privilegios'],
                                "Estado"=>$data['Estado']
                            );
                        }
                        $response['Usuarios'] = $users;
                    }else{
                        $response['Message'] = "Ocurrio un error en la Ejecucion de la consulta: ".$datos->error;
                        error_log($response['Message']);
                        throw new Exception($response['Message']);
                    }

                    $datos->close();
                }else{
                    $response['Message'] = "Ocurrio un error en la Preparacion de la consulta: ".$datos->error;
                    error_log($response);
                    throw new Exception($response);
                }
                $con->getDB()->close();
            }catch(Exception $e){
                $response['Message'] = 'Excepcion encontrada en el metodo extract_all_users: '.$e->getMessage();
                error_log($response['Message']);
            }finally{
                $con->getBD()->close();
            }
            return $response;
            
        }


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







        public function Update_Product_SQL($ID,$NOMBRE,$PRECIO,$REFERENCIA,$STOCK,$VENDIDOS){
           
            $con = new Conexion();
            $response = array("Success"=>false , "Message"=>"");
            try{

                $cadena = "UPDATE Productos SET Nombre = ? , Precio = ? , Referencia = ? , Stock = ? , Vendidos = ? WHERE ID = ?";
                $datos = ($con->getBD())->prepare($cadena);
            
                if ($datos) {
                 
                    $datos->bind_param("sisii",$NOMBRE,$PRECIO,$REFERENCIA,$STOCK,$VENDIDOS);
               
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




        


     public function Extract_AllCategory(){
        $con = new Conexion();
        $categorias = array();
        $response = array("Success"=>false , "Message"=>"" , "Categorias"=>array());
        try{
            $consulta = "SELECT * FROM CATEGORIA";
            $datos = ($con->getBD()->prepare($consulta));

            if($datos){
                if($datos->execute()){
                    $response['Success'] = true;
                    $result = $datos->fetchAll(PDO::FETCH_ASSOC);
                    if(count($result)>0){
                        $response['Message'] = HttpStatusCode::OK;
                        for($i=0;$i<count($result);$i++){
                            $categorias[$i] = $result[$i];
                        }
                    }else{
                        $response['Message'] = HttpStatusCode::NOT_FOUND;
                        $response['Success'] = true;
                    }
                    $response['Categorias'] = $categorias;
                }else{
                    $datos = null;
                    $response['Message'] = "Ocurrio un error en la Ejecucion de la consulta";
                    error_log($response['Message']);
                    throw new Exception($response['Message']);
                }
            }else{
                $datos = null;
                $response['Message'] = "Ocurrio un error en la Preparacion de la consulta";
                error_log($response['Message']);
                throw new Exception($response['Message']);
            }

        }catch(PDOException $pdo){
            $response['Message'] = HttpStatusCode::INTERNAL_SERVER_ERROR." : ".$pdo->getMessage();
            error_log($response['Message']);
        }catch(Exception $e){
            $response['Message'] = HttpStatusCode::INTERNAL_SERVER_ERROR." : ".$pdo->getMessage();
            error_log($response['Message']);
        }finally{
            $con = null;
        }
        return $response;
     }

     public function Extract_All_Data_Object_by_Category($dato){
            
        $con = new Conexion();
        $productos = array();
        $response = array("Success"=>false,"Message"=>"","Productos"=>array());
        try{
            @$cadena = "SELECT p.ID as 'ID', p.Nombre as 'Nombre', c.Nombre as 'Categoria' FROM Productos p inner join Categoria c on p.CategoriaID = c.ID WHERE c.Nombre = ?";
            $datos = ($con->getBD())->prepare($cadena);

            if($datos){

                //@$searchTherm = "%".$dato."%";
                if($datos->execute([$dato])){

                    $response['Success'] = true;
                    $result = $datos->fetchAll(PDO::FETCH_ASSOC);
                    if(count($result)>0){
                        $response['Message'] = HttpStatusCode::OK;

                        foreach($result as $data){
                            $productos[] = array(
                                "ID"=>$data['ID'],
                                "Nombre"=>$data['Nombre'],
                                "Categoria"=>$data['Categoria'],
                            );
                        }
                        
                    }
                    $response["Productos"]=$productos;
                }else{
                    $response['Message']="Ocurrio un error en la Ejecucion de la consulta: ".$datos->error;
                    error_log($response['Message']);
                    throw new Exception($response['Message']);
                }
               $datos = null;
            }else{
                $response['Message']="Ocurrio un error en la Preparacion de la consulta: ".$datos->error;
                error_log($response['Message']);
                throw new Exception($response['Message']);
            }
            $con = null;
        }catch(Exception $e){
                $response['Message']="Excepcion encontrada en el metodo Extract_num_products: ".$e->getMessage();
                error_log($response['Message']);
        }finally{
           $con = null;
        }
        return $response;
    }



      public function Extract_All_Data_Object($dato){
            
        $con = new Conexion();
        $productos = array();
        $response = array("Success"=>false,"Message"=>"","Productos"=>array());
        try{
            @$cadena = "SELECT p.ID as 'ID', p.Nombre as 'Nombre', c.Nombre as 'Categoria' FROM Productos p inner join Categoria c on p.CategoriaID = c.ID WHERE p.Nombre LIKE ?";
            $datos = ($con->getBD())->prepare($cadena);

            if($datos){

                @$searchTherm = "%".$dato."%";
                if($datos->execute([$searchTherm])){

                    $response['Success'] = true;
                    $result = $datos->fetchAll(PDO::FETCH_ASSOC);
                    if(count($result)>0){
                        $response['Message'] = HttpStatusCode::OK;

                        foreach($result as $data){
                            $productos[] = array(
                                "ID"=>$data['ID'],
                                "Nombre"=>$data['Nombre'],
                                "Categoria"=>$data['Categoria'],
                            );
                        }
                        
                    }
                    $response["Productos"]=$productos;
                }else{
                    $response['Message']="Ocurrio un error en la Ejecucion de la consulta: ".$datos->error;
                    error_log($response['Message']);
                    throw new Exception($response['Message']);
                }
               $datos = null;
            }else{
                $response['Message']="Ocurrio un error en la Preparacion de la consulta: ".$datos->error;
                error_log($response['Message']);
                throw new Exception($response['Message']);
            }
            $con = null;
        }catch(Exception $e){
                $response['Message']="Excepcion encontrada en el metodo Extract_num_products: ".$e->getMessage();
                error_log($response['Message']);
        }finally{
           $con = null;
        }
        return $response;
    }


    
    public function Extract_All_Data_Object_Unit($dato){
            
        $con = new Conexion();
        $productos = array();
        $response = array("Success"=>false,"Message"=>"","Productos"=>array());
        try{
            @$cadena = "SELECT p.ID as 'ID', p.Nombre as 'Nombre', c.Nombre as 'Categoria' FROM Productos p inner join Categoria c on p.CategoriaID = c.ID WHERE p.Nombre = ?";
            $datos = ($con->getBD())->prepare($cadena);

            if($datos){

                @$searchTherm = "%".$dato."%";
                if($datos->execute([$searchTherm])){

                    $response['Success'] = true;
                    $result = $datos->fetchAll(PDO::FETCH_ASSOC);
                    if(count($result)>0){
                        $response['Message'] = HttpStatusCode::OK;

                        foreach($result as $data){
                            $productos[] = array(
                                "ID"=>$data['ID'],
                                "Nombre"=>$data['Nombre'],
                                "Categoria"=>$data['Categoria'],
                            );
                        }
                        
                    }
                    $response["Productos"]=$productos;
                }else{
                    $response['Message']="Ocurrio un error en la Ejecucion de la consulta: ".$datos->error;
                    error_log($response['Message']);
                    throw new Exception($response['Message']);
                }
               $datos = null;
            }else{
                $response['Message']="Ocurrio un error en la Preparacion de la consulta: ".$datos->error;
                error_log($response['Message']);
                throw new Exception($response['Message']);
            }
            $con = null;
        }catch(Exception $e){
                $response['Message']="Excepcion encontrada en el metodo Extract_num_products: ".$e->getMessage();
                error_log($response['Message']);
        }finally{
           $con = null;
        }
        return $response;
    }











        public function Extract_All_Data_Object_(){
            $con = new Conexion();
            $productos = array();
            $response = array("Success"=>false,"Message"=>"","Productos"=>array());
            try{
                @$cadena = "SELECT p.ID as 'ID', p.Nombre as 'Nombre', c.Nombre as 'Categoria' FROM Productos p inner join Categoria c on p.CategoriaID = c.ID ORDER BY p.ID";
                $datos = ($con->getBD())->prepare($cadena);
    
                if($datos){

                    if($datos->execute()){
    
                        $response['Success'] = true;
                        $result = $datos->fetchAll(PDO::FETCH_ASSOC);
                        
                        if(count($result)>0){
                            $response['Message'] = HttpStatusCode::OK;
                            foreach($result as $data){
                                $productos[] = array(
                                    "ID"=>$data['ID'],
                                    "Nombre"=>$data['Nombre'],
                                    "Categoria"=>$data['Categoria']
                                );
                            }
                            $response['Productos'] = $productos;
                        }else{
                            $response['Message'] = HttpStatusCode::NOT_FOUND;
                        }
                    }else{
                        $response['Message']="Ocurrio un error en la Ejecucion de la consulta: ".$datos->error;
                        error_log($response['Message']);
                        throw new Exception($response['Message']);
                    }
                }else{
                    $response['Message']="Ocurrio un error en la Preparacion de la consulta: ".$datos->error;
                    error_log($response['Message']);
                    throw new Exception($response['Message']);
                }
                $con = null;
            }catch(Exception $e){
                    $response['Message']="Excepcion encontrada en el metodo Extract_All_Data_Object_: ".$e->getMessage();
                    error_log($response['Message']);
            }finally{
                $con = null;
            }
            return $response;           
        }
        
        
       


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
