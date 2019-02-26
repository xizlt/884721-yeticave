<?php

date_default_timezone_set ("Europe/Moscow");
require_once ('functions.php');

$is_auth = rand(0, 1);
$user_name = 'Иван'; // укажите здесь ваше имя

$config = require 'config.php';
$connection = connectDb($config['db']);
$categories = getCategories($connection);

<<<<<<< HEAD

=======
// Мой рабочий вариант но без валидации
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $lot = $_POST['lot'];

        $filename = uniqid() . '.jpg';
        $lot['img'] = 'img/' . $filename;
        move_uploaded_file($_FILES['lot_img']['tmp_name'], $lot['img']);

        $sql = 'INSERT INTO lots (category_id, name, description, img, start_price, end_time, step, user_id) VALUES (?, ?, ?, ?, ?, ?, ?, 1)';

        $stmt = mysqli_prepare($connection, $sql);
        mysqli_stmt_bind_param($stmt, 'isssisi', $lot['category'], $lot['name'], $lot['message'], $lot['img'], $lot['rate'], $lot['date'], $lot['step']);

        $res = mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);


        if ($res) {
            $lot_id = mysqli_insert_id($connection);

            header("Location: lot.php?id=" . $lot_id);
        } else {
            $content = include_template('error.php', ['error' => mysqli_error($connection)]);
        }
    }

    
//проверки

// Название
if (!empty($val)) {
    if (strlen($val) < 2 || strlen($val) > 101) {
        $errors = "Название не может быть меньше 2 и больше 100 символов";
    } else {
        $msg = "Все хорошо";
    }
}else{
    $errors = "Заполните поле";
}

// Цена и ставка
if (!empty($val)) {
    if (!is_numeric($var)) {
        $errors = "Заполните поле цифрами";
    } else {
        if ($var < 0) {
            $errors = "Введите сумму больше 0";
        } else {
            if (strlen($val) > 6) {
                $errors = "Цена не может быть больше 999 999 руб";
            } else {
                if (!is_int($val)) {
                    $errors = "Цена должна равняться целому числу";
                } else {
                    $msg = "Все хорошо";
                }
            }
        }
    }
}else{
    $errors = "Заполните поле";
}
//для описания
if (!empty($val)) {
    if (strlen($val) < 11 || strlen($val) > 301) {
        $errors = "Описание не может быть меньше 10 и больше 300 символов";
    } else {
        $msg = "Все хорошо";
    }
}else{
    $errors = "Заполните поле";
}

//категории
if ($val=="Выберите категорию"){
    $errors = "Выберите категорию";
}else{
    $msg = "Все хорошо";
}

//дата
if (!empty($val)){
    $dl = strtotime($val);
    $date = date("Y-m-d H:i", $d1);
    if ( $date == time()){
        $errors = "Дата должна быть больше текущей";
    }else{
        if ($date > date("Y-m-d H:i", $d1 . "+ 3 month")){
            $errors = "Дата не может быть больше 3 месяцев от текущей";
        }else {
            $msg = "Все хорошо";
        }
    }
}else{
    $errors = "Укажите дату";
}



/* ВАРИК КАК ПО ДЕМКЕ НО НЕ РАБОТАЕТ
>>>>>>> parent of b433814... попытка
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $lot = $_POST['lot'];
    $lot_data = $_POST['lot'];
    $fail_data = $_FILES;

    $errors = validate_lot($lot_data);
    if (empty($errors)){

        $lot['img'] = upload_img($fail_data);

        $sql = 'INSERT INTO lots (category_id, name, description, img, start_price, end_time, step, user_id) VALUES (?, ?, ?, ?, ?, ?, ?, 1)';
        $stmt = mysqli_prepare($connection, $sql);
        mysqli_stmt_bind_param($stmt, 'isssisi', $lot['category'], $lot['name'], $lot['message'], $lot['img'], $lot['rate'], $lot['date'], $lot['step']);
        $res = mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);

        if ($res) {
            $lot_id = mysqli_insert_id($connection);

<<<<<<< HEAD
            header("Location: lot.php?id=" . $lot_id);
=======
    } else {
        $page_content = include_template('add_lot.php', ['lot' => $lot, 'errors' => $errors, 'dict' => $dict, 'categories' => $categories]);
    }
}else {
    $page_content = include_template('add_lot.php', []);
}
*/
$page_content = include_template('add_lot.php', [
    'categories' => $categories,
    'lot' => $lot,
    'errors' => $errors
]);
$layout = include_template('layout.php', [
    'content' => $page_content,
    'title' => 'Добавление лота',
    'user_name' => $user_name,
    'categories' => $categories,
    'is_auth' => $is_auth
]);


print($layout);

/* ПОДСМОТРЕл
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $add_lot = $_POST;
    $required = ['category', 'name', 'message', 'lot_img', 'rate', 'date', 'step'];
    $dict = ['category' => 'Категория', 'name' => 'Название', 'message' => 'Описание лота','lot_img' => 'Изображение','rate' => 'начальную цену','date' => 'дату завершения торгов','step' => 'шаг ставки'];
    $errors = [];
    foreach ($required as $key) {
        if (!isset($_POST[$key])) {
            $errors[$key] = 'Это поле надо заполнить';
        }
// Валидация на выбор категории
        if($key === 'category' && $add_lot[$key] === 'Выберите категорию') {
            $errors[$key] = 'Выберите категорию из списка';
        }
    }

    // Валидация на заполнение числовых значений цены и мин ставки
    foreach($add_lot as $key => $value) {
        if($key === 'rate' || $key === 'step') {
            if(!filter_var($value, FILTER_VALIDATE_INT)) {
                $errors[$key] = 'Введите в это поле положительное, целое число.';
            } else {
                if($value <= 0) {
                    $errors[$key] = 'Введите в это поле положительное, целое число.';
                }
            }
        }
    }

    // Валидация на заполнение верной даты
    if( ($add_lot['date']) !== date('Y-m-d' , strtotime($add_lot['date'])) || strtotime($add_lot['date']) < strtotime('tomorrow')) {
        $errors['date'] = 'Введите корректную дату завершения торгов, которая позже текущей даты хотя бы на один день';
    }
    // Валидация на загрузку файла с картинкой лота
    if (isset($_FILES['lot_img']['name']) && !empty($_FILES['lot_img']['name'])) {
        $finfo = finfo_open(FILEINFO_MIME_TYPE);
        $file_type = finfo_file($finfo, $_FILES['lot_img']['tmp_name']);
        if (!array_search($file_type, IMG_FILE_TYPES)) {
            $errors['lot_img'] = 'Необходимо загрузить фото с расширением JPEG, JPG или PNG';
>>>>>>> parent of b433814... попытка
        } else {
            $page_content = include_template('add_lot.php', ['errors' => $errors, 'categories' => $categories]);
        }
    }
}
$page_content = include_template('add_lot.php', [
    'categories' => $categories,
    'lot' => $lot
]);

$layout = include_template('layout.php', [
    'content' => $page_content,
    'title' => 'Добавление лота',
    'user_name' => $user_name,
    'categories' => $categories,
    'is_auth' => $is_auth
]);
print($layout);
