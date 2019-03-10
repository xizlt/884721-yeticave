<?php

/**
 * Возвращает массив ошибок при валидации формы регистрации юзера
 * @param $user_data
 * @param $file_data
 * @param $connection
 * @return array
 */
function validate_user($user_data, $file_data, $connection)
{
    $errors = [];
    if ($error = validate_user_name(get_value($user_data, 'name'))) {
        $errors['name'] = $error;
    }
    if ($error = validate_user_password(get_value($user_data, 'password'))) {
        $errors['password'] = $error;
    }
    if ($error = validate_user_email(get_value($user_data, 'email'), $connection)) {
        $errors['email'] = $error;
    }
    if ($error = validate_user_contacts(get_value($user_data, 'contacts'))) {
        $errors['contacts'] = $error;
    }
    if ($error = validate_avatar_file(get_value($file_data, 'avatar'))) {
        $errors['avatar'] = $error;
    }
    return $errors;
}

/**
 * Проверяет поле Имя для формы регистрации
 * @param $name
 * @return string|null
 */
function validate_user_name($name)
{
    if (empty($name)) {
        return 'Заполните поле Имя';
    }
    if (mb_strlen($name) > 255) {
        return 'Допустимая длина строки 255 символов';
    }
    return null;
}

/**
 * Проверяет поле Пароль для формы регистрации
 * @param $password
 * @return string|null
 */
function validate_user_password($password)
{
    if (empty($password)) {
        return 'Заполните поле пароль';
    }
    if (mb_strlen($password) > 255) {
        return 'Допустимая длина строки 255 символов';
    }
    return null;
}

/**
 * Проверяет поле email для формы регистрации
 * @param $email
 * @param $connection
 * @return string|null
 */
function validate_user_email($email, $connection)
{
    if (empty($email)) {
        return 'Заполните поле email';
    }
    if (isset_email($connection, $email)) {
        return 'Данный email уже есть в базе';
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        return 'Проверьте правильность написания email';
    }
    if (mb_strlen($email) > 320) {
        return 'Допустимая длина email 320 символов';
    }
    return null;
}

/**
 * Проверяет поле контакты для формы регистрации
 * @param $contacts
 * @return string|null
 */
function validate_user_contacts($contacts)
{
    if (empty($contacts)) {
        return 'Заполните поле контакты';
    }
    if (mb_strlen($contacts) > 1000) {
        return 'Допустимая длина строки 1000 символов';
    }
    return null;
}

/**
 * Проверяет поле аватар для формы регистрации
 * @param $file_data
 * @return string|null
 */
function validate_avatar_file($file_data)
{
    if (!$tmp_name = get_value($file_data, 'tmp_name')) {
        return null;
    }
    $finfo = finfo_open(FILEINFO_MIME_TYPE);
    $file_type = finfo_file($finfo, $tmp_name);
    if ($file_type !== 'image/gif' and $file_type !== 'image/jpg' and $file_type !== 'image/jpeg' and $file_type !== 'image/png') {
        return 'Файл нужно загрузить в формате .jpg, .jpeg, .png';
    }
    return null;
}