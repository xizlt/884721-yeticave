<?php
/**
 * Возвращает путь на загруженный файл. Перемещает файл
 * @param $fail_data
 * @return string
 *
 */
function upload_img($fail_data){
        $path = ($_FILES['img']['name']);
        $tmp_name = $_FILES['img']['tmp_name'];
        $tmp_name_type = mime_content_type($tmp_name);
        if ($tmp_name_type !== 'image/jpg'){
            return "файл нужно загрузить в формате jpg";
        }
        $result = 'img/' . $path;
        move_uploaded_file($tmp_name, $result);
        return $result;
}