<main class="container">
    <section class="promo">
        <h2 class="promo__title">Нужен стафф для катки?</h2>
        <p class="promo__text">На нашем интернет-аукционе ты найдёшь самое эксклюзивное сноубордическое и горнолыжное
            снаряжение.</p>
        <ul class="promo__list">
            <!--заполните этот список из массива категорий-->
            <?php foreach ($categories as $category) : ?>

                <li class="promo__item promo__item--boards">
                    <a class="promo__link"  href="/all-lots.php?category=<?= get_value($category, 'id') ?>"><?= get_value($category, 'name') ?></a>
                </li>

            <?php endforeach; ?>
        </ul>
    </section>
    <section class="lots">
        <div class="lots__header">
            <h2>Открытые лоты</h2>
        </div>
        <ul class="lots__list">
            <!--заполните этот список из массива с товарами-->
            <?php foreach ($lots as $lot): ?>

                <li class="lots__item lot">
                    <div class="lot__image">
                        <img src="<?= $lot['img']; ?>" width="350" height="260" alt="">
                    </div>
                    <div class="lot__info">
                        <span class="lot__category"><?= clean(get_value($lot, 'category_name')); ?></span>
                        <h3 class="lot__title"><a class="text-link" href="lot.php?id=<?= $lot['id']; ?>"><?= clean(get_value($lot, 'name')); ?></a></h3>
                        <div class="lot__state">
                            <div class="lot__rate">
                                <span class="lot__amount">Стартовая цена</span>
                                <span class="lot__cost"><?= format_price(clean(get_value($lot, 'start_price'))); ?></span>
                            </div>
                            <div class="lot__timer timer <?php if (time_before_end(clean(get_value($lot, 'end_time'))) < '01:00'): ?>timer--finishing<?php endif; ?>">
                                <?= time_before_end(clean(get_value($lot, 'end_time'))) ?>
                            </div>
                        </div>
                    </div>
                </li>

            <?php endforeach; ?>
        </ul>

        <?php if ($pages_count > 1): ?>

        <ul class="pagination-list">

            <?php if ($cur_page > 1): ?>
                <li class="pagination-item pagination-item-prev">
                    <a href="index.php?page=<?= ($cur_page - 1); ?>">Назад</a>
                </li>
            <?php endif; ?>

            <?php foreach ($pages as $page): ?>
                <li class="pagination-item <?php if ((int)$page === (int)$cur_page): ?>pagination-item-active<?php endif; ?>">
                    <a href="index.php?page=<?= $page; ?>"><?= $page; ?></a>
                </li>
            <?php endforeach; ?>

            <?php if ($cur_page < $pages_count): ?>
                <li class="pagination-item pagination-item-next">
                    <a href="index.php?page=<?= ($cur_page + 1); ?>">Вперед</a>
                </li>
            <?php endif; ?>

        </ul>

        <?php endif; ?>

    </section>
</main>