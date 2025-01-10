<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - TaskFlow</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <h2 class="mb-4">Login</h2>
                <?php
                $flashMessage = getFlashMessage();
                if ($flashMessage) {
                    echo "<div class='alert alert-{$flashMessage['type']}'>{$flashMessage['message']}</div>";
                }
                if (isset($error)) {
                    echo "<div class='alert alert-danger'>$error</div>";
                }
                ?>
                <form action="index.php?action=login" method="POST">
                    <input type="hidden" name="csrf_token" value="<?php echo generateCSRFToken(); ?>">
                    <div class="form-group">
                        <label for="email">Email:</label>
                        <input type="email" id="email" name="email" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="password">Password:</label>
                        <input type="password" id="password" name="password" class="form-control" required>
                    </div>
                    <button type="submit" class="btn btn-primary">Login</button>
                </form>
                <p class="mt-3">Don't have an account? <a href="index.php?action=register">Register here</a></p>
            </div>
        </div>
    </div>
</body>
</html>

