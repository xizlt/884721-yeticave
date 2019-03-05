<main>
    <nav class="nav">
        <ul class="nav__list container">
            <?php foreach ($categories as $category) : ?>
                <li class="nav__item">
                    <a href=""> <?=$category['name']; ?></a>
                </li>
            <?php endforeach; ?>
        </ul>
    </nav>
    <form class="form container <?php if($errors): ?>form--invalid<?php endif;?>""  action="https://echo.htmlacademy.ru" method="post"> <!-- form--invalid -->
    <h2>Вход</h2>
    <div class="form__item <?php if($errors): ?>form__item--invalid<?php endif;?>"> <!-- form__item--invalid -->
        <label for="email">E-mail*</label>
        <input id="email" type="text" name="email" placeholder="Введите e-mail" required>
        <span class="form__error">Введите e-mail</span>
    </div>
    <div class="form__item form__item--last <?php if($errors): ?>form__item--invalid<?php endif;?>">
        <label for="password">Пароль*</label>
        <input id="password" type="password" name="password" placeholder="Введите пароль" required>
        <span class="form__error">Введите пароль</span>
    </div>
    <button type="submit" class="button">Войти</button>
    </form>
</main>