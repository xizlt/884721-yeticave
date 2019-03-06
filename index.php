<?php
date_default_timezone_set("Europe/Moscow");
session_start();
require_once ('functions/db.php');
require_once ('functions/template.php');
require_once ('functions/upload.php');

$config = require 'config.php';
$connection = connectDb($config['db']);

$categories = getCategories($connection);
$lots = getLots($connection);

$page_content = include_template('index.php', [
    'categories' => $categories,
    'lots' => $lots
]);
$layout = include_template('layout.php', [
    'content' => $page_content,
    'title' => 'Главная страница аукциона',
    'user_name' => $user_name,
    'categories' => $categories,
    'is_auth' => $is_auth
]);

print($layout);
