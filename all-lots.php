<?php
date_default_timezone_set("Europe/Moscow");
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
session_start();
require_once('functions/main.php');
require_once('functions/db.php');
require_once('functions/rate_validate.php');
require_once('functions/lot_validate.php');
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
$categories = get_categories($connection);
$categories_page = trim($_GET['category']) ?? '';

function get_search($connection, $categories_page)
{
    $sql = "SELECT l.id AS id_lot, l.name AS lot_name, c.name AS category, l.end_time AS time, img, start_price
        FROM lots l
        JOIN users u ON l.user_id = u.id
        JOIN categories c ON l.category_id = c.id
        WHERE MATCH(c.name) AGAINST ('$categories_page')
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
$lots = get_search($connection, $categories_page);

$page_content = include_template('all-lots.php', [
    'categories' => $categories,
    'lots' => $lots,
    //'user' => $user,
    //'errors' => $errors,
    //'show_rate' => $show_rate,
    //'rates' => $rates,
    'categories_page' => $categories_page
]);

$layout = include_template('layout.php', [
    'content' => $page_content,
    'title' => 'Страница лота',
    'categories' => $categories,
    'user' => $user
]);
print($layout);