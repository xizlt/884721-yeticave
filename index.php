<?php
date_default_timezone_set("Europe/Moscow");

require_once('functions.php');

$is_auth = rand(0, 1);
$user_name = 'Иван'; // укажите здесь ваше имя


$config = require 'config.php';
$connection = connectDb($config['db']);

mysqli_set_charset($connection, "utf8"); // кодировка
// соответствие типам
$link = mysqli_init();
mysqli_options($link, MYSQLI_OPT_INT_AND_FLOAT_NATIVE, 1);


$categories = getCategories($connection);
$lots = getLots($connection);


/*
// подключение к MySQL
$con = mysqli_connect("localhost", "root", "", "yeticave"); //ресурс соединения
mysqli_set_charset($con, "utf8"); // кодировка

// соответствие типам
$link = mysqli_init();
mysqli_options($link, MYSQLI_OPT_INT_AND_FLOAT_NATIVE, 1);

if ($con == false) {
    die("Ошибка подключения: " . mysqli_connect_error()); // проверка на ошибку соединения
}

//запрос в БД
$sql = 'SELECT l.id, c.name AS category_name, l.name, l.img, COALESCE(MAX(r.amount), l.start_price) AS total_price, l.create_time AS last_rite_time
        FROM lots l
        JOIN categories c
        ON l.category_id = c.id
        GROUP BY l.id
        ORDER BY l.create_time DESC;';
$result_lots = mysqli_query($con, $sql);
$lots = mysqli_fetch_all($result_lots, MYSQLI_ASSOC);

$sql_cat = 'SELECT * FROM categories';
$result_cat = mysqli_query($con, $sql_cat);
$categories = mysqli_fetch_all($result_cat, MYSQLI_ASSOC);
*/

$page_content = include_template('index.php', [
    'categories' => $categories,
    'lots' => $lots,
]);
$layout = include_template('layout.php', [
    'content' => $page_content,
    'title' => 'Главная страница аукциона',
    'user_name' => $user_name,
    'categories' => $categories,
    'is_auth' => $is_auth
]);

print($layout);
