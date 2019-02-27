<?php
date_default_timezone_set("Europe/Moscow");

require_once('functions/db.php');
require_once('functions/template.php');

$config = require 'config.php';
$connection = connectDb($config['db']);

$categories = getCategories($connection);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $name = $_POST['name'];
    $password = $_POST['password'];
    $email = $_POST['email'];
    $message = $_POST['message'];
    $avatar = $_FILES['avatar'];

    $name = clean($name);
    $password = clean($password);
    $email = clean($email);
    $message = clean($message);
    echo $message . '<br>';
    echo $password . '<br>';
    echo $email . '<br>';
    echo $avatar . '<br>';

    if (($name) && ($password) && ($email) && ($message)) {

       // $email_validate = filter_var($email, FILTER_VALIDATE_EMAIL);

        //if (check_length($name, 2, 30) && check_length($password, 2, 30) && check_length($message, 2, 1000) && $email_validate && $avatar) {

       // $tmp_name = $_FILES['$avatar']['tmp_name'];
       // $path = $_FILES['$avatar']['name'];
        //$result = 'img/' . $path;
        //move_uploaded_file($tmp_name, $result);

            $sql = 'INSERT INTO users (name, password, email, contacts, avatar) VALUES (?,?,?,?,?)';
        $stmt = mysqli_prepare($connection, $sql);
        mysqli_stmt_bind_param($stmt, 'sssss', $name, $password, $email, $message, $avatar);
        $res = mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);

            if ($res) {
                header("Location: index.php");
            } else {
                echo "1 ошибка";
            }

        //} else {
        //    echo "2 ошибка";
       //}

    } else {echo "3 ошибка";}
}else{echo "4 ошибка";}

$page_content = include_template('registration.php', [
    'categories' => $categories,
    'lots' => $lots
]);
$layout = include_template('layout.php', [
    'content' => $page_content,
    'title' => 'Главная страница аукциона',
    'categories' => $categories
]);

print($layout);