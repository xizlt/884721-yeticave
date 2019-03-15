<main>
    <?= include_template('categories.php', ['categories'=>$categories]); ?>
    <section class="rates container">
        <h2>Мои ставки</h2>
        <table class="rates__list">

            <?php foreach ($lots as $lot): ?>
            <tr class="rates__item <?php if (time_before_end_by_my_lots(clean(get_value($lot, 'end_time_lot'))) === '00:00:00'): ?>rates__item--end<?php endif; ?>">
                <td class="rates__info">
                    <div class="rates__img">
                        <img src="<?= get_value($lot, 'img') ?>" width="54" height="40" alt="<?= get_value($lot, 'name_lot') ?>">
                    </div>
                    <h3 class="rates__title"><a href="lot.php?id=<?= $lot['id_lot'] ?>"><?= get_value($lot, 'name_lot') ?></a></h3>
                </td>
                <td class="rates__category">
                    <?= clean(get_value($lot, 'category_name')) ?>
                </td>
                <td class="rates__timer">
                    <?php if (time_before_end_by_my_lots(clean(get_value($lot, 'end_time_lot'))) === '00:00:00'): ?>
                            <div class="timer timer--end">Торги окончены</div>
                    <?php elseif (get_value($lot, 'winner_id')): ?>
                        <div class="timer timer--win">Ставка выиграла</div>
                    <?php else: ?>
                    <div class="timer <?php if (time_before_end_by_my_lots(clean(get_value($lot, 'end_time_lot'))) < '01:00:00'): ?>timer--finishing<?php endif; ?>">
                        <?= time_before_end_by_my_lots(clean(get_value($lot, 'end_time_lot'))) ?>
                    </div>
                    <?php endif; ?>
                </td>
                <td class="rates__price">
                    <?= format_price(clean(get_value($lot, 'amount'))) ?>
                </td>
                <td class="rates__time">
                    <?= time_rite(clean(get_value($lot, 'time_add_rite'))) ?>
                </td>
            </tr>
            <?php endforeach; ?>

            <tr class="rates__item">
                <td class="rates__info">
                    <div class="rates__img">
                        <img src="img/rate2.jpg" width="54" height="40" alt="Сноуборд">
                    </div>
                    <h3 class="rates__title"><a href="lot.html">DC Ply Mens 2016/2017 Snowboard</a></h3>
                </td>
                <td class="rates__category">
                    Доски и лыжи
                </td>
                <td class="rates__timer">
                    <div class="timer timer--finishing">07:13:34</div>
                </td>
                <td class="rates__price">
                    10 999 р
                </td>
                <td class="rates__time">
                    20 минут назад
                </td>
            </tr>
            <tr class="rates__item rates__item--win">
                <td class="rates__info">
                    <div class="rates__img">
                        <img src="img/rate3.jpg" width="54" height="40" alt="Крепления">
                    </div>
                    <div>
                        <h3 class="rates__title"><a href="lot.html">Крепления Union Contact Pro 2015 года размер L/XL</a></h3>
                        <p>Телефон +7 900 667-84-48, Скайп: Vlas92. Звонить с 14 до 20</p>
                    </div>
                </td>
                <td class="rates__category">
                    Крепления
                </td>
                <td class="rates__timer">
                    <div class="timer timer--win">Ставка выиграла</div>
                </td>
                <td class="rates__price">
                    10 999 р
                </td>
                <td class="rates__time">
                    Час назад
                </td>
            </tr>
            <tr class="rates__item">
                <td class="rates__info">
                    <div class="rates__img">
                        <img src="img/rate4.jpg" width="54" height="40" alt="Ботинки">
                    </div>
                    <h3 class="rates__title"><a href="lot.html">Ботинки для сноуборда DC Mutiny Charocal</a></h3>
                </td>
                <td class="rates__category">
                    Ботинки
                </td>
                <td class="rates__timer">
                    <div class="timer">07:13:34</div>
                </td>
                <td class="rates__price">
                    10 999 р
                </td>
                <td class="rates__time">
                    Вчера, в 21:30
                </td>
            </tr>
            <tr class="rates__item rates__item--end">
                <td class="rates__info">
                    <div class="rates__img">
                        <img src="img/rate5.jpg" width="54" height="40" alt="Куртка">
                    </div>
                    <h3 class="rates__title"><a href="lot.html">Куртка для сноуборда DC Mutiny Charocal</a></h3>
                </td>
                <td class="rates__category">
                    Одежда
                </td>
                <td class="rates__timer">
                    <div class="timer timer--end">Торги окончены</div>
                </td>
                <td class="rates__price">
                    10 999 р
                </td>
                <td class="rates__time">
                    Вчера, в 21:30
                </td>
            </tr>
            <tr class="rates__item rates__item--end">
                <td class="rates__info">
                    <div class="rates__img">
                        <img src="img/rate6.jpg" width="54" height="40" alt="Маска">
                    </div>
                    <h3 class="rates__title"><a href="lot.html">Маска Oakley Canopy</a></h3>
                </td>
                <td class="rates__category">
                    Разное
                </td>
                <td class="rates__timer">
                    <div class="timer timer--end">Торги окончены</div>
                </td>
                <td class="rates__price">
                    10 999 р
                </td>
                <td class="rates__time">
                    19.03.17 в 08:21
                </td>
            </tr>
            <tr class="rates__item rates__item--end">
                <td class="rates__info">
                    <div class="rates__img">
                        <img src="img/rate7.jpg" width="54" height="40" alt="Сноуборд">
                    </div>
                    <h3 class="rates__title"><a href="lot.html">DC Ply Mens 2016/2017 Snowboard</a></h3>
                </td>
                <td class="rates__category">
                    Доски и лыжи
                </td>
                <td class="rates__timer">
                    <div class="timer timer--end">Торги окончены</div>
                </td>
                <td class="rates__price">
                    10 999 р
                </td>
                <td class="rates__time">
                    19.03.17 в 08:21
                </td>
            </tr>
        </table>
    </section>
</main>