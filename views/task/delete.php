<?php require_once 'views/templates/header.php'; ?>

<h1>Delete Task</h1>

<p>Are you sure you want to delete the task "<?php echo htmlspecialchars($task['title']); ?>"?</p>
<p>This action cannot be undone.</p>

<form action="index.php?action=task_delete&id=<?php echo $task['id']; ?>" method="POST">
    <button type="submit" class="btn btn-danger">Delete Task</button>
</form>

<a href="index.php?action=task_view&id=<?php echo $task['id']; ?>" class="btn btn-secondary mt-3">Cancel</a>

<?php require_once 'views/templates/footer.php'; ?>

