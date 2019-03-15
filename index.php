<?php
date_default_timezone_set("Europe/Moscow");
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
session_start();
require_once('functions/main.php');
require_once('functions/db.php');
require_once('functions/template.php');
require_once('functions/upload.php');

if (!file_exists('config.php')) {
    die('Создайте и сконфигурируйте файл config.php на основе config.sample.php');
}
$config = require 'config.php';

$connection = connectDb($config['db']);
if (!$connection) {
    $page_content = include_template('error.php', ['error' => mysqli_error($connection)]);
}

$user = null;
if (isset($_SESSION['user_id'])) {
    $user = get_user_by_id($connection, $_SESSION['user_id']);
}

$categories = get_categories($connection);

$total_lots = count_lots($connection);
$cur_page = $_GET['page'] ?? 1;
$cur_page = clean($cur_page);
$page_items = 9;

$pages_count = ceil($total_lots / $page_items);
$offset = ($cur_page - 1) * $page_items;
$pages = range(1, $pages_count);

$lots = get_lots($connection, $page_items, $offset);

if ($cur_page > $pages_count) {
    header("HTTP/1.0 404 Not Found");
    $page_content = include_template('404.php', ['categories' => $categories]);

    $layout = include_template('layout.php', [
        'content' => $page_content,
        'title' => 'Ошибка',
        'categories' => $categories
    ]);
    print($layout);
    exit;
}

$page_content = include_template('index.php', [
    'categories' => $categories,
    'lots' => $lots,
    'cur_page' => $cur_page,
    'page_items' => $page_items,
    'offset' => $offset,
    'pages' => $pages,
    'pages_count' => $pages_count

]);
$layout = include_template('layout.php', [
    'content' => $page_content,
    'title' => 'Главная страница аукциона',
    'user' => $user,
    'categories' => $categories
]);

print($layout);
