<?php require_once 'views/templates/header.php'; ?>

<h1>Public Projects</h1>

<?php if (empty($projects)): ?>
    <p>No public projects available.</p>
<?php else: ?>
    <div class="row">
        <?php foreach ($projects as $project): ?>
            <div class="col-md-4 mb-4">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title"><?php echo htmlspecialchars($project['name']); ?></h5>
                        <p class="card-text"><?php echo htmlspecialchars(substr($project['description'], 0, 100)) . '...'; ?></p>
                        <a href="index.php?action=project_view&id=<?php echo $project['id']; ?>" class="btn btn-primary">View Project</a>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
<?php endif; ?>

<?php if (!isLoggedIn()): ?>
    <p>Want to create your own projects? <a href="index.php?action=register">Register now</a> or <a href="index.php?action=login">login</a> if you already have an account.</p>
<?php endif; ?>

<?php require_once 'views/templates/footer.php'; ?>

