<?php require_once 'views/templates/header.php'; ?>

<h1>Manage Roles</h1>

<table class="table">
    <thead>
        <tr>
            <th>User</th>
            <th>Current Role</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($users as $user): ?>
            <tr>
                <td><?php echo htmlspecialchars($user['name']); ?></td>
                <td><?php echo htmlspecialchars($user['role']); ?></td>
                <td>
                    <form action="index.php?action=update_role" method="POST">
                        <input type="hidden" name="user_id" value="<?php echo $user['id']; ?>">
                        <select name="new_role">
                            <option value="admin" <?php echo $user['role'] == 'admin' ? 'selected' : ''; ?>>Admin</option>
                            <option value="project_manager" <?php echo $user['role'] == 'project_manager' ? 'selected' : ''; ?>>Project Manager</option>
                            <option value="team_member" <?php echo $user['role'] == 'team_member' ? 'selected' : ''; ?>>Team Member</option>
                        </select>
                        <button type="submit" class="btn btn-sm btn-primary">Update Role</button>
                    </form>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<?php require_once 'views/templates/footer.php'; ?>

