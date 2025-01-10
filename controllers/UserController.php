<?php

namespace Controllers;

require_once __DIR__ . '/../models/User.php';
require_once __DIR__ . '/../models/Task.php';
require_once __DIR__ . '/../models/Project.php';
require_once __DIR__ . '/../includes/utils.php';

use Models\User;
use Models\Task;
use Models\Project;

class UserController {
    private $user;
    private $task;
    private $project;
    private $db;

    public function __construct($db) {
        $this->db = $db;
        $this->user = new User($db);
        $this->task = new Task($db);
        $this->project = new Project($db);
    }

    public function register() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $name = trim($_POST['name']);
            $email = trim($_POST['email']);
            $password = $_POST['password'];

            if (empty($name) || empty($email) || empty($password)) {
                $error = "All fields are required.";
            } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $error = "Invalid email format.";
            } elseif (strlen($password) < 8) {
                $error = "Password must be at least 8 characters long.";
            } else {
                if ($this->user->create($name, $email, $password)) {
                    setFlashMessage('success', "Registration successful. Please log in.");
                    header('Location: index.php?action=login');
                    exit;
                } else {
                    $error = "Registration failed. Please try again.";
                }
            }
        }
        require 'views/user/register.php';
    }

    public function login() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email = $_POST['email'];
            $password = $_POST['password'];

            if (empty($email) || empty($password)) {
                $error = "Both email and password are required.";
            } else {
                if ($this->user->login($email, $password)) {
                    setFlashMessage('success', "Login successful.");
                    header('Location: index.php?action=dashboard');
                    exit;
                } else {
                    $error = "Invalid email or password.";
                }
            }
        }
        require 'views/user/login.php';
    }

    public function dashboard() {
        if (!isLoggedIn()) {
            header('Location: index.php?action=login');
            exit;
        }
        $user_id = $_SESSION['user_id'];
        $user_role = $_SESSION['user_role'];

        switch ($user_role) {
            case 'admin':
                $this->adminDashboard();
                break;
            case 'project_manager':
                $this->managerDashboard($user_id);
                break;
            default:
                $this->userDashboard($user_id);
                break;
        }
    }

    private function userDashboard($user_id) {
        $taskStats = $this->task->getTaskStatistics($user_id);
        $totalTasks = $taskStats['total_tasks'];
        $completedTasks = $taskStats['completed_tasks'];
        $completionRate = $totalTasks > 0 ? ($completedTasks / $totalTasks) * 100 : 0;

        $projects = $this->project->getAssignedAndPublicProjects($user_id);

        require 'views/user/dashboard.php';
    }

    private function managerDashboard($user_id) {
        $projects = $this->project->getByUserId($user_id);
        $totalProjects = count($projects);
        $completedProjects = 0;
        $totalTasks = 0;
        $completedTasks = 0;

        foreach ($projects as $project) {
            $projectProgress = $this->project->getProjectProgress($project['id']);
            if ($projectProgress == 100) {
                $completedProjects++;
            }
            $projectTasks = $this->task->getByProjectId($project['id']);
            $totalTasks += count($projectTasks);
            $completedTasks += count(array_filter($projectTasks, function($task) {
                return $task['status'] === 'done';
            }));
        }

        $projectCompletionRate = $totalProjects > 0 ? ($completedProjects / $totalProjects) * 100 : 0;
        $taskCompletionRate = $totalTasks > 0 ? ($completedTasks / $totalTasks) * 100 : 0;

        require 'views/manager/dashboard.php';
    }

    private function adminDashboard() {
        $totalUsers = $this->user->getTotalUsers();
        $totalProjects = $this->project->getTotalProjects();
        $totalTasks = $this->task->getTotalTasks();

        $projectManagers = $this->user->getUsersByRole('project_manager');
        $recentActivities = $this->getRecentActivities(10); // Get 10 most recent activities

        require 'views/admin/dashboard.php';
    }

    public function logout() {
        session_destroy();
        setFlashMessage('success', "You have been logged out.");
        header('Location: index.php?action=login');
        exit;
    }

    public function profile() {
        if (!isLoggedIn()) {
            header('Location: index.php?action=login');
            exit;
        }
        $user = $this->user->getById($_SESSION['user_id']);
        require 'views/user/profile.php';
    }

    public function updateEmail() {
        if (!isLoggedIn()) {
            header('Location: index.php?action=login');
            exit;
        }
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $newEmail = $_POST['new_email'];
            if ($this->user->updateEmail($_SESSION['user_id'], $newEmail)) {
                setFlashMessage('success', "Email updated successfully.");
            } else {
                setFlashMessage('error', "Failed to update email.");
            }
        }
        header('Location: index.php?action=user_profile');
        exit;
    }

    public function updatePassword() {
        if (!isLoggedIn()) {
            header('Location: index.php?action=login');
            exit;
        }
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $currentPassword = $_POST['current_password'];
            $newPassword = $_POST['new_password'];
            $confirmPassword = $_POST['confirm_password'];

            if ($newPassword !== $confirmPassword) {
                setFlashMessage('error', "New passwords do not match.");
            } elseif (!$this->user->verifyPassword($_SESSION['user_id'], $currentPassword)) {
                setFlashMessage('error', "Current password is incorrect.");
            } elseif ($this->user->updatePassword($_SESSION['user_id'], $newPassword)) {
                setFlashMessage('success', "Password updated successfully.");
            } else {
                setFlashMessage('error', "Failed to update password.");
            }
        }
        header('Location: index.php?action=user_profile');
        exit;
    }

    private function getRecentActivities($limit) {
        // This is a placeholder. In a real application, you would fetch this data from your database.
        return [
            ['type' => 'Task Update', 'description' => 'Task "Implement login" marked as complete', 'date' => '2023-05-10 14:30:00'],
            ['type' => 'New Project', 'description' => 'Project "Website Redesign" created', 'date' => '2023-05-09 09:15:00'],
            ['type' => 'New User', 'description' => 'User "John Doe" registered', 'date' => '2023-05-08 16:45:00'],
        ];
    }

    public function manageUsers() {
        // Check if the current user is an admin
        if ($_SESSION['user_role'] !== 'admin') {
            setFlashMessage('error', "You don't have permission to access this page.");
            header('Location: index.php?action=dashboard');
            exit;
        }

        $users = $this->user->getAll();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $userId = $_POST['user_id'];
            $newRole = $_POST['new_role'];

            if ($this->user->updateRole($userId, $newRole)) {
                setFlashMessage('success', "User role updated successfully.");
            } else {
                setFlashMessage('error', "Failed to update user role.");
            }
            header('Location: index.php?action=manage_users');
            exit;
        }

        require 'views/admin/manage_users.php';
    }
}

