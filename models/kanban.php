<?php
namespace Models;

class Kanban {
    private $db;

    public function __construct($db) {
        $this->db = $db;
    }

    public function createBoard($project_id, $name) {
        $query = "INSERT INTO kanban_boards (project_id, name) VALUES (?, ?)";
        $stmt = $this->db->prepare($query);
        if ($stmt->execute([$project_id, $name])) {
            return $this->db->lastInsertId();
        }
        return false;
    }

    public function createColumn($board_id, $name, $position) {
        $query = "INSERT INTO kanban_columns (board_id, name, position) VALUES (?, ?, ?)";
        $stmt = $this->db->prepare($query);
        return $stmt->execute([$board_id, $name, $position]);
    }

    public function addTaskToColumn($task_id, $column_id, $position) {
        $query = "INSERT INTO kanban_tasks (task_id, column_id, position) VALUES (?, ?, ?)";
        $stmt = $this->db->prepare($query);
        return $stmt->execute([$task_id, $column_id, $position]);
    }

    public function getBoardByProject($project_id) {
        $query = "SELECT * FROM kanban_boards WHERE project_id = ?";
        $stmt = $this->db->prepare($query);
        $stmt->execute([$project_id]);
        return $stmt->fetch(\PDO::FETCH_ASSOC);
    }

    public function getColumnsByBoard($board_id) {
        $query = "SELECT * FROM kanban_columns WHERE board_id = ? ORDER BY position";
        $stmt = $this->db->prepare($query);
        $stmt->execute([$board_id]);
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function getTasksByColumn($column_id) {
        $query = "SELECT t.* FROM tasks t JOIN kanban_tasks kt ON t.id = kt.task_id WHERE kt.column_id = ? ORDER BY kt.position";
        $stmt = $this->db->prepare($query);
        $stmt->execute([$column_id]);
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function moveTask($task_id, $new_column_id, $new_position) {
        $query = "UPDATE kanban_tasks SET column_id = ?, position = ? WHERE task_id = ?";
        $stmt = $this->db->prepare($query);
        return $stmt->execute([$new_column_id, $new_position, $task_id]);
    }

    public function getLastInsertId() {
        return $this->db->lastInsertId();
    }
}

