<?php
date_default_timezone_set("Europe/Moscow");
session_start();
require_once ('functions/db.php');
require_once ('functions/template.php');
require_once ('functions/upload.php');

$config = require 'config.php';
$connection = connectDb($config['db']);

$user = null;
$categories = getCategories($connection);
$lots = getLots($connection);

if (isset($_SESSION['user_id'])){
    $user = get_user_by_id($connection, $_SESSION['user_id']);
}
$page_content = include_template('index.php', [
    'categories' => $categories,
    'lots' => $lots
]);
$layout = include_template('layout.php', [
    'content' => $page_content,
    'title' => 'Главная страница аукциона',
    'user' => $user,
    'categories' => $categories
]);

print($layout);
