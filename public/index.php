<?php
session_start();
require_once __DIR__ . '/../src/controllers/UserController.php';
require_once __DIR__ . '/../src/controllers/ProjectController.php';
require_once __DIR__ . '/../src/controllers/TaskController.php';

$user_controller = new UserController();
$project_controller = new ProjectController();
$task_controller = new TaskController();

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
        // Add other actions as needed
        default:
            echo json_encode(['success' => false, 'message' => 'Invalid action']);
    }
    exit;
}

// API routes
if (strpos($request_uri, '/api/') === 0) {
    header('Content-Type: application/json');

    if ($request_method === 'POST') {
        if ($request_uri === '/api/register') {
            $data = json_decode(file_get_contents('php://input'), true);
            echo $user_controller->register($data['username'], $data['email'], $data['password']);
        } elseif ($request_uri === '/api/login') {
            $data = json_decode(file_get_contents('php://input'), true);
            echo $user_controller->login($data['username'], $data['password']);
        } elseif ($request_uri === '/api/logout') {
            echo $user_controller->logout();
        } elseif ($request_uri === '/api/projects') {
            $data = json_decode(file_get_contents('php://input'), true);
            echo $project_controller->create($data['name'], $data['description'], $_SESSION['user_id']);
        } elseif ($request_uri === '/api/tasks') {
            $data = json_decode(file_get_contents('php://input'), true);
            echo $task_controller->create($data['project_id'], $data['title'], $data['description'], $data['status'], $data['priority'], $data['assigned_to'], $_SESSION['user_id']);
        }
    } elseif ($request_method === 'GET') {
        if (preg_match('/^\/api\/projects\/(\d+)$/', $request_uri, $matches)) {
            $project_id = $matches[1];
            echo $project_controller->read($project_id);
        } elseif (preg_match('/^\/api\/projects\/(\d+)\/tasks$/', $request_uri, $matches)) {
            $project_id = $matches[1];
            echo $task_controller->read($project_id);
        } 
    } elseif ($request_method === 'PUT') {
        if (preg_match('/^\/api\/tasks\/(\d+)\/status$/', $request_uri, $matches)) {
            $task_id = $matches[1];
            $data = json_decode(file_get_contents('php://input'), true);
            echo $task_controller->updateStatus($task_id, $data['status']);
        }
    }
    exit;
}

// For all non-API requests, serve the main application
include __DIR__ . '/views/app.php';