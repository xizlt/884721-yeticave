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
        //$tmp_name_type = mime_content_type(in_string($tmp_name));
        //if ($tmp_name_type == 'image/jpg' || $tmp_name_type == 'image/png' || $tmp_name_type == 'image/jpeg'){
            $result = 'img/' . $path;
            move_uploaded_file($tmp_name, $result);
       // }

       // return "файл нужно загрузить в формате .jpg, .jpeg, .png";
return $result;
}