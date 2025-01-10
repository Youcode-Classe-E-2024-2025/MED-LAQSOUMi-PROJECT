<?php
require_once 'models/Category.php';

class CategoryController {
    private $category;

    public function __construct($db) {
        $this->category = new Category($db);
    }

    public function create() {
        requireLogin();
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $name = $_POST['name'];

            if ($this->category->create($name)) {
                setFlashMessage('success', "Category created successfully.");
                header('Location: index.php?action=category_list');
                exit;
            } else {
                setFlashMessage('error', "Failed to create category. Please try again.");
            }
        }
        require 'views/category/create.php';
    }

    public function list() {
        requireLogin();
        $categories = $this->category->getAll();
        require 'views/category/list.php';
    }

    public function edit($id) {
        requireLogin();
        $category = $this->category->getById($id);
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $name = $_POST['name'];

            if ($this->category->update($id, $name)) {
                setFlashMessage('success', "Category updated successfully.");
                header('Location: index.php?action=category_list');
                exit;
            } else {
                setFlashMessage('error', "Failed to update category. Please try again.");
            }
        }
        require 'views/category/edit.php';
    }

    public function delete($id) {
        requireLogin();
        if ($this->category->delete($id)) {
            setFlashMessage('success', "Category deleted successfully.");
        } else {
            setFlashMessage('error', "Failed to delete category. Please try again.");
        }
        header('Location: index.php?action=category_list');
        exit;
    }
}

