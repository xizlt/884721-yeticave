<?php

date_default_timezone_set ("Europe/Moscow");
require_once ('functions.php');

$is_auth = rand(0, 1);
$user_name = 'Иван'; // укажите здесь ваше имя

$config = require 'config.php';
$connection = connectDb($config['db']);

$categories = getCategories($connection);


if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $lots = $_POST['lot-img'];
    $filename = uniqid() . '.jpg';
    $lot['img'] = $filename;
    move_uploaded_file($_FILES['lot-img']['tmp_name'], 'img/' . $filename);
}
/*
$name = name;
$category = category;
$message = message;
$img = img;
$lot-rate = lot-rate;
$lot-step = lot-step;
$lot-date = lot-date;
*/
/*

if (isset($_FILES['lot-img'])) {
$file_name = $_FILES['lot-img']['name'];
$file_path =_DIR_. '/img/';
$file_url = '/img/' . $file_name;
$file_url = '/img/' . $file_name;
 move_uploaded_file($_FILES['lot-img']['tmp_name'], $file_path . $file_name);
print("<a href='$file_url'>$file_name
<a>");
}
*/


$sql = 'INSERT INTO lots (name, category_id, description, img, start_price, step, end_time, user_id,) VALUE (?,?,?,?,?,?,?,1)';

$stmt = db_get_prepare_stmt($connection, $sql, [$lot['lot-name'],$lot['category'],$lot['message'],$lot['img'],$lot['lot-rate'],$lot['lot-step'],$lot['lot-date']]);

$res = mysqli_stmt_execute($stmt);

/*
if ($res) {
    $lot_id_add = mysqli_insert_id($connection);
    header("Location: lot.php?id=" . $lot_id_add);
} else {
    $page_content = include_template('error.php', ['error' => mysqli_error($connection)]);
}

*/

$page_content = include_template('add_lot.php', [
    'categories' => $categories
]);
$layout = include_template('layout.php', [
    'content' => $page_content,
    'title' => 'Добавление лота',
    'user_name' => $user_name,
    'categories' => $categories,
    'is_auth' => $is_auth
]);
print($layout);