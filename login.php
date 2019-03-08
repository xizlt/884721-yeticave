<?php

date_default_timezone_set ("Europe/Moscow");
require_once ('functions/db.php');
require_once ('functions/template.php');
require_once ('functions/login_validate.php');

session_start();

$config = require 'config.php';
$connection = connectDb($config['db']);
if (!$connection) {
    $page_content = include_template('error.php', ['errors' => mysqli_error($connection)]);
}
$categories = getCategories($connection);

$login_data = [];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $login_data = $_POST;

    $user = check_user($connection, $login_data);
/*
    if (!count($errors) and $user) {
        if (password_verify($login_data['password'], $user['password'])) {
            $_SESSION['user'] = $user;
        } else {
            $errors['password'] = 'Неверный пароль';
        }
    } else {
        $errors['email'] = 'Такой пользователь не найден';
    }
*/
$errors = validate_login($connection, $login_data);
if (!$errors){
    $_SESSION['user'] = $user;
}
    if (count($errors)) {
        $page_content = include_template('login.php', ['login_data' => $login_data, 'errors' => $errors]);
    } else {
        header("Location: /index.php");
        exit();
    }
}

$page_content = include_template('login.php', [
    'categories' => $categories,
    'errors' => $errors,
    'login_data' => $login_data
]);

$layout = include_template('layout.php', [
    'content' => $page_content,
    'title' => 'Страница входа',
    'categories' => $categories
]);
print($layout);