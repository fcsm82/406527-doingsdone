<?php
/**
 * Функция получения данных пользователя по его email
 * @param string $email Email пользователя
 * @param mysqli object $connection Объект подключения к БД
 * @return array|false Возвращает данные пользователя | false в случае отсутствия пользователя в БД
 */
function getUserByEmail($email, $connection)
{
    $sql =
        "SELECT * FROM users ".
        "WHERE email = ?";
    $values = [mysqli_real_escape_string($connection, $email)];

    $user = dbFetchData($connection, $sql, $values);

    return $user ? $user[0] : false;
}
