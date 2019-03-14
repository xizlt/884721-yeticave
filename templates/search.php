<main>
    <?= include_template('categories.php', ['categories'=>$categories]); ?>

    <div class="container">
        <section class="lots">
            <h2>Результаты поиска по запросу «<span><?= $search ?></span>»</h2>
            <ul class="lots__list">
                <?php if(!$lots): ?> <h3> Ничего не найдено по вашему запросу </h3> <?php endif; ?>
                <?php foreach ($lots as $lot): ?>
                <li class="lots__item lot">
                    <div class="lot__image">
                        <img src="<?= get_value($lot, 'img') ?>" width="350" height="260" alt="Сноуборд">
                    </div>
                    <div class="lot__info">
                        <span class="lot__category"><?= clean(get_value($lot, 'category')) ?></span>
                        <h3 class="lot__title"><a class="text-link" href="lot.php?id=<?= $lot['id_lot']; ?>"><?= clean(get_value($lot, 'lot_name')) ?></a></h3>
                        <div class="lot__state">
                            <div class="lot__rate">
                                <span class="lot__amount">Стартовая цена</span>
                                <span class="lot__cost"><?= format_price(clean(get_value($lot, 'start_price'))) ?></span>
                            </div>
                            <div class="lot__timer timer <?php if (time_before_end(clean(get_value($lot, 'time'))) < '00:10'): ?>timer--finishing<?php endif; ?>">
                                <?= time_before_end(clean(get_value($lot, 'time'))) ?>
                            </div>
                        </div>
                    </div>
                </li>
                <?php endforeach; ?>

            </ul>
        </section>

        <?php if ($pages_count > 1): ?>

        <ul class="pagination-list">

            <?php if ($cur_page > 1): ?>
                <li class="pagination-item pagination-item-prev">
                    <a href="search.php?search=<?= $search ?>&find=Найти&page=<?= ($cur_page - 1); ?>">Назад</a>
                </li>
            <?php endif; ?>

            <?php foreach ($pages as $page): ?>
                <li class="pagination-item <?php if ((int)$page === (int)$cur_page): ?>pagination-item-active<?php endif; ?>">
                    <a href="search.php?search=<?= $search ?>&find=Найти&page=<?= $page; ?>"><?= $page; ?></a>
                </li>
            <?php endforeach; ?>

            <?php if ($cur_page < $pages_count): ?>
                <li class="pagination-item pagination-item-next">
                    <a href="search.php?search=<?= $search ?>&find=Найти&page=<?= ($cur_page + 1); ?>">Вперед</a>
                </li>
            <?php endif; ?>

        </ul>

        <?php endif; ?>

    </div>
</main>