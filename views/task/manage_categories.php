<?php require_once 'views/templates/header.php'; ?>

<h1>Manage Categories</h1>

<form action="index.php?action=manage_categories" method="POST">
    <input type="hidden" name="action" value="create">
    <input type="text" name="name" required placeholder="New Category Name">
    <button type="submit">Add Category</button>
</form>

<table class="table">
    <thead>
        <tr>
            <th>Name</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($categories as $category): ?>
            <tr>
                <td><?php echo htmlspecialchars($category['name']); ?></td>
                <td>
                    <form action="index.php?action=manage_categories" method="POST" style="display:inline;">
                        <input type="hidden" name="action" value="update">
                        <input type="hidden" name="id" value="<?php echo $category['id']; ?>">
                        <input type="text" name="name" value="<?php echo htmlspecialchars($category['name']); ?>" required>
                        <button type="submit">Update</button>
                    </form>
                    <form action="index.php?action=manage_categories" method="POST" style="display:inline;">
                        <input type="hidden" name="action" value="delete">
                        <input type="hidden" name="id" value="<?php echo $category['id']; ?>">
                        <button type="submit" onclick="return confirm('Are you sure you want to delete this category?');">Delete</button>
                    </form>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<?php require_once 'views/templates/footer.php'; ?>

