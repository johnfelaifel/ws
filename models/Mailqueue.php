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
        $sql = "INSERT INTO mailqueue (recipients,subject,body,datetime,estado) VALUES (:recipients,:subject,:body,NOW(),'P')";
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(":recipients", $this->getRecipients(), PDO::PARAM_STR);
        $stmt->bindValue(":subject", $this->getSubject(), PDO::PARAM_INT);
        $stmt->bindValue(":body", $this->getBody(), PDO::PARAM_INT);
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
        $sql = "SELECT * FROM mailqueue WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(":id", $this->getId(), PDO::PARAM_INT);
        $stmt->execute();
        return $response = $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getAllE()
    {
        $sql = "SELECT * FROM mailqueue WHERE estado = 'E' ORDER BY datetime DESC";
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        return $response = $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getAllP()
    {
        $sql = "SELECT * FROM mailqueue WHERE estado = 'P' ORDER BY datetime DESC";
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        return $response = $stmt->fetchAll(PDO::FETCH_ASSOC);
    }    

    public function getAllFull()
    {
        $sql = "SELECT * FROM mailqueue ORDER BY datetime DESC";
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        return $response = $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    //Updates
    public function updateOne()
    {
        $sql = "UPDATE mailqueue SET recipients=:recipients, subject=:subject, body=:body, estado=:estado WHERE id = :id";             
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(":recipients", $this->getRecipients(), PDO::PARAM_STR);
        $stmt->bindValue(":subject", $this->getSubject(), PDO::PARAM_INT);
        $stmt->bindValue(":body", $this->getBody(), PDO::PARAM_INT);
        $stmt->bindValue(":estado", $this->getEstado(), PDO::PARAM_INT);
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
        $sql = "UPDATE mailqueue SET $campo = $valor WHERE id = :id";
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
        $sql = "DELETE FROM mailqueue WHERE id = :id";
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
