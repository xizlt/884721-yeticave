<?php

/**
 * Возвращает массив всех ошибок валидации лота
 * @param array $lot_data
 * @return array
 */
function validate_lot($lot_data){
    $errors = [];
    if ($error = validate_lot_name($lot_data['name'])){
        $errors[] = $error;
    }
    if ($error = validate_lot_start_price($lot_data['start_price'])){
        $errors[] = $error;
    }
    if ($error = validate_lot_description($lot_data['description'])){
        $errors[] = $error;
    }
    if ($error = validate_lot_step($lot_data['step'])){
        $errors[] = $error;
    }
    if ($error = validate_lot_end_time($lot_data['end_time'])){
        $errors[] = $error;
    }
    if ($error = validate_lot_category($lot_data['category'])){
        $errors[] = $error;
    }
    return $errors;
}


/**
 * Возвращает текст ошибок для поля "Наименование лота"
 * @param string $name "Наименование лота"
 * @return string|null
 */
function validate_lot_name($name){
    if(empty($name)){
        return 'Укажите имя лота';
    }
    if (mb_strlen($name)> 255){
        return 'Максимальная длина строки должна быть не более 255 символов';
    }
    return null;
}

/**
 * Возвращает текст ошибок для поля "Описание лота"
 * @param string $description "Описание лота"
 * @return string|null
 */
function validate_lot_description($description){
    if(empty($description)){
        return 'Напишите описание лота';
    }
    if (mb_strlen($description)> 1000){
        return 'Максимальная длина строки должна быть не более 1 000 символов';
    }
    if (mb_strlen($description) < 3){
        return 'Описание не может быть меньше 3 символов';
    }
    return null;
}

/**
 * Возвращает текст ошибок для поля "Шаг ставки"
 * @param  integer $step "Шаг ставки"
 * @return string|null
 */
function validate_lot_step($step){
    if(empty($step)){
        return 'Укажите шаг ставки';
    }
    if(!is_numeric($step)){
        return 'Шаг ставки должен быть числом';
    }
    if ($step < 0){
        return 'Шаг ставки не должен быть меньше 0';
    }
    if ($step > 4294967295){
        return 'Шаг ставки не должна быть больше 4 294 967 295';
    }
    return null;
}

/**
 * Возвращает текст ошибок для поля "Начальная цена"
 * @param integer $start_price "Начальная цена"
 * @return string|null
 */
function validate_lot_start_price($start_price){
    if(empty($start_price)){
        return 'Укажите стартовую цену лота';
    }
    if(!is_numeric($start_price)){
        return 'Цена должна быть числом';
    }
    if ($start_price < 0){
        return 'Цена не должна быть меньше 0';
    }
    if ($start_price > 4294967295){
        return 'Цена не должна быть больше 4 294 967 295';
    }
    return null;
}

/**
 * Возвращает текст ошибок для поля "Дата окончания торгов" и проверяет, что переданная дата соответствует формату ДД.ММ.ГГГГ
 * @param string $end_time 'Дата окончания торгов'
 * @return string|null
 */
function validate_lot_end_time($end_time){

    $result = false;
    $regexp = '/(\d{2})\.(\d{2})\.(\d{4})/m';
    if (preg_match($regexp, $end_time, $parts) && count($parts) == 4) {
        $result = checkdate($parts[2], $parts[1], $parts[3]);
    }
    if ($result) {
        return 'Укажите дату';
    }
    if ($end_time < date('d.m.Y', time())) {
        return 'дата должна быть больше текущей';
    }
    return null;
}

/**
 * Возвращает текст ошибок для поля "Выберите категорию"
 * @param integer $category "Выберите категорию"
 * @return string
 */
function validate_lot_category($category){
    if ($category == 'Выберите категорию') {
        return 'Выберите категорию';
    }
    return null;
}