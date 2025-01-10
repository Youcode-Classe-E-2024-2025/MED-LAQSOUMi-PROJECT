<?php require_once 'views/templates/header.php'; ?>

<h1>Your Tasks</h1>

<?php if (empty($tasks)): ?>
    <p>No tasks found.</p>
<?php else: ?>
    <table class="table">
        <thead>
            <tr>
                <th>Title</th>
                <th>Project</th>
                <th>Status</th>
                <th>Priority</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($tasks as $task): ?>
                <tr>
                    <td><?php echo htmlspecialchars($task['title']); ?></td>
                    <td><?php echo htmlspecialchars($task['project_name']); ?></td>
                    <td><?php echo htmlspecialchars($task['status']); ?></td>
                    <td><?php echo htmlspecialchars($task['priority']); ?></td>
                    <td>
                        <a href="index.php?action=task_view&id=<?php echo $task['id']; ?>" class="btn btn-sm btn-info">View</a>
                        <?php if ($_SESSION['user_role'] === 'admin' || $_SESSION['user_role'] === 'project_manager' || $task['assigned_to'] == $_SESSION['user_id']): ?>
                            <a href="index.php?action=task_edit&id=<?php echo $task['id']; ?>" class="btn btn-sm btn-warning">Edit</a>
                        <?php endif; ?>
                        <?php if ($_SESSION['user_role'] === 'admin' || $_SESSION['user_role'] === 'project_manager'): ?>
                            <a href="index.php?action=task_delete&id=<?php echo $task['id']; ?>" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure you want to delete this task?');">Delete</a>
                        <?php endif; ?>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
<?php endif; ?>

<?php require_once 'views/templates/footer.php'; ?>

