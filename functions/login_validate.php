<?php

/**
 * Возвращает массив ошибок при проверки логина и пароля
 * @param $connection
 * @param $login_data
 * @return array
 */
function validate_login($connection, $login_data, $user)
{
    $errors = [];
    if ($error = validate_email($login_data['email'])) {
        $errors['email'] = $error;
    }
    if (!isset($errors['email'])) {
        $user = get_user_by_email($connection, $login_data['email']);
        if (!$user) {
            $errors['email'] = 'Такой пользователь не найден в базе';
        }
    }
    if ($error = validate_password($login_data['password'], $user['password'])) {
        $errors['password'] = $error;
    }
    if (!$errors) {
        $_SESSION['user_id'] = $user['id'];
    }
    return $errors;
}

/**
 * Валидация пароля из формы
 * @param $password
 * @param $user
 * @return string|null
 */
function validate_password($password, $user)
{
    if (empty($password)) {
        return 'Заполните поле пароль';
    }
    if (mb_strlen($password) > 255) {
        return 'Допустимая длина строки 255 символов';
    }
    if (!password_verify($password, $user)) {
        return 'Неверный пароль';
    }
    return null;
}

/**
 * Валидация email из формы
 * @param $email
 * @return string|null
 */
function validate_email($email)
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
    return null;
}
