<?php
session_start();
require_once __DIR__ . '/config/database.php';
require_once __DIR__ . '/controllers/UserController.php';
require_once __DIR__ . '/controllers/ProjectController.php';
require_once __DIR__ . '/controllers/TaskController.php';
require_once __DIR__ . '/controllers/TagController.php';
require_once __DIR__ . '/includes/utils.php';

use Controllers\UserController;
use Controllers\ProjectController;
use Controllers\TaskController;
use Controllers\TagController;

$db = getDatabaseConnection();

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
        $projectController->$action($_GET['id'] ?? null);
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
        $tagController->$action();
        break;
    case 'user_projects':
        $projectController->userProjects();
        break;
    case 'project_kanban':
        $projectController->kanbanBoard($_GET['id']);
        break;
    case 'user_tasks':
        $taskController->userTasks();
        break;
    default:
        setFlashMessage('error', "Invalid action.");
        header('Location: index.php?action=dashboard');
        exit;
}

