<?php
/**
 * Возвращает путь на загруженный файл аватарки. Перемещает файл
 * @param $file_data
 * @return string
 */
function upload_img($file_data)
{
    $path = get_value($file_data, 'name');
    $tmp_name = get_value($file_data, 'tmp_name');
    $result = 'uploads/' . $path;
    move_uploaded_file($tmp_name, $result);
    return $result;
}