<?php
/**
 * Возвращает путь на загруженный файл. Перемещает файл
 * @param $fail_data
 * @return string
 *
 */
function upload_img(){
    $path = ($_FILES['img']['name']);
    $tmp_name = $_FILES['img']['tmp_name'];

    $result = 'img/' . $path;
    move_uploaded_file($tmp_name, $result);

    return $result;
}