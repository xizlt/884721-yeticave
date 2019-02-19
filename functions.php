<?php
function include_template($name, $data)
{
    $name = 'templates/' . $name;
    $result = '';

    if (!is_readable($name)) {
        return $result;
    }

    ob_start();
    extract($data);
    require $name;

    $result = ob_get_clean();

    return $result;
}

function formatPrice($lot)
{
    $rate_ceil = ceil($lot);
    if ($rate_ceil >= 1000) {
        $rate_ceil = number_format($rate_ceil, 0, null, ' ');
    }
    return $rate_ceil . " &#8381";
}

function filterXss($lots)
{
    $text = htmlspecialchars($lots);
    return $text;
}

function time_before_tomorrow()
{
    $now = date_create('now');
    $tomorrow = date_create('tomorrow');
    $diff = date_diff($now, $tomorrow);
    return date_interval_format($diff, "%H:%I");
}

function connectDb($config)
{
    $connection = mysqli_connect($config['host'], $config['user'], $config['password'], $config['database']);
    mysqli_set_charset($connection, "utf8");
    // соответствие типам
    $link = mysqli_init();
    mysqli_options($link, MYSQLI_OPT_INT_AND_FLOAT_NATIVE, 1);

    if ($connection == false) {
        $connection = die("Ошибка подключения: " . mysqli_connect_error()); // проверка на ошибку соединения
    }
    return $connection;
}

function getCategories($connection)
{
    $result = [];
    $sql = 'SELECT * FROM categories';
    if ($query = mysqli_query($connection, $sql)) {
        $result = mysqli_fetch_all($query, MYSQLI_ASSOC);
    }
    return $result;
}


function getLots($connection)
{
    $result = [];
    $sql = 'SELECT l.id, c.name AS category_name, l.name, l.img, l.start_price AS total_price, l.create_time AS last_rite_time
            FROM lots l
            JOIN categories c
            ON l.category_id = c.id
            ORDER BY l.create_time DESC;';
    if ($query = mysqli_query($connection, $sql)) {
        $result = mysqli_fetch_all($query, MYSQLI_ASSOC);
    }
    return $result;
}

function getLots_id($connection, $lot_id)
{
    $result = [];
    $sql = 'SELECT *, c.name AS category_name, l.name as name FROM lots l JOIN categories c
            ON l.category_id = c.id WHERE  l.id = ' . $lot_id;
    if ($query = mysqli_query($connection, $sql)) {
        $result = mysqli_fetch_all($query, MYSQLI_ASSOC);
    }
    return $result;
}