

<?php

include_once(__DIR__ . '/../../capa-datos/ServiceError.php');
    class internalPetitionPost{
        private $resource;
        private $url;
        private $data = array();

        public function __construct($Url , $Data){ 
            $this->resource = curl_init();
            $this->url = $Url;
            $this->data = $Data;
        }

       public function getResource(){
            return $this->resource;
       }
       public function getUrl(){
            return $this->url;
       }

       public function getData(){
            return $this->data;
       }

       public function sendPost(){
           try{
                $responsePetition = array("StatusCode"=>"","Message"=>"");

                curl_setopt($this->getResource(),CURLOPT_URL,$this->getUrl());
                curl_setopt($this->getResource(),CURLOPT_POST,true);
                curl_setopt($this->getResource(),CURLOPT_POSTFIELDS,http_build_query($this->getData()));

                curl_setopt($this->getResource(),CURLOPT_RETURNTRANSFER,true);
                $response = curl_exec($this->getResource());
                if($response===false){
                 
                    $responsePetition['Message'] = "Ocurrio un error al ejecutar el servicio: ".curl_error($this->getResource());
                    $responsePetition['StatusCode'] = HttpStatusCode::INTERNAL_SERVER_ERROR;
                }else{
                    $responsePetition = json_decode($response,true);
                }
                if (json_last_error() !== JSON_ERROR_NONE) {
                    $responsePetition['Message'] = "Error al decodificar la respuesta JSON: " . json_last_error_msg();
                    $responsePetition['StatusCode'] = HttpStatusCode::INTERNAL_SERVER_ERROR;
                }
           }catch(Exception $e){
                error_log($responsePetition['Message']);
                $responsePetition['Message']." Error: ".$e->getMessage();
           }
           return $responsePetition;
       }
    }

?>