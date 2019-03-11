<main>
    <nav class="nav">
        <ul class="nav__list container">
            <?php foreach ($categories as $category): ?>
                <li class="nav__item">
                    <a href="all-lots.php"><?= clean(get_value($category, 'name')) ?></a>
                </li>
            <?php endforeach; ?>
        </ul>
    </nav>

    <form class="form container <?php if ($errors): ?>form--invalid<?php endif; ?>" action="/sign_up.php" method="post" enctype="multipart/form-data"> <!-- form--invalid -->
        <h2>Регистрация нового аккаунта</h2>
        <div class="form__item <?php if (get_value($errors, 'email')): ?>form__item--invalid<?php endif; ?>">
            <!-- form__item--invalid -->
            <label for="email">E-mail*</label>
            <input id="email" type="text" name="email" placeholder="Введите e-mail" value="<?= get_value($user_data, 'email') ?>">
            <span class="form__error"><?= get_value($errors, 'email') ?></span>
        </div>
        <div class="form__item <?php if (get_value($errors, 'password')): ?>form__item--invalid<?php endif; ?>">
            <label for="password">Пароль*</label>
            <input id="password" type="password" name="password" placeholder="Введите пароль" value="<?= clean(get_value($user_data, 'password')) ?>">
            <span class="form__error"><?= get_value($errors, 'password') ?></span>
        </div>
        <div class="form__item <?php if (get_value($errors, 'name')): ?>form__item--invalid<?php endif; ?>">
            <label for="name">Имя*</label>
            <input id="name" type="text" name="name" placeholder="Введите имя" value="<?= clean(get_value($user_data, 'name')) ?>">
            <span class="form__error"><?= get_value($errors, 'name') ?></span>
        </div>
        <div class="form__item <?php if (get_value($errors, 'contacts')): ?>form__item--invalid<?php endif; ?>">
            <label for="message">Контактные данные*</label>
            <textarea id="message" name="contacts" placeholder="Напишите как с вами связаться"><?= clean(get_value($user_data, 'contacts')) ?></textarea>
            <span class="form__error"><?= get_value($errors, 'contacts') ?></span>
        </div>
        <div class="form__item form__item--file form__item--last <?php if (get_value($errors, 'avatar')): ?>form__item--invalid<?php endif; ?>">
            <label>Аватар</label>
            <div class="preview">
                <button class="preview__remove" type="button">x</button>
                <div class="preview__img">
                    <img src="img/avatar.jpg" width="113" height="113" alt="Ваш аватар">
                </div>
            </div>
            <div class="form__input-file">
                <input class="visually-hidden" type="file" id="photo2" value="<?= $file_data['avatar'] ?>" name="avatar">
                <label for="photo2">
                    <span>+ Добавить</span>
                </label>
            </div>
            <span class="form__error"><?= get_value($errors, 'avatar') ?></span>
        </div>
        <span class="form__error form__error--bottom">Пожалуйста, исправьте ошибки в форме.</span>
        <button type="submit" class="button">Зарегистрироваться</button>
        <a class="text-link" href="#">Уже есть аккаунт</a>
    </form>
</main>
