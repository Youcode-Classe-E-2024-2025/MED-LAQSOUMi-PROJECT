<?php

require_once __DIR__ . '/../utils/Database.php';

class User {
    private $db;
    private $table = 'users';

    public $id;
    public $username;
    public $email;
    public $password;

    public function __construct() {
        $this->db = new Database();
    }

    public function create($username, $email, $password) {
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
        $sql = "INSERT INTO users (username, email, password) VALUES (?, ?, ?)";
        $stmt = $this->db->query($sql, [$username, $email, $hashedPassword]);
        return $stmt->insert_id;
    }

    public function login($username, $password) {
        $query = "SELECT id, username, password FROM " . $this->table . " WHERE username = ?";
        $stmt = $this->db->query($query, [$username]);
        $result = $stmt->get_result();
        if($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            if(password_verify($password, $row['password'])) {
                return $row;
            }
        }
        return false;
    }

    public function getByUsername($username) {
        $sql = "SELECT * FROM users WHERE username = ?";
        $stmt = $this->db->query($sql, [$username]);
        $result = $stmt->get_result();
        return $result->fetch_assoc();
    }

    public function getProjects() {
        $query = "SELECT p.id, p.name, p.description, pm.role as project_role
                  FROM projects p
                  JOIN project_members pm ON p.id = pm.project_id
                  WHERE pm.user_id = ?";
        $stmt = $this->db->query($query, [$this->id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}