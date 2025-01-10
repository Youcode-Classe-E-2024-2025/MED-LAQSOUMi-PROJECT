<?php
namespace Models;

class Task {
    private $db;

    public function __construct($db) {
        $this->db = $db;
    }

    public function create($title, $description, $project_id, $assigned_to, $created_by, $status = 'todo', $priority = 'medium') {
        $query = "INSERT INTO tasks (title, description, project_id, assigned_to, created_by, status, priority) VALUES (?, ?, ?, ?, ?, ?, ?)";
        $stmt = $this->db->prepare($query);
        return $stmt->execute([$title, $description, $project_id, $assigned_to, $created_by, $status, $priority]);
    }

    public function getByProjectId($project_id) {
        $query = "SELECT * FROM tasks WHERE project_id = ?";
        $stmt = $this->db->prepare($query);
        $stmt->execute([$project_id]);
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function getById($id) {
        $query = "SELECT t.*, c.name as category_name FROM tasks t LEFT JOIN categories c ON t.category_id = c.id WHERE t.id = ?";
        $stmt = $this->db->prepare($query);
        $stmt->execute([$id]);
        return $stmt->fetch(\PDO::FETCH_ASSOC);
    }

    public function update($id, $title, $description, $status, $priority, $assigned_to, $category_id) {
        $query = "UPDATE tasks SET title = ?, description = ?, status = ?, priority = ?, assigned_to = ?, category_id = ? WHERE id = ?";
        $stmt = $this->db->prepare($query);
        return $stmt->execute([$title, $description, $status, $priority, $assigned_to, $category_id, $id]);
    }

    public function delete($id) {
        $query = "DELETE FROM tasks WHERE id = ?";
        $stmt = $this->db->prepare($query);
        return $stmt->execute([$id]);
    }

    public function getAssignedTasks($user_id) {
        $query = "SELECT t.*, p.name as project_name 
                  FROM tasks t 
                  JOIN projects p ON t.project_id = p.id 
                  WHERE t.assigned_to = ?";
        $stmt = $this->db->prepare($query);
        $stmt->execute([$user_id]);
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function getAllTasks() {
        $query = "SELECT t.*, p.name as project_name 
                  FROM tasks t 
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

    public function updateStatus($id, $status) {
        $query = "UPDATE tasks SET status = ? WHERE id = ?";
        $stmt = $this->db->prepare($query);
        return $stmt->execute([$status, $id]);
    }

    public function getTotalTasks() {
        $query = "SELECT COUNT(*) as total FROM tasks";
        $stmt = $this->db->prepare($query);
        $stmt->execute();
        return $stmt->fetch(\PDO::FETCH_ASSOC)['total'];
    }

    public function getTaskStatistics($user_id) {
        $query = "SELECT 
                    COUNT(*) as total_tasks,
                    SUM(CASE WHEN status = 'done' THEN 1 ELSE 0 END) as completed_tasks
                  FROM tasks
                  WHERE assigned_to = ?";
        $stmt = $this->db->prepare($query);
        $stmt->execute([$user_id]);
        return $stmt->fetch(\PDO::FETCH_ASSOC);
    }
    public function getTasksByUser($user_id) {
        $query = "SELECT * FROM tasks WHERE assigned_to = ?";
        $stmt = $this->db->prepare($query);
        $stmt->execute([$user_id]);
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }
}

