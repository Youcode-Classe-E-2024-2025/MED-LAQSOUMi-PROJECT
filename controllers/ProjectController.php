<?php

namespace Controllers;

require_once __DIR__ . '/../models/Project.php';
require_once __DIR__ . '/../models/Task.php';
require_once __DIR__ . '/../models/Kanban.php';
require_once __DIR__ . '/../includes/utils.php';

use Models\Project;
use Models\Task;
use Models\Kanban;

class ProjectController {
    private $project;
    private $task;
    private $kanban;

    public function __construct($db) {
        $this->project = new Project($db);
        $this->task = new Task($db);
        $this->kanban = new Kanban($db);
    }

    public function project_create() {
        if ($_SESSION['user_role'] !== 'admin' && $_SESSION['user_role'] !== 'project_manager') {
            setFlashMessage('error', "You don't have permission to create a project.");
            header('Location: index.php?action=dashboard');
            exit;
        }
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $name = $_POST['name'];
            $description = $_POST['description'];
            $is_public = isset($_POST['is_public']) ? 1 : 0;
            $user_id = $_SESSION['user_id'];

            if ($this->project->create($name, $description, $user_id, $is_public)) {
                $project_id = $this->project->getLastInsertId();
                $this->kanban->createBoard($project_id, 'Default Board');
                $board_id = $this->kanban->getLastInsertId();
                $this->kanban->createColumn($board_id, 'To Do', 1);
                $this->kanban->createColumn($board_id, 'In Progress', 2);
                $this->kanban->createColumn($board_id, 'Done', 3);
                setFlashMessage('success', "Project created successfully.");
                header('Location: index.php?action=project_view&id=' . $project_id);
                exit;
            } else {
                setFlashMessage('error', "Failed to create project. Please try again.");
            }
        }
        require 'views/project/create.php';
    }

    public function project_view($id) {
        $project = $this->project->getById($id);
        if (!$project) {
            setFlashMessage('error', "Project not found.");
            header('Location: index.php?action=project_list');
            exit;
        }
        $tasks = $this->task->getByProjectId($id);
        $board = $this->kanban->getBoardByProject($id);
        $columns = $this->kanban->getColumnsByBoard($board['id']);
        foreach ($columns as &$column) {
            $column['tasks'] = $this->kanban->getTasksByColumn($column['id']);
        }
        require 'views/project/view.php';
    }

    public function project_edit($id) {
        $project = $this->project->getById($id);
        if (!$project) {
            setFlashMessage('error', "Project not found.");
            header('Location: index.php?action=project_list');
            exit;
        }
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $name = $_POST['name'];
            $description = $_POST['description'];
            $is_public = isset($_POST['is_public']) ? 1 : 0;
            if ($this->project->update($id, $name, $description, $is_public)) {
                setFlashMessage('success', "Project updated successfully.");
                header('Location: index.php?action=project_view&id=' . $id);
                exit;
            } else {
                setFlashMessage('error', "Failed to update project. Please try again.");
            }
        }
        require 'views/project/edit.php';
    }

    public function project_delete($id) {
        if ($this->project->delete($id)) {
            setFlashMessage('success', "Project deleted successfully.");
            header('Location: index.php?action=project_list');
            exit;
        } else {
            setFlashMessage('error', "Failed to delete project. Please try again.");
            header('Location: index.php?action=project_view&id=' . $id);
            exit;
        }
    }

    public function project_list() {
        $projects = $this->project->getAll();
        require 'views/project/list.php';
    }

    public function userProjects() {
        $user_id = $_SESSION['user_id'];
        $user_role = $_SESSION['user_role'];
    
        if ($user_role === 'admin') {
            $projects = $this->project->getAll();
        } elseif ($user_role === 'project_manager') {
            $projects = $this->project->getByUserId($user_id);
        } else {
            $projects = $this->project->getAssignedAndPublicProjects($user_id);
        }
    
        require 'views/project/user_projects.php';
    }

    public function kanbanBoard($id) {
        $project = $this->project->getById($id);
        if (!$project) {
            setFlashMessage('error', "Project not found.");
            header('Location: index.php?action=project_list');
            exit;
        }
    
        $board = $this->kanban->getBoardByProject($id);
        $columns = $this->kanban->getColumnsByBoard($board['id']);
        foreach ($columns as &$column) {
            $column['tasks'] = $this->kanban->getTasksByColumn($column['id']);
        }
    
        require 'views/project/kanban_board.php';
    }
}

