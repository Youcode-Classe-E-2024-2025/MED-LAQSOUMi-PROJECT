<?php

require_once __DIR__ . '/../utils/Database.php';

class Project {
    private $db;
    private $table = 'projects';

    public $id;
    public $name;
    public $description;
    public $created_by;

    public function __construct() {
        $this->db = new Database();
    }

    public function create($name, $description, $createdBy) {
        $sql = "INSERT INTO projects (name, description, created_by) VALUES (?, ?, ?)";
        $stmt = $this->db->query($sql, [$name, $description, $createdBy]);
        return $stmt->insert_id;
    }

    public function read($id) {
        $query = "SELECT * FROM " . $this->table . " WHERE id = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function getById($id) {
        $sql = "SELECT * FROM projects WHERE id = ?";
        $stmt = $this->db->query($sql, [$id]);
        $result = $stmt->get_result();
        return $result->fetch_assoc();
    }

    public function update() {
        $query = "UPDATE " . $this->table . " SET name=:name, description=:description WHERE id=:id";
        $stmt = $this->conn->prepare($query);

        $this->name = htmlspecialchars(strip_tags($this->name));
        $this->description = htmlspecialchars(strip_tags($this->description));

        $stmt->bindParam(":name", $this->name);
        $stmt->bindParam(":description", $this->description);
        $stmt->bindParam(":id", $this->id);

        return $stmt->execute();
    }

    public function delete() {
        $query = "DELETE FROM " . $this->table . " WHERE id = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $this->id);
        return $stmt->execute();
    }

    public function getMembers() {
        $query = "SELECT u.id, u.username, u.email, pm.role as project_role
                  FROM users u
                  JOIN project_members pm ON u.id = pm.user_id
                  WHERE pm.project_id = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $this->id);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getByUser($userId) {
        $sql = "SELECT p.* FROM projects p
                JOIN project_members pm ON p.id = pm.project_id
                WHERE pm.user_id = ?";
        $stmt = $this->db->query($sql, [$userId]);
        $result = $stmt->get_result();
        return $result->fetch_all(MYSQLI_ASSOC);
    }
    
}