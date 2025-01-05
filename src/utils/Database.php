<?php

require_once __DIR__ . '/../config/database.php';

class Database {
    private $conn;

    public function __construct() {
        $this->conn = getDBConnection();
    }

    public function query($sql, $params = []) {
        $stmt = $this->conn->prepare($sql);
        if ($stmt === false) {
            throw new Exception("Unable to prepare statement: " . $this->conn->error);
        }
        
        if (!empty($params)) {
            $types = str_repeat('s', count($params));
            $stmt->bind_param($types, ...$params);
        }
        
        $stmt->execute();
        return $stmt;
    }

    public function close() {
        $this->conn->close();
    }
}