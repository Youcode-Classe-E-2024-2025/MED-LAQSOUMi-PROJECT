<?php require_once 'includes/functions.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Categories - TaskFlow</title>
</head>
<body>
    <h1>Categories</h1>
    <a href="index.php?action=category_create">Create New Category</a>
    <ul>
        <?php foreach ($categories as $category): ?>
            <li><?php echo sanitize($category['name']); ?></li>
        <?php endforeach; ?>
    </ul>
    <p><a href="index.php?action=dashboard">Back to Dashboard</a></p>
</body>
</html>

