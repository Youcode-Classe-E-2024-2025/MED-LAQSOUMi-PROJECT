<?php require_once 'views/templates/header.php'; ?>

<div class="container mt-4">
    <h1><?php echo htmlspecialchars($project['name']); ?></h1>
    <p><?php echo htmlspecialchars($project['description']); ?></p>
    <p>Status: <?php echo $project['is_public'] ? 'Public' : 'Private'; ?></p>

    <h2>Tasks</h2>
    <?php if (empty($tasks)): ?>
        <p>No tasks yet.</p>
    <?php else: ?>
        <table class="table">
            <thead>
                <tr>
                    <th>Title</th>
                    <th>Type</th>
                    <th>Status</th>
                    <th>Assigned To</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($tasks as $task): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($task['title']); ?></td>
                        <td><?php echo htmlspecialchars($task['type']); ?></td>
                        <td><?php echo htmlspecialchars($task['status']); ?></td>
                        <td><?php echo htmlspecialchars($task['assigned_to_name'] ?? 'Unassigned'); ?></td>
                        <td>
                            <a href="index.php?action=task_edit&id=<?php echo $task['id']; ?>" class="btn btn-sm btn-primary">Edit</a>
                            <a href="index.php?action=task_delete&id=<?php echo $task['id']; ?>" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure you want to delete this task?');">Delete</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php endif; ?>

    <a href="index.php?action=task_create&project_id=<?php echo $project['id']; ?>" class="btn btn-success">Add Task</a>

    <h2 class="mt-4">Activity Timeline</h2>
    <?php if (empty($activities)): ?>
        <p>No activities recorded yet.</p>
    <?php else: ?>
        <ul class="list-group">
            <?php foreach ($activities as $activity): ?>
                <li class="list-group-item">
                    <strong><?php echo htmlspecialchars($activity['user_name']); ?></strong>
                    <?php echo htmlspecialchars($activity['action']); ?>:
                    <?php echo htmlspecialchars($activity['details']); ?>
                    <small class="text-muted float-right"><?php echo $activity['created_at']; ?></small>
                </li>
            <?php endforeach; ?>
        </ul>
    <?php endif; ?>

    <a href="index.php?action=project_list" class="btn btn-secondary mt-3">Back to Projects</a>
</div>

<?php require_once 'views/templates/footer.php'; ?>

