<?php
session_start();
require_once 'includes/utils.php';
require_once 'config/database.php';
require_once 'controllers/UserController.php';
require_once 'controllers/ProjectController.php';
require_once 'controllers/TaskController.php';

$userController = new UserController($db);
$projectController = new ProjectController($db);
$taskController = new TaskController($db);

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
    case 'user_profile':
        $userController->profile();
        break;
    case 'user_update_email':
        $userController->updateEmail();
        break;
    case 'user_update_password':
        $userController->updatePassword();
        break;
    case 'project_create':
        $projectController->create();
        break;
    case 'project_list':
        $projectController->list();
        break;
    case 'project_view':
        $projectController->view($_GET['id'] ?? null);
        break;
    case 'project_edit':
        $projectController->edit($_GET['id'] ?? null);
        break;
    case 'project_delete':
        $projectController->delete($_GET['id'] ?? null);
        break;
    case 'task_create':
        $taskController->create();
        break;
    case 'task_edit':
        $taskController->edit($_GET['id'] ?? null);
        break;
    case 'task_delete':
        $taskController->delete($_GET['id'] ?? null);
        break;
    case 'task_update_status':
        $taskController->updateStatus();
        break;
    case 'assigned_tasks':
        $taskController->assignedTasks();
        break;
    case 'kanban':
        $taskController->kanban();
        break;
    default:
        header('Location: index.php?action=dashboard');
        exit;
}

