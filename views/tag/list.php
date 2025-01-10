<?php require_once 'includes/functions.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tags - TaskFlow</title>
</head>
<body>
    <h1>Tags</h1>
    <a href="index.php?action=tag_create">Create New Tag</a>
    <ul>
        <?php foreach ($tags as $tag): ?>
            <li><?php echo sanitize($tag['name']); ?></li>
        <?php endforeach; ?>
    </ul>
    <p><a href="index.php?action=dashboard">Back to Dashboard</a></p>
</body>
</html>

