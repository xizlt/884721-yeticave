<main>

<?= require_once('categories.php'); ?>

    <form class="form form--add-lot container <?php if ($errors): ?>form--invalid<?php endif; ?>" action="/add.php" method="post" enctype="multipart/form-data"> <!-- form--invalid -->
        <h2>Добавление лота</h2>
        <div class="form__container-two">
            <div class="form__item <?php if ($errors['name']): ?>form__item--invalid<?php endif; ?>">
                <!-- form__item--invalid -->
                <label for="lot-name">Наименование</label>
                <input id="lot-name" type="text" name="name" placeholder="Введите наименование лота" value="<?= clean(get_value($lot_data, 'name')); ?>">
                <span class="form__error"><?= $errors['name']; ?></span>
            </div>
            <div class="form__item <?php if ($errors['category_id']): ?>form__item--invalid<?php endif; ?>">
                <label for="category">Категория</label>
                <select id="category" name="category_id">
                    <option value="">Выберите категорию</option>
                    <?php foreach ($categories as $category): ?>
                        <option value="<?= $category['id']; ?>" <?= get_value($lot_data, 'category_id') == get_value($category, 'id')? 'selected': '' ?>> <?= $category['name']; ?></option>
                    <?php endforeach; ?>
                </select>
                <span class="form__error"><?= $errors['category_id']; ?></span>
            </div>
        </div>
        <div class="form__item form__item--wide <?php if ($errors['description']): ?>form__item--invalid <?php endif; ?>">
            <label for="message">Описание</label>
            <textarea id="message" name="description" placeholder="Напишите описание лота"><?= clean(get_value($lot_data, 'description')); ?></textarea>
            <span class="form__error"><?= $errors['description']; ?></span>
        </div>
        <div class="form__item form__item--file <?php if ($errors['img']): ?>form__item--invalid<?php endif; ?>">
            <!-- form__item--uploaded -->
            <label>Изображение</label>
            <div class="preview">
                <button class="preview__remove" type="button">x</button>
                <div class="preview__img">
                    <img src="" width="113" height="113" alt="Изображение лота">

                </div>
            </div>
            <div class="form__input-file">
                <input class="visually-hidden" type="file" id="photo2" name="img" value="<?= get_value($lot_data, 'img') ?>">
                <label for="photo2">
                    <span>+ Добавить</span>
                </label>

            </div>
            <span class="form__error"><?= $errors['img']; ?></span>
        </div>


        <div class="form__container-three">
            <div class="form__item form__item--small <?php if ($errors['start_price']): ?>form__item--invalid<?php endif; ?>">
                <label for="lot-rate">Начальная цена</label>
                <input id="lot-rate" type="number" name="start_price" placeholder="0" value="<?= clean(get_value($lot_data, 'start_price')); ?>">
                <span class="form__error"><?= $errors['start_price']; ?></span>
            </div>
            <div class="form__item form__item--small <?php if ($errors['step']): ?>form__item--invalid<?php endif; ?>">
                <label for="lot-step">Шаг ставки</label>
                <input id="lot-step" type="number" name="step" placeholder="0" value="<?= clean(get_value($lot_data, 'step')); ?>">
                <span class="form__error"><?= $errors['step']; ?></span>
            </div>
            <div class="form__item <?php if ($errors['end_time']): ?>form__item--invalid<?php endif; ?>">
                <label for="lot-date">Дата окончания торгов</label>
                <input class="form__input-date" id="lot-date" type="date" name="end_time" value="<?= clean(get_value($lot_data, 'end_time')); ?>">
                <span class="form__error"><?= $errors['end_time']; ?></span>
            </div>
        </div>
        <span class="form__error form__error--bottom">Пожалуйста, исправьте ошибки в форме.</span>
        <button type="submit" class="button">Добавить лот</button>
    </form>
</main>
