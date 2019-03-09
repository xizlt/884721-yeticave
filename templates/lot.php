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
    <h2><?= $lot ['name']; ?></h2>
    <div class="lot-item__content">
        <div class="lot-item__left">
            <div class="lot-item__image">
                <img src="<?= $lot['img']; ?>" width="730" height="548" alt="Сноуборд">
            </div>
            <p class="lot-item__category">Категория: <span><?= get_value($lot, 'category_name'); ?></span></p>
            <p class="lot-item__description"> <?= get_value($lot, 'description'); ?></p>
        </div>
        <div class="lot-item__right">

            <?php if($show_rate !== false): ?>

                <div class="lot-item__state">
                    <div class="lot-item__timer timer">
                        <?= time_before_end(get_value($lot, 'end_time')) ?>
                    </div>
                    <div class="lot-item__cost-state">
                        <div class="lot-item__rate">
                            <span class="lot-item__amount">Текущая цена</span>
                            <span class="lot-item__cost"><?=formatPrice(get_value($lot, 'price')); ?></span>
                        </div>
                        <div class="lot-item__min-cost">
                            Мин. ставка <span><?= formatPrice(get_value($lot, 'rate')); ?></span>
                        </div>
                    </div>
                    <form class="lot-item__form" action="/lot.php?id=<?= $lot['id']; ?>" method="post" enctype="application/x-www-form-urlencoded">
                        <p class="lot-item__form-item <?php if($errors): ?> form__item--invalid <?php endif; ?>">
                            <label for="cost">Ваша ставка</label>
                            <input id="cost" type="text" name="amount" placeholder="<?= formatPrice($lot['rate']); ?>">
                            <span class="form__error"><?= $errors ?></span>
                        </p>
                        <button type="submit" class="button">Сделать ставку</button>
                    </form>
                </div>

                <?php endif;?>

            <div class="history">
                <h3>История ставок (<span><?= count($rate) ?></span>)</h3>
                <table class="history__list">
                    <?php foreach ($rate as $key): ?>
                    <tr class="history__item">
                        <td class="history__name"><?= $key['name']; ?></td>
                        <td class="history__price"><?= formatPrice($key['amount']); ?></td>
                        <td class="history__time"><?= time_rite($key['time']); ?></td>
                    </tr>
                    <?php endforeach; ?>

                </table>
            </div>
        </div>
    </div>
</section>
    </main>