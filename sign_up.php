<?php
date_default_timezone_set ("Europe/Moscow");
require_once ('functions/db.php');
require_once ('functions/registr.php');
require_once ('functions/template.php');
require_once ('functions/upload.php');
$config = require 'config.php';
$connection = connectDb($config['db']);
if (!$connection) {
    $page_content = include_template('error.php', ['errors' => mysqli_error($connection)]);
}
$categories = getCategories($connection);
$user_reg = [];
$file_data = [];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $user_reg = $_POST;
    $file_data = $_FILES;

    $errors = validate_user($user_reg, $file_data, $connection);

    if (!$errors) {
        $user_reg['avatar'] = upload_avatar($file_data);
        $res = add_user($connection, $user_reg, $file_data);

        header("Location: login.php");
        exit();
    }
}
$page_content = include_template('sign_up.php', [
    'categories' => $categories,
    'user_reg' => $user_reg,
    'errors' => $errors,
    'file_data' => $file_data
]);
$layout = include_template('layout.php', [
    'content' => $page_content,
    'title' => 'Регистрация',
    'categories' => $categories
]);
print($layout);