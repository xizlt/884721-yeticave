<?php
date_default_timezone_set("Europe/Moscow");

require_once('functions.php');

$is_auth = rand(0, 1);
$user_name = 'Иван'; // укажите здесь ваше имя


$config = require 'config.php';

if (!isset($_GET['id'])){
   die('Отсутствует id лота в запросе');
}
$lot_id = $_GET['id'];

$connection = connectDb($config['db']);
$categories = getCategories($connection);

$lot = getLot($connection, $lot_id);
if($lot) {
    $page_content = include_template('lot.php', [
        'categories' => $categories,
        'lot' => $lot
    ]);
}else{
    header("HTTP/1.0 404 Not Found");
    $page_content = include_template('error.php', [
        'error' => 'Такого лота нет'
    ]);
}

$layout = include_template('layout.php', [
    'content' => $page_content,
    'title' => 'Страница лота',
    'user_name' => $user_name,
    'categories' => $categories,
    'is_auth' => $is_auth
]);
print($layout);