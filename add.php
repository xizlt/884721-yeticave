<?php

date_default_timezone_set ("Europe/Moscow");
require_once ('functions.php');

$is_auth = rand(0, 1);
$user_name = 'Иван'; // укажите здесь ваше имя

$config = require 'config.php';
$connection = connectDb($config['db']);
$categories = getCategories($connection);

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $lot = $_POST['lot'];

        $filename = uniqid() . '.jpg';
        $lot['img'] = 'img/' . $filename;
        move_uploaded_file($_FILES['lot_img']['tmp_name'], $lot['img']);

        $sql = 'INSERT INTO lots (category_id, name, description, img, start_price, end_time, step, user_id) VALUES (?, ?, ?, ?, ?, ?, ?, 1)';

        $stmt = mysqli_prepare($connection, $sql);
        mysqli_stmt_bind_param($stmt, 'isssisi', $lot['category'], $lot['name'], $lot['message'], $lot['img'], $lot['rate'], $lot['date'], $lot['step']);

        $res = mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);

//$res = add_lot($connection);
        if ($res) {
            $lot_id = mysqli_insert_id($connection);

            header("Location: lot.php?id=" . $lot_id);
        } else {
            $content = include_template('error.php', ['error' => mysqli_error($connection)]);
        }
    }


/*
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $lot = $_POST['lot'];
////////////////////////////////////////////////////
    $required = ['category', 'name', 'message', 'lot_img', 'rate', 'date', 'step'];
    $dict = ['category' => 'Категория', 'name' => 'Название', 'message' => 'Описание лота','lot_img' => 'Изображение','rate' => 'начальную цену','date' => 'дату завершения торгов','step' => 'шаг ставки'];
    $errors = [];
    foreach ($required as $key) {
        if (!isset($_POST[$key])) {
            $errors[$key] = 'Это поле надо заполнить';
        }

    }
    if (isset($_FILES['lot_img']['name'])) {
        $tmp_name = $_FILES['lot_img']['tmp_name'];
        //$path = ($_FILES['lot_img']['name']);

        $finfo = finfo_open(FILEINFO_MIME_TYPE);
        $file_type = finfo_file($finfo, $tmp_name);

        if ($file_type !== "image/jpg" || $file_type !== "image/jpeg" || $file_type !== "image/png") {
            $errors['lot_img'] = 'Загрузите картинку в формате JPG, JPEG, PNG';
        }else {

            if($file_type == "image/jpg"){
                $filename = uniqid() . '.jpg';
            }elseif($file_type == "image/jpeg"){
                $filename = uniqid() . '.jpeg';
            }elseif($file_type == "image/png"){
                $filename = uniqid() . '.png';
            }
            //move_uploaded_file($tmp_name, 'img/' . $path);
            $lot['img'] = 'img/' . $filename;
            move_uploaded_file($tmp_name, 'img/' . $lot['img']);
        }
    }else {
        $errors['lot_img'] = 'Вы не загрузили файл';
    }

    if (!count($errors)) {
        $sql = 'INSERT INTO lots (category_id, name, description, img, start_price, end_time, step, user_id) VALUES (?, ?, ?, ?, ?, ?, ?, 1)';
        $stmt = mysqli_prepare($connection, $sql);
        mysqli_stmt_bind_param($stmt, 'isssisi', $lot['category'], $lot['name'], $lot['message'], $lot['img'], $lot['rate'], $lot['date'], $lot['step']);
        $res = mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);
        if ($res) {
            $lot_id = mysqli_insert_id($connection);
            header("Location: lot.php?id=" . $lot_id);
        }

    } else {
        $page_content = include_template('add_lot.php', ['lot' => $lot, 'errors' => $errors, 'dict' => $dict]);
    }
}else {
    $page_content = include_template('add_lot.php', []);
}
*/
$page_content = include_template('add_lot.php', [
    'categories' => $categories,
    'lot' => $lot,
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