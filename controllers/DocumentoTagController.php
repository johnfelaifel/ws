<?php
require_once 'config/parameters.php';
require_once 'config/db.php';
require_once 'models/DocumentoTag.php';
require_once 'models/LogGeneral.php';
require_once 'helpers/Utils.php';

class DocumentoTagController
{
    private $table = "DocumentoTag";

    function __construct()
    {
        header("HTTP/1.1 200 OK");
        header("Content_Type: application/json");        
    }

    public function create()
    {
        //Evaluacion de método de recepcion // Formateo de Datos
        $method = $_SERVER['REQUEST_METHOD'];
        if ($method == 'POST' || $method == 'GET') {
            $idDocumento = isset($_REQUEST['id_documento']) ? filter_var(trim($_REQUEST['id_documento']), FILTER_SANITIZE_NUMBER_INT) : false;
            $nombre = isset($_REQUEST['nombre']) ? trim($_REQUEST['nombre']) : false;
            $idUser = isset($_REQUEST['idUser']) ? filter_var(trim($_REQUEST['idUser']), FILTER_SANITIZE_NUMBER_INT) : false;

            //Creación de Objeto con datos // Almacenamiento de Datos
            if ($idDocumento && $nombre && $idUser) {
                $data = new $this->table();
                $data->setIdDocumento($idDocumento);
                $data->setNombre($nombre);                                                          
                $response = $data->create();
                //Registro en Log General
                foreach ($response as $value) {                    
                    if($value['status'] == "created"){
                        $description = 'Creado en Tabla: '.$this->table.', Registro id: '.$value['id'].', Valor: '.$nombre;
                        $saveLog=Utils::createLog($idUser,$description);                        
                        foreach ($saveLog as $data1) {                    
                            if($value['status'] != "created"){                                
                                $response[] = ['status' => "error", 'description' => "Log General " . $value['status']];
                                break;
                            }
                        }
                    }                    
                }                
            } else {
                $response[] = ['status' => "error", 'description' => "id_documento, nombre and idUser are Requiredes"];                
            }


        } else {                        
            $response[] = ['status' => "error", 'description' => "Invalid Method"];
        }
        echo json_encode($response);
    }

    public function getOne()
    {
        //Evaluacion de método de recepcion // Formateo de Datos
        $method = $_SERVER['REQUEST_METHOD'];
        if ($method == 'GET') {
            $id = isset($_GET['id']) ? filter_var(trim($_GET['id']), FILTER_SANITIZE_NUMBER_INT) : false;
        } else if ($method == 'POST') {
            $id = isset($_POST['id']) ? filter_var(trim($_POST['id']), FILTER_SANITIZE_NUMBER_INT) : false;
        } else {            
            $response[] = ['status' => "error", 'description' => "Invalid Method"];
        }
        //Obtención de datos
        if ($id) {
            $data = new $this->table();
            $data->setId($id);
            $response = $data->getOne();
        } else {            
            $response[] = ['status' => "error", 'description' => "id is Required"];            
        }
        echo json_encode($response);
    }

    public function getAllxDocumento()
    {
        //Evaluacion de método de recepcion // Formateo de Datos
        $method = $_SERVER['REQUEST_METHOD'];
        if ($method == 'GET') {
            $idDocumento = isset($_GET['id_documento']) ? filter_var(trim($_GET['id_documento']), FILTER_SANITIZE_NUMBER_INT) : false;
        } else if ($method == 'POST') {
            $idDocumento = isset($_POST['id_documento']) ? filter_var(trim($_POST['id_documento']), FILTER_SANITIZE_NUMBER_INT) : false;
        } else {
            $response[] = ['status' => "error", 'description' => "Invalid Method"];
        }
        //Obtención de datos
        if ($idDocumento) {
            $data = new $this->table();
            $data->setIdDocumento($idDocumento);
            $response = $data->getAllxDocumento();
        } else {                        
            $response[] = ['status' => "error", 'description' => "id_documento is Required"]; 
        }
        echo json_encode($response);
    }        

    public function getAllFull()
    {
        //Evaluacion de método de recepcion // Formateo de Datos
        $method = $_SERVER['REQUEST_METHOD'];
        if ($method == 'GET') {
            $data = new $this->table();       
            $response = $data->getAllFull();
        } else {
            $response[] = ['status' => "error", 'description' => "Invalid Method"];
        }
        echo json_encode($response);
    }

    public function find()
    {        
        //Evaluacion de método de recepcion // Formateo de Datos        
        $method = $_SERVER['REQUEST_METHOD'];
        if ($method == 'GET' || $method == 'POST') {            
            $campo = isset($_REQUEST['campo']) ? trim($_REQUEST['campo']) : false;
            $valor = isset($_REQUEST['valor']) ? trim($_REQUEST['valor']) : false;        
        } else {
            $response[] = ['status' => "error", 'description' => "Invalid Method"];
        }                
        
        //Obtención de datos
        if ($campo && $valor) {
            $data = new $this->table();
            $response = $data->find($campo, $valor);            
        } else {            
            $response[] = ['status' => "error", 'description' => "campo and valor are Requiredes"];            
        }
        echo json_encode($response);
    }    

    public function update()
    {
        //Evaluacion de método de recepcion // Formateo de Datos        
        $method = $_SERVER['REQUEST_METHOD'];
        if ($method == 'GET') {
            $id = isset($_GET['id']) ? filter_var(trim($_GET['id']), FILTER_SANITIZE_NUMBER_INT) : false;
            $campo = isset($_GET['campo']) ? trim($_GET['campo']) : false;
            $valor = isset($_GET['valor']) ? trim($_GET['valor']) : false;
            $idUser = isset($_GET['idUser']) ? filter_var(trim($_GET['idUser']), FILTER_SANITIZE_NUMBER_INT) : false;
        } else if ($method == 'POST') {
            $id = isset($_POST['id']) ? filter_var(trim($_POST['id']), FILTER_SANITIZE_NUMBER_INT) : false;
            $campo = isset($_POST['campo']) ? trim($_POST['campo']) : false;
            $valor = isset($_POST['valor']) ? trim($_POST['valor']) : false;
            $idUser = isset($_POST['idUser']) ? filter_var(trim($_POST['idUser']), FILTER_SANITIZE_NUMBER_INT) : false;
        } else {
            $response[] = ['status' => "error", 'description' => "Invalid Method"];
        }
        //Actualización de datos
        if ($id && $campo && $valor && $idUser) {
            $data = new $this->table();
            $data->setId($id);
            //Consulta datos para Log
            $tupla = $data->getOne();
            foreach ($tupla as $value) {
                $dataSave = $value[$campo];
            }
            //fin consulta
            //Update
            $response = $data->update($campo, $valor);
            //Registro en Log General
            foreach ($response as $value) {
                if ($value['status'] == "updated") {                    
                    $description = "Actualizado en Tabla: $this->table, Registro id: $id, Campo: $campo, Dato Anterior:$dataSave, Dato Nuevo: $valor";
                    $saveLog = Utils::createLog($idUser, $description);
                    foreach ($saveLog as $data1) {
                        if ($data1['status'] != "created") {
                            $response[] = ['error' => "Log General " . $data1['status']];
                            break;
                        }
                    }
                }
            }
        } else {
            $response[] = ['error' => "id, campo, valor and  idUser are Requiredes"];
        }
        echo json_encode($response);
    }

    public function delete()
    {
        //Evaluacion de método de recepcion 
        $method = $_SERVER['REQUEST_METHOD'];
        if ($method == 'GET') {
            $id = isset($_GET['id']) ? filter_var(trim($_GET['id']), FILTER_SANITIZE_NUMBER_INT) : false;
            $idUser = isset($_GET['idUser']) ? filter_var(trim($_GET['idUser']), FILTER_SANITIZE_NUMBER_INT) : false;
        } else if ($method == 'POST') {
            $id = isset($_POST['id']) ? filter_var(trim($_POST['id']), FILTER_SANITIZE_NUMBER_INT) : false;
            $idUser = isset($_POST['idUser']) ? filter_var(trim($_POST['idUser']), FILTER_SANITIZE_NUMBER_INT) : false;
        } else {
            $response[] = ['status' => "error", 'description' => "Invalid Method"];
        }
        //Obtención de datos
        if ($id && $idUser) {            
            $data = new $this->table();
            $data->setId($id);
            //Consulta datos para Log
            $tupla = $data->getOne();
            foreach ($tupla as $value) {
                $searchValue = $value['nombre'];
            }
            //fin consulta
            $response = $data->delete();
            //Registro en Log General
            foreach ($response as $value) {
                if ($value['status'] == "deleted") {
                    $description = "Eliminado en Tabla: $this->table, Registro id: $id, Valor: $searchValue";
                    $saveLog = Utils::createLog($idUser, $description);
                    foreach ($saveLog as $data1) {
                        if ($data1['status'] != "created") {
                            $response[] = ['error' => "Log General " . $data1['status']];
                            break;
                        }
                    }
                }
            }
        } else {
            $response[] = ['error' => "id and idUser are Requiredes"];
        }
        echo json_encode($response);
    }
}
