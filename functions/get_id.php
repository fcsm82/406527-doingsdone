<?php

/**
 * @param string $email Email пользователя
 * @param mysqli object $connection Объект подключения к БД
 * @return bool|string Возвращает false или id пользователя
 */
function getIdByEmail($email, $connection)
{
    $sql =
        'SELECT id FROM users ' .
        'WHERE email = ?';
    $values = [$email];

    $result = dbFetchData($connection, $sql, $values);
    if (!$result) {
        return false;
    }

    return $result[0]['id'];
}
