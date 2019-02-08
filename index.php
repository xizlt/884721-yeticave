<?php
$is_auth = rand(0, 1);
$user_name = 'Иван'; // укажите здесь ваше имя

$categories = ['Доски и лыжи', 'Крепления', 'Ботинки', 'Одежда', 'Инструменты', 'Разное'];
$lots = [
    [   'name' => '2014 Rossignol District Snowboard',
        'group' => 'Доски и лыжи',
        'price' => '10999',
        'image' => 'img/lot-1.jpg'
    ],
    [   'name' => 'DC Ply Mens 2016/2017 Snowboard',
        'group' => 'Доски и лыжи',
        'price' => '159999',
        'image' => 'img/lot-2.jpg'
    ],
    [   'name' => 'Крепления Union Contact Pro 2015 года размер L/XL	',
        'group' => 'Крепления',
        'price' => '8000',
        'image' => 'img/lot-3.jpg'
    ],
    [   'name' => 'Ботинки для сноуборда DC Mutiny Charocal',
        'group' => 'Ботинки',
        'price' => '10999',
        'image' => 'img/lot-4.jpg'
    ],
    [   'name'=> 'Куртка для сноуборда DC Mutiny Charocal',
        'group' => 'Одежда',
        'price' => '7500',
        'image' => 'img/lot-5.jpg'
    ],
    [   'name' => 'Маска Oakley Canopy',
        'group' => 'Разное',
        'price' => '5400',
        'image' => 'img/lot-6.jpg'
    ]
];

function formatPrice ($lot)
{
    $rate_ceil = ceil($lot);
    if ($rate_ceil >= 1000) {
        $rate_ceil = number_format($rate_ceil, 0, null, ' ');
    }
    return $rate_ceil . " &#8381";
}

require_once('functions.php');
?>

