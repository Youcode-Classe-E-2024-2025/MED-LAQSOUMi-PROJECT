<?php require_once 'views/templates/header.php'; ?>

<h1>Edit Project</h1>

<form action="index.php?action=project_edit&id=<?php echo $project['id']; ?>" method="POST">
    <div class="form-group">
        <label for="name">Project Name:</label>
        <input type="text" id="name" name="name" value="<?php echo htmlspecialchars($project['name']); ?>" required class="form-control">
    </div>
    <div class="form-group">
        <label for="description">Description:</label>
        <textarea id="description" name="description" required class="form-control"><?php echo htmlspecialchars($project['description']); ?></textarea>
    </div>
    <button type="submit" class="btn btn-primary">Update Project</button>
</form>

<a href="index.php?action=project_view&id=<?php echo $project['id']; ?>" class="btn btn-secondary mt-3">Cancel</a>

<?php require_once 'views/templates/footer.php'; ?>

