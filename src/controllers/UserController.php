<?php
require_once __DIR__ . '/../models/User.php';
class UserController {
    private $userModel;

    public function __construct() {
        $this->userModel = new User();
    }

    public function register($username, $email, $password) {
        // Add validation here
        $userId = $this->userModel->create($username, $email, $password);
        if ($userId) {
            $_SESSION['user_id'] = $userId;
            return json_encode(['success' => true, 'message' => 'User registered successfully']);
        }
        return json_encode(['success' => false, 'message' => 'Registration failed']);
    }

    public function login($username, $password) {
        $user = $this->userModel->getByUsername($username);
        if ($user && password_verify($password, $user['password'])) {
            $_SESSION['user_id'] = $user['id'];
            return json_encode(['success' => true, 'message' => 'Login successful']);
        }
        return json_encode(['success' => false, 'message' => 'Invalid credentials']);
    }

    public function logout() {
        session_destroy();
        return json_encode(['success' => true, 'message' => 'Logout successful']);
    }
}