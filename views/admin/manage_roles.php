<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Roles - TaskFlow</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            margin: 0;
            padding: 20px;
            background-color: #f4f4f4;
        }
        .container {
            max-width: 800px;
            margin: auto;
            background: white;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }
        h1 {
            color: #333;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        th, td {
            padding: 10px;
            border: 1px solid #ddd;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
        .btn {
            display: inline-block;
            padding: 5px 10px;
            background-color: #007bff;
            color: #fff;
            text-decoration: none;
            border-radius: 4px;
        }
        .btn:hover {
            background-color: #0056b3;
        }
        form {
            margin-bottom: 20px;
        }
        input[type="text"] {
            padding: 5px;
            width: 200px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Manage Roles</h1>
        
        <h2>Create New Role</h2>
        <form action="index.php?action=admin_manage_roles" method="POST">
            <input type="hidden" name="action" value="create">
            <input type="text" name="name" placeholder="Role Name" required>
            <button type="submit" class="btn">Create Role</button>
        </form>

        <h2>Existing Roles</h2>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($roles as $role): ?>
                    <tr>
                        <td><?php echo $role['id']; ?></td>
                        <td><?php echo htmlspecialchars($role['name']); ?></td>
                        <td>
                            <form action="index.php?action=admin_manage_roles" method="POST" style="display:inline;">
                                <input type="hidden" name="action" value="update">
                                <input type="hidden" name="id" value="<?php echo $role['id']; ?>">
                                <input type="text" name="name" value="<?php echo htmlspecialchars($role['name']); ?>" required>
                                <button type="submit" class="btn">Update</button>
                            </form>
                            <form action="index.php?action=admin_manage_roles" method="POST" style="display:inline;">
                                <input type="hidden" name="action" value="delete">
                                <input type="hidden" name="id" value="<?php echo $role['id']; ?>">
                                <button type="submit" class="btn" onclick="return confirm('Are you sure you want to delete this role?');">Delete</button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

        <a href="index.php?action=admin_dashboard" class="btn">Back to Admin Dashboard</a>
    </div>
</body>
</html>

