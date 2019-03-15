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
if ($user_id = get_value($_SESSION, 'user_id')) {
    $user = get_user_by_id($connection, $user_id);
}

$categories = get_categories($connection);

$total_lots = count_lots($connection);
$cur_page = $_GET['page'] ?? 1;
$cur_page = clean($cur_page);
$page_items = 9;

$pages_count = ceil($total_lots / $page_items);
$offset = ($cur_page - 1) * $page_items;
$pages = range(1, $pages_count);

function get_my_lots($connection, $user_id){
    $sql = "SELECT l.end_time as end_time_lot, r.create_time as time_add_rite, r.amount, l.name as name_lot, c.name as category_name, l.id as id_lot, img 
            FROM rate r
            join lots l ON r.lot_id = l.id
            JOIN categories c ON c.id = l.category_id
            JOIN users u ON u.id = l.user_id
            WHERE r.user_id = $user_id  
            ORDER BY l.end_time DESC 
            ";
    $query = mysqli_query($connection, $sql);
    return  $result = mysqli_fetch_all($query, MYSQLI_ASSOC);
}

$lots = get_my_lots($connection, $user_id);

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

$page_content = include_template('my-lots.php', [
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
    'title' => 'Мои ставки',
    'user' => $user,
    'categories' => $categories
]);

print($layout);