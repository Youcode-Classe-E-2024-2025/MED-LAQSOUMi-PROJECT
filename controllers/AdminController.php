<?php
require_once __DIR__ . '/../models/User.php';
require_once __DIR__ . '/../models/Role.php';
require_once __DIR__ . '/../models/Permission.php';
require_once __DIR__ . '/../includes/utils.php';

use Models\User;
use Models\Role;
use Models\Permission;

class AdminController {
    private $user;
    private $role;
    private $permission;

    public function __construct($db) {
        $this->user = new User($db);
        $this->role = new Role($db);
        $this->permission = new Permission($db);
    }

    public function manageUsers() {
        $users = $this->user->getAll();
        require 'views/admin/manage_users.php';
    }

    public function manageRoles() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $action = $_POST['action'];
            switch ($action) {
                case 'create':
                    $name = $_POST['name'];
                    if ($this->role->create($name)) {
                        setFlashMessage('success', "Role created successfully.");
                    } else {
                        setFlashMessage('error', "Failed to create role.");
                    }
                    break;
                case 'update':
                    $id = $_POST['id'];
                    $name = $_POST['name'];
                    if ($this->role->update($id, $name)) {
                        setFlashMessage('success', "Role updated successfully.");
                    } else {
                        setFlashMessage('error', "Failed to update role.");
                    }
                    break;
                case 'delete':
                    $id = $_POST['id'];
                    if ($this->role->delete($id)) {
                        setFlashMessage('success', "Role deleted successfully.");
                    } else {
                        setFlashMessage('error', "Failed to delete role.");
                    }
                    break;
            }
        }
        $roles = $this->role->getAll();
        require 'views/admin/manage_roles.php';
    }

    public function managePermissions() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $action = $_POST['action'];
            switch ($action) {
                case 'create':
                    $name = $_POST['name'];
                    if ($this->permission->create($name)) {
                        setFlashMessage('success', "Permission created successfully.");
                    } else {
                        setFlashMessage('error', "Failed to create permission.");
                    }
                    break;
                case 'update':
                    $id = $_POST['id'];
                    $name = $_POST['name'];
                    if ($this->permission->update($id, $name)) {
                        setFlashMessage('success', "Permission updated successfully.");
                    } else {
                        setFlashMessage('error', "Failed to update permission.");
                    }
                    break;
                case 'delete':
                    $id = $_POST['id'];
                    if ($this->permission->delete($id)) {
                        setFlashMessage('success', "Permission deleted successfully.");
                    } else {
                        setFlashMessage('error', "Failed to delete permission.");
                    }
                    break;
                case 'assign':
                    $roleId = $_POST['role_id'];
                    $permissionId = $_POST['permission_id'];
                    if ($this->role->assignPermission($roleId, $permissionId)) {
                        setFlashMessage('success', "Permission assigned successfully.");
                    } else {
                        setFlashMessage('error', "Failed to assign permission.");
                    }
                    break;
                case 'remove':
                    $roleId = $_POST['role_id'];
                    $permissionId = $_POST['permission_id'];
                    if ($this->role->removePermission($roleId, $permissionId)) {
                        setFlashMessage('success', "Permission removed successfully.");
                    } else {
                        setFlashMessage('error', "Failed to remove permission.");
                    }
                    break;
            }
        }
        $permissions = $this->permission->getAll();
        $roles = $this->role->getAll();
        require 'views/admin/manage_permissions.php';
    }
}

