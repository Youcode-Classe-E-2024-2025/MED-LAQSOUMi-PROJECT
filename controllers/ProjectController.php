<?php
require_once 'models/Project.php';
require_once 'models/Task.php';
require_once 'includes/utils.php';

use Models\Project;
use Models\Task;

class ProjectController {
    private $project;
    private $task;

    public function __construct($db) {
        $this->project = new Project($db);
        $this->task = new Task($db);
    }

    public function create() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $name = $_POST['name'];
            $description = $_POST['description'];
            $is_public = isset($_POST['is_public']) ? 1 : 0;
            $user_id = $_SESSION['user_id'];

            if (empty($name)) {
                $error = "Project name is required.";
            } else {
                if ($this->project->create($name, $description, $user_id, $is_public)) {
                    setFlashMessage('success', "Project created successfully.");
                    header('Location: index.php?action=project_list');
                    exit;
                } else {
                    $error = "Failed to create project. Please try again.";
                }
            }
        }
        require 'views/project/create.php';
    }

    public function list() {
        $user_id = $_SESSION['user_id'];
        $user_role = $_SESSION['user_role'];

        if ($user_role === 'admin') {
            $projects = $this->project->getAll();
        } elseif ($user_role === 'project_manager') {
            $projects = $this->project->getByUserId($user_id);
        } else {
            $projects = $this->project->getAssignedAndPublicProjects($user_id);
        }

        require 'views/project/list.php';
    }

    public function view($id) {
        $project = $this->project->getById($id);
        if (!$project || (!$project['is_public'] && $project['user_id'] != $_SESSION['user_id'])) {
            setFlashMessage('error', "You don't have permission to view this project.");
            header('Location: index.php?action=project_list');
            exit;
        }
        $tasks = $this->task->getByProjectId($id);
        require 'views/project/view.php';
    }

    public function edit($id) {
        $project = $this->project->getById($id);
        if (!$project || $project['user_id'] != $_SESSION['user_id']) {
            setFlashMessage('error', "You don't have permission to edit this project.");
            header('Location: index.php?action=project_list');
            exit;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $name = $_POST['name'];
            $description = $_POST['description'];
            $is_public = isset($_POST['is_public']) ? 1 : 0;

            if (empty($name)) {
                $error = "Project name is required.";
            } else {
                if ($this->project->update($id, $name, $description, $is_public)) {
                    setFlashMessage('success', "Project updated successfully.");
                    header('Location: index.php?action=project_view&id=' . $id);
                    exit;
                } else {
                    $error = "Failed to update project. Please try again.";
                }
            }
        }

        require 'views/project/edit.php';
    }

    public function delete($id) {
        $project = $this->project->getById($id);
        if (!$project || $project['user_id'] != $_SESSION['user_id']) {
            setFlashMessage('error', "You don't have permission to delete this project.");
            header('Location: index.php?action=project_list');
            exit;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if ($this->project->delete($id)) {
                setFlashMessage('success', "Project deleted successfully.");
                header('Location: index.php?action=project_list');
                exit;
            } else {
                $error = "Failed to delete project. Please try again.";
            }
        }
        require 'views/project/delete.php';
    }

    public function listPublicProjects() {
        $projects = $this->project->getPublicProjects();
        require 'views/project/public_list.php';
    }
}

