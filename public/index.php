<?php
session_start();
require_once __DIR__ . '/../src/controllers/UserController.php';
require_once __DIR__ . '/../src/controllers/ProjectController.php';
require_once __DIR__ . '/../src/controllers/TaskController.php';

$user_controller = new UserController();
$project_controller = new ProjectController();
$task_controller = new TaskController();

$request_method = $_SERVER['REQUEST_METHOD'];

if (isset($_GET['action'])) {
    header('Content-Type: application/json');
    
    switch ($_GET['action']) {
        case 'getUserProjects':
            echo $project_controller->getUserProjects($_SESSION['user_id']);
            break;
        case 'getProjectTasks':
            if (isset($_GET['project_id'])) {
                echo $task_controller->read($_GET['project_id']);
            } else {
                echo json_encode(['success' => false, 'message' => 'Project ID is required']);
            }
            break;
        case 'register':
            if ($request_method === 'POST') {
                $data = json_decode(file_get_contents('php://input'), true);
                echo $user_controller->register($data['username'], $data['email'], $data['password']);
            } else {
                echo json_encode(['success' => false, 'message' => 'Invalid request method']);
            }
            break;
        case 'login':
            if ($request_method === 'POST') {
                $data = json_decode(file_get_contents('php://input'), true);
                echo $user_controller->login($data['username'], $data['password']);
            } else {
                echo json_encode(['success' => false, 'message' => 'Invalid request method']);
            }
            break;
        case 'logout':
            if ($request_method === 'POST') {
                echo $user_controller->logout();
            } else {
                echo json_encode(['success' => false, 'message' => 'Invalid request method']);
            }
            break;
        case 'createProject':
            if ($request_method === 'POST') {
                $data = json_decode(file_get_contents('php://input'), true);
                echo $project_controller->create($data['name'], $data['description'], $_SESSION['user_id']);
            } else {
                echo json_encode(['success' => false, 'message' => 'Invalid request method']);
            }
            break;
        case 'createTask':
            if ($request_method === 'POST') {
                $data = json_decode(file_get_contents('php://input'), true);
                echo $task_controller->create($data['project_id'], $data['title'], $data['description'], $data['status'], $data['priority'], $data['assigned_to'], $_SESSION['user_id']);
            } else {
                echo json_encode(['success' => false, 'message' => 'Invalid request method']);
            }
            break;
        case 'getProject':
            if ($request_method === 'GET' && isset($_GET['project_id'])) {
                echo $project_controller->read($_GET['project_id']);
            } else {
                echo json_encode(['success' => false, 'message' => 'Invalid request or missing project ID']);
            }
            break;
        case 'updateTaskStatus':
            if ($request_method === 'PUT' && isset($_GET['task_id'])) {
                $data = json_decode(file_get_contents('php://input'), true);
                echo $task_controller->updateStatus($_GET['task_id'], $data['status']);
            } else {
                echo json_encode(['success' => false, 'message' => 'Invalid request or missing task ID']);
            }
            break;
        default:
            echo json_encode(['success' => false, 'message' => 'Invalid action']);
    }
    exit;
}

// For all non-API requests, serve the main application
include __DIR__ . '/views/app.php';