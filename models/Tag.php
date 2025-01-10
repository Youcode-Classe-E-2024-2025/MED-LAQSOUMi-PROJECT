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

    public function getByTaskId($taskId) {
        $query = "SELECT t.* FROM tags t
                  JOIN task_tags tt ON t.id = tt.tag_id
                  WHERE tt.task_id = ?";
        $stmt = $this->db->prepare($query);
        $stmt->execute([$taskId]);
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function addToTask($taskId, $tagId) {
        $query = "INSERT INTO task_tags (task_id, tag_id) VALUES (?, ?)";
        $stmt = $this->db->prepare($query);
        return $stmt->execute([$taskId, $tagId]);
    }

    public function removeFromTask($taskId, $tagId) {
        $query = "DELETE FROM task_tags WHERE task_id = ? AND tag_id = ?";
        $stmt = $this->db->prepare($query);
        return $stmt->execute([$taskId, $tagId]);
    }
}

