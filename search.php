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

$categories = get_categories($connection);

$user = null;
if (isset($_SESSION['user_id'])) {
    $user = get_user_by_id($connection, $_SESSION['user_id']);
}

$search = $_GET['search'] ?? '';
$search = clean($search);
if (empty($search)){
    header("Location: /");
    exit();
}
$cur_page = $_GET['page'] ?? 1;
$cur_page = clean($cur_page);

$page_items = 9;
$total_lots = count_search($connection, $search);

$pages_count = ceil($total_lots / $page_items);
$offset = ($cur_page - 1) * $page_items;
$pages = range(1, $pages_count);

$lots = get_search($connection, $search, $page_items, $offset);

if (clean(isset($_GET['page']))) {
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
}
$page_content = include_template('search.php', [
    'lots' => $lots,
    'categories' => $categories,
    'search' => $search,
    'cur_page' => $cur_page,
    'page_items' => $page_items,
    'offset' => $offset,
    'pages' => $pages,
    'pages_count' => $pages_count

]);
$layout = include_template('layout.php', [
    'content' => $page_content,
    'title' => 'Страница поиска',
    'categories' => $categories,
    'user' => $user
]);

print($layout);