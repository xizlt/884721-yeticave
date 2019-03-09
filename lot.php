<?php
date_default_timezone_set("Europe/Moscow");
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
session_start();
require_once ('functions/main.php');
require_once ('functions/db.php');
require_once ('functions/rate_validate.php');
require_once ('functions/lot_validate.php');
require_once ('functions/template.php');
require_once ('functions/upload.php');

$config = require 'config.php';

if (!get_value($_GET, 'id')) {
    die('<b>Отсутствует id лота в запросе или такого параметра нет</b>');
} else {
    $lot_id = get_value($_GET,'id');
}

$connection = connectDb($config['db']);

$user = null;
$categories = getCategories($connection);

if ($user_id = get_value($_SESSION, 'user_id')){
    $user = get_user_by_id($connection, $user_id);
}

$lot = getLot($connection, $lot_id);
$rate = rate_user($connection, $lot_id);
$show_rate = rate_show($lot, $user, $rate);

if (!$lot) {
    header("HTTP/1.0 404 Not Found");
    $page_content = include_template('error.php', [
        'error' => 'Такого лота нет'
    ]);
}

$errors = [];
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $amount = $_POST['amount'];
    //$lot = getLot($connection, $lot_id);
    $errors = error_amount($amount, $lot);

    if (!$errors) {
        add_rate($connection, $amount, $user, $lot_id);
        header("Location: lot.php?id=$lot_id");
        exit();
    }
}


$page_content = include_template('lot.php', [
    'categories' => $categories,
    'lot' => $lot,
    'user' => $user,
    'errors' => $errors,
    'show_rate' => $show_rate,
    'rate' => $rate
]);

$layout = include_template('layout.php', [
    'content' => $page_content,
    'title' => 'Страница лота',
    'categories' => $categories,
    'user' => $user
]);
print($layout);