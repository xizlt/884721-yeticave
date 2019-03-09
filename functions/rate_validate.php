<?php

function error_amount($amount, $lot)
{
    if (!isset($_SESSION['user_id'])) {
        return 'Для добавления ставки необходимо зарегистрироваться или войти';
    }
    if (empty($amount)) {
        return 'Укажите ставку';
    }
    if ($amount < $lot['start_price']) {
        return 'Ставка должна быть больше минимальной ставки';
    }
    if (!(int)$amount) {
        return 'Ставка может быть только целым числом';
    }
    return null;
}

