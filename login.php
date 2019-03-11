<?php

date_default_timezone_set("Europe/Moscow");

require_once('functions/main.php');
require_once('functions/db.php');
require_once('functions/template.php');
require_once('functions/login_validate.php');

session_start();

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

$login_data = [];
$errors = [];
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $login_data = $_POST;

    $errors = validate_login($connection, $login_data, $user);

    if (!$errors) {
        header("Location: /index.php");
        exit();
    }
}

$page_content = include_template('login.php', [
    'categories' => $categories,
    'errors' => $errors,
    'login_data' => $login_data
]);

$layout = include_template('layout.php', [
    'content' => $page_content,
    'title' => 'Страница входа',
    'categories' => $categories,
    'user' => $user
]);
print($layout);