<?php
//шаблонизатор
function include_template($name, $data){
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
//преобразует цену к формату Х ХХХ
function formatPrice($lot){
    $rate_ceil = ceil($lot);
    if ($rate_ceil >= 1000) {
        $rate_ceil = number_format($rate_ceil, 0, null, ' ');
    }
    return $rate_ceil . " &#8381";
}

//Xss
function filterXss($lots){
    $text = htmlspecialchars($lots);
    return $text;
}
//время до окончания жизни лота
function time_before_end($end_string_time){
    $end_time = strtotime($end_string_time);
    $secs_to_end_time = $end_time - time();
    $hours = floor($secs_to_end_time / 3600);
    $minutes = floor(($secs_to_end_time % 3600) / 60);
    $hours = sprintf('%02d', $hours);
    $minutes =sprintf('%02d', $minutes);
    $result = $hours . ":" . $minutes;
    if ($result <= 0) {
        $result = "00:00";
    }
    return $result;
}

//подключение к БД
function connectDb($config){
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

//получение списка категорий
function getCategories($connection){
    $result = [];
    $sql = 'SELECT * FROM categories';
    if ($query = mysqli_query($connection, $sql)) {
        $result = mysqli_fetch_all($query, MYSQLI_ASSOC);
    }else{
        $error = mysqli_error($connection);
        $result = print('Ошибка MySQL ' . $error);
    }
    return $result;
}

//получение списка лотов
function getLots($connection){
    $result = [];
    $sql = 'SELECT l.id, c.name AS category_name, l.name, l.img, l.start_price, l.create_time AS last_rite_time, l.end_time
            FROM lots l
            JOIN categories c
            ON l.category_id = c.id
            ORDER BY l.create_time DESC;';
    if ($query = mysqli_query($connection, $sql)) {
        $result = mysqli_fetch_all($query, MYSQLI_ASSOC);
    }else{
        $error = mysqli_error($connection);
        $result = print('Ошибка MySQL ' . $error);
    }
    return $result;
}

//получение лота для просмотра
function getLot($connection, $lot_id){
    $result = [];
    $sql = "SELECT l.id, c.name AS category_name, l.name as name, COALESCE(MAX(r.amount), l.start_price)as price, l.img,l.description, l.start_price, l.end_time
            FROM lots l
            JOIN categories c
            ON l.category_id = c.id
            JOIN rate r
            ON r.lot_id = l.id 
            where l.id ='$lot_id';";

    if ($query = mysqli_query($connection, $sql)) {
        $result = mysqli_fetch_all($query, MYSQLI_ASSOC);
    } else{
        $error = mysqli_error($connection);
        $result = print('Ошибка MySQL ' . $error);
    }

    if ($result) {
        return $result[0];
    } else {
        return null;
    }
}

function clean($value = "") {
    $value = trim($value);
    $value = stripslashes($value);
    $value = strip_tags($value);
    $value = htmlspecialchars($value);

    return $value;
}

function check_length($value = "", $min, $max) {
    $result = (mb_strlen($value) < $min || mb_strlen($value) > $max);
    return !$result;
}


function validate_lot($lot_data){
    $error = [];
    foreach ($lot_data as $data => $key){
        if (empty($key)){
            $error = $key;
        }
    }
   return $error;
}

function upload_img($fail_data){

    $tmp_name = $_FILES['lot_img']['tmp_name'];
    $path = $_FILES['lot_img']['name'];
    $result = 'img/' . $path;
    move_uploaded_file($tmp_name, $result);

    return $result;
}


