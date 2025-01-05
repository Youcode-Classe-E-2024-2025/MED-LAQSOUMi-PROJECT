<?php

require_once __DIR__ . '/../models/Task.php';

class TaskController {
    private $taskModel;

    public function __construct() {
        $this->taskModel = new Task();
    }

    public function create($projectId, $title, $description, $status, $priority, $assignedTo, $createdBy) {
        // Add validation here
        $taskId = $this->taskModel->create($projectId, $title, $description, $status, $priority, $assignedTo, $createdBy);
        if ($taskId) {
            return json_encode(['success' => true, 'task_id' => $taskId]);
        }
        return json_encode(['success' => false, 'message' => 'Failed to create task']);
    }

    public function read($projectId) {
        $tasks = $this->taskModel->getByProject($projectId);
        return json_encode(['success' => true, 'tasks' => $tasks]);
    }

    public function updateStatus($taskId, $newStatus) {
        $success = $this->taskModel->updateStatus($taskId, $newStatus);
        if ($success) {
            return json_encode(['success' => true, 'message' => 'Task status updated']);
        }
        return json_encode(['success' => false, 'message' => 'Failed to update task status']);
    }

    // Add more methods as needed
}