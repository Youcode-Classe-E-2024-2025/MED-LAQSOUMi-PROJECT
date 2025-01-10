<?php require_once 'views/templates/header.php'; ?>

<h1>Projects</h1>

<!-- ... (existing project list code) ... -->

<nav aria-label="Page navigation">
    <ul class="pagination">
        <?php for ($i = 1; $i <= $totalPages; $i++): ?>
            <li class="page-item <?php echo $i === $page ? 'active' : ''; ?>">
                <a class="page-link" href="index.php?action=project_list&page=<?php echo $i; ?>"><?php echo $i; ?></a>
            </li>
        <?php endfor; ?>
    </ul>
</nav>

<?php require_once 'views/templates/footer.php'; ?>

