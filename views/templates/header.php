<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $pageTitle ?? 'TaskFlow'; ?></title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        .kanban-board {
            display: flex;
            overflow-x: auto;
            padding: 20px 0;
        }
        .kanban-column {
            flex: 0 0 300px;
            margin: 0 10px;
            background-color: #f1f1f1;
            border-radius: 5px;
            padding: 10px;
        }
        .kanban-task {
            background-color: white;
            border: 1px solid #ddd;
            border-radius: 3px;
            padding: 10px;
            margin-bottom: 10px;
            cursor: move;
        }
        .task-tags {
            margin-top: 5px;
        }
        .tag {
            display: inline-block;
            background-color: #007bff;
            color: white;
            padding: 2px 5px;
            border-radius: 3px;
            font-size: 0.8em;
            margin-right: 5px;
        }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
    <a class="navbar-brand" href="index.php?action=dashboard">TaskFlow</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav">
            <?php if (isLoggedIn()): ?>
                <li class="nav-item">
                    <a class="nav-link" href="index.php?action=dashboard">Dashboard</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="index.php?action=user_projects">My Projects</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="index.php?action=user_tasks">My Tasks</a>
                </li>
                <?php if ($_SESSION['user_role'] === 'admin' || $_SESSION['user_role'] === 'project_manager'): ?>
                    <li class="nav-item">
                        <a class="nav-link" href="index.php?action=project_create">Create Project</a>
                    </li>
                <?php endif; ?>
                <?php if ($_SESSION['user_role'] === 'admin'): ?>
                    <li class="nav-item">
                        <a class="nav-link" href="index.php?action=manage_users">Manage Users</a>
                    </li>
                <?php endif; ?>
                <li class="nav-item">
                    <a class="nav-link" href="index.php?action=logout">Logout</a>
                </li>
            <?php else: ?>
                <li class="nav-item">
                    <a class="nav-link" href="index.php?action=login">Login</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="index.php?action=register">Register</a>
                </li>
            <?php endif; ?>
        </ul>
    </div>
</nav>

    <div class="container mt-4">
        <?php
        $flashMessage = getFlashMessage();
        if ($flashMessage) {
            echo "<div class='alert alert-{$flashMessage['type']}'>{$flashMessage['message']}</div>";
        }
        ?>


</body>
</html>

