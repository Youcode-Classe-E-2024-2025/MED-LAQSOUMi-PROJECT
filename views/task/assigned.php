<?php require_once 'views/templates/header.php'; ?>

<div class="container mt-4">
    <h1>Assigned Tasks</h1>

    <?php if (empty($tasks)): ?>
        <p>You have no assigned tasks.</p>
    <?php else: ?>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Title</th>
                    <th>Project</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($tasks as $task): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($task['title']); ?></td>
                        <td><?php echo htmlspecialchars($task['project_name']); ?></td>
                        <td><?php echo htmlspecialchars($task['status']); ?></td>
                        <td>
                            <a href="index.php?action=task_edit&id=<?php echo $task['id']; ?>" class="btn btn-sm btn-primary">Edit</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php endif; ?>

    <a href="index.php?action=dashboard" class="btn btn-secondary">Back to Dashboard</a>
</div>

<?php require_once 'views/templates/footer.php'; ?>

