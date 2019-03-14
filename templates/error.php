<main>
    <?= include_template('categories.php', ['categories'=>$categories]); ?>

    <section class="lot-item container">
        <h2>Ошибка</h2>
        <p class="error"><?= $error; ?></p>
    </section>
</main>