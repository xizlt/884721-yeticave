<?php

/**
 * подключение к БД
 * @param $config
 * @return mysqli
 */
function connectDb($config)
{
    $connection = mysqli_connect($config['host'], $config['user'], $config['password'], $config['database']);
    mysqli_set_charset($connection, "utf8");
    // соответствие типам
    $link = mysqli_init();
    mysqli_options($link, MYSQLI_OPT_INT_AND_FLOAT_NATIVE, 1);

    if ($connection === false) {
        $connection = die("Ошибка подключения: " . mysqli_connect_error()); // проверка на ошибку соединения
    }
    return $connection;
}

/**
 * получение списка категорий
 * @param $connection
 * @return array|int|null
 */
function get_categories($connection)
{
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
 * @param $page_items
 * @param $offset
 * @return array|null
 */
function get_lots($connection, $page_items, $offset)
{
    $sql = "SELECT l.id, c.name AS category_name, l.name, l.img, l.start_price, l.create_time AS last_rite_time, l.end_time
            FROM lots l
            JOIN categories c
            ON l.category_id = c.id
            ORDER BY l.create_time DESC
            LIMIT $page_items offset $offset";
    if ($query = mysqli_query($connection, $sql)) {
        return $result = mysqli_fetch_all($query, MYSQLI_ASSOC);
    }
    return null;
}

/**
 * получение лота для просмотра
 * @param $connection
 * @param $lot_id
 * @return array|null |null
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
    if (!$result) {
        die('Ошибка при сохранении лота');
    }
    $lot_id = mysqli_insert_id($connection);
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
        return $user_id;
    }
    return null;
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
    $sql = "SELECT * FROM users WHERE id = $id";
    $res = mysqli_query($connection, $sql);
    $user = $res ? mysqli_fetch_array($res, MYSQLI_ASSOC) : null;
    return $user;
}

/**
 * Запись новой ставки
 * @param $connection
 * @param $amount
 * @param $user
 * @param $lot_id
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

/**
 * возвращает кол-во записей для пагинации index
 * @param $connection
 * @return null|array
 */
function count_lots($connection){
    $sql='SELECT count(*) AS cnt FROM lots';
    if ($query = mysqli_query($connection, $sql)) {
        return $result = mysqli_fetch_assoc($query)['cnt'];
    }
    return null;
}

/**
 * возвращает кол-во записей для пагинации search
 * @param $connection
 * @param $search
 * @return int
 */
function count_search($connection, $search){
    $sql="SELECT count(*) AS cnt FROM lots
          WHERE MATCH(name, description) AGAINST ('$search')
          ";
    if ($query = mysqli_query($connection, $sql)) {
        return $result = mysqli_fetch_assoc($query)['cnt'];
    }
    return null;
}

/**
 * Возвращает массив по запросу поиска
 * @param $connection
 * @param $search
 * @param $page_items
 * @param $offset
 * @return array|null
 */
function get_search($connection, $search, $page_items, $offset)
{
    $sql = "SELECT l.id AS id_lot, l.name AS lot_name, c.name AS category, l.end_time AS time, img, start_price
        FROM lots l
        JOIN categories c ON l.category_id = c.id
        WHERE MATCH(l.name, description) AGAINST ('%$search%')
        ORDER BY l.create_time DESC 
        LIMIT $page_items OFFSET $offset
          ;";

    if ($query = mysqli_query($connection, $sql)) {
        return $result = mysqli_fetch_all($query, MYSQLI_ASSOC);
    }
    return null;
}

/**
 * Возвращает лоты по id категории
 * @param $connection
 * @param $category_lots
 * @param $page_items
 * @param $offset
 * @return array|int|null
 */
function get_search_by_category($connection, $category_lots, $page_items, $offset)
{
    $sql = "SELECT l.id AS id_lot, l.name AS lot_name, c.name AS category, l.end_time AS time, img, start_price
        FROM lots l
        JOIN categories c ON l.category_id = c.id
        WHERE c.id = $category_lots
        ORDER BY l.create_time DESC
        LIMIT $page_items OFFSET $offset
          ;";

    if ($query = mysqli_query($connection, $sql)) {
        return $result = mysqli_fetch_all($query, MYSQLI_ASSOC);
    }
    return null;
}

/**
 * @param $connection
 * @param $category_lots
 * @return array|null
 */
function count_lots_category($connection, $category_lots){
    $sql="SELECT count(*) AS cnt FROM lots
          WHERE  category_id = $category_lots 
          ";
    if ($query = mysqli_query($connection, $sql)) {
        return $result = mysqli_fetch_assoc($query)['cnt'];
    }
    return null;
}
