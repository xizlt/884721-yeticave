<?php

date_default_timezone_set("Europe/Moscow");
session_start();
require_once('functions/main.php');
require_once('functions/db.php');
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

$categories = get_categories($connection);

$user = null;
if (isset($_SESSION['user_id'])) {
    $user = get_user_by_id($connection, $_SESSION['user_id']);
} else{
    http_response_code(403);
    exit();
}

$file_data = [];
$lot_data = [];
$errors = [];
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $lot_data = $_POST;
    $file_data = $_FILES;

    $errors = validate_lot($lot_data, $file_data);

    if (empty($errors)) {
        $lot_data['img'] = upload_img($file_data['img']);
        $lot_id = add_lot($connection, $lot_data, $user);

        if ($lot_id) {
            header("Location: lot.php?id=" . $lot_id);
            exit();
        }
    }
}

$page_content = include_template('add_lot.php', [
    'categories' => $categories,
    'lot_data' => $lot_data,
    'errors' => $errors,
    'file_data' => $file_data,
    'user' => $user
]);

$layout = include_template('layout.php', [
    'content' => $page_content,
    'title' => 'Добавление лота',
    'categories' => $categories,
    'user' => $user

]);
print($layout);