<?php

date_default_timezone_set("Europe/Moscow");

require_once('functions/registr.php');
require_once('functions/upload.php');
require_once('functions/db.php');
$config = require 'config.php';
$connection = connectDb($config['db']);
/*
$user_data = [
    'name' => 'ivan',
    'contacts' => 'contact',
    'avatar' => 'img/Screenshot_20180505-085242.jpg',
    'password' => '123',
    'email' => 'g@g.ru'
];
*/

$id = 74;
/*
$errors = validate_user($user_data, $file_data, $connection);
var_dump($errors);

*/
$user = get_user_by_id($connection, $id);
var_dump($user);