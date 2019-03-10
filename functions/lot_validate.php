<?php

/**
 * Возвращает массив всех ошибок валидации лота
 * @param array $lot_data
 * @param $file_data
 * @return array
 * @throws Exception
 */
function validate_lot($lot_data, $file_data)
{
    $errors = [];
    if ($error = validate_lot_name($lot_data['name'])) {
        $errors['name'] = $error;
    }
    if ($error = validate_lot_start_price($lot_data['start_price'])) {
        $errors['start_price'] = $error;
    }
    if ($error = validate_lot_description($lot_data['description'])) {
        $errors['description'] = $error;
    }
    if ($error = validate_lot_step($lot_data['step'])) {
        $errors['step'] = $error;
    }
    if ($error = validate_lot_end_time($lot_data['end_time'])) {
        $errors['end_time'] = $error;
    }
    if ($error = validate_lot_category_id($lot_data['category_id'])) {
        $errors['category_id'] = $error;
    }
    if ($error = validate_lot_img_file(get_value($file_data, 'img'))) {
        $errors['img'] = $error;
    }
    return $errors;
}


/**
 * Возвращает текст ошибок для поля "Наименование лота"
 * @param string $name "Наименование лота"
 * @return string|null
 */
function validate_lot_name($name)
{
    if (empty($name)) {
        return 'Укажите имя лота';
    }
    if (mb_strlen($name) > 255) {
        return 'Максимальная длина строки должна быть не более 255 символов';
    }
    return null;
}

/**
 * Возвращает текст ошибок для поля "Описание лота"
 * @param string $description "Описание лота"
 * @return string|null
 */
function validate_lot_description($description)
{
    if (empty($description)) {
        return 'Напишите описание лота';
    }
    if (mb_strlen($description) > 1000) {
        return 'Максимальная длина строки должна быть не более 1 000 символов';
    }
    if (mb_strlen($description) < 3) {
        return 'Описание не может быть меньше 3 символов';
    }
    return null;
}

/**
 * Возвращает текст ошибок для поля "Шаг ставки"
 * @param  integer $step "Шаг ставки"
 * @return string|null
 */
function validate_lot_step($step)
{
    if (empty($step)) {
        return 'Укажите шаг ставки';
    }
    if (!is_numeric($step)) {
        return 'Шаг ставки должен быть числом';
    }
    if ($step < 0) {
        return 'Шаг ставки не должен быть меньше 0';
    }
    if ($step > 4294967295) {
        return 'Шаг ставки не должна быть больше 4 294 967 295';
    }
    return null;
}

/**
 * Возвращает текст ошибок для поля "Начальная цена"
 * @param integer $start_price "Начальная цена"
 * @return string|null
 */
function validate_lot_start_price($start_price)
{
    if (empty($start_price)) {
        return 'Укажите стартовую цену лота';
    }
    if (!is_numeric($start_price)) {
        return 'Цена должна быть числом';
    }
    if ($start_price < 0) {
        return 'Цена не должна быть меньше 0';
    }
    if ($start_price > 4294967295) {
        return 'Цена не должна быть больше 4 294 967 295';
    }
    return null;
}

/**
 * Возвращает текст ошибок для поля "Дата окончания торгов" и проверяет, что переданная дата соответствует формату ДД.ММ.ГГГГ
 * @param string $end_time 'Дата окончания торгов'
 * @return string|null
 * @throws Exception
 */
function validate_lot_end_time($end_time)
{
    if (empty($end_time)) {
        return 'Укажите дату';
    }
    $date = new DateTime($end_time);
    $now = new DateTime();

    if ($date < $now) {
        return 'дата должна быть больше текущей';
    }

    $result = false;
    $regexp = '/(\d{2})\.(\d{2})\.(\d{4})/m';
    if (preg_match($regexp, $end_time, $parts) && count($parts) == 4) {
        $result = checkdate($parts[2], $parts[1], $parts[3]);
        return 'Формат даты должен быть ДД.ММ.ГГГГ';
    }
    return null;
}

/**
 * Возвращает текст ошибок для поля "Выберите категорию"
 * @param $category_id
 * @return string
 */
function validate_lot_category_id($category_id)
{
    if (empty($category_id)) {
        return 'Выберите категорию';
    }
    return null;
}

/**
 * Проверяет соответствие формату загружаемой картинки
 * @param $file_data
 * @return string|null
 */
function validate_lot_img_file($file_data)
{
    if ($tmp_name = get_value($file_data, 'tmp_name')) {
        $finfo = finfo_open(FILEINFO_MIME_TYPE);
        $file_type = finfo_file($finfo, $tmp_name);
        if ($file_type !== 'image/jpg' and $file_type !== 'image/jpeg' and $file_type !== 'image/png') {
            return 'Файл нужно загрузить в формате .jpg, .jpeg, .png';
        }
        return null;
    }
    return 'Необходимо загрузить файл';
}

