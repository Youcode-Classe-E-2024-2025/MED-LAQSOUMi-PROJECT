<?php
namespace Models;

class Category {
    private $db;

    public function __construct($db) {
        $this->db = $db;
    }

    public function create($name) {
        $query = "INSERT INTO categories (name) VALUES (?)";
        $stmt = $this->db->prepare($query);
        return $stmt->execute([$name]);
    }

    public function update($id, $name) {
        $query = "UPDATE categories SET name = ? WHERE id = ?";
        $stmt = $this->db->prepare($query);
        return $stmt->execute([$name, $id]);
    }

    public function delete($id) {
        $query = "DELETE FROM categories WHERE id = ?";
        $stmt = $this->db->prepare($query);
        return $stmt->execute([$id]);
    }

    public function getAll() {
        $query = "SELECT * FROM categories";
        $stmt = $this->db->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getById($id) {
        $query = "SELECT * FROM categories WHERE id = ?";
        $stmt = $this->db->prepare($query);
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}

