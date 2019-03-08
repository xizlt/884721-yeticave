<?php

date_default_timezone_set ("Europe/Moscow");
require_once ('functions/db.php');
require_once ('functions/registr.php');
require_once ('functions/template.php');
require_once ('functions/upload.php');

session_start();

$config = require 'config.php';
$connection = connectDb($config['db']);
if (!$connection) {
    $page_content = include_template('error.php', ['errors' => mysqli_error($connection)]);
}
$categories = getCategories($connection);


if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $login_data = $_POST;


    function validate_login($connection, $login_data){
        if ($error = validate_password($login_data['password'])) {
            $errors['password'] = $error;
        }
        if ($error = validate_email($login_data['email'], $connection)) {
            $errors['email'] = $error;
        }
    }

    function validate_password($password)
    {
        if (empty($password)) {
            return 'Заполните поле пароль';
        }
        if (mb_strlen($password) > 255){
            return 'Допустимая длина строки 255 символов';
        }
        return null;
    }

    function validate_email($email, $connection)
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

    $errors = validate_login($connection, $login_data);



/*
    $user = check_user($connection, $login_data);

    if (!count($errors) and $user) {
        if (password_verify($login_data['password'], $user['password'])) {
            $_SESSION['user'] = $user;
        } else {
            $errors['password'] = 'Неверный пароль';
        }
    } else {
        $errors['email'] = 'Такой пользователь не найден';
    }

    if (count($errors)) {
        $page_content = include_template('login.php', ['login_data' => $login_data, 'errors' => $errors]);
    } else {
        header("Location: /index.php");
        exit();
    }
}
*/
$page_content = include_template('login.php', [
    'categories' => $categories,
    'errors' => $errors,
    'login_data' => $login_data
]);

$layout = include_template('layout.php', [
    'content' => $page_content,
    'title' => 'Страница входа',
    'user_name' => $user_name,
    'categories' => $categories,
    'is_auth' => $is_auth
]);
print($layout);