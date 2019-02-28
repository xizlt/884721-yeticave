 <main>
    <nav class="nav">
      <ul class="nav__list container">
        <li class="nav__item">
          <a href="all-lots.html">Доски и лыжи</a>
        </li>
        <li class="nav__item">
          <a href="all-lots.html">Крепления</a>
        </li>
        <li class="nav__item">
          <a href="all-lots.html">Ботинки</a>
        </li>
        <li class="nav__item">
          <a href="all-lots.html">Одежда</a>
        </li>
        <li class="nav__item">
          <a href="all-lots.html">Инструменты</a>
        </li>
        <li class="nav__item">
          <a href="all-lots.html">Разное</a>
        </li>
      </ul>
    </nav>
    <form class="form container" action="registration.php" method="post"> <!-- form--invalid -->
      <h2>Регистрация нового аккаунта</h2>
      <div class="form__item"> <!-- form__item--invalid -->
        <label for="email">E-mail*</label>
        <input id="email" type="text" name="email" placeholder="Введите e-mail" required>
        <span class="form__error">Введите e-mail</span>
      </div>
      <div class="form__item">
        <label for="password">Пароль*</label>
        <input id="password" type="text" name="pas sword" placeholder="Введите пароль" required>
        <span class="form__error">Введите пароль</span>
      </div>
      <div class="form__item">
        <label for="name">Имя*</label>
        <input id="name" type="text" name="name" placeholder="Введите имя" required>
        <span class="form__error">Введите имя</span>
      </div>
      <div class="form__item">
        <label for="message">Контактные данные*</label>
        <textarea id="message" name="message" placeholder="Напишите как с вами связаться" required></textarea>
        <span class="form__error">Напишите как с вами связаться</span>
      </div>
      <div class="form__item form__item--file form__item--last">
        <label>Аватар</label>
        <div class="preview">
          <button class="preview__remove" type="button">x</button>
          <div class="preview__img">
            <img src="img/avatar.jpg" width="113" height="113" alt="Ваш аватар">
          </div>
        </div>
        <div class="form__input-file">
          <input class="visually-hidden" type="file" id="photo2" value="" name="avatar">
          <label for="photo2">
            <span>+ Добавить</span>
          </label>
        </div>
      </div>
      <span class="form__error form__error--bottom">Пожалуйста, исправьте ошибки в форме.</span>
      <button type="submit" class="button">Зарегистрироваться</button>
      <a class="text-link" href="#">Уже есть аккаунт</a>
    </form>
  </main>