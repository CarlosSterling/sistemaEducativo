<?php
require_once ('config/dataBase.php');
require_once('models/instructores.php');

class InstructoresController {
    private $db;
    private $instructores;

    public function __construct() {
        $database = new Database();
        $this->db = $database->getConnection();
        $this->instructores = new Instructores($this->db);
    }

    public function GetInstructores() {
        try {
            $stmt = $this->instructores->getAll();
            $instructores = $stmt->fetchAll(PDO::FETCH_ASSOC);
            echo json_encode([
                'status' => 'success',
                'data' => $instructores
            ]);
            http_response_code(200);
        } catch (Exception $e) {
            echo json_encode([
                'status' => 'error',
                'message' => $e->getMessage()
            ]);
            http_response_code(500);
        }
    }

    public function AddInstructor() {
        $data = json_decode(file_get_contents('php://input'), true);
        if ($this->instructores->add($data['nombre'], $data['correo'])) {
            echo json_encode(['status' => 'success', 'message' => 'Instructor agregado']);
            http_response_code(201);
        }
    }

    public function UpdateInstructor() {
        $data = json_decode(file_get_contents('php://input'), true);
        if ($this->instructores->update($data['id'], $data['nombre'], $data['correo'])) {
            echo json_encode(['status' => 'success', 'message' => 'Instructor actualizado']);
            http_response_code(200);
        }
    }

  public function DeleteInstructor() {
        $data = json_decode(file_get_contents('php://input'), true);
        if ($this->instructores->delete($data['id'])) {
            echo json_encode(['status' => 'success', 'message' => 'Instructor eliminado']);
            http_response_code(200);
        }
    }

    public function PatchInstructor() {
        $data = json_decode(file_get_contents('php://input'), true);
        if (isset($data['id'])) {
            $currentData = $this->instructores->getById($data['id']);
            $nombre = isset($data['nombre']) ? $data['nombre'] : $currentData['nombre'];
            $correo = isset($data['correo']) ? $data['correo'] : $currentData['correo'];

            if ($this->instructores->update($data['id'], $nombre, $correo)) {
                echo json_encode(['status' => 'success', 'message' => 'Instructor actualizado parcialmente']);
                http_response_code(200);
            } else {
                echo json_encode(['status' => 'error', 'message' => 'No se pudo actualizar el instructor']);
                http_response_code(500);
            }
        } else {
            echo json_encode(['status' => 'error', 'message' => 'ID del instructor no proporcionado']);
            http_response_code(400);
        }
    }
}