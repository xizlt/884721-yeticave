<?php

date_default_timezone_set("Europe/Moscow");

require_once('functions/registr.php');
require_once('functions/upload.php');
require_once('functions/db.php');

$user_reg = [
    'name' => 'ivan',
    'contacts' => 'contact',
    'avatar' => 'img/Screenshot_20180505-085242.jpg',
    'password' => '123',
    'email' => 'g@g.ru'
];

$errors = validate_user($user_reg, $file_data, $connection);
var_dump($errors);

