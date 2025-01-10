<?php require_once 'views/templates/header.php'; ?>

<h1>Tags</h1>

<a href="index.php?action=tag_create" class="btn btn-primary mb-3">Create New Tag</a>

<table class="table">
    <thead>
        <tr>
            <th>ID</th>
            <th>Name</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($tags as $tag): ?>
            <tr>
                <td><?php echo $tag['id']; ?></td>
                <td><?php echo htmlspecialchars($tag['name']); ?></td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<?php require_once 'views/templates/footer.php'; ?>

