<?php require_once 'views/templates/header.php'; ?>

<h1><?php echo htmlspecialchars($project['name']); ?></h1>
<p><?php echo htmlspecialchars($project['description']); ?></p>

<h2>Kanban Board</h2>
<div id="kanban-board" class="kanban-board">
    <?php foreach ($columns as $column): ?>
        <div class="kanban-column" data-column-id="<?php echo $column['id']; ?>">
            <h3><?php echo htmlspecialchars($column['name']); ?></h3>
            <div class="kanban-tasks">
                <?php foreach ($column['tasks'] as $task): ?>
                    <div class="kanban-task" data-task-id="<?php echo $task['id']; ?>">
                        <h4><?php echo htmlspecialchars($task['title']); ?></h4>
                        <p><?php echo htmlspecialchars($task['description']); ?></p>
                        <div class="task-tags">
                            <?php foreach ($this->tag->getTagsByTask($task['id']) as $tag): ?>
                                <span class="tag"><?php echo htmlspecialchars($tag['name']); ?></span>
                            <?php endforeach; ?>
                        </div>
                        <a href="index.php?action=task_edit&id=<?php echo $task['id']; ?>">Edit</a>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    <?php endforeach; ?>
</div>

<h2>Tasks</h2>
<a href="index.php?action=task_create&project_id=<?php echo $project['id']; ?>" class="btn btn-primary">Create New Task</a>
<table class="table">
    <thead>
        <tr>
            <th>Title</th>
            <th>Status</th>
            <th>Priority</th>
            <th>Assigned To</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($tasks as $task): ?>
            <tr>
                <td><?php echo htmlspecialchars($task['title']); ?></td>
                <td><?php echo htmlspecialchars($task['status']); ?></td>
                <td><?php echo htmlspecialchars($task['priority']); ?></td>
                <td><?php echo htmlspecialchars($task['assigned_to_name'] ?? 'Unassigned'); ?></td>
                <td>
                    <a href="index.php?action=task_edit&id=<?php echo $task['id']; ?>" class="btn btn-sm btn-primary">Edit</a>
                    <a href="index.php?action=task_delete&id=<?php echo $task['id']; ?>" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure you want to delete this task?');">Delete</a>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const kanbanBoard = document.getElementById('kanban-board');
    let draggedTask = null;

    kanbanBoard.addEventListener('dragstart', function(e) {
        if (e.target.classList.contains('kanban-task')) {
            draggedTask = e.target;
            e.dataTransfer.setData('text/plain', e.target.dataset.taskId);
        }
    });

    kanbanBoard.addEventListener('dragover', function(e) {
        e.preventDefault();
    });

    kanbanBoard.addEventListener('drop', function(e) {
        e.preventDefault();
        const column = e.target.closest('.kanban-column');
        if (column && draggedTask) {
            const taskId = draggedTask.dataset.taskId;
            const columnId = column.dataset.columnId;
            const tasksContainer = column.querySelector('.kanban-tasks');
            tasksContainer.appendChild(draggedTask);

            // Send AJAX request to update task position
            fetch('index.php?action=move_task', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                },
                body: `task_id=${taskId}&new_column_id=${columnId}&new_position=${tasksContainer.children.length}`
            })
            .then(response => response.json())
            .then(data => {
                if (!data.success) {
                    alert('Failed to move task: ' + data.message);
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('An error occurred while moving the task');
            });
        }
    });
});
</script>

<?php require_once 'views/templates/footer.php'; ?>

