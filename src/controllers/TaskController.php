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

    public function update($id, $title, $description, $status, $priority, $assignedTo) {
        $this->taskModel->id = $id;
        $this->taskModel->title = $title;
        $this->taskModel->description = $description;
        $this->taskModel->status = $status;
        $this->taskModel->priority = $priority;
        $this->taskModel->assigned_to = $assignedTo;

        if ($this->taskModel->update()) {
            return json_encode(['success' => true, 'message' => 'Task updated successfully']);
        } else {
            return json_encode(['success' => false, 'message' => 'Unable to update task']);
        }
    }

    public function delete($id) {
        $this->taskModel->id = $id;

        if ($this->taskModel->delete()) {
            return json_encode(['success' => true, 'message' => 'Task deleted successfully']);
        } else {
            return json_encode(['success' => false, 'message' => 'Unable to delete task']);
        }
    }

    public function updateStatus($taskId, $newStatus) {
        $success = $this->taskModel->updateStatus($taskId, $newStatus);
        if ($success) {
            return json_encode(['success' => true, 'message' => 'Task status updated']);
        }
        return json_encode(['success' => false, 'message' => 'Failed to update task status']);
    }

    public function getByAssignee($userId) {
        $tasks = $this->taskModel->getByAssignee($userId);
        return json_encode(['success' => true, 'tasks' => $tasks]);
    }

    public function updatePriority($taskId, $newPriority) {
        $success = $this->taskModel->updatePriority($taskId, $newPriority);
        if ($success) {
            return json_encode(['success' => true, 'message' => 'Task priority updated']);
        }
        return json_encode(['success' => false, 'message' => 'Failed to update task priority']);
    }

    public function assignTask($taskId, $userId) {
        $success = $this->taskModel->assignTask($taskId, $userId);
        if ($success) {
            return json_encode(['success' => true, 'message' => 'Task assigned successfully']);
        }
        return json_encode(['success' => false, 'message' => 'Failed to assign task']);
    }
}