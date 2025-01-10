<?php require_once 'views/templates/header.php'; ?>

<h1>Edit Task</h1>

<?php if (isset($error)): ?>
    <div class="alert alert-danger"><?php echo $error; ?></div>
<?php endif; ?>

<form action="index.php?action=task_edit&id=<?php echo $task['id']; ?>" method="POST">
    <div class="form-group">
        <label for="title">Title:</label>
        <input type="text" id="title" name="title" class="form-control" value="<?php echo htmlspecialchars($task['title']); ?>" required>
    </div>
    
    <div class="form-group">
        <label for="description">Description:</label>
        <textarea id="description" name="description" class="form-control"><?php echo htmlspecialchars($task['description']); ?></textarea>
    </div>
    
    <div class="form-group">
        <label for="status">Status:</label>
        <select id="status" name="status" class="form-control">
            <option value="todo" <?php echo $task['status'] == 'todo' ? 'selected' : ''; ?>>To Do</option>
            <option value="in_progress" <?php echo $task['status'] == 'in_progress' ? 'selected' : ''; ?>>In Progress</option>
            <option value="completed" <?php echo $task['status'] == 'completed' ? 'selected' : ''; ?>>Completed</option>
        </select>
    </div>
    
    <div class="form-group">
        <label for="assigned_to">Assigned To:</label>
        <select id="assigned_to" name="assigned_to" class="form-control">
            <option value="">Unassigned</option>
            <?php foreach ($users as $user): ?>
                <option value="<?php echo $user['id']; ?>" <?php echo $task['assigned_to'] == $user['id'] ? 'selected' : ''; ?>>
                    <?php echo htmlspecialchars($user['name']); ?>
                </option>
            <?php endforeach; ?>
        </select>
    </div>
    
    <button type="submit" class="btn btn-primary">Update Task</button>
</form>

<a href="index.php?action=project_view&id=<?php echo $task['project_id']; ?>" class="btn btn-secondary mt-3">Back to Project</a>

<?php require_once 'views/templates/footer.php'; ?>

