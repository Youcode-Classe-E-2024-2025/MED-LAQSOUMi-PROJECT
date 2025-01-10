<?php require_once 'views/templates/header.php'; ?>

<h1><?php echo htmlspecialchars($task['title'] ?? 'Task Details'); ?></h1>

<p><strong>Status:</strong> <?php echo htmlspecialchars($task['status'] ?? 'Unknown'); ?></p>
<p><strong>Priority:</strong> <?php echo htmlspecialchars($task['priority'] ?? 'Unknown'); ?></p>
<p><strong>Assigned To:</strong> <?php echo htmlspecialchars($task['assigned_to_name'] ?? 'Unassigned'); ?></p>

<h2>Description</h2>
<div>
    <?php 
    if (isset($task['description_html']) && !empty($task['description_html'])) {
        echo $task['description_html'];
    } elseif (isset($task['description']) && !empty($task['description'])) {
        echo nl2br(htmlspecialchars($task['description']));
    } else {
        echo '<p>No description available.</p>';
    }
    ?>
</div>

<h2>Project</h2>
<p><?php echo htmlspecialchars($task['project_name'] ?? 'Unknown Project'); ?></p>

<h2>Category</h2>
<p><?php echo htmlspecialchars($task['category_name'] ?? 'Uncategorized'); ?></p>

<h2>Tags</h2>
<?php if (isset($task_tags) && !empty($task_tags)): ?>
    <ul>
        <?php foreach ($task_tags as $tag): ?>
            <li><?php echo htmlspecialchars($tag['name']); ?></li>
        <?php endforeach; ?>
    </ul>
<?php else: ?>
    <p>No tags assigned.</p>
<?php endif; ?>

<a href="index.php?action=task_edit&id=<?php echo $task['id']; ?>" class="btn btn-primary">Edit Task</a>
<a href="index.php?action=project_view&id=<?php echo $task['project_id']; ?>" class="btn btn-secondary">Back to Project</a>

<?php require_once 'views/templates/footer.php'; ?>

