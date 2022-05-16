<?php
class DocumentoTag
{
    private $db;
    private $id;    
    private $idDocumento;    
    private $nombre;

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

    public function getIdDocumento() {
        return $this->idDocumento;
    }
     
    public function setIdDocumento($idDocumento) {
        $this->idDocumento = $idDocumento;
    }

    public function getNombre() {
        return $this->nombre;
    }
     
    public function setNombre($nombre) {
        $this->nombre = $nombre;
    }


    //Creates    
    public function create()
    {
        $sql = "INSERT INTO documento_tag (id_documento,nombre) VALUES (:id_documento,:nombre)";
        $stmt = $this->db->prepare($sql);        
        $stmt->bindValue(":id_documento", $this->getIdDocumento(), PDO::PARAM_INT);
        $stmt->bindValue(":nombre", $this->getNombre(), PDO::PARAM_STR);
        $stmt->execute();
        if ($id = $this->db->lastInsertId()) {
            $response[] = ['status' => "created",'id' => $id];        
        } else {
            $response[] = ['status' => "error", 'description' => "Failed to create"];
        }
        return $response;
    }

    //Readers
    public function getOne()
    {
        $sql = "SELECT * FROM documento_tag WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(":id", $this->getId(), PDO::PARAM_INT);
        $stmt->execute();
        return $response = $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getAllxDocumento()
    {
        $sql = "SELECT * FROM documento_tag WHERE id_documento=:id_documento";
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(":id_documento",$this->getIdDocumento(),PDO::PARAM_INT);
        $stmt->execute();
        return $response = $stmt->fetchAll(PDO::FETCH_ASSOC);
    }    

    public function getAllFull()
    {
        $sql = "SELECT * FROM documento_tag";
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        return $response = $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function find($campo,$valor)
    {
        $sql = "SELECT id_documento FROM documento_tag WHERE $campo LIKE '%$valor%'";
        $stmt = $this->db->prepare($sql);        
        $stmt->execute();
        return $response = $stmt->fetchAll(PDO::FETCH_ASSOC);
    }     

    //Updates
    public function update($campo,$valor){        
        $sql = "UPDATE documento_tag SET $campo = $valor WHERE id = :id";                
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
        $sql = "DELETE FROM documento_tag WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(":id", $this->getId(), PDO::PARAM_INT);
        if ($stmt->execute()) {
            $response[] = ['status' => "deleted",'id' => $this->getId()];
        } else {
            $response[] = ['status' => "error", 'description' => "Failed to delete"];
        }        
        return $response;
    }
}
?>
