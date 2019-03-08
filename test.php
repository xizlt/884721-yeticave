<?php

date_default_timezone_set("Europe/Moscow");
require_once('functions/main.php');
require_once('functions/registration.php');
require_once('functions/upload.php');
require_once('functions/db.php');

$config = require 'config.php';
$connection = connectDb($config['db']);

$user_data = [
    'name' => 'ivan',
    'contacts' => 'contact',
    'avatar' => 'img/Screenshot_20180505-085242.jpg',
    'password' => '123',
    'email' => 'g@g.ru'
];

$name = get_value($user_data, 'sfdgsd');
var_dump($name);
/*
$errors = validate_user($user_data, $file_data, $connection);
var_dump($errors);

*/
$user = get_value($array, $key);
//var_dump($user);