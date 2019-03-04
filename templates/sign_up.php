<main>
    <nav class="nav">
        <ul class="nav__list container">
            <?php foreach ($categories as $category): ?>
                <li class="nav__item">
                    <a href="all-lots.php"><?= $category['name'] ?></a>
                </li>
            <?php endforeach; ?>
        </ul>
    </nav>
    
    <form class="form container <?php if($errors): ?>form--invalid<?php endif;?>" action="../sign_up.php" method="post" enctype="multipart/form-data"> <!-- form--invalid -->
        <h2>Регистрация нового аккаунта</h2>
        <div class="form__item <?php if($errors['email']): ?>form__item--invalid<?php endif; ?>"> <!-- form__item--invalid -->
            <label for="email">E-mail*</label>
            <input id="email" type="text" name="email" placeholder="Введите e-mail" value="<?= $user_reg['email']?>" >
            <span class="form__error"><?= $errors['email']?></span>
        </div>
        <div class="form__item <?php if($errors['password']): ?>form__item--invalid<?php endif; ?>">
            <label for="password">Пароль*</label>
            <input id="password" type="password" name="password" placeholder="Введите пароль" value="<?= $user_reg['password']?>" >
            <span class="form__error"><?= $errors['password']?></span>
        </div>
        <div class="form__item <?php if($errors['name']): ?>form__item--invalid<?php endif; ?>">
            <label for="name">Имя*</label>
            <input id="name" type="text" name="name" placeholder="Введите имя" value="<?= $user_reg['name']?>" >
            <span class="form__error"><?= $errors['name']?></span>
        </div>
        <div class="form__item <?php if($errors['contacts']): ?>form__item--invalid<?php endif; ?>">
            <label for="message">Контактные данные*</label>
            <textarea id="message" name="contacts" placeholder="Напишите как с вами связаться" ><?= $user_reg['contacts']?></textarea>
            <span class="form__error"><?= $errors['contacts']?></span>
        </div>
        <div class="form__item form__item--file form__item--last <?php if($errors['avatar']): ?>form__item--invalid<?php endif; ?>">
            <label>Аватар</label>
            <div class="preview">
                <button class="preview__remove" type="button">x</button>
                <div class="preview__img">
                    <img src="img/avatar.jpg" width="113" height="113" alt="Ваш аватар">
                </div>
            </div>
            <div class="form__input-file">
                <input class="visually-hidden" type="file" id="photo2" value="<?= $file_data['avatar']?>" name="avatar">
                <label for="photo2">
                    <span>+ Добавить</span>
                </label>
            </div>
            <span class="form__error"><?= $errors['avatar']?></span>
        </div>
        <span class="form__error form__error--bottom">Пожалуйста, исправьте ошибки в форме.</span>
        <button type="submit" class="button">Зарегистрироваться</button>
        <a class="text-link" href="#">Уже есть аккаунт</a>
    </form>
</main>
