<?php
/**
 * @var array $errors ошибки валидации формы лота
 * @var array $categories категории лота
 */
?>

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

    <form class="form container <?php if ($errors): ?>form--invalid<?php endif; ?>" action="/login.php"
          enctype="application/x-www-form-urlencoded" method="post"> <!-- form--invalid -->
        <h2>Вход</h2>
        <div class="form__item <?php if (get_value($errors, 'email')): ?>form__item--invalid<?php endif; ?>">
            <!-- form__item--invalid -->
            <label for="email">E-mail*</label>
            <input id="email" type="text" name="email" placeholder="Введите e-mail" value="<?= get_value($login_data, 'email') ?>">
            <span class="form__error"><?= get_value($errors, 'email'); ?></span>
        </div>
        <div class="form__item form__item--last <?php if (get_value($errors, 'password')): ?>form__item--invalid<?php endif; ?>">
            <label for="password">Пароль*</label>
            <input id="password" type="password" name="password" placeholder="Введите пароль" value="<?= clean(get_value($login_data, 'password')) ?>">
            <span class="form__error"> <?= get_value($errors, 'password'); ?> </span>
        </div>
        <button type="submit" class="button">Войти</button>
    </form>
</main>