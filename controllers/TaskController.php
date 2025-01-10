<?php
require_once 'models/Task.php';
require_once 'models/Project.php';
require_once 'models/User.php';
require_once 'includes/utils.php';

use Models\Task;
use Models\Project;
use Models\User;

class TaskController {
    private $task;
    private $project;
    private $user;

    public function __construct($db) {
        $this->task = new Task($db);
        $this->project = new Project($db);
        $this->user = new User($db);
    }

    public function create() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $title = $_POST['title'];
            $description = $_POST['description'];
            $project_id = $_POST['project_id'];
            $type = $_POST['type'];
            $assigned_to = $_POST['assigned_to'] ?? null;

            $project = $this->project->getById($project_id);
            if (!$project || $project['user_id'] != $_SESSION['user_id']) {
                setFlashMessage('error', "You don't have permission to add tasks to this project.");
                header('Location: index.php?action=project_list');
                exit;
            }

            if (empty($title)) {
                $error = "Task title is required.";
            } else {
                if ($this->task->create($title, $description, $project_id, $assigned_to, $type)) {
                    setFlashMessage('success', "Task created successfully.");
                    header('Location: index.php?action=project_view&id=' . $project_id);
                    exit;
                } else {
                    $error = "Failed to create task. Please try again.";
                }
            }
        }
        $project_id = $_GET['project_id'];
        $team_members = $this->user->getAll();
        require 'views/task/create.php';
    }

    public function edit($id) {
        $task = $this->task->getById($id);
        if (!$task) {
            setFlashMessage('error', "Task not found.");
            header('Location: index.php?action=project_list');
            exit;
        }

        $project = $this->project->getById($task['project_id']);
        if (!$project || ($project['user_id'] != $_SESSION['user_id'] && $_SESSION['user_role'] != 'project_manager')) {
            setFlashMessage('error', "You don't have permission to edit this task.");
            header('Location: index.php?action=project_list');
            exit;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $title = $_POST['title'];
            $description = $_POST['description'];
            $status = $_POST['status'];
            $type = $_POST['type'];
            $assigned_to = $_POST['assigned_to'];

            if (empty($title)) {
                $error = "Task title is required.";
            } else {
                if ($this->task->update($id, $title, $description, $status, $assigned_to, $type)) {
                    setFlashMessage('success', "Task updated successfully.");
                    header('Location: index.php?action=project_view&id=' . $task['project_id']);
                    exit;
                } else {
                    $error = "Failed to update task. Please try again.";
                }
            }
        }

        $team_members = $this->user->getAll();
        require 'views/task/edit.php';
    }

    public function delete($id) {
        $task = $this->task->getById($id);
        if (!$task) {
            setFlashMessage('error', "Task not found.");
            header('Location: index.php?action=project_list');
            exit;
        }

        $project = $this->project->getById($task['project_id']);
        if (!$project || ($project['user_id'] != $_SESSION['user_id'] && $_SESSION['user_role'] != 'project_manager')) {
            setFlashMessage('error', "You don't have permission to delete this task.");
            header('Location: index.php?action=project_list');
            exit;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if ($this->task->delete($id)) {
                setFlashMessage('success', "Task deleted successfully.");
                header('Location: index.php?action=project_view&id=' . $task['project_id']);
                exit;
            } else {
                $error = "Failed to delete task. Please try again.";
            }
        }

        require 'views/task/delete.php';
    }

    public function assignedTasks() {
        $user_id = $_SESSION['user_id'];
        $tasks = $this->task->getAssignedTasks($user_id);
        require 'views/task/assigned.php';
    }

    public function kanban() {
        $user_id = $_SESSION['user_id'];
        $user_role = $_SESSION['user_role'];

        $tasks = $this->task->getTasksByUserRole($user_id, $user_role);
        $grouped_tasks = $this->groupTasksByStatus($tasks);
        require 'views/task/kanban.php';
    }

    private function groupTasksByStatus($tasks) {
        $grouped = [
            'todo' => [],
            'in_progress' => [],
            'done' => []
        ];

        foreach ($tasks as $task) {
            $status = $task['status'];
            if (!isset($grouped[$status])) {
                $grouped[$status] = [];
            }
            $grouped[$status][] = $task;
        }

        return $grouped;
    }

    public function updateStatus() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $task_id = $_POST['task_id'];
            $new_status = $_POST['new_status'];
            $task = $this->task->getById($task_id);

            if (!$task) {
                echo json_encode(['success' => false, 'message' => 'Task not found.']);
                exit;
            }

            if ($this->task->update($task_id, $task['title'], $task['description'], $new_status, $task['assigned_to'], $task['type'])) {
                echo json_encode(['success' => true]);
            } else {
                echo json_encode(['success' => false, 'message' => 'Failed to update task status.']);
            }
        }
        exit;
    }
}

