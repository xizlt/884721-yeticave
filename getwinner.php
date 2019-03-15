<?php
date_default_timezone_set("Europe/Moscow");
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
session_start();
require_once('functions/main.php');
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
$user = null;
if ($user_id = get_value($_SESSION, 'user_id')) {
    $user = get_user_by_id($connection, $user_id);
}



$winners = search_winner($connection);

foreach ($winners as $winner) {
    $lot = winner_update($connection, intval($winner['user_id']), intval($winner['id_lot']));
}
