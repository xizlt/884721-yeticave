<main>
    <nav class="nav">
        <ul class="nav__list container">
            <?php foreach ($categories as $category): ?>
                <li class="nav__item">
                    <a href="all-lots.php"><?= get_value($category, 'name') ?></a>
                </li>
            <?php endforeach; ?>
        </ul>
    </nav>
    <section class="lot-item container">
        <h2>Ошибка</h2>
        <p class="error"><?= $errors; ?></p>
    </section>
</main>