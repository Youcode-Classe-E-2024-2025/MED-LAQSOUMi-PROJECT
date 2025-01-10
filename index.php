<?php
session_start();
require_once 'config/database.php';
require_once 'controllers/UserController.php';
require_once 'controllers/ProjectController.php';
require_once 'controllers/TaskController.php';
require_once 'controllers/TagController.php';
require_once 'includes/utils.php';

$userController = new UserController($db);
$projectController = new ProjectController($db);
$taskController = new TaskController($db);
$tagController = new TagController($db);

$action = $_GET['action'] ?? 'login';

if (!isLoggedIn() && !in_array($action, ['login', 'register'])) {
    header('Location: index.php?action=login');
    exit;
}

switch ($action) {
    case 'register':
    case 'login':
    case 'logout':
    case 'dashboard':
        $userController->$action();
        break;
    case 'project_create':
    case 'project_view':
    case 'project_edit':
    case 'project_delete':
    case 'project_list':
        $projectController->project_list();
        break;
    case 'task_create':
    case 'task_edit':
    case 'task_delete':
        $taskController->$action($_GET['id'] ?? null);
        break;
    case 'move_task':
        $taskController->moveTask();
        break;
    case 'tag_create':
    case 'tag_list':
        $tagController->tag_list();
        break;
    default:
        setFlashMessage('error', "Invalid action.");
        header('Location: index.php?action=dashboard');
        exit;
}

