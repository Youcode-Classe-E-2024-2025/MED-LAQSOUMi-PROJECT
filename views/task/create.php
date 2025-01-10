<?php require_once 'views/templates/header.php'; ?>

<h1>Create New Task</h1>

<form action="index.php?action=task_create" method="POST">
    <input type="hidden" name="project_id" value="<?php echo $project_id; ?>">
    
    <div class="form-group">
        <label for="title">Title:</label>
        <input type="text" id="title" name="title" class="form-control" required>
    </div>
    
    <div class="form-group">
        <label for="description">Description:</label>
        <textarea id="description" name="description" class="form-control" rows="3" required></textarea>
    </div>
    
    <div class="form-group">
        <label for="status">Status:</label>
        <select id="status" name="status" class="form-control" required>
            <option value="todo">To Do</option>
            <option value="in_progress">In Progress</option>
            <option value="done">Done</option>
        </select>
    </div>
    
    <div class="form-group">
        <label for="priority">Priority:</label>
        <select id="priority" name="priority" class="form-control" required>
            <option value="low">Low</option>
            <option value="medium">Medium</option>
            <option value="high">High</option>
        </select>
    </div>
    
    <div class="form-group">
        <label for="assigned_to">Assign To:</label>
        <select id="assigned_to" name="assigned_to" class="form-control">
            <option value="">Unassigned</option>
            <?php foreach ($team_members as $member): ?>
                <option value="<?php echo $member['id']; ?>"><?php echo htmlspecialchars($member['name']); ?></option>
            <?php endforeach; ?>
        </select>
    </div>
    
    <div class="form-group">
        <label>Tags:</label>
        <?php foreach ($tags as $tag): ?>
            <div class="form-check">
                <input type="checkbox" id="tag_<?php echo $tag['id']; ?>" name="tags[]" value="<?php echo $tag['id']; ?>" class="form-check-input">
                <label for="tag_<?php echo $tag['id']; ?>" class="form-check-label"><?php echo htmlspecialchars($tag['name']); ?></label>
            </div>
        <?php endforeach; ?>
    </div>
    
    <button type="submit" class="btn btn-primary">Create Task</button>
</form>

<a href="index.php?action=project_view&id=<?php echo $project_id; ?>" class="btn btn-secondary mt-3">Back to Project</a>

<?php require_once 'views/templates/footer.php'; ?>

