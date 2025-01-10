<?php
require_once 'models/User.php';
require_once 'models/Task.php';
require_once 'includes/utils.php';

use Models\User;
use Models\Task;

class UserController {
    private $user;
    private $task;

    public function __construct($db) {
        $this->user = new User($db);
        $this->task = new Task($db);
    }

    public function register() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $name = $_POST['name'];
            $email = $_POST['email'];
            $password = $_POST['password'];

            if (empty($name) || empty($email) || empty($password)) {
                $error = "All fields are required.";
            } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $error = "Invalid email format.";
            } elseif (strlen($password) < 6) {
                $error = "Password must be at least 6 characters long.";
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
        $user = $this->user->getById($_SESSION['user_id']);
        $assignedTasks = $this->task->getAssignedTasks($_SESSION['user_id']);
        require 'views/user/dashboard.php';
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

    public function getRecentActivity() {
        // This is a placeholder. In a real application, you would fetch this data from your database.
        $recentActivity = [
            ['type' => 'Task Update', 'description' => 'Task "Implement login" marked as complete', 'date' => '2023-05-10 14:30:00'],
            ['type' => 'New Project', 'description' => 'Project "Website Redesign" created', 'date' => '2023-05-09 09:15:00'],
            ['type' => 'Comment', 'description' => 'New comment on task "Fix navigation bug"', 'date' => '2023-05-08 16:45:00'],
        ];

        header('Content-Type: application/json');
        echo json_encode($recentActivity);
        exit;
    }
}

