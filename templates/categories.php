<nav class="nav">
    <ul class="nav__list container">
        <?php foreach ($categories as $category): ?>
            <li class="nav__item">
                <a href="/all-lots.php?category=<?= get_value($category, 'id') ?>"><?= get_value($category, 'name') ?></a>
            </li>
        <?php endforeach; ?>
    </ul>
</nav>