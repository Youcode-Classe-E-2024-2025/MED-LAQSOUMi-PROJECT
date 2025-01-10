<?php require_once 'views/templates/header.php'; ?>

<div class="container-fluid mt-4">
    <h1>Kanban Board</h1>
    
    <div class="row">
        <?php
        $statuses = [
            'backlog' => ['title' => 'Backlog', 'class' => 'bg-secondary'],
            'todo' => ['title' => 'To Do', 'class' => 'bg-primary'],
            'in_progress' => ['title' => 'In Progress', 'class' => 'bg-warning'],
            'done' => ['title' => 'Done', 'class' => 'bg-success']
        ];

        foreach ($statuses as $status => $info):
        ?>
        <div class="col-md-3">
            <div class="card">
                <div class="card-header <?php echo $info['class']; ?> text-white">
                    <?php echo $info['title']; ?>
                </div>
                <div class="card-body" id="<?php echo $status; ?>">
                    <?php foreach ($tasks[$status] as $task): ?>
                        <div class="card mb-2" data-task-id="<?php echo $task['id']; ?>">
                            <div class="card-body">
                                <h5 class="card-title"><?php echo htmlspecialchars($task['title']); ?></h5>
                                <p class="card-text"><?php echo htmlspecialchars($task['description']); ?></p>
                                <button class="btn btn-sm btn-danger delete-task" data-task-id="<?php echo $task['id']; ?>">Delete</button>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
        <?php endforeach; ?>
    </div>
    
    <div class="row mt-4">
        <div class="col-md-12">
            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#addTaskModal">
                Add New Task
            </button>
        </div>
    </div>
</div>

<!-- Add Task Modal -->
<div class="modal fade" id="addTaskModal" tabindex="-1" role="dialog" aria-labelledby="addTaskModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addTaskModalLabel">Add New Task</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="index.php?action=kanban_create_task" method="POST">
                <div class="modal-body">
                    <div class="form-group">
                        <label for="taskTitle">Task Title</label>
                        <input type="text" class="form-control" id="taskTitle" name="title" required>
                    </div>
                    <div class="form-group">
                        <label for="taskDescription">Task Description</label>
                        <textarea class="form-control" id="taskDescription" name="description" rows="3" required></textarea>
                    </div>
                    <div class="form-group">
                        <label for="taskStatus">Status</label>
                        <select class="form-control" id="taskStatus" name="status">
                            <option value="todo">To Do</option>
                            <option value="in_progress">In Progress</option>
                            <option value="completed">Completed</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Add Task</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js"></script>
<script>
$(document).ready(function() {
    $('.card-body').sortable({
        connectWith: '.card-body',
        update: function(event, ui) {
            var taskId = ui.item.data('task-id');
            var newStatus = ui.item.parent().attr('id');
            $.ajax({
                url: 'index.php?action=kanban_update_task_status',
                method: 'POST',
                data: { task_id: taskId, new_status: newStatus },
                success: function(response) {
                    var data = JSON.parse(response);
                    if (!data.success) {
                        alert(data.message);
                    }
                }
            });
        }
    });

    $('.delete-task').click(function() {
        var taskId = $(this).data('task-id');
        if (confirm('Are you sure you want to delete this task?')) {
            $.ajax({
                url: 'index.php?action=kanban_delete_task',
                method: 'POST',
                data: { task_id: taskId },
                success: function(response) {
                    location.reload();
                }
            });
        }
    });
});
</script>

<?php require_once 'views/templates/footer.php'; ?>

