<main>
    <nav class="nav">
        <ul class="nav__list container">
            <?php foreach ($categories as $category) : ?>
                <li class="nav__item">
                    <a href=""> <?= get_value($category, 'name'); ?></a>
                </li>
            <?php endforeach; ?>
        </ul>
    </nav>

    <section class="lot-item container">
        <h2><?= clean(get_value($lot, 'name')); ?></h2>
        <div class="lot-item__content">
            <div class="lot-item__left">
                <div class="lot-item__image">
                    <img src="<?= $lot['img']; ?>" width="730" height="548" alt="Сноуборд">
                </div>
                <p class="lot-item__category">Категория: <span><?= clean(get_value($lot, 'category_name')); ?></span></p>
                <p class="lot-item__description"> <?= clean(get_value($lot, 'description')); ?></p>
            </div>
            <div class="lot-item__right">
                    <div class="lot-item__state">
                        <div class="lot-item__timer timer">
                            <?= time_before_end(clean(get_value($lot, 'end_time'))) ?>
                        </div>
                        <div class="lot-item__cost-state">
                            <div class="lot-item__rate">
                                <span class="lot-item__amount">Текущая цена</span>
                                <span class="lot-item__cost"><?= format_price(clean(get_value($lot, 'price'))); ?></span>
                            </div>
                            <div class="lot-item__min-cost">
                                Мин. ставка <span><?= format_price(clean(get_value($lot, 'rate'))); ?></span>
                            </div>
                        </div>

                        <?php if ($show_rate !== false): ?>

                        <form class="lot-item__form" action="/lot.php?id=<?= $lot['id']; ?>" method="post" enctype="application/x-www-form-urlencoded">
                            <p class="lot-item__form-item <?php if ($errors): ?> form__item--invalid <?php endif; ?>">
                                <label for="cost">Ваша ставка</label>
                                <input id="cost" type="text" name="amount"
                                       placeholder="<?= format_price(clean(get_value($lot, 'rate'))); ?>">
                                <span class="form__error"><?= $errors ?></span>
                            </p>
                            <button type="submit" class="button">Сделать ставку</button>
                        </form>

                        <?php endif; ?>

                    </div>
                <div class="history">
                    <h3>История ставок (<span><?= count($rates) ?></span>)</h3>
                    <table class="history__list">
                        <?php foreach ($rates as $rate): ?>
                            <tr class="history__item">
                                <td class="history__name"><?= clean(get_value($rate, 'name')); ?></td>
                                <td class="history__price"><?= format_price(clean(get_value($rate, 'amount'))); ?></td>
                                <td class="history__time"><?= time_rite(clean(get_value($rate, 'time'))); ?></td>
                            </tr>
                        <?php endforeach; ?>

                    </table>
                </div>
            </div>
        </div>
    </section>
</main>