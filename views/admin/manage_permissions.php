<?php require_once 'views/templates/header.php'; ?>

<h1>Manage Permissions</h1>

<h2>Create New Permission</h2>
<form action="index.php?action=admin_manage_permissions" method="POST">
    <input type="hidden" name="action" value="create">
    <input type="text" name="name" required placeholder="Permission Name">
    <button type="submit">Create Permission</button>
</form>

<h2>Existing Permissions</h2>
<table class="table">
    <thead>
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($permissions as $permission): ?>
            <tr>
                <td><?php echo $permission['id']; ?></td>
                <td><?php echo htmlspecialchars($permission['name']); ?></td>
                <td>
                    <form action="index.php?action=admin_manage_permissions" method="POST" style="display:inline;">
                        <input type="hidden" name="action" value="update">
                        <input type="hidden" name="id" value="<?php echo $permission['id']; ?>">
                        <input type="text" name="name" value="<?php echo htmlspecialchars($permission['name']); ?>" required>
                        <button type="submit">Update</button>
                    </form>
                    <form action="index.php?action=admin_manage_permissions" method="POST" style="display:inline;">
                        <input type="hidden" name="action" value="delete">
                        <input type="hidden" name="id" value="<?php echo $permission['id']; ?>">
                        <button type="submit" onclick="return confirm('Are you sure you want to delete this permission?');">Delete</button>
                    </form>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<h2>Assign Permissions to Roles</h2>
<form action="index.php?action=admin_manage_permissions" method="POST">
    <input type="hidden" name="action" value="assign">
    <select name="role_id" required>
        <?php foreach ($roles as $role): ?>
            <option value="<?php echo $role['id']; ?>"><?php echo htmlspecialchars($role['name']); ?></option>
        <?php endforeach; ?>
    </select>
    <select name="permission_id" required>
        <?php foreach ($permissions as $permission): ?>
            <option value="<?php echo $permission['id']; ?>"><?php echo htmlspecialchars($permission['name']); ?></option>
        <?php endforeach; ?>
    </select>
    <button type="submit">Assign Permission</button>
</form>

<?php require_once 'views/templates/footer.php'; ?>

