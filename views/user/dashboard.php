<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - TaskFlow</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
<?php require_once 'views/templates/header.php'; ?>

<div class="container mt-4">
    <h1>Welcome, <?php echo htmlspecialchars($_SESSION['user_name']); ?>!</h1>
    <p>Role: <?php echo htmlspecialchars($_SESSION['user_role']); ?></p>

    <div class="row mt-4">
        <div class="col-md-6">
            <h2>Quick Links</h2>
            <ul class="list-group">
                <li class="list-group-item">
                    <a href="index.php?action=project_list" class="btn btn-primary btn-block">View All Projects</a>
                </li>
                <li class="list-group-item">
                    <a href="index.php?action=assigned_tasks" class="btn btn-info btn-block">View Assigned Tasks</a>
                </li>
                <li class="list-group-item">
                    <a href="index.php?action=kanban" class="btn btn-success btn-block">Kanban Board</a>
                </li>
                <?php if ($_SESSION['user_role'] === 'admin' || $_SESSION['user_role'] === 'project_manager'): ?>
                    <li class="list-group-item">
                        <a href="index.php?action=project_create" class="btn btn-warning btn-block">Create New Project</a>
                    </li>
                <?php endif; ?>
                <?php if ($_SESSION['user_role'] === 'admin'): ?>
                    <li class="list-group-item">
                        <a href="index.php?action=admin_dashboard" class="btn btn-danger btn-block">Admin Dashboard</a>
                    </li>
                <?php endif; ?>
                <li class="list-group-item">
                    <a href="index.php?action=user_profile" class="btn btn-secondary btn-block">Edit Profile</a>
                </li>
            </ul>
        </div>
        <div class="col-md-6">
            <h2>Recent Activity</h2>
            <div id="recent-activity">
                <!-- This section will be populated by AJAX -->
                <p>Loading recent activity...</p>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    fetch('index.php?action=get_recent_activity')
        .then(response => response.json())
        .then(data => {
            const activityHtml = data.map(item => `
                <div class="card mb-2">
                    <div class="card-body">
                        <h5 class="card-title">${item.type}</h5>
                        <p class="card-text">${item.description}</p>
                        <small class="text-muted">${item.date}</small>
                    </div>
                </div>
            `).join('');
            document.getElementById('recent-activity').innerHTML = activityHtml;
        })
        .catch(error => {
            console.error('Error fetching recent activity:', error);
            document.getElementById('recent-activity').innerHTML = '<p>Failed to load recent activity.</p>';
        });
});
</script>

<?php require_once 'views/templates/footer.php'; ?>

</body>
</html>

