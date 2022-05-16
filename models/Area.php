<?php
class Area
{
    private $db;
    private $id;    
    private $nombre;
    private $cod_archivistico;    
    private $estado;

    function __construct()
    {
        $this->db = Database::Connect();
    }

    public function getId()
    {
        return $this->id;
    }
    public function setId($id)
    {
        $this->id = $id;
    }

    public function getNombre()
    {
        return $this->nombre;
    }
    public function setNombre($nombre)
    {
        $this->nombre = $nombre;
    }

    public function getCodArchivistico()
    {
        return $this->cod_archivistico;
    }
    public function setCodArchivistico($cod_archivistico)
    {
        $this->cod_archivistico = $cod_archivistico;
    }

    public function getEstado()
    {
        return $this->estado;
    }
    public function setEstado($estado)
    {
        $this->estado = $estado;
    }

    //Creates
    public function create()
    {
        $sql = "INSERT INTO area (nombre,cod_archivistico) VALUES (:nombre,:cod_archivistico)";    
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(":nombre", $this->getNombre(), PDO::PARAM_STR);        
        $stmt->bindValue(":cod_archivistico", $this->getCodArchivistico(), PDO::PARAM_STR);
        $stmt->execute();
        //$error = $stmt->errorInfo();
        if ($id = $this->db->lastInsertId()) {
            $response[] = ['status' => "created", 'id' => $id];
        } else {
            $response[] = ['status' => "error", 'description' => "Failed to create"];
        }
        return $response;
    }
    //Readers
    public function getOne()
    {
        $sql = "SELECT * FROM area WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(":id", $this->getId(), PDO::PARAM_INT);
        $stmt->execute();
        return $response = $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getAll()
    {
        $sql = "SELECT * FROM area WHERE estado = 'A' ORDER BY nombre ASC";
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        return $response = $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getAllFull()
    {
        $sql = "SELECT * FROM area ORDER BY nombre ASC";
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        return $response = $stmt->fetchAll(PDO::FETCH_ASSOC);            
    }

    //Updates
    public function update($campo,$valor){        
        $sql = "UPDATE area SET $campo = $valor WHERE id = :id";                
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(":id", $this->getId(), PDO::PARAM_INT);
        if ($stmt->execute()) {
            $response[] = ['status' => "updated",'id' => $this->getId()];
        } else {
            $response[] = ['status' => "error", 'description' => "Failed to updated"];
        }        
        return $response;
    }

    //Deletes
    public function delete()
    {
        $sql = "DELETE FROM area WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(":id", $this->getId(), PDO::PARAM_INT);
        if ($stmt->execute()) {
            $response[] = ['status' => "deleted",'id' => $this->getId()];
        } else {
            $response[] = ['status' => "error", 'description' => "Failed to deleted"];            
        }        
        return $response;
    }
}
?>
