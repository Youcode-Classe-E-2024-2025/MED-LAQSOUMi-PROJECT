<?php require_once 'views/templates/header.php'; ?>

<h1>Manage Tags</h1>

<form action="index.php?action=manage_tags" method="POST">
    <input type="hidden" name="action" value="create">
    <input type="text" name="name" required placeholder="New Tag Name">
    <button type="submit">Add Tag</button>
</form>

<table class="table">
    <thead>
        <tr>
            <th>Name</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($tags as $tag): ?>
            <tr>
                <td><?php echo htmlspecialchars($tag['name']); ?></td>
                <td>
                    <form action="index.php?action=manage_tags" method="POST" style="display:inline;">
                        <input type="hidden" name="action" value="update">
                        <input type="hidden" name="id" value="<?php echo $tag['id']; ?>">
                        <input type="text" name="name" value="<?php echo htmlspecialchars($tag['name']); ?>" required>
                        <button type="submit">Update</button>
                    </form>
                    <form action="index.php?action=manage_tags" method="POST" style="display:inline;">
                        <input type="hidden" name="action" value="delete">
                        <input type="hidden" name="id" value="<?php echo $tag['id']; ?>">
                        <button type="submit" onclick="return confirm('Are you sure you want to delete this tag?');">Delete</button>
                    </form>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<?php require_once 'views/templates/footer.php'; ?>

