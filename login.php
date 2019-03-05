<?php
date_default_timezone_set ("Europe/Moscow");
require_once ('functions/db.php');
require_once ('functions/registr.php');
require_once ('functions/template.php');
require_once ('functions/upload.php');
$is_auth = rand(0, 1);
$user_name = 'Иван'; // укажите здесь ваше имя
$config = require 'config.php';
$connection = connectDb($config['db']);
if (!$connection) {
    $page_content = include_template('error.php', ['errors' => mysqli_error($connection)]);
}
$categories = getCategories($connection);
$page_content = include_template('login.php', [
    'categories' => $categories,
    'errors' => $errors
]);
$layout = include_template('layout.php', [
    'content' => $page_content,
    'title' => 'Страница входа',
    'user_name' => $user_name,
    'categories' => $categories,
    'is_auth' => $is_auth
]);
print($layout);