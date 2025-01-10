<?php
require_once 'models/Role.php';
require_once 'models/User.php';
require_once 'includes/utils.php';

use Models\Role;
use Models\User;

class RoleController {
    private $role;
    private $user;

    public function __construct($db) {
        $this->role = new Role($db);
        $this->user = new User($db);
    }

    public function list() {
        $roles = $this->role->getAll();
        require 'views/role/list.php';
    }

    public function create() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $name = $_POST['name'];
            if ($this->role->create($name)) {
                setFlashMessage('success', "Role created successfully.");
                header('Location: index.php?action=role_list');
                exit;
            } else {
                setFlashMessage('error', "Failed to create role.");
            }
        }
        require 'views/role/create.php';
    }

    public function edit($id) {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $name = $_POST['name'];
            if ($this->role->update($id, $name)) {
                setFlashMessage('success', "Role updated successfully.");
                header('Location: index.php?action=role_list');
                exit;
            } else {
                setFlashMessage('error', "Failed to update role.");
            }
        }
        $role = $this->role->getById($id);
        require 'views/role/edit.php';
    }

    public function delete($id) {
        if ($this->role->delete($id)) {
            setFlashMessage('success', "Role deleted successfully.");
        } else {
            setFlashMessage('error', "Failed to delete role.");
        }
        header('Location: index.php?action=role_list');
        exit;
    }

    public function assign() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $userId = $_POST['user_id'];
            $roleId = $_POST['role_id'];
            if ($this->user->assignRole($userId, $roleId)) {
                setFlashMessage('success', "Role assigned successfully.");
            } else {
                setFlashMessage('error', "Failed to assign role.");
            }
            header('Location: index.php?action=manage_users');
            exit;
        }
        $users = $this->user->getAll();
        $roles = $this->role->getAll();
        require 'views/role/assign.php';
    }
}

