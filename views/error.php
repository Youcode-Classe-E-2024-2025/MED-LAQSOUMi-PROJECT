<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Error - TaskFlow</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-5">
        <div class="alert alert-danger" role="alert">
            <h4 class="alert-heading">Oops! Something went wrong.</h4>
            <p><?php echo htmlspecialchars($error); ?></p>
            <hr>
            <p class="mb-0">Please go back and try again. If the problem persists, contact the system administrator.</p>
        </div>
        <a href="index.php" class="btn btn-primary">Go to Homepage</a>
    </div>
</body>
</html>

