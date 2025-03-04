<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS, PATCH");
header("Access-Control-Allow-Headers: Content-Type, Authorization");
header("Content-Type: application/json; charset=UTF-8");

require_once 'config/dataBase.php';
require_once 'models/instructores.php';
require_once 'controllers/InstructoresController.php';

$requestUri = trim($_SERVER['REQUEST_URI'], '/');
$requestParts = explode('/', $requestUri);

$resource = isset($requestParts[1]) ? ucfirst($requestParts[1]) : null;
$action = isset($requestParts[2]) ? $requestParts[2] : null;

$controller = new InstructoresController();

switch ($action) {
    case 'GetInstructores':
        $controller->GetInstructores();
        break;
    case 'AddInstructor':
        $controller->AddInstructor();
        break;
    case 'UpdateInstructor':
        $controller->UpdateInstructor();
        break;
    case 'DeleteInstructor':
        $controller->DeleteInstructor();
        break;
    case 'PatchInstructor':
        $controller->PatchInstructor();
        break;
    default:
        echo json_encode(['status' => 'error', 'message' => 'Endpoint no encontrado']);
        http_response_code(404);
        break;
}