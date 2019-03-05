<?php

date_default_timezone_set ("Europe/Moscow");
require_once ('functions/db.php');
require_once ('functions/registr.php');
require_once ('functions/template.php');
require_once ('functions/upload.php');

session_start();

$is_auth = rand(0, 1);
$user_name = 'Иван'; // укажите здесь ваше имя

$config = require 'config.php';
$connection = connectDb($config['db']);
if (!$connection) {
    $page_content = include_template('error.php', ['errors' => mysqli_error($connection)]);
}
$categories = getCategories($connection);


if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $form = $_POST;

    $user = check_user($connection, $form);

    if (!count($errors) and $user) {
        if (password_verify($form['password'], $user['password'])) {
            $_SESSION['user'] = $user;
        } else {
            $errors['password'] = 'Неверный пароль';
        }
    } else {
        $errors['email'] = 'Такой пользователь не найден';
    }

    if (count($errors)) {
        $page_content = include_template('login.php', ['form' => $form, 'errors' => $errors]);
    } else {
        header("Location: /index.php");
        exit();
    }
}

$page_content = include_template('login.php', [
    'categories' => $categories,
    'errors' => $errors,
    'form' => $form
]);

$layout = include_template('layout.php', [
    'content' => $page_content,
    'title' => 'Страница входа',
    'user_name' => $user_name,
    'categories' => $categories,
    'is_auth' => $is_auth
]);
print($layout);