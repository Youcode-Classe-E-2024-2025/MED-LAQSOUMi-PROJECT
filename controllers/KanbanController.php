<?php
require_once 'models/Kanban.php';
require_once 'includes/utils.php';

use Models\Kanban;

class KanbanController {
    private $kanban;

    public function __construct($db) {
        $this->kanban = new Kanban($db);
    }

    public function index() {
        requireLogin();
        $tasks = $this->kanban->getTasksByStatus($_SESSION['user_id']);
        require 'views/kanban/index.php';
    }

    public function createTask() {
        requireLogin();
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $title = $_POST['title'];
            $description = $_POST['description'];
            $status = $_POST['status'] ?? 'todo';
            $projectId = $_POST['project_id'] ?? null;
            if ($this->kanban->createTask($_SESSION['user_id'], $title, $description, $status, $projectId)) {
                setFlashMessage('success', 'Task created successfully.');
            } else {
                setFlashMessage('error', 'Failed to create task.');
            }
        }
        header('Location: index.php?action=kanban');
        exit;
    }

    public function updateTaskStatus() {
        requireLogin();
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $taskId = $_POST['task_id'];
            $newStatus = $_POST['new_status'];
            if ($this->kanban->updateTaskStatus($taskId, $newStatus)) {
                echo json_encode(['success' => true]);
            } else {
                echo json_encode(['success' => false, 'message' => 'Failed to update task status.']);
            }
        }
        exit;
    }

    public function deleteTask() {
        requireLogin();
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $taskId = $_POST['task_id'];
            if ($this->kanban->deleteTask($taskId)) {
                setFlashMessage('success', 'Task deleted successfully.');
            } else {
                setFlashMessage('error', 'Failed to delete task.');
            }
        }
        header('Location: index.php?action=kanban');
        exit;
    }
}

