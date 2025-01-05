<?php
require_once __DIR__ . '/../models/Task.php';
require_once __DIR__ . '/../config/database.php';

class TaskController {
    private $taskModel;
    private $conn;

    public function __construct() {
        $this->conn = getDBConnection();
        $this->taskModel = new Task($this->conn);
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

    public function update($id, $title, $description, $status, $priority, $assigned_to) {
        $this->taskModel->id = $id;
        $this->taskModel->title = $title;
        $this->taskModel->description = $description;
        $this->taskModel->status = $status;
        $this->taskModel->priority = $priority;
        $this->taskModel->assigned_to = $assigned_to;

        if($this->taskModel->update()) {
            return json_encode(array("message" => "Task updated successfully."));
        } else {
            return json_encode(array("message" => "Unable to update task."));
        }
    }

    public function delete($id) {
        $this->taskModel->id = $id;

        if($this->taskModel->delete()) {
            return json_encode(array("message" => "Task deleted successfully."));
        } else {
            return json_encode(array("message" => "Unable to delete task."));
        }
    }
}