<?php

date_default_timezone_set("Europe/Moscow");
require_once('functions.php');

$is_auth = rand(0, 1);
$user_name = 'Иван'; // укажите здесь ваше имя

$config = require 'config.php';
$connection = connectDb($config['db']);
$categories = getCategories($connection);


if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $lot = $_POST['lot'];
    $lot_data = $_POST['lot'];
    $fail_data = $_FILES;

    $errors = validate_lot($lot_data);
    if (empty($errors)){

        $lot['img'] = upload_img($fail_data);

        $sql = 'INSERT INTO lots (category_id, name, description, img, start_price, end_time, step, user_id) VALUES (?, ?, ?, ?, ?, ?, ?, 1)';
        $stmt = mysqli_prepare($connection, $sql);
        mysqli_stmt_bind_param($stmt, 'isssisi', $lot['category'], $lot['name'], $lot['message'], $lot['img'], $lot['rate'], $lot['date'], $lot['step']);
        $res = mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);

        if ($res) {
            $lot_id = mysqli_insert_id($connection);

            header("Location: lot.php?id=" . $lot_id);
        } else {
            $page_content = include_template('add_lot.php', ['errors' => $errors, 'categories' => $categories]);
        }
    }
}
$page_content = include_template('add_lot.php', [
    'categories' => $categories,
    'lot' => $lot
]);

$layout = include_template('layout.php', [
    'content' => $page_content,
    'title' => 'Добавление лота',
    'user_name' => $user_name,
    'categories' => $categories,
    'is_auth' => $is_auth
]);
print($layout);
