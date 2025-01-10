<?php
require_once 'models/Tag.php';
require_once 'includes/utils.php';

use Models\Tag;

class TagController {
    private $tag;

    public function __construct($db) {
        $this->tag = new Tag($db);
    }

    public function create() {
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

    public function tag_list() {
        $tags = $this->tag->getAll();
        require 'views/tag/list.php';
    }
}

