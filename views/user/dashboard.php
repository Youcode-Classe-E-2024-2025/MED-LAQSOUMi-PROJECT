<?php require_once 'views/templates/header.php'; ?>

<h1>Personal Dashboard</h1>

<h2>Your Statistics</h2>
<p>Total Tasks: <?php echo $totalTasks; ?></p>
<p>Completed Tasks: <?php echo $completedTasks; ?></p>
<p>Completion Rate: <?php echo number_format($completionRate, 2); ?>%</p>

<h2>Your Projects</h2>
<?php if (!empty($projects)): ?>
    <ul>
    <?php foreach ($projects as $project): ?>
        <li>
            <a href="index.php?action=project_view&id=<?php echo $project['id']; ?>">
                <?php echo htmlspecialchars($project['name']); ?>
            </a>
        </li>
    <?php endforeach; ?>
    </ul>
<?php else: ?>
    <p>You are not assigned to any projects yet.</p>
<?php endif; ?>

<?php require_once 'views/templates/footer.php'; ?>

