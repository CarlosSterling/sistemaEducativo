<?php
class Instructores {
    private $connect;
    private $tableName = "instructores";
    public $id;
    public $nombre;
    public $correo;

    public function __construct($db) {
        $this->connect = $db;
    }

    public function getAll() {
        try {
            $query = "SELECT * FROM $this->tableName";
            $stmt = $this->connect->prepare($query);
            $stmt->execute();
            return $stmt;
        } catch (PDOException $e) {
            echo json_encode(['status' => 'error', 'message' => $e->getMessage()]);
            http_response_code(500);
        }
    }
    public function getById($id) {
        try {
            $query = "SELECT * FROM $this->tableName WHERE id = :id";
            $stmt = $this->connect->prepare($query);
            $stmt->bindParam(':id', $id);
            $stmt->execute();
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            echo json_encode(['status' => 'error', 'message' => $e->getMessage()]);
            http_response_code(500);
        }
    }

    public function add($nombre, $correo) {
        try {
            $query = "INSERT INTO $this->tableName (nombre, correo) VALUES (:nombre, :correo)";
            $stmt = $this->connect->prepare($query);
            $stmt->bindParam(':nombre', $nombre);
            $stmt->bindParam(':correo', $correo);
            return $stmt->execute();
        } catch (PDOException $e) {
            echo json_encode(['status' => 'error', 'message' => $e->getMessage()]);
            http_response_code(500);
        }
    }

    public function update($id, $nombre, $correo) {
        try {
            $query = "UPDATE $this->tableName SET nombre = :nombre, correo = :correo WHERE id = :id";
            $stmt = $this->connect->prepare($query);
            $stmt->bindParam(':id', $id);
            $stmt->bindParam(':nombre', $nombre);
            $stmt->bindParam(':correo', $correo);
            return $stmt->execute();
        } catch (PDOException $e) {
            echo json_encode(['status' => 'error', 'message' => $e->getMessage()]);
            http_response_code(500);
        }
    }

    public function delete($id) {
        try {
            $query = "DELETE FROM $this->tableName WHERE id = :id";
            $stmt = $this->connect->prepare($query);
            $stmt->bindParam(':id', $id);
            return $stmt->execute();
        } catch (PDOException $e) {
            echo json_encode(['status' => 'error', 'message' => $e->getMessage()]);
            http_response_code(500);
        }
    }
}