<?php
date_default_timezone_set ("Europe/Moscow");

session_start();

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
$user_data = [];
$file_data = [];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $user_data = $_POST;
    $file_data = $_FILES;

    $errors = validate_user($user_data, $file_data, $connection);

    if (!$errors) {
        $user_data['avatar'] = upload_avatar($file_data);
        add_user($connection, $user_data, $file_data);

        header("Location: login.php");
        exit();
    }
}
$page_content = include_template('sign_up.php', [
    'categories' => $categories,
    'user_data' => $user_data,
    'errors' => $errors,
    'file_data' => $file_data
]);
$layout = include_template('layout.php', [
    'content' => $page_content,
    'title' => 'Регистрация',
    'categories' => $categories
]);
print($layout);