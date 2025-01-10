<?php require_once 'includes/functions.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tasks - TaskFlow</title>
</head>
<body>
    <h1>Tasks</h1>
    <table>
        <thead>
            <tr>
                <th>Title</th>
                <th>Description</th>
                <th>Due Date</th>
                <th>Status</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($tasks as $task): ?>
                <tr>
                    <td><?php echo sanitize($task['title']); ?></td>
                    <td><?php echo sanitize($task['description']); ?></td>
                    <td><?php echo sanitize($task['due_date']); ?></td>
                    <td><?php echo sanitize($task['status']); ?></td>
                    <td>
                        <a href="index.php?action=task_view&id=<?php echo $task['id']; ?>">View</a>
                        <form action="index.php?action=task_update_status" method="POST" style="display: inline;">
                            <input type="hidden" name="task_id" value="<?php echo $task['id']; ?>">
                            <select name="status" onchange="this.form.submit()">
                                <option value="To Do" <?php echo $task['status'] == 'To Do' ? 'selected' : ''; ?>>To Do</option>
                                <option value="In Progress" <?php echo $task['status'] == 'In Progress' ? 'selected' : ''; ?>>In Progress</option>
                                <option value="Done" <?php echo $task['status'] == 'Done' ? 'selected' : ''; ?>>Done</option>
                            </select>
                        </form>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <p><a href="index.php?action=dashboard">Back to Dashboard</a></p>
</body>
</html>

