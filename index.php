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

$config = require 'config.php';
$connection = connectDb($config['db']);
if (!$connection) {
    $page_content = include_template('error.php', ['error' => mysqli_error($connection)]);
}

$user = null;
$categories = getCategories($connection);
$lots = getLots($connection);

if (isset($_SESSION['user_id'])) {
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
