<?php
function validate_user($user_data, $file_data, $connection)
{
    $errors = [];
    if ($error = validate_user_name($user_data['name'])) {
        $errors['name'] = $error;
    }
    if ($error = validate_user_password($user_data['password'])) {
        $errors['password'] = $error;
    }
    if ($error = validate_user_email($user_data['email'], $connection)) {
        $errors['email'] = $error;
    }
    if ($error = validate_user_contacts($user_data['contacts'])) {
        $errors['contacts'] = $error;
    }
    if ($error = validate_file($file_data)) {
        $errors['avatar'] = $error;
    }
    return $errors;
}

function validate_user_name($name)
{
    if (empty($name)) {
        return 'Заполните поле Имя';
    }
    if (mb_strlen($name) > 255){
        return 'Допустимая длина строки 255 символов';
    }
    return null;
}

function validate_user_password($password)
{
    if (empty($password)) {
        return 'Заполните поле пароль';
    }
    if (mb_strlen($password) > 255){
        return 'Допустимая длина строки 255 символов';
    }
    return null;
}

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


function validate_user_contacts($contacts)
{
    if (empty($contacts)) {
        return 'Заполните поле контакты';
    }
    if (mb_strlen($contacts) > 1000){
        return 'Допустимая длина строки 1000 символов';
    }
    return null;
}


function validate_file($file_data)
{
    if (empty($file_data['avatar']['tmp_name'])){
        return null;
    }
    $finfo = finfo_open(FILEINFO_MIME_TYPE);
    $file_name = $file_data['avatar']['tmp_name'];
    $file_type = finfo_file($finfo, $file_name);
    if ($file_type !== 'image/gif' and $file_type !== 'image/jpg' and $file_type !== 'image/jpeg' and $file_type !== 'image/png') {
        return 'Файл нужно загрузить в формате .jpg, .jpeg, .png';
    }
    return null;
}