<main>
    <nav class="nav">
        <ul class="nav__list container">
            <?php foreach ($categories as $category) : ?>
                <li class="nav__item">
                    <a href="#"> <?= get_value($category, 'name'); ?></a>
                </li>
            <?php endforeach; ?>
        </ul>
    </nav>

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
                                <span class="lot__amount"><?= $rates ?></span>
                                <span class="lot__cost"><?= format_price(clean(get_value($lot, 'start_price'))) ?></span>
                            </div>
                            <div class="lot__timer timer">
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
            <li class="pagination-item <?php if ($page === $cur_page): ?> pagination-item-prev<?php endif; ?>"><a href="search.php?search=<?= $search ?>&find=Найти&page=<?= $page ;?>">Назад</a></li>
            <?php foreach ($pages as $page): ?>
            <li class="pagination-item"><a href="search.php?search=<?= $search ?>&find=Найти&page=<?=$page;?>"><?=$page;?></a></li>
            <?php endforeach; ?>
            <li class="pagination-item pagination-item-next"><a href="#">Вперед</a></li>
        </ul>
        <?php endif; ?>
    </div>
</main>