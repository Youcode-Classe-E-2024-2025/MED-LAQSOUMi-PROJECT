<?php

require_once __DIR__ . '/../config/database.php';

class Project {
    private $db;

    public function __construct() {
        $this->db = new Database();
    }

    public function create($name, $description, $user_id, $is_public = false) {
        $sql = "INSERT INTO projects (name, description, user_id, is_public) VALUES (?, ?, ?, ?)";
        $params = [$name, $description, $user_id, $is_public ? 1 : 0];
        $stmt = $this->db->query($sql, $params);
        return $stmt->affected_rows > 0;
    }

    public function read($id) {
        $sql = "SELECT * FROM projects WHERE id = ?";
        $stmt = $this->db->query($sql, [$id]);
        $result = $stmt->get_result();
        return $result->fetch_assoc();
    }

    public function update($id, $name, $description, $is_public) {
        $sql = "UPDATE projects SET name = ?, description = ?, is_public = ? WHERE id = ?";
        $params = [$name, $description, $is_public ? 1 : 0, $id];
        $stmt = $this->db->query($sql, $params);
        return $stmt->affected_rows > 0;
    }

    public function delete($id) {
        $sql = "DELETE FROM projects WHERE id = ?";
        $stmt = $this->db->query($sql, [$id]);
        return $stmt->affected_rows > 0;
    }

    public function getUserProjects($user_id) {
        $sql = "SELECT * FROM projects WHERE user_id = ?";
        $stmt = $this->db->query($sql, [$user_id]);
        $result = $stmt->get_result();
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function getPublicProjects() {
        $sql = "SELECT * FROM projects WHERE is_public = 1";
        $stmt = $this->db->query($sql);
        $result = $stmt->get_result();
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function getUserProjects($user_id) {
        $projects = $this->project->getUserProjects($user_id);
        return json_encode(['success' => true, 'projects' => $projects]);
    }

    public function getPublicProjects() {
        $projects = $this->project->getPublicProjects();
        return json_encode(['success' => true, 'projects' => $projects]);
    }
}

