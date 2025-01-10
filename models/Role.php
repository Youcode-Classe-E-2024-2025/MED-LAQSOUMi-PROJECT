<?php
namespace Models;

class Role {
    private $db;

    public function __construct($db) {
        $this->db = $db;
    }

    public function create($name) {
        $query = "INSERT INTO roles (name) VALUES (?)";
        $stmt = $this->db->prepare($query);
        return $stmt->execute([$name]);
    }

    public function update($id, $name) {
        $query = "UPDATE roles SET name = ? WHERE id = ?";
        $stmt = $this->db->prepare($query);
        return $stmt->execute([$name, $id]);
    }

    public function delete($id) {
        $query = "DELETE FROM roles WHERE id = ?";
        $stmt = $this->db->prepare($query);
        return $stmt->execute([$id]);
    }

    public function getAll() {
        $query = "SELECT * FROM roles";
        $stmt = $this->db->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function getById($id) {
        $query = "SELECT * FROM roles WHERE id = ?";
        $stmt = $this->db->prepare($query);
        $stmt->execute([$id]);
        return $stmt->fetch(\PDO::FETCH_ASSOC);
    }

    public function assignPermission($role_id, $permission_id) {
        $query = "INSERT INTO role_permissions (role_id, permission_id) VALUES (?, ?)";
        $stmt = $this->db->prepare($query);
        return $stmt->execute([$role_id, $permission_id]);
    }

    public function removePermission($role_id, $permission_id) {
        $query = "DELETE FROM role_permissions WHERE role_id = ? AND permission_id = ?";
        $stmt = $this->db->prepare($query);
        return $stmt->execute([$role_id, $permission_id]);
    }

    public function getPermissions($role_id) {
        $query = "SELECT p.* FROM permissions p JOIN role_permissions rp ON p.id = rp.permission_id WHERE rp.role_id = ?";
        $stmt = $this->db->prepare($query);
        $stmt->execute([$role_id]);
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }
}

