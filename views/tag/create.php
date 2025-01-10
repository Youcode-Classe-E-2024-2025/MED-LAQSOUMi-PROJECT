<?php require_once 'views/templates/header.php'; ?>

<h1>Edit Task</h1>

<form action="index.php?action=task_edit&id=<?php echo $task['id']; ?>" method="POST">
    <div class="form-group">
        <label for="title">Title:</label>
        <input type="text" id="title" name="title" class="form-control" value="<?php echo htmlspecialchars($task['title']); ?>" required>
    </div>
    
    <div class="form-group">
        <label for="description">Description:</label>
        <textarea id="description" name="description" class="form-control" rows="3" required><?php echo htmlspecialchars($task['description']); ?></textarea>
    </div>
    
    <div class="form-group">
        <label for="status">Status:</label>
        <select id="status" name="status" class="form-control" required>
            <option value="todo" <?php echo $task['status'] == 'todo' ? 'selected' : ''; ?>>To Do</option>
            <option value="in_progress" <?php echo $task['status'] == 'in_progress' ? 'selected' : ''; ?>>In Progress</option>
            <option value="done" <?php echo $task['status'] == 'done' ? 'selected' : ''; ?>>Done</option>
        </select>
    </div>
    
    <div class="form-group">
        <label for="priority">Priority:</label>
        <select id="priority" name="priority" class="form-control" required>
            <option value="low" <?php echo $task['priority'] == 'low' ? 'selected' : ''; ?>>Low</option>
            <option value="medium" <?php echo $task['priority'] == 'medium' ? 'selected' : ''; ?>>Medium</option>
            <option value="high" <?php echo $task['priority'] == 'high' ? 'selected' : ''; ?>>High</option>
        </select>
    </div>
    
    <div class="form-group">
        <label for="assigned_to">Assign To:</label>
        <select id="assigned_to" name="assigned_to" class="form-control">
            <option value="">Unassigned</option>
            <?php foreach ($team_members as $member): ?>
                <option value="<?php echo $member['id']; ?>" <?php echo $task['assigned_to'] == $member['id'] ? 'selected' : ''; ?>><?php echo htmlspecialchars($member['name']); ?></option>
            <?php endforeach; ?>
        </select>
    </div>
    
    <div class="form-group">
        <label>Tags:</label>
        <?php foreach ($tags as $tag): ?>
            <div class="form-check">
                <input type="checkbox" id="tag_<?php echo $tag['id']; ?>" name="tags[]" value="<?php echo $tag['id']; ?>" class="form-check-input" <?php echo in_array($tag['id'], array_column($task_tags, 'id')) ? 'checked' : ''; ?>>
                <label for="tag_<?php echo $tag['id']; ?>" class="form-check-label"><?php echo htmlspecialchars($tag['name']); ?></label>
            </div>
        <?php endforeach; ?>
    </div>
    
    <button type="submit" class="btn btn-primary">Update Task</button>
</form>

<a href="index.php?action=project_view&id=<?php echo $task['project_id']; ?>" class="btn btn-secondary mt-3">Back to Project</a>

<?php require_once 'views/templates/footer.php'; ?>

