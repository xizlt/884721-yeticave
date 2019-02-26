<?php
/**
 * Возвращает путь на загруженный файл. Перемещает файл
 * @param $fail_data
 * @return string
 *
 */
function upload_img($fail_data){
    $path = ($_FILES['img']['name']);
    if (isset($path)) {
        $tmp_name = $_FILES['img']['tmp_name'];

        $result = 'img/' . $path;
        move_uploaded_file($tmp_name, $result);
        return $result;
           }
    return "нет файла";
}