<?php

require_once __DIR__ . '/../utils/Database.php';

class Task {
    private $db;

    public $id;
    public $project_id;
    public $title;
    public $description;
    public $status;
    public $priority;
    public $assigned_to;
    public $created_by;

    public function __construct() {
        $this->db = new Database();
    }

    public function create($projectId, $title, $description, $status, $priority, $assignedTo, $createdBy) {
        $sql = "INSERT INTO tasks (project_id, title, description, status, priority, assigned_to, created_by) 
                VALUES (?, ?, ?, ?, ?, ?, ?)";
        $stmt = $this->db->query($sql, [$projectId, $title, $description, $status, $priority, $assignedTo, $createdBy]);
        return $stmt->insert_id;
    }

    public function read($project_id) {
        $query = "SELECT * FROM " . $this->table . " WHERE project_id = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $project_id);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getByProject($projectId) {
        $sql = "SELECT * FROM tasks WHERE project_id = ?";
        $stmt = $this->db->query($sql, [$projectId]);
        $result = $stmt->get_result();
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function update() {
        $query = "UPDATE " . $this->table . " SET title=:title, description=:description, status=:status, priority=:priority, assigned_to=:assigned_to WHERE id=:id";
        $stmt = $this->conn->prepare($query);

        $this->title = htmlspecialchars(strip_tags($this->title));
        $this->description = htmlspecialchars(strip_tags($this->description));
        $this->status = htmlspecialchars(strip_tags($this->status));
        $this->priority = htmlspecialchars(strip_tags($this->priority));

        $stmt->bindParam(":title", $this->title);
        $stmt->bindParam(":description", $this->description);
        $stmt->bindParam(":status", $this->status);
        $stmt->bindParam(":priority", $this->priority);
        $stmt->bindParam(":assigned_to", $this->assigned_to);
        $stmt->bindParam(":id", $this->id);

        return $stmt->execute();
    }

    public function updateStatus($taskId, $newStatus) {
        $sql = "UPDATE tasks SET status = ? WHERE id = ?";
        $stmt = $this->db->query($sql, [$newStatus, $taskId]);
        return $stmt->affected_rows > 0;
    }

    public function delete() {
        $query = "DELETE FROM " . $this->table . " WHERE id = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $this->id);
        return $stmt->execute();
    }
}