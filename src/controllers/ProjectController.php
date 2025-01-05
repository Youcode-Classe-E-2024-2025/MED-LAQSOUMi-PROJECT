<?php

require_once __DIR__ . '/../models/Project.php';
require_once __DIR__ . '/../models/User.php';

class ProjectController {
    private $projectModel;
    private $userModel;

    public function __construct() {
        $this->projectModel = new Project();
        $this->userModel = new User();
    }

    public function create($name, $description, $userId) {
        // Add validation here
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

    public function update($id, $name, $description) {
        $this->projectModel->id = $id;
        $this->projectModel->name = $name;
        $this->projectModel->description = $description;

        if ($this->projectModel->update()) {
            return json_encode(['success' => true, 'message' => 'Project updated successfully']);
        } else {
            return json_encode(['success' => false, 'message' => 'Unable to update project']);
        }
    }

    public function delete($id) {
        $this->projectModel->id = $id;

        if ($this->projectModel->delete()) {
            return json_encode(['success' => true, 'message' => 'Project deleted successfully']);
        } else {
            return json_encode(['success' => false, 'message' => 'Unable to delete project']);
        }
    }

    public function getUserProjects($userId) {
        $projects = $this->projectModel->getByUser($userId);
        return json_encode(['success' => true, 'projects' => $projects]);
    }

    public function getMembers($projectId) {
        $members = $this->projectModel->getMembers($projectId);
        return json_encode(['success' => true, 'members' => $members]);
    }

    public function addMember($projectId, $userId, $role = 'MEMBER') {
        if ($this->projectModel->addMember($projectId, $userId, $role)) {
            return json_encode(['success' => true, 'message' => 'Member added successfully']);
        } else {
            return json_encode(['success' => false, 'message' => 'Failed to add member']);
        }
    }

    public function removeMember($projectId, $userId) {
        if ($this->projectModel->removeMember($projectId, $userId)) {
            return json_encode(['success' => true, 'message' => 'Member removed successfully']);
        } else {
            return json_encode(['success' => false, 'message' => 'Failed to remove member']);
        }
    }
}