<?php require_once 'views/templates/header.php'; ?>

<h1><?php echo htmlspecialchars($project['name']); ?> - Kanban Board</h1>

<div class="kanban-board">
    <?php foreach ($columns as $column): ?>
        <div class="kanban-column" data-column-id="<?php echo $column['id']; ?>">
            <h3><?php echo htmlspecialchars($column['name']); ?></h3>
            <div class="kanban-tasks">
                <?php foreach ($column['tasks'] as $task): ?>
                    <div class="kanban-task" draggable="true" data-task-id="<?php echo $task['id']; ?>">
                        <h4><?php echo htmlspecialchars($task['title']); ?></h4>
                        <p><?php echo htmlspecialchars($task['description']); ?></p>
                        <a href="index.php?action=task_edit&id=<?php echo $task['id']; ?>" class="btn btn-sm btn-primary">Edit</a>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    <?php endforeach; ?>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const kanbanBoard = document.querySelector('.kanban-board');
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

