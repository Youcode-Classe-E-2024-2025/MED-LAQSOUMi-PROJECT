<?php
namespace Models;

class User {
    private $db;

    public function __construct($db) {
        $this->db = $db;
    }

    public function create($name, $email, $password, $role = 'team_member') {
        $hash = password_hash($password, PASSWORD_DEFAULT);
        $query = "INSERT INTO users (name, email, password, role) VALUES (?, ?, ?, ?)";
        $stmt = $this->db->prepare($query);
        return $stmt->execute([$name, $email, $hash, $role]);
    }

    public function login($email, $password) {
        $query = "SELECT * FROM users WHERE email = ?";
        $stmt = $this->db->prepare($query);
        $stmt->execute([$email]);
        $user = $stmt->fetch(\PDO::FETCH_ASSOC);
        
        if ($user && password_verify($password, $user['password'])) {
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['user_name'] = $user['name'];
            $_SESSION['user_role'] = $user['role'];
            return true;
        }
        return false;
    }

    public function getById($id) {
        $query = "SELECT * FROM users WHERE id = ?";
        $stmt = $this->db->prepare($query);
        $stmt->execute([$id]);
        return $stmt->fetch(\PDO::FETCH_ASSOC);
    }

    public function getAll() {
        $query = "SELECT * FROM users";
        $stmt = $this->db->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function updateEmail($id, $email) {
        $query = "UPDATE users SET email = ? WHERE id = ?";
        $stmt = $this->db->prepare($query);
        return $stmt->execute([$email, $id]);
    }

    public function updatePassword($id, $password) {
        $hash = password_hash($password, PASSWORD_DEFAULT);
        $query = "UPDATE users SET password = ? WHERE id = ?";
        $stmt = $this->db->prepare($query);
        return $stmt->execute([$hash, $id]);
    }

    public function updateRole($id, $role) {
        $query = "UPDATE users SET role = ? WHERE id = ?";
        $stmt = $this->db->prepare($query);
        return $stmt->execute([$role, $id]);
    }

    public function verifyPassword($id, $password) {
        $query = "SELECT password FROM users WHERE id = ?";
        $stmt = $this->db->prepare($query);
        $stmt->execute([$id]);
        $user = $stmt->fetch(\PDO::FETCH_ASSOC);
        
        if ($user) {
            return password_verify($password, $user['password']);
        }
        return false;
    }

    public function getUsersByRole($role) {
        $query = "SELECT * FROM users WHERE role = ?";
        $stmt = $this->db->prepare($query);
        $stmt->execute([$role]);
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function getTotalUsers() {
        $query = "SELECT COUNT(*) as total FROM users";
        $stmt = $this->db->prepare($query);
        $stmt->execute();
        return $stmt->fetch(\PDO::FETCH_ASSOC)['total'];
    }

    public function assignRole($userId, $roleId) {
        $query = "UPDATE users SET role = ? WHERE id = ?";
        $stmt = $this->db->prepare($query);
        return $stmt->execute([$roleId, $userId]);
    }
}

