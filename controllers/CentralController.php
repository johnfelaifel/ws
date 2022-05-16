<?php
require_once 'config/parameters.php';
require_once 'helpers/Utils.php';

class CentralController {
    
    public function start() {
        $response[] = ['error' => "unknown method"];       
        echo json_encode($response);
    } 

    public function testRead() {
		header("HTTP/1.1 200 OK");			
		header("Content_Type: application/json");	
        $method = $_SERVER['REQUEST_METHOD']; 
        if ($method == 'GET') {
            $dato = new Personal();
            $dato->setId(1);
            $persona = $dato->getOnePDO();
            echo json_encode($persona);    
        } else {
            $response = array();
            $response[] = ['error' => "Method Invalid"];
			echo json_encode($response);             
        }
    }     

    public function testWriteJson() {
        header("Content_Type: application/json");
        /*
         * En donde se recibe el dato por un Json
         * Ejemplo Postman -> body -> raw
            {
                "id": "1",
                "documento": "79312843",
                "nombres": "JESUS ANTONIO ",
                "apellidos": "AMAYA MALAVER",
                "estado": "I"
            }
        */         
        $body = json_decode(file_get_contents("php://input"),true);
        echo $body["nombres"];
        
    }    
 
    public function testWritePost() {
        /*
         * En donde se recibe el dato por un Formulario Post
         * Ejemplo Postman -> body -> form-data
                nombres: Juan Dairo
                apellidos: Perez López
        */
		header("HTTP/1.1 200 OK");			
		header("Content_Type: application/json");        
        $method = $_SERVER['REQUEST_METHOD']; 
        if ($method == 'POST') {
            $nombres = $_POST["nombres"];
            $apellidos = $_POST["apellidos"];  
            $response = array();
            $response[] = ['nombres' =>$nombres];
        } else {
            $response = array();
            $response[] = ['error' => "Method Invalid"];    
        }   
        echo json_encode($response);                  
        
    } 
    
    
    
}
