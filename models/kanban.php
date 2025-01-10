<?php
namespace Models;

class Kanban {
    private $db;

    public function __construct($db) {
        $this->db = $db;
    }

    public function createTask($userId, $title, $description, $status = 'todo', $projectId = null) {
        $query = "INSERT INTO tasks (title, description, status, project_id, assigned_to) VALUES (?, ?, ?, ?, ?)";
        $stmt = $this->db->prepare($query);
        return $stmt->execute([$title, $description, $status, $projectId, $userId]);
    }

    public function getTasks($userId) {
        $query = "SELECT * FROM tasks WHERE assigned_to = ? ORDER BY id DESC";
        $stmt = $this->db->prepare($query);
        $stmt->execute([$userId]);
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function updateTaskStatus($taskId, $newStatus) {
        $query = "UPDATE tasks SET status = ? WHERE id = ?";
        $stmt = $this->db->prepare($query);
        return $stmt->execute([$newStatus, $taskId]);
    }

    public function deleteTask($taskId) {
        $query = "DELETE FROM tasks WHERE id = ?";
        $stmt = $this->db->prepare($query);
        return $stmt->execute([$taskId]);
    }

    public function getTasksByStatus($userId) {
        $query = "SELECT * FROM tasks WHERE assigned_to = ? ORDER BY id DESC";
        $stmt = $this->db->prepare($query);
        $stmt->execute([$userId]);
        $tasks = $stmt->fetchAll(\PDO::FETCH_ASSOC);

        $groupedTasks = [
            'backlog' => [],
            'todo' => [],
            'in_progress' => [],
            'done' => []
        ];

        foreach ($tasks as $task) {
            switch ($task['status']) {
                case 'todo':
                    $groupedTasks['todo'][] = $task;
                    break;
                case 'in_progress':
                    $groupedTasks['in_progress'][] = $task;
                    break;
                case 'completed':
                    $groupedTasks['done'][] = $task;
                    break;
                default:
                    $groupedTasks['backlog'][] = $task;
                    break;
            }
        }

        return $groupedTasks;
    }
}

