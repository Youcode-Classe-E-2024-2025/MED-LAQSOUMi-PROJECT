<?php

namespace Controllers;

require_once __DIR__ . '/../models/Task.php';
require_once __DIR__ . '/../models/Project.php';
require_once __DIR__ . '/../models/User.php';
require_once __DIR__ . '/../models/Category.php';
require_once __DIR__ . '/../models/Tag.php';
require_once __DIR__ . '/../models/Kanban.php';
require_once __DIR__ . '/../includes/utils.php';

use Models\Task;
use Models\Project;
use Models\User;
use Models\Category;
use Models\Tag;
use Models\Kanban;

class TaskController {
    private $task;
    private $project;
    private $user;
    private $category;
    private $tag;
    private $kanban;

    public function __construct($db) {
        $this->task = new Task($db);
        $this->project = new Project($db);
        $this->user = new User($db);
        $this->category = new Category($db);
        $this->tag = new Tag($db);
        $this->kanban = new Kanban($db);
    }

    public function task_create() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $title = $_POST['title'];
            $description = $_POST['description'];
            $project_id = $_POST['project_id'];
            $assigned_to = $_POST['assigned_to'];
            $status = $_POST['status'];
            $priority = $_POST['priority'];
            $created_by = $_SESSION['user_id'];

            if ($this->task->create($title, $description, $project_id, $assigned_to, $created_by, $status, $priority)) {
                $task_id = $this->task->getLastInsertId();
                
                // Handle tags
                if (isset($_POST['tags'])) {
                    foreach ($_POST['tags'] as $tag_id) {
                        $this->tag->addToTask($task_id, $tag_id);
                    }
                }

                // Add task to Kanban board
                $board = $this->kanban->getBoardByProject($project_id);
                $columns = $this->kanban->getColumnsByBoard($board['id']);
                $first_column = $columns[0];
                $this->kanban->addTaskToColumn($task_id, $first_column['id'], 0);

                setFlashMessage('success', "Task created successfully.");
                header('Location: index.php?action=project_view&id=' . $project_id);
                exit;
            } else {
                setFlashMessage('error', "Failed to create task. Please try again.");
            }
        }
        $project_id = $_GET['project_id'];
        $team_members = $this->user->getAll();
        $categories = $this->category->getAll();
        $tags = $this->tag->getAll();
        require 'views/task/create.php';
    }

    public function task_edit($id) {
        $task = $this->task->getById($id);
        if (!$task) {
            setFlashMessage('error', "Task not found.");
            header('Location: index.php?action=project_list');
            exit;
        }

        $project = $this->project->getById($task['project_id']);
        if (!$project || ($_SESSION['user_role'] !== 'admin' && $project['user_id'] != $_SESSION['user_id'] && $_SESSION['user_role'] !== 'project_manager')) {
            setFlashMessage('error', "You don't have permission to edit this task.");
            header('Location: index.php?action=project_list');
            exit;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $title = $_POST['title'];
            $description = $_POST['description'];
            $status = $_POST['status'];
            $priority = $_POST['priority'];
            $assigned_to = $_POST['assigned_to'];
            $category_id = $_POST['category_id'];

            if ($this->task->update($id, $title, $description, $status, $priority, $assigned_to, $category_id)) {
                // Handle tags
                $this->tag->removeAllFromTask($id);
                if (isset($_POST['tags'])) {
                    foreach ($_POST['tags'] as $tag_id) {
                        $this->tag->addToTask($id, $tag_id);
                    }
                }

                setFlashMessage('success', "Task updated successfully.");
                header('Location: index.php?action=project_view&id=' . $task['project_id']);
                exit;
            } else {
                setFlashMessage('error', "Failed to update task. Please try again.");
            }
        }

        $team_members = $this->user->getAll();
        $categories = $this->category->getAll();
        $tags = $this->tag->getAll();
        $task_tags = $this->tag->getTagsByTask($id);
        require 'views/task/edit.php';
    }

    public function task_delete($id) {
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
                setFlashMessage('error', "Failed to delete task. Please try again.");
                header('Location: index.php?action=task_view&id=' . $id);
                exit;
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
            $taskId = $_POST['task_id'];
            $newStatus = $_POST['new_status'];
            
            // Validate input
            if (!is_numeric($taskId) || !in_array($newStatus, ['backlog', 'todo', 'in_progress', 'done'])) {
                echo json_encode(['success' => false, 'message' => 'Invalid input']);
                exit;
            }
            
            $task = $this->task->getById($taskId);
            if (!$task) {
                echo json_encode(['success' => false, 'message' => 'Task not found']);
                exit;
            }
            
            // Check if the user has permission to update this task
            if ($_SESSION['user_role'] !== 'admin' && $task['assigned_to'] != $_SESSION['user_id']) {
                echo json_encode(['success' => false, 'message' => 'You do not have permission to update this task']);
                exit;
            }
            
            if ($this->task->updateStatus($taskId, $newStatus)) {
                echo json_encode(['success' => true]);
            } else {
                echo json_encode(['success' => false, 'message' => 'Failed to update task status']);
            }
        }
        exit;
    }

    public function moveTask() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $task_id = $_POST['task_id'];
            $new_column_id = $_POST['new_column_id'];
            $new_position = $_POST['new_position'];

            if ($this->kanban->moveTask($task_id, $new_column_id, $new_position)) {
                echo json_encode(['success' => true]);
            } else {
                echo json_encode(['success' => false, 'message' => 'Failed to move task']);
            }
            exit;
        }
    }

    public function userTasks() {
        $user_id = $_SESSION['user_id'];
        $user_role = $_SESSION['user_role'];
    
        if ($user_role === 'admin') {
            $tasks = $this->task->getAllTasks();
        } elseif ($user_role === 'project_manager') {
            $tasks = $this->task->getTasksByProjectManager($user_id);
        } else {
            $tasks = $this->task->getAssignedTasks($user_id);
        }
    
        require 'views/task/user_tasks.php';
    }
}

