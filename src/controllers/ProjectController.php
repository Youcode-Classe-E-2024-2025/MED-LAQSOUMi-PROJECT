<?php
require_once __DIR__ . '/../models/Project.php';

class ProjectController {
    private $projectModel;

    public function __construct() {
        $this->projectModel = new Project();
    }

    public function create($name, $description, $userId) {
        $projectId = $this->projectModel->create($name, $description, $userId);
        if ($projectId) {
            return json_encode(['success' => true, 'project_id' => $projectId]);
        }
        return json_encode(['success' => false, 'message' => 'Failed to create project']);
    }

    public function read($projectId) {
        $project = $this->projectModel->getById($projectId);
        if ($project) {
            return json_encode(['success' => true, 'project' => $project]);
        }
        return json_encode(['success' => false, 'message' => 'Project not found']);
    }
    public function getUserProjects($userId) {
        $projects = $this->projectModel->getByUser($userId);
        return json_encode(['success' => true, 'projects' => $projects]);
    }
}