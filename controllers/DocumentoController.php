<?php
require_once 'config/parameters.php';
require_once 'config/db.php';
require_once 'models/Documento.php';
require_once 'models/LogGeneral.php';
require_once 'helpers/Utils.php';

class DocumentoController
{
    private $table = "Documento";

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
            $nombre = isset($_REQUEST['nombre']) ? trim($_REQUEST['nombre']) : false;
            $idArea = isset($_REQUEST['id_area']) ? filter_var(trim($_REQUEST['id_area']), FILTER_SANITIZE_NUMBER_INT) : false;
            $idCategoria = isset($_REQUEST['id_categoria']) ? filter_var(trim($_REQUEST['id_categoria']), FILTER_SANITIZE_NUMBER_INT) : false;
            $idTipoDocumento = isset($_REQUEST['id_tipo_documento']) ? filter_var(trim($_REQUEST['id_tipo_documento']), FILTER_SANITIZE_NUMBER_INT) : false;
            $descripcion = isset($_REQUEST['descripcion']) ? trim($_REQUEST['descripcion']) : false;
            $nombreArchivo = isset($_REQUEST['nombre_archivo']) ? trim($_REQUEST['nombre_archivo']) : false;
            $idUser = isset($_REQUEST['idUser']) ? filter_var(trim($_REQUEST['idUser']), FILTER_SANITIZE_NUMBER_INT) : false;

            //Creación de Objeto con datos // Almacenamiento de Datos
            if ($nombre && $idArea && $idCategoria && $idTipoDocumento && $descripcion && $nombreArchivo && $idUser) {
                $data = new $this->table();
                $data->setNombre($nombre);
                $data->setIdArea($idArea);
                $data->setIdCategoria($idCategoria);
                $data->setIdTipoDocumento($idTipoDocumento);
                $data->setDescripcion($descripcion);
                $data->setNombreArchivo($nombreArchivo);
                $response = $data->create();
                //Registro en Log General
                foreach ($response as $value) {
                    if ($value['status'] == "created") {
                        $description = 'Creado en Tabla: ' . $this->table . ', Registro id: ' . $value['id'] . ', Valor: ' . $nombre;
                        $saveLog = Utils::createLog($idUser, $description);
                        foreach ($saveLog as $data1) {
                            if ($value['status'] != "created") {
                                $response[] = ['status' => "error", 'description' => "Log General " . $value['status']];
                                break;
                            }
                        }
                    }
                }
            } else {
                $response[] = ['status' => "error", 'description' => "nombre, id_area, id_categoria, id_tipo_documento, descripcion, nombre_archivo and idUser are Requiredes"];
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

    public function getAll()
    {
        //Evaluacion de método de recepcion // Formateo de Datos
        $method = $_SERVER['REQUEST_METHOD'];
        if ($method == 'GET') {
            $data = new $this->table();
            $response = $data->getAll();
        } else {
            $response[] = ['status' => "error", 'description' => "Invalid Method"];
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

    public function getAllxArea()
    {
        //Evaluacion de método de recepcion // Formateo de Datos
        $method = $_SERVER['REQUEST_METHOD'];
        if ($method == 'POST' || $method == 'GET') {
            $id = isset($_REQUEST['id_area']) ? filter_var(trim($_REQUEST['id_area']), FILTER_SANITIZE_NUMBER_INT) : false;
        } else {
            $response[] = ['status' => "error", 'description' => "Invalid Method"];
        }
        //Obtención de datos
        if ($id) {
            $data = new $this->table();
            $data->setIdArea($id);
            $response = $data->getAllxArea();
        } else {
            $response[] = ['status' => "error", 'description' => "id_area is Required"];
        }
        echo json_encode($response);
    }

    public function getAllxCategoria()
    {
        //Evaluacion de método de recepcion // Formateo de Datos
        $method = $_SERVER['REQUEST_METHOD'];
        if ($method == 'POST' || $method == 'GET') {
            $id = isset($_REQUEST['id_categoria']) ? filter_var(trim($_REQUEST['id_categoria']), FILTER_SANITIZE_NUMBER_INT) : false;
        } else {
            $response[] = ['status' => "error", 'description' => "Invalid Method"];
        }
        //Obtención de datos
        if ($id) {
            $data = new $this->table();
            $data->setIdCategoria($id);
            $response = $data->getAllxCategoria();
        } else {
            $response[] = ['status' => "error", 'description' => "id_categoria is Required"];
        }
        echo json_encode($response);
    }

    public function getAllxTipoDocumento()
    {
        //Evaluacion de método de recepcion // Formateo de Datos
        $method = $_SERVER['REQUEST_METHOD'];
        if ($method == 'POST' || $method == 'GET') {
            $id = isset($_REQUEST['id_tipo_documento']) ? filter_var(trim($_REQUEST['id_tipo_documento']), FILTER_SANITIZE_NUMBER_INT) : false;
        } else {
            $response[] = ['status' => "error", 'description' => "Invalid Method"];
        }
        //Obtención de datos
        if ($id) {
            $data = new $this->table();
            $data->setIdTipoDocumento($id);
            $response = $data->getAllxTipoDocumento();
        } else {
            $response[] = ['status' => "error", 'description' => "id_tipo_documento is Required"];
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

    public function getIn()
    {
        //Evaluacion de método de recepcion // Formateo de Datos        
        $method = $_SERVER['REQUEST_METHOD'];
        if ($method == 'GET' || $method == 'POST') {
            $values = isset($_REQUEST['valores']) ? trim($_REQUEST['valores']) : false;
        } else {
            $response[] = ['status' => "error", 'description' => "Invalid Method"];
        }

        //Obtención de datos
        if ($values) {
            //DOC:2022-04-26:Revision de formato correcto
            $lastChar = substr(trim($values), -1);
            if ($lastChar == "0" || $lastChar == "1" || $lastChar == "2" || $lastChar == "3" || $lastChar == "4" || $lastChar == "5" || $lastChar == "6" || $lastChar == "7" || $lastChar == "8" || $lastChar == "9") {
                $data = new $this->table();
                $response = $data->getIn($values);
            } else {
                $response[] = ['status' => "error", 'description' => "error in values format (correct example: 1,526,36)"];
            }
        } else {
            $response[] = ['status' => "error", 'description' => "valores is Required"];
        }
        echo json_encode($response);
    }

    public function updateOne()
    {
        //Evaluacion de método de recepcion // Formateo de Datos        
        $method = $_SERVER['REQUEST_METHOD'];
        if ($method == 'GET' || $method == 'POST') {
            $id = isset($_REQUEST['id']) ? filter_var(trim($_REQUEST['id']), FILTER_SANITIZE_NUMBER_INT) : false;
            $nombre = isset($_REQUEST['nombre']) ? trim($_REQUEST['nombre']) : false;
            $idArea = isset($_REQUEST['id_area']) ? filter_var(trim($_REQUEST['id_area']), FILTER_SANITIZE_NUMBER_INT) : false;
            $idCategoria = isset($_REQUEST['id_categoria']) ? filter_var(trim($_REQUEST['id_categoria']), FILTER_SANITIZE_NUMBER_INT) : false;
            $idTipoDocumento = isset($_REQUEST['id_tipo_documento']) ? filter_var(trim($_REQUEST['id_tipo_documento']), FILTER_SANITIZE_NUMBER_INT) : false;            
            $tags = isset($_REQUEST['tags']) ? trim($_REQUEST['tags']) : false;
            $descripcionDocumento = isset($_REQUEST['descripcion']) ? trim($_REQUEST['descripcion']) : false;
            $nombreArchivo = isset($_REQUEST['nombre_archivo']) ? trim($_REQUEST['nombre_archivo']) : false;
            $estado = isset($_REQUEST['estado']) ? trim($_REQUEST['estado']) : false;
            $idUser = isset($_REQUEST['idUser']) ? filter_var(trim($_REQUEST['idUser']), FILTER_SANITIZE_NUMBER_INT) : false;
        } else {
            $response[] = ['error' => "Method Invalid"];
        }
        //Actualización de datos
        if ($id && $nombre && $idArea && $idCategoria && $idTipoDocumento && $descripcionDocumento && $nombreArchivo && $estado && $idUser) {
            $data = new $this->table();
            $data->setId($id);
            //Consulta datos de comparación
            $tupla = $data->getOne();
            foreach ($tupla as $value) {
                $nombreSave = $value['nombre'];
                $idAreaSave = $value['id_area'];
                $idCategoriaSave = $value['id_categoria'];
                $idTipoDocumentoSave = $value['id_tipo_documento'];
                $nombreArchivoSave = $value['nombre_archivo'];
                $descripcionSave = $value['descripcion'];
                $estadoSave = $value['estado'];
            }
            //Update one row
            $data->setNombre($nombre);
            $data->setIdArea($idArea);
            $data->setIdCategoria($idCategoria);
            $data->setIdTipoDocumento($idTipoDocumento);
            $data->setDescripcion($descripcionDocumento);
            $data->setNombreArchivo($nombreArchivo);
            $data->setEstado($estado);
            $response = $data->updateOne();

            //Registro en Log General
            foreach ($response as $value) {
                if ($value['status'] == "updated") {
                    //Adicion de cambios al Log
                    if ($nombreSave != $nombre) {
                        $campo = "nombre";
                        $dataSave = $nombreSave;
                        $newData = $nombre;
                        $description = "Actualizado en Tabla: $this->table, Registro id: $id, Campo: $campo, Dato Anterior:$dataSave, Dato Nuevo: $newData";
                        $saveLog = Utils::createLog($idUser, $description);
                        foreach ($saveLog as $data1) {
                            if ($data1['status'] != "created") {
                                $response[] = ['error' => "Log General " . $data1['status']];
                                break;
                            }
                        }
                    }

                    //Adicion de cambios al Log
                    if ($idAreaSave != $idArea) {
                        $campo = "id_area";
                        $dataSave = $idAreaSave;
                        $newData = $idArea;
                        $description = "Actualizado en Tabla: $this->table, Registro id: $id, Campo: $campo, Dato Anterior:$dataSave, Dato Nuevo: $newData";
                        $saveLog = Utils::createLog($idUser, $description);
                        foreach ($saveLog as $data1) {
                            if ($data1['status'] != "created") {
                                $response[] = ['error' => "Log General " . $data1['status']];
                                break;
                            }
                        }
                    }

                    //Adicion de cambios al Log
                    if ($idCategoriaSave != $idCategoria) {
                        $campo = "id_categoria";
                        $dataSave = $idCategoriaSave;
                        $newData = $idCategoria;
                        $description = "Actualizado en Tabla: $this->table, Registro id: $id, Campo: $campo, Dato Anterior:$dataSave, Dato Nuevo: $newData";
                        $saveLog = Utils::createLog($idUser, $description);
                        foreach ($saveLog as $data1) {
                            if ($data1['status'] != "created") {
                                $response[] = ['error' => "Log General " . $data1['status']];
                                break;
                            }
                        }
                    }

                    //Adicion de cambios al Log
                    if ($idTipoDocumentoSave != $idTipoDocumento) {
                        $campo = "id_tipo_documento";
                        $dataSave = $idTipoDocumentoSave;
                        $newData = $idTipoDocumento;
                        $description = "Actualizado en Tabla: $this->table, Registro id: $id, Campo: $campo, Dato Anterior:$dataSave, Dato Nuevo: $newData";
                        $saveLog = Utils::createLog($idUser, $description);
                        foreach ($saveLog as $data1) {
                            if ($data1['status'] != "created") {
                                $response[] = ['error' => "Log General " . $data1['status']];
                                break;
                            }
                        }
                    }

                    //Adicion de cambios al Log
                    if ($descripcionSave != $descripcionDocumento) {
                        $campo = "descripcion";
                        $dataSave = $descripcionSave;
                        $newData = $descripcionDocumento;
                        $description = "Actualizado en Tabla: $this->table, Registro id: $id, Campo: $campo, Dato Anterior:$dataSave, Dato Nuevo: $newData";
                        $saveLog = Utils::createLog($idUser, $description);
                        foreach ($saveLog as $data1) {
                            if ($data1['status'] != "created") {
                                $response[] = ['error' => "Log General " . $data1['status']];
                                break;
                            }
                        }
                    }

                    //Adicion de cambios al Log
                    if ($nombreArchivoSave != $nombreArchivo) {
                        //DOC:2022-04-25: Elimina el archivo existente al ser reemplazado por uno nuevo
                        $path = SERVER_RELATIVE . 'Storage/' . $nombreArchivoSave;
                        unlink($path);

                        $campo = "nombre_archivo";
                        $dataSave = $nombreArchivoSave;
                        $newData = $nombreArchivo;
                        $description = "Actualizado en Tabla: $this->table, Registro id: $id, Campo: $campo, Dato Anterior:$dataSave, Dato Nuevo: $newData";
                        $saveLog = Utils::createLog($idUser, $description);
                        foreach ($saveLog as $data1) {
                            if ($data1['status'] != "created") {
                                $response[] = ['error' => "Log General " . $data1['status']];
                                break;
                            }
                        }
                    }

                    //Adicion de cambios al Log
                    if ($estadoSave != $estado) {
                        $campo = "estado";
                        $dataSave = $estadoSave;
                        $newData = $estado;
                        $description = "Actualizado en Tabla: $this->table, Registro id: $id, Campo: $campo, Dato Anterior:$dataSave, Dato Nuevo: $newData";
                        $saveLog = Utils::createLog($idUser, $description);
                        foreach ($saveLog as $data1) {
                            if ($data1['status'] != "created") {
                                $response[] = ['error' => "Log General " . $data1['status']];
                                break;
                            }
                        }
                    }
                }
            }

            //Registro de Tags Asociados
            if ($tags) {
                $tags = explode(",", $tags);
                foreach ($tags as $valor) {
                    $descripcion = str_replace(" ", "%20", trim($valor));
                    $consulta = BASE_URL . "DocumentoTag/create&id_documento=" . $id . "&nombre=" . $descripcion . "&idUser=" . $idUser;
                    file_get_contents($consulta);
                }
            }            

        } else {
            $response[] = ['error' => "id, nombre, id_area, id_categoria, id_tipo_documento, descripcion, nombre_archivo, estado and  idUser are Requiredes"];
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
                            $response[] = ['status' => "error", 'description' => "Log General " . $data1['status']];
                            break;
                        }
                    }
                }
            }
        } else {
            $response[] = ['status' => "error", 'description' => "id, campo, valor and  idUser are Requiredes"];
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
        } else if ($method == 'DELETE') {
            $id = isset($_DELETE['id']) ? filter_var(trim($_DELETE['id']), FILTER_SANITIZE_NUMBER_INT) : false;
            $idUser = isset($_DELETE['idUser']) ? filter_var(trim($_DELETE['idUser']), FILTER_SANITIZE_NUMBER_INT) : false;
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
                            $response[] = ['status' => "error", 'description' => "Log General " . $data1['status']];
                            break;
                        }
                    }
                }
            }
        } else {
            $response[] = ['status' => "error", 'description' => "id and idUser are Requiredes"];
        }
        echo json_encode($response);
    }
}
