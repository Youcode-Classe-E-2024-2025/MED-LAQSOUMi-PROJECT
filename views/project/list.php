<?php require_once 'views/templates/header.php'; ?>

<div class="container mt-4">
    <h1>Projects</h1>
    
    <?php if ($_SESSION['user_role'] === 'project_manager'): ?>
        <a href="index.php?action=project_create" class="btn btn-primary mb-3">Create New Project</a>
    <?php endif; ?>

    <?php if (empty($projects)): ?>
        <p>No projects found.</p>
    <?php else: ?>
        <div class="row">
            <?php foreach ($projects as $project): ?>
                <div class="col-md-4 mb-4">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title"><?php echo htmlspecialchars($project['name']); ?></h5>
                            <p class="card-text"><?php echo htmlspecialchars(substr($project['description'], 0, 100)) . '...'; ?></p>
                            <p class="card-text"><small class="text-muted">Status: <?php echo $project['is_public'] ? 'Public' : 'Private'; ?></small></p>
                            <a href="index.php?action=project_view&id=<?php echo (int)$project['id']; ?>" class="btn btn-info">View</a>
                            <?php if ($_SESSION['user_role'] === 'project_manager' && $project['user_id'] == $_SESSION['user_id']): ?>
                                <a href="index.php?action=project_edit&id=<?php echo (int)$project['id']; ?>" class="btn btn-warning">Edit</a>
                                <a href="index.php?action=project_delete&id=<?php echo (int)$project['id']; ?>" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this project?');">Delete</a>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
</div>

<?php require_once 'views/templates/footer.php'; ?>

