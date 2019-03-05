<?php
/**
 * Возвращает путь на загруженный файл. Перемещает файл
 * @param $file_data
 * @return string
 *
 */
function upload_img($file_data){
    $path = ($file_data['img']['name']);
    $tmp_name = $file_data['img']['tmp_name'];

    $result = 'img/' . $path;
    move_uploaded_file($tmp_name, $result);

    return $result;
}


function upload_avatar($file_data)
{
        $path = $file_data['avatar']['name'];
        $tmp_name = $file_data['avatar']['tmp_name'];
        $result = 'avatar/' . $path;
        move_uploaded_file($tmp_name, $result);
        return $result;
}