<?php
include_once 'config/url.php'; 
include_once 'config/connection.php';
class ConsultGet {
    private $conn;

    public function __construct($connection) {
        $this->conn = $connection;
    }

    public function getPatientRecords($id = null) {
        if ($id) {
            $query = 'SELECT * FROM patient_record WHERE id = :id';
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(':id', $id);
            $stmt->execute();
            return $stmt->fetch();
        } else {
            $query = 'SELECT * FROM patient_record';
            $stmt = $this->conn->prepare($query);
            $stmt->execute();
            return $stmt->fetchAll();
        }
    }
}

class ConsultPost {
    private $conn;

    public function __construct($connection) {
        $this->conn = $connection;
    }

    public function searchPatientRecords($search) {
        $query = 'SELECT * FROM patient_record WHERE name LIKE :search';
        $stmt = $this->conn->prepare($query);
        $stmt->bindValue(':search', '%' . $search . '%');
        $stmt->execute();
        return $stmt->fetchAll();
    }
}
