<?php
/**
 * Возвращает путь на загруженный файл аватарки. Перемещает файл
 * @param $file_data
 * @return string
 */
function upload_img($file_data)
{
    $path = get_value($file_data, 'name');
    if (!$path){
        return null;
    }
    $tmp_name = get_value($file_data, 'tmp_name');
    $result = 'uploads/' . $path;
    if (!move_uploaded_file($tmp_name, $result)) {
        die('Не найдена папка uploads или отсутствуют права на запись в неё');
    }
    return $result;
}