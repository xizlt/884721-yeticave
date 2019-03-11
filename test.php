<?php

date_default_timezone_set("Europe/Moscow");
//require_once('functions/main.php');
require_once('functions/template.php');
//require_once('functions/registration.php');
//require_once('functions/upload.php');
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
];*/
/*
$name = get_value($user_data, 'sfdgsd');
var_dump($name);
*/

$lot_id = 2;
$lot = getLot($connection, $lot_id);
$user = 42;
$errors = rate_show($lot, $user, $rate);

var_dump($errors);

