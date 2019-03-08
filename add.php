<?php

date_default_timezone_set ("Europe/Moscow");
session_start();
require_once ('functions/db.php');
require_once ('functions/lot_validate.php');
require_once ('functions/template.php');
require_once ('functions/upload.php');

$config = require 'config.php';
$connection = connectDb($config['db']);
if (!$connection) {
    $page_content = include_template('error.php', ['errors' => mysqli_error($connection)]);
}
$user = null;
$categories = getCategories($connection);
$file_data = [];
$lot_data = [];

if (isset($_SESSION['user_id'])) {
    $user = get_user_by_id($connection, $_SESSION['user_id']);
    if (!$user) {
        http_response_code(403);
        exit();
    }
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $lot_data = $_POST;
    $file_data = $_FILES;

    $errors = validate_lot($lot_data,$file_data);

    if (!$errors) {
        $lot_data['img'] = upload_img($file_data);
        $lot_id = add_lot($connection, $lot_data);

        if ($lot_id) {
            header("Location: lot.php?id=" . $lot_id);
            exit();
        }
    }
}

$page_content = include_template('add_lot.php', array(
    'categories' => $categories,
    'lot_data' => $lot_data,
    'errors' => $errors,
    'file_data' => $file_data
));

$layout = include_template('layout.php', [
    'content' => $page_content,
    'title' => 'Добавление лота',
    'user' => $user,
    'categories' => $categories

]);
print($layout);