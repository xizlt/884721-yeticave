<?php
date_default_timezone_set("Europe/Moscow");

session_start();
require_once('functions/main.php');
require_once('functions/registration.php');
require_once('functions/db.php');
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
    if ($user) {
        header("Location: /");
        exit();
    }
}

$user_data = [];
$file_data = [];
$errors = [];
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user_data = $_POST;
    $file_data = $_FILES;

    $errors = validate_user($user_data, $file_data, $connection);

    if (!$errors) {
        $user_data['avatar'] = upload_img(get_value($file_data, 'avatar'));
        add_user($connection, $user_data);

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
    'categories' => $categories,
    '$user' => $user
]);
print($layout);