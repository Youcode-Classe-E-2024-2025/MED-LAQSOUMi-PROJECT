<?php
namespace Models;

class Task {
    private $db;
    private $id;
    private $title;
    private $description;
    private $status;
    private $type;
    private $project_id;
    private $assigned_to;
    private $created_at;
    private $updated_at;

    public function __construct($db) {
        $this->db = $db;
    }

    public function create($title, $description, $project_id, $assigned_to = null, $type = 'basic', $status = 'todo') {
        $query = "INSERT INTO tasks (title, description, project_id, assigned_to, type, status) VALUES (?, ?, ?, ?, ?, ?)";
        $stmt = $this->db->prepare($query);
        return $stmt->execute([$title, $description, $project_id, $assigned_to, $type, $status]);
    }

    public function getByProjectId($project_id) {
        $query = "SELECT t.*, u.name AS assigned_to_name 
                  FROM tasks t 
                  LEFT JOIN users u ON t.assigned_to = u.id 
                  WHERE t.project_id = ?";
        $stmt = $this->db->prepare($query);
        $stmt->execute([$project_id]);
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function getById($id) {
        $query = "SELECT t.*, u.name AS assigned_to_name 
                  FROM tasks t 
                  LEFT JOIN users u ON t.assigned_to = u.id 
                  WHERE t.id = ?";
        $stmt = $this->db->prepare($query);
        $stmt->execute([$id]);
        return $stmt->fetch(\PDO::FETCH_ASSOC);
    }

    public function update($id, $title, $description, $status, $assigned_to = null, $type = 'basic') {
        $query = "UPDATE tasks SET title = ?, description = ?, status = ?, assigned_to = ?, type = ? WHERE id = ?";
        $stmt = $this->db->prepare($query);
        return $stmt->execute([$title, $description, $status, $assigned_to, $type, $id]);
    }

    public function delete($id) {
        $query = "DELETE FROM tasks WHERE id = ?";
        $stmt = $this->db->prepare($query);
        return $stmt->execute([$id]);
    }

    public function assignUser($taskId, $userId) {
        $query = "UPDATE tasks SET assigned_to = ? WHERE id = ?";
        $stmt = $this->db->prepare($query);
        return $stmt->execute([$userId, $taskId]);
    }

    public function getAssignedTasks($user_id) {
        $query = "SELECT t.*, p.name as project_name FROM tasks t 
                  JOIN projects p ON t.project_id = p.id 
                  WHERE t.assigned_to = ?";
        $stmt = $this->db->prepare($query);
        $stmt->execute([$user_id]);
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function getAllTasks() {
        $query = "SELECT t.*, p.name as project_name FROM tasks t 
                  JOIN projects p ON t.project_id = p.id";
        $stmt = $this->db->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function getTasksByUserRole($user_id, $user_role) {
        if ($user_role === 'admin') {
            return $this->getAllTasks();
        } elseif ($user_role === 'project_manager') {
            $query = "SELECT t.*, p.name as project_name 
                      FROM tasks t 
                      JOIN projects p ON t.project_id = p.id 
                      WHERE p.user_id = ?";
            $stmt = $this->db->prepare($query);
            $stmt->execute([$user_id]);
            return $stmt->fetchAll(\PDO::FETCH_ASSOC);
        } else {
            return $this->getAssignedTasks($user_id);
        }
    }

    // Getters and setters
    public function getId() { return $this->id; }
    public function getTitle() { return $this->title; }
    public function setTitle($title) { $this->title = $title; }
    public function getDescription() { return $this->description; }
    public function setDescription($description) { $this->description = $description; }
    public function getStatus() { return $this->status; }
    public function setStatus($status) { $this->status = $status; }
    public function getType() { return $this->type; }
    public function setType($type) { $this->type = $type; }
    public function getProjectId() { return $this->project_id; }
    public function setProjectId($project_id) { $this->project_id = $project_id; }
    public function getAssignedTo() { return $this->assigned_to; }
    public function setAssignedTo($assigned_to) { $this->assigned_to = $assigned_to; }
}

