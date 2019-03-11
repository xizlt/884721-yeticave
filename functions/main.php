<?php

/**
 * Проверяет наличие ключа
 * @param $array
 * @param $key
 * @return null
 */
function get_value($array, $key)
{
    if (!isset($array[$key])) {
        return null;
    }
    return $array[$key];
}