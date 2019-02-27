<?php

date_default_timezone_set ("Europe/Moscow");
require_once ('functions/db.php');
require_once ('functions/lot_validate.php');
require_once ('functions/template.php');
require_once ('functions/upload.php');


$is_auth = rand(0, 1);
$user_name = 'Иван'; // укажите здесь ваше имя

$config = require 'config.php';
$connection = connectDb($config['db']);
$categories = getCategories($connection);

$lot_data = [];
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $lot_data = $_POST;
    $fail_data = $_FILES;

    $errors = validate_lot($lot_data);

    if (!empty($errors)) {
        $page_content = include_template('add_lot.php', ['errors' => $error, 'categories' => $categories, 'lot_data' => $lot_data]);
    }else {
        $lot_data['img'] = upload_img($fail_data);

        $res = add_lot($connection, $lot_data);
        if ($res) {
            $lot_id = mysqli_insert_id($connection);
            header("Location: lot.php?id=" . $lot_id);
        } else {
            $content = include_template('error.php', ['errors' => mysqli_error($connection)]);
        }
    }

}

$page_content = include_template('add_lot.php', [
    'categories' => $categories,
    '$lot_data' => $lot_data,
    'errors' => $errors
]);

$layout = include_template('layout.php', [
    'content' => $page_content,
    'title' => 'Добавление лота',
    'user_name' => $user_name,
    'categories' => $categories,
    'is_auth' => $is_auth
]);
print($layout);