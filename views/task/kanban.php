<?php require_once 'views/templates/header.php'; ?>

<div class="container-fluid mt-4">
    <h1>Kanban Board</h1>

    <div class="row">
        <?php
        $statuses = [
            'todo' => ['title' => 'To Do', 'class' => 'bg-light'],
            'in_progress' => ['title' => 'In Progress', 'class' => 'bg-info'],
            'done' => ['title' => 'Done', 'class' => 'bg-success']
        ];

        foreach ($statuses as $status => $info):
        ?>
        <div class="col-md-4">
            <div class="card <?php echo $info['class']; ?> mb-3">
                <div class="card-header">
                    <h3><?php echo $info['title']; ?></h3>
                </div>
                <div class="card-body">
                    <?php if (isset($grouped_tasks[$status])): ?>
                        <?php foreach ($grouped_tasks[$status] as $task): ?>
                            <div class="card mb-2">
                                <div class="card-body">
                                    <h5 class="card-title"><?php echo htmlspecialchars($task['title']); ?></h5>
                                    <p class="card-text"><?php echo htmlspecialchars($task['description']); ?></p>
                                    <p class="card-text"><small class="text-muted">Project: <?php echo htmlspecialchars($task['project_name']); ?></small></p>
                                    <a href="index.php?action=task_edit&id=<?php echo $task['id']; ?>" class="btn btn-sm btn-primary">Edit</a>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <p>No tasks in this status.</p>
                    <?php endif; ?>
                </div>
            </div>
        </div>
        <?php endforeach; ?>
    </div>
</div>

<?php require_once 'views/templates/footer.php'; ?>

