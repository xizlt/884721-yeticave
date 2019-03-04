<?php
function validate_user($user_reg, $file_data, $connection)
{
    $email = $user_reg['email'];
    $errors = [];
    if ($error = validate_user_name($user_reg['name'])) {
        $errors['name'] = $error;
    }
    if ($error = validate_user_password($user_reg['password'])) {
        $errors['password'] = $error;
    }
    if (isset_email($connection, $email)) {
        $errors['email'] = isset_email($connection, $email);
    }
    if ($error = validate_user_email($user_reg['email'])) {
        $errors['email'] = $error;
    }
    if ($error = validate_user_contacts($user_reg['contacts'])) {
        $errors['contacts'] = $error;
    }
    if ($error = validate_file($file_data)) {
        $errors['avatar'] = $error;
    }
    return $errors;
}

function validate_user_name($name)
{
    if (empty($name)) {
        return 'Заполните поле Имя';
    }
    return null;
}

function validate_user_password($password)
{
    if (empty($password)) {
        return 'Заполните поле пароль';
    }
    return null;
}

function validate_user_email($email)
{
    if (empty($email)) {
        return 'Заполните поле email';
    }
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        return 'Проверьте правильность написания email';
    }

    return null;
}


function validate_user_contacts($contacts)
{
    if (empty($contacts)) {
        return 'Заполните поле контакты';
    }
    return null;
}

// Здесь где-то ошибка
function validate_file($file_data)
{
    if (empty($file_data['avatar']['tmp_name'])){
        return null;
    }
    $finfo = finfo_open(FILEINFO_MIME_TYPE);
    $file_name = $file_data['avatar']['tmp_name'];
    $file_type = finfo_file($finfo, $file_name);
    if ($file_type !== 'image/gif' and $file_type !== 'image/jpg' and $file_type !== 'image/jpeg' and $file_type !== 'image/png') {
        return 'Файл нужно загрузить в формате .jpg, .jpeg, .png';
    }
    return null;
}