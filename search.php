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

$search = trim($_GET['search']) ?? '';
$cur_page = $_GET['page'] ?? 1;
$page_items = 9;

$result = mysqli_query($connection, "SELECT COUNT(*) as cnt FROM lots");
$items_count = mysqli_fetch_assoc($result)['cnt'];

$pages_count = ceil($items_count / $page_items);
$offset = ($cur_page - 1) * $page_items;
$pages = range(1, $pages_count);

var_dump($pages_count);
function get_search($connection, $search, $page_items, $offset)
{
    $sql = "SELECT l.id AS id_lot, l.name AS lot_name, c.name AS category, l.end_time AS time, img, start_price
        FROM lots l
        JOIN users u ON l.user_id = u.id
        JOIN categories c ON l.category_id = c.id
        WHERE MATCH(l.name, description) AGAINST ('$search')
        ORDER BY l.create_time DESC;
        ";

    if ($query = mysqli_query($connection, $sql)) {
        $result = mysqli_fetch_all($query, MYSQLI_ASSOC);
    } else {
        $error = mysqli_error($connection);
        $result = print('Ошибка MySQL ' . $error);
    }
    return $result;
}
$lots = get_search($connection, $search, $page_items, $offset);
$rates = '6 cnfdjr';

$page_content = include_template('search.php', [
    'lots' => $lots,
    'categories' => $categories,
    'search' => $search,
    'rates' => $rates,
    'pages' => $pages,
    'pages_count' => $pages_count,
    'cur_page' => $cur_page

]);
$layout = include_template('layout.php', [
    'content' => $page_content,
    'title' => 'Главная страница аукциона',
    'categories' => $categories,
    'user' => $user
]);

print($layout);