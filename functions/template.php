<?php

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
function clean($value = "") {
    $value = trim($value);
    $value = stripslashes($value);
    $value = strip_tags($value);
    $value = htmlspecialchars($value);

    return $value;
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