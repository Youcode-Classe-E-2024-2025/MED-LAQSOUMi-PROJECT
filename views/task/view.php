<?php require_once 'views/templates/header.php'; ?>

<div class="container mt-4">
    <h1><?php echo htmlspecialchars($task['title']); ?></h1>
    <p><strong>Status:</strong> <?php echo htmlspecialchars($task['status']); ?></p>
    <p><strong>Type:</strong> <?php echo htmlspecialchars($task['type']); ?></p>
    <p><strong>Assigned To:</strong> <?php echo htmlspecialchars($task['assigned_to_name'] ?? 'Unassigned'); ?></p>

    <h2>Description</h2>
    <div class="card">
        <div class="card-body">
            <?php echo $task['description_html']; ?>
        </div>
    </div>

    <div class="mt-3">
        <a href="index.php?action=task_edit&id=<?php echo $task['id']; ?>" class="btn btn-primary">Edit Task</a>
        <a href="index.php?action=project_view&id=<?php echo $task['project_id']; ?>" class="btn btn-secondary">Back to Project</a>
    </div>
</div>

<?php require_once 'views/templates/footer.php'; ?>

