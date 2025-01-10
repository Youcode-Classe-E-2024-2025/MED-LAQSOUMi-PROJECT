<?php require_once 'views/templates/header.php'; ?>

<h1>Admin Dashboard</h1>

<h2>System Statistics</h2>
<p>Total Users: <?php echo $totalUsers; ?></p>
<p>Total Projects: <?php echo $totalProjects; ?></p>
<p>Total Tasks: <?php echo $totalTasks; ?></p>

<h2>Project Managers</h2>
<?php if (!empty($projectManagers)): ?>
    <ul>
    <?php foreach ($projectManagers as $manager): ?>
        <li><?php echo htmlspecialchars($manager['name']); ?></li>
    <?php endforeach; ?>
    </ul>
<?php else: ?>
    <p>No project managers found.</p>
<?php endif; ?>

<h2>Recent Activities</h2>
<?php if (!empty($recentActivities)): ?>
    <ul>
    <?php foreach ($recentActivities as $activity): ?>
        <li>
            <?php echo htmlspecialchars($activity['type']); ?>: 
            <?php echo htmlspecialchars($activity['description']); ?> 
            (<?php echo $activity['date']; ?>)
        </li>
    <?php endforeach; ?>
    </ul>
<?php else: ?>
    <p>No recent activities.</p>
<?php endif; ?>

<?php require_once 'views/templates/footer.php'; ?>

