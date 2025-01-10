<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Tag - TaskFlow</title>
</head>
<body>
    <h1>Create New Tag</h1>
    <form action="index.php?action=tag_create" method="POST">
        <div>
            <label for="name">Tag Name:</label>
            <input type="text" id="name" name="name" required>
        </div>
        <button type="submit">Create Tag</button>
    </form>
    <p><a href="index.php?action=tag_list">Back to Tags</a></p>
</body>
</html>

