<?php require_once 'views/templates/header.php'; ?>

<h1>Project Manager Dashboard</h1>

<h2>Project Statistics</h2>
<p>Total Projects: <?php echo $totalProjects; ?></p>
<p>Completed Projects: <?php echo $completedProjects; ?></p>
<p>Project Completion Rate: <?php echo number_format($projectCompletionRate, 2); ?>%</p>

<h2>Task Statistics</h2>
<p>Total Tasks: <?php echo $totalTasks; ?></p>
<p>Completed Tasks: <?php echo $completedTasks; ?></p>
<p>Task Completion Rate: <?php echo number_format($taskCompletionRate, 2); ?>%</p>

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
    <p>You haven't created any projects yet.</p>
<?php endif; ?>

<?php require_once 'views/templates/footer.php'; ?>

