<?php
date_default_timezone_set ("Europe/Moscow");
require_once ('functions.php');

$is_auth = rand(0, 1);
$user_name = 'Иван'; // укажите здесь ваше имя

$config = require 'config.php';
$connection = connectDb($config['db']);

$categories = getCategories($connection);



$page_content = include_template('add_lot.php', [
    'categories' => $categories,
    'lots' => $lots
]);
$layout = include_template('layout.php', [
    'content' => $page_content,
    'title' => 'Добавление лота',
    'user_name' => $user_name,
    'categories' => $categories,
    'is_auth' => $is_auth
]);
print($layout);