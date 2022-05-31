<?php
class Mailqueue
{
    private $db;
    private $id;
    private $recipients;
    private $subject;
    private $body;
    private $datetime;
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

    public function getRecipients()
    {
        return $this->recipients;
    }

    public function setRecipients($recipients)
    {
        $this->recipients = $recipients;
    }

    public function getSubject()
    {
        return $this->subject;
    }

    public function setSubject($subject)
    {
        $this->subject = $subject;
    }

    public function getBody()
    {
        return $this->body;
    }

    public function setBody($body)
    {
        $this->body = $body;
    }

    public function getDatetime()
    {
        return $this->datetime;
    }

    public function setDatetime($datetime)
    {
        $this->datetime = $datetime;
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
        $sql = "INSERT INTO mailqueue (nombre,id_area,id_categoria,id_tipo_documento,descripcion,nombre_archivo) VALUES (:nombre,:id_area,:id_categoria,:id_tipo_documento,:descripcion,:nombre_archivo)";
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(":nombre", $this->getNombre(), PDO::PARAM_STR);
        $stmt->bindValue(":id_area", $this->getIdArea(), PDO::PARAM_INT);
        $stmt->bindValue(":id_categoria", $this->getIdCategoria(), PDO::PARAM_INT);
        $stmt->bindValue(":id_tipo_documento", $this->getIdTipoDocumento(), PDO::PARAM_INT);
        $stmt->bindValue(":descripcion", $this->getDescripcion(), PDO::PARAM_STR);
        $stmt->bindValue(":nombre_archivo", $this->getNombreArchivo(), PDO::PARAM_STR);
        $stmt->execute();
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
        $sql = "SELECT * FROM documento WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(":id", $this->getId(), PDO::PARAM_INT);
        $stmt->execute();
        return $response = $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getAll()
    {
        $sql = "SELECT * FROM documento WHERE estado = 'A' ORDER BY nombre ASC";
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        return $response = $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getAllFull()
    {
        $sql = "SELECT * FROM documento ORDER BY nombre ASC";
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        return $response = $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getAllxArea()
    {
        $sql = "SELECT * FROM documento WHERE id_area=:id_area AND estado = 'A'";
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(":id_area", $this->getIdArea(), PDO::PARAM_INT);
        $stmt->execute();
        return $response = $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getAllFullxArea()
    {
        $sql = "SELECT * FROM documento WHERE id_area=:id_area";
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(":id_area", $this->getIdArea(), PDO::PARAM_INT);
        $stmt->execute();
        return $response = $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getAllxCategoria()
    {
        $sql = "SELECT * FROM documento WHERE id_categoria=:id_categoria";
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(":id_categoria", $this->getIdCategoria(), PDO::PARAM_INT);
        $stmt->execute();
        return $response = $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getAllxTipoDocumento()
    {
        $sql = "SELECT * FROM documento WHERE id_tipo_documento=:id_tipo_documento AND estado = 'A'";
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(":id_tipo_documento", $this->getIdTipoDocumento(), PDO::PARAM_INT);
        $stmt->execute();
        return $response = $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function find($campo, $valor)
    {
        $sql = "SELECT id FROM documento WHERE $campo LIKE '%$valor%'";
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        return $response = $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getIn($values)
    {
        $sql = "SELECT * FROM documento WHERE id IN ($values)";
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        return $response = $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    //Updates
    public function updateOne()
    {
        $sql = "UPDATE documento SET nombre=:nombre, id_area=:id_area, id_categoria=:id_categoria, id_tipo_documento=:id_tipo_documento, descripcion=:descripcion, nombre_archivo=:nombre_archivo, estado=:estado WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(":nombre", $this->getNombre(), PDO::PARAM_STR);
        $stmt->bindValue(":id_area", $this->getIdArea(), PDO::PARAM_INT);
        $stmt->bindValue(":id_categoria", $this->getIdCategoria(), PDO::PARAM_INT);
        $stmt->bindValue(":id_tipo_documento", $this->getIdTipoDocumento(), PDO::PARAM_INT);
        $stmt->bindValue(":descripcion", $this->getDescripcion(), PDO::PARAM_STR);
        $stmt->bindValue(":nombre_archivo", $this->getNombreArchivo(), PDO::PARAM_STR);
        $stmt->bindValue(":estado", $this->getEstado(), PDO::PARAM_STR);
        $stmt->bindValue(":id", $this->getId(), PDO::PARAM_INT);
        if ($stmt->execute()) {
            $response[] = ['status' => "updated", 'id' => $this->getId()];
        } else {
            $response[] = ['status' => "error", 'description' => "Failed to updated"];
        }
        return $response;
    }

    public function update($campo, $valor)
    {
        $sql = "UPDATE documento SET $campo = $valor WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(":id", $this->getId(), PDO::PARAM_INT);
        if ($stmt->execute()) {
            $response[] = ['status' => "updated", 'id' => $this->getId()];
        } else {
            $response[] = ['status' => "error", 'description' => "Failed to updated"];
        }
        return $response;
    }

    //Deletes
    public function delete()
    {
        $sql = "DELETE FROM documento WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(":id", $this->getId(), PDO::PARAM_INT);
        if ($stmt->execute()) {
            $response[] = ['status' => "deleted", 'id' => $this->getId()];
        } else {
            $response[] = ['status' => "error", 'description' => "Failed to delete"];
        }
        return $response;
    }
}
