<?php

/**
 * Возвращает массив ошибок при добавлении ставки
 * @param $amount
 * @return null
 */
function error_amount($amount)
{
    if (!isset($_SESSION['user'])) {
        $errors = 'Для добавления ставки необходимо зарегистрироваться или войти';
    }
    if (!$amount) {
        $errors = 'Укажите ставку';
    }
    if ($amount < $lot_data['start_price']) {
        $errors = 'Ставка должна быть больше минимальной ставки';
    }
    if ($amount > $lot_data['start_price']) {
        $errors = 'Следующая ставка должна равняться минимальной ставки';
    }
    if (!is_int($amount)) {
        $errors = 'Ставка может быть только целое число';
    }
    return null;
}

