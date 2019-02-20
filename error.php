<?php
date_default_timezone_set("Europe/Moscow");
require_once('functions.php');
require_once('error.php');
$is_auth = rand(0, 1);
$user_name = 'Иван'; // укажите здесь ваше имя


$config = require 'config.php';
$connection = connectDb($config['db']);


$layout = include_template('layout.php', [
    'content' => $page_content,
    'title' => 'Страница лота',
    'user_name' => $user_name,
    'categories' => $categories,
    'is_auth' => $is_auth
]);
print($layout);
