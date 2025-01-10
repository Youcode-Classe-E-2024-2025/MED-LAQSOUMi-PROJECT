<?php
session_start();
require_once 'includes/utils.php';
require_once 'config/database.php';
require_once 'controllers/UserController.php';
require_once 'controllers/ProjectController.php';
require_once 'controllers/TaskController.php';
require_once 'controllers/AdminController.php';

try {
    $userController = new UserController($db);
    $projectController = new ProjectController($db);
    $taskController = new TaskController($db);
    $adminController = new AdminController($db);

    $action = $_GET['action'] ?? 'home';

    switch ($action) {
        case 'home':
            // Show public projects for guests, dashboard for logged-in users
            if (isLoggedIn()) {
                $userController->dashboard();
            } else {
                $projectController->listPublic();
            }
            break;
        case 'register':
        case 'login':
        case 'logout':
            $userController->$action();
            break;
        case 'user_profile':
            requireLogin();
            $userController->profile();
            break;
        case 'user_update_email':
        case 'user_update_password':
            requireLogin();
            $userController->$action();
            break;
        case 'project_create':
        case 'project_edit':
        case 'project_delete':
        case 'project_view':
        case 'project_list':
            requireLogin();
            $projectController->$action($_GET['id'] ?? null);
            break;
        case 'task_create':
        case 'task_edit':
        case 'task_delete':
        case 'task_update_status':
            requireLogin();
            $taskController->$action($_GET['id'] ?? null);
            break;
        case 'manage_categories':
        case 'manage_tags':
            requireLogin();
            $taskController->$action();
            break;
        case 'admin_dashboard':
        case 'manage_users':
        case 'manage_roles':
        case 'manage_permissions':
            requireAdmin();
            $adminController->$action();
            break;
        default:
            throw new Exception("Invalid action: $action");
    }
} catch (Exception $e) {
    // Log the error
    error_log($e->getMessage());
    
    // Display a user-friendly error message
    $error = "An unexpected error occurred. Please try again later.";
    require 'views/error.php';
}

