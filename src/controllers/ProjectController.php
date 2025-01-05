<?php

require_once __DIR__ . '/../models/Project.php';

class ProjectController {
    private $project;

    public function __construct() {
        $this->project = new Project();
    }

    public function create($name, $description, $user_id, $is_public = false) {
        $result = $this->project->create($name, $description, $user_id, $is_public);
        if ($result) {
            return json_encode(['success' => true, 'message' => 'Project created successfully']);
        } else {
            return json_encode(['success' => false, 'message' => 'Failed to create project']);
        }
    }

    public function read($id) {
        $project = $this->project->read($id);
        if ($project) {
            return json_encode(['success' => true, 'project' => $project]);
        } else {
            return json_encode(['success' => false, 'message' => 'Project not found']);
        }
    }

    public function update($id, $name, $description, $is_public) {
        $result = $this->project->update($id, $name, $description, $is_public);
        if ($result) {
            return json_encode(['success' => true, 'message' => 'Project updated successfully']);
        } else {
            return json_encode(['success' => false, 'message' => 'Failed to update project']);
        }
    }

    public function delete($id) {
        $result = $this->project->delete($id);
        if ($result) {
            return json_encode(['success' => true, 'message' => 'Project deleted successfully']);
        } else {
            return json_encode(['success' => false, 'message' => 'Failed to delete project']);
        }
    }

    public function getUserProjects($user_id) {
        $projects = $this->project->getUserProjects($user_id);
        return json_encode(['success' => true, 'projects' => $projects]);
    }

    public function getPublicProjects() {
        $projects = $this->project->getPublicProjects();
        return json_encode(['success' => true, 'projects' => $projects]);
    }
}

