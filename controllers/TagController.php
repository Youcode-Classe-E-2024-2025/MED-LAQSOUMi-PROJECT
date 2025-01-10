<?php
require_once 'models/Tag.php';

class TagController {
    private $tag;

    public function __construct($db) {
        $this->tag = new Tag($db);
    }

    public function create() {
        requireLogin();
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $name = $_POST['name'];

            if ($this->tag->create($name)) {
                setFlashMessage('success', "Tag created successfully.");
                header('Location: index.php?action=tag_list');
                exit;
            } else {
                setFlashMessage('error', "Failed to create tag. Please try again.");
            }
        }
        require 'views/tag/create.php';
    }

    public function list() {
        requireLogin();
        $tags = $this->tag->getAll();
        require 'views/tag/list.php';
    }

    public function edit($id) {
        requireLogin();
        $tag = $this->tag->getById($id);
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $name = $_POST['name'];

            if ($this->tag->update($id, $name)) {
                setFlashMessage('success', "Tag updated successfully.");
                header('Location: index.php?action=tag_list');
                exit;
            } else {
                setFlashMessage('error', "Failed to update tag. Please try again.");
            }
        }
        require 'views/tag/edit.php';
    }

    public function delete($id) {
        requireLogin();
        if ($this->tag->delete($id)) {
            setFlashMessage('success', "Tag deleted successfully.");
        } else {
            setFlashMessage('error', "Failed to delete tag. Please try again.");
        }
        header('Location: index.php?action=tag_list');
        exit;
    }
}

