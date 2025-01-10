<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Category - TaskFlow</title>
</head>
<body>
    <h1>Create New Category</h1>
    <form action="index.php?action=category_create" method="POST">
        <div>
            <label for="name">Category Name:</label>
            <input type="text" id="name" name="name" required>
        </div>
        <button type="submit">Create Category</button>
    </form>
    <p><a href="index.php?action=category_list">Back to Categories</a></p>
</body>
</html>

