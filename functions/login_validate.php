<?php

function validate_login($login_data,$connection)
{
    $errors = [];
    $user = check_user($login_data, $connection);
    if ($error = validate_password($login_data['password'], $user['password'])) {
        $errors['password'] = $error;
    }
    if ($error = validate_email($login_data['email'], $user['email'])) {
        $errors['email'] = $error;
    }
    return $errors;
}

function validate_password($password,$user)
{
    if (empty($password)) {
        return 'Заполните поле пароль';
    }
    if (mb_strlen($password) > 255){
        return 'Допустимая длина строки 255 символов';
    }
    if (!password_verify($password, $user)) {
        return 'Неверный пароль';
    }
    return null;
}

function validate_email($email,$user)
{
    if (empty($email)) {
        return 'Заполните поле email';
    }
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        return 'Проверьте правильность написания email';
    }
    if (mb_strlen($email) > 320) {
        return 'Допустимая длина email 320 символов';
    }
    if (!$user){
        return 'Такой пользователь не найден';
    }
    return null;
}
