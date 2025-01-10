<?php require_once 'views/templates/header.php'; ?>

<h1>Delete Project</h1>

<p>Are you sure you want to delete the project "<?php echo htmlspecialchars($project['name']); ?>"?</p>
<p>This action cannot be undone.</p>

<form action="index.php?action=project_delete&id=<?php echo $project['id']; ?>" method="POST">
    <button type="submit" class="btn btn-danger">Delete Project</button>
</form>

<a href="index.php?action=project_view&id=<?php echo $project['id']; ?>" class="btn btn-secondary mt-3">Cancel</a>

<?php require_once 'views/templates/footer.php'; ?>

