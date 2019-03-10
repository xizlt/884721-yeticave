<?php

/**
 * подключение к БД
 * @param $config
 * @return mysqli|void
 */
function connectDb($config)
{
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
function getCategories($connection)
{
    $result = [];
    $sql = 'SELECT * FROM categories';
    if ($query = mysqli_query($connection, $sql)) {
        $result = mysqli_fetch_all($query, MYSQLI_ASSOC);
    } else {
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
function getLots($connection)
{
    $result = [];
    $sql = 'SELECT l.id, c.name AS category_name, l.name, l.img, l.start_price, l.create_time AS last_rite_time, l.end_time
            FROM lots l
            JOIN categories c
            ON l.category_id = c.id
            ORDER BY l.create_time DESC;';
    if ($query = mysqli_query($connection, $sql)) {
        $result = mysqli_fetch_all($query, MYSQLI_ASSOC);
    } else {
        $error = mysqli_error($connection);
        $result = print('Ошибка MySQL ' . $error);
    }
    return $result;
}

/**
 * получение лота для просмотра
 * @param $connection
 * @param $lot_id
 * @return |null
 */
function get_lot($connection, $lot_id)
{
        $sql = "SELECT l.id, l.user_id AS user_id_rate, c.name AS category_name, l.name AS name, COALESCE(MAX(r.amount), l.start_price)AS price, l.img, l.description, (l.step + COALESCE(MAX(r.amount), l.start_price))AS rate, l.end_time
            FROM lots l
            JOIN categories c
            ON l.category_id = c.id
            JOIN rate r
            ON r.lot_id = l.id
            where l.id = $lot_id
            ;";

        if ($query = mysqli_query($connection, $sql)) {
            $result = mysqli_fetch_assoc($query);
        } else {
            $error = mysqli_error($connection);
            die('Ошибка MySQL: ' . $error);
        }

        if (get_value($result, 'id')) {
            return $result;
        }

        return null;
}

/**
 *
 * Запись нового лота
 * @param $connection
 * @param $lot_data
 * @param $user
 * @return int|string
 */
function add_lot($connection, $lot_data, $user)
{
    $sql = 'INSERT INTO lots (category_id, name, description, img, start_price, end_time, step, user_id) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?)';
    $stmt = mysqli_prepare($connection, $sql);
    mysqli_stmt_bind_param($stmt, 'isssisii',
        $lot_data['category_id'],
        $lot_data['name'],
        $lot_data['description'],
        $lot_data['img'],
        $lot_data['start_price'],
        $lot_data['end_time'],
        $lot_data['step'],
        $user['id']
    );
    $result = mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
    if ($result) {
        $lot_id = mysqli_insert_id($connection);
    }
    return $lot_id;
}

/**
 * Запись нового юзера
 * @param $connection
 * @param $user_data
 * @return int|string
 */
function add_user($connection, $user_data)
{
    $password = password_hash($user_data['password'], PASSWORD_DEFAULT);
    $sql = 'INSERT INTO users (name, email, contacts, avatar, password) VALUE (? ,? ,? ,? ,?)';
    $stmt = mysqli_prepare($connection, $sql);
    mysqli_stmt_bind_param($stmt, 'sssss',
        $user_data['name'],
        $user_data['email'],
        $user_data['contacts'],
        $user_data['avatar'],
        $password
    );
    $result = mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
    if ($result) {
        $user_id = mysqli_insert_id($connection);
    }
    return $user_id;
}

/**
 * Сверка email для формы регистрации юзера
 * @param $connection
 * @param $email
 * @return string|null
 */
function isset_email($connection, $email)
{
    $email_user = mysqli_real_escape_string($connection, $email);
    $sql = "SELECT id FROM users WHERE email = '$email_user'";
    $res = mysqli_query($connection, $sql);
    $isset = mysqli_num_rows($res);
    if ($isset > 0) {
        return 'Пользователь с этим email уже зарегистрирован';
    }
    return null;
}

/**
 * Сверка email для формы входа юзера
 * @param $connection
 * @param $email
 * @return array|null
 */
function get_user_by_email($connection, $email)
{
    $email = mysqli_real_escape_string($connection, $email);
    $sql = "SELECT * FROM users WHERE email = '$email'";
    $res = mysqli_query($connection, $sql);
    $user = $res ? mysqli_fetch_array($res, MYSQLI_ASSOC) : null;
    return $user;
}

/**
 * Получение Получение массива с данными о пользователе по id
 * @param $connection
 * @param $id
 * @return array|null
 */
function get_user_by_id($connection, $id)
{
    $id = (int)$id;
    $sql = "SELECT * FROM users WHERE id = '$id'";
    $res = mysqli_query($connection, $sql);
    $user = $res ? mysqli_fetch_array($res, MYSQLI_ASSOC) : null;
    return $user;
}

/**
 * Запись новой ставки
 * @param $connection
 * @param $amount
 * @return bool
 */
function add_rate($connection, $amount, $user, $lot_id)
{
    $sql = 'INSERT INTO rate(amount, user_id, lot_id) 
            VALUES (?, ?, ?)';
    $stmt = mysqli_prepare($connection, $sql);
    mysqli_stmt_bind_param($stmt, 'iii',
        $amount,
        $user['id'],
        $lot_id
    );
    $result = mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);

    return $result;
}

/**
 * Возвращает массив с ставками
 * @param $connection
 * @param $lot_id
 * @return array|int|null
 */
function rates_user($connection, $lot_id)
{
    $sql = "SELECT * , u.name, r.create_time AS time, r.user_id
            FROM rate r 
            JOIN users u 
            ON u.id = r.user_id 
            WHERE r.lot_id = '$lot_id'
            ORDER BY time DESC";
    if ($query = mysqli_query($connection, $sql)) {
        $result = mysqli_fetch_all($query, MYSQLI_ASSOC);
    } else {
        $error = mysqli_error($connection);
        $result = print('Ошибка MySQL ' . $error);
    }
    return $result;
}