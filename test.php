<?php

date_default_timezone_set("Europe/Moscow");

require_once('functions/lot_validate.php');
require_once('functions/upload.php');

$lot_data = [
    'category' => 2,
    'name' => 'bord',
    'description' => 'Описание',
    'img' => 'img/Screenshot_20180505-085242.jpg',
    'start_price' => 1,
    'end_time' => '28.02.2019',
    'step' => 200
];

$errors = validate_lot($lot_data);
var_dump($errors);

