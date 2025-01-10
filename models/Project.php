<?php
namespace Models;

class Project {
    protected $db;

    public function __construct($db) {
        $this->db = $db;
    }

    public function create($name, $description, $user_id, $is_public = false) {
        $query = "INSERT INTO projects (name, description, user_id, is_public) VALUES (?, ?, ?, ?)";
        $stmt = $this->db->prepare($query);
        return $stmt->execute([$name, $description, $user_id, $is_public]);
    }

    public function getById($id) {
        $query = "SELECT * FROM projects WHERE id = ?";
        $stmt = $this->db->prepare($query);
        $stmt->execute([$id]);
        return $stmt->fetch(\PDO::FETCH_ASSOC);
    }

    public function getAll() {
        $query = "SELECT * FROM projects";
        $stmt = $this->db->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function update($id, $name, $description, $is_public) {
        $query = "UPDATE projects SET name = ?, description = ?, is_public = ? WHERE id = ?";
        $stmt = $this->db->prepare($query);
        return $stmt->execute([$name, $description, $is_public, $id]);
    }

    public function delete($id) {
        $query = "DELETE FROM projects WHERE id = ?";
        $stmt = $this->db->prepare($query);
        return $stmt->execute([$id]);
    }

    public function getPublicProjects() {
        $query = "SELECT * FROM projects WHERE is_public = 1";
        $stmt = $this->db->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function getByUserId($user_id) {
        $query = "SELECT * FROM projects WHERE user_id = ?";
        $stmt = $this->db->prepare($query);
        $stmt->execute([$user_id]);
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function getAssignedAndPublicProjects($user_id) {
        $query = "SELECT DISTINCT p.* FROM projects p 
                  LEFT JOIN tasks t ON p.id = t.project_id 
                  WHERE p.is_public = 1 OR t.assigned_to = ? OR p.user_id = ?";
        $stmt = $this->db->prepare($query);
        $stmt->execute([$user_id, $user_id]);
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function getTotalProjects() {
        $query = "SELECT COUNT(*) as total FROM projects";
        $stmt = $this->db->prepare($query);
        $stmt->execute();
        return $stmt->fetch(\PDO::FETCH_ASSOC)['total'];
    }

    public function getProjectProgress($id) {
        $query = "SELECT 
                  COUNT(*) as total_tasks,
                  SUM(CASE WHEN status = 'done' THEN 1 ELSE 0 END) as completed_tasks
                  FROM tasks
                  WHERE project_id = ?";
        $stmt = $this->db->prepare($query);
        $stmt->execute([$id]);
        $result = $stmt->fetch(\PDO::FETCH_ASSOC);
        
        if ($result['total_tasks'] > 0) {
            return ($result['completed_tasks'] / $result['total_tasks']) * 100;
        }
        return 0;
    }

    public function getLastInsertId() {
        return $this->db->lastInsertId();
    }
}

