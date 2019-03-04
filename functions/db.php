<?php

/**
 * подключение к БД
 * @param $config
 * @return mysqli|void
 */
function connectDb($config){
    $connection = mysqli_connect($config['host'], $config['user'], $config['password'], $config['database']);
    mysqli_set_charset($connection, "utf8");
    // соответствие типам
    $link = mysqli_init();
    mysqli_options($link, MYSQLI_OPT_INT_AND_FLOAT_NATIVE, 1);

    if ($connection == false) {
        $connection = die("Ошибка подключения: " . mysqli_connect_error()); // проверка на ошибку соединения
    }
    return $connection;
}

/**
 * получение списка категорий
 * @param $connection
 * @return array|int|null
 */
function getCategories($connection){
    $result = [];
    $sql = 'SELECT * FROM categories';
    if ($query = mysqli_query($connection, $sql)) {
        $result = mysqli_fetch_all($query, MYSQLI_ASSOC);
    }else{
        $error = mysqli_error($connection);
        $result = print('Ошибка MySQL ' . $error);
    }
    return $result;
}

/**
 * получение списка лотов
 * @param $connection
 * @return array|int|null
 */
function getLots($connection){
    $result = [];
    $sql = 'SELECT l.id, c.name AS category_name, l.name, l.img, l.start_price, l.create_time AS last_rite_time, l.end_time
            FROM lots l
            JOIN categories c
            ON l.category_id = c.id
            ORDER BY l.create_time DESC;';
    if ($query = mysqli_query($connection, $sql)) {
        $result = mysqli_fetch_all($query, MYSQLI_ASSOC);
    }else{
        $error = mysqli_error($connection);
        $result = print('Ошибка MySQL ' . $error);
    }
    return $result;
}

/**
 * получение лота для просмотра
 * @param $connection
 * @param integer $lot_id
 * @return |null
 */
function getLot($connection, $lot_id){
    $result = [];
    $sql = "SELECT l.id, c.name AS category_name, l.name as name, COALESCE(MAX(r.amount), l.start_price)as price, l.img,l.description, l.start_price, l.end_time
            FROM lots l
            JOIN categories c
            ON l.category_id = c.id
            JOIN rate r
            ON r.lot_id = l.id 
            where l.id ='$lot_id';";

    if ($query = mysqli_query($connection, $sql)) {
        $result = mysqli_fetch_all($query, MYSQLI_ASSOC);
    } else{
        $error = mysqli_error($connection);
        $result = print('Ошибка MySQL ' . $error);
    }

    if ($result) {
        return $result[0];
    } else {
        return null;
    }
}

/**
 * @param $connection
 * @param $lot_data
 * @return bool
 */
function add_lot($connection, $lot_data){
    $sql = 'INSERT INTO lots (category_id, name, description, img, start_price, end_time, step, user_id) 
            VALUES (?, ?, ?, ?, ?, ?, ?, 1)';
    $stmt = mysqli_prepare($connection, $sql);
    mysqli_stmt_bind_param($stmt, 'isssisi',
        $lot_data['category_id'],
        $lot_data['name'],
        $lot_data['description'],
        $lot_data['img'],
        $lot_data['start_price'],
        $lot_data['end_time'],
        $lot_data['step']
    );
    $result = mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
    if ($result) {
        $lot_id = mysqli_insert_id($connection);
    }
    return $lot_id;
}

function add_user($connection, $user_reg){
    $password = password_hash($user_reg['password'], PASSWORD_DEFAULT);
    $sql = 'INSERT INTO users (name, email, contacts, avatar, password) VALUE (? ,? ,? ,? ,?)';
    $stmt = mysqli_prepare($connection, $sql);
    mysqli_stmt_bind_param($stmt, 'sssss',
        $user_reg['name'],
        $user_reg['email'],
        $user_reg['contacts'],
        $user_reg['avatar'],
        $password
    );
    $result = mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
    return $result;
}

function isset_email($connection, $email){
    $email_user = mysqli_real_escape_string($connection, $email);
    $sql = "SELECT id FROM users WHERE email = '$email_user'";
    $res = mysqli_query($connection, $sql);
    $isset = mysqli_num_rows($res);
    if ($isset > 0) {
        return 'Пользователь с этим email уже зарегистрирован';
    }
    return null;
}