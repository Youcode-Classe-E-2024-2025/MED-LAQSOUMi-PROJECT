<?php
namespace Models;

class Tag {
    private $db;

    public function __construct($db) {
        $this->db = $db;
    }

    public function create($name) {
        $query = "INSERT INTO tags (name) VALUES (?)";
        $stmt = $this->db->prepare($query);
        return $stmt->execute([$name]);
    }

    public function getAll() {
        $query = "SELECT * FROM tags";
        $stmt = $this->db->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function addToTask($task_id, $tag_id) {
        $query = "INSERT INTO task_tags (task_id, tag_id) VALUES (?, ?)";
        $stmt = $this->db->prepare($query);
        return $stmt->execute([$task_id, $tag_id]);
    }

    public function removeFromTask($task_id, $tag_id) {
        $query = "DELETE FROM task_tags WHERE task_id = ? AND tag_id = ?";
        $stmt = $this->db->prepare($query);
        return $stmt->execute([$task_id, $tag_id]);
    }

    public function getTagsByTask($task_id) {
        $query = "SELECT t.* FROM tags t JOIN task_tags tt ON t.id = tt.tag_id WHERE tt.task_id = ?";
        $stmt = $this->db->prepare($query);
        $stmt->execute([$task_id]);
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function removeAllFromTask($task_id) {
        $query = "DELETE FROM task_tags WHERE task_id = ?";
        $stmt = $this->db->prepare($query);
        return $stmt->execute([$task_id]);
    }
}

