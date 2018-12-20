<?php
/**
 * Функция проверки авторизации пользователя
 * @param mysqli object $connection Объект подключения к БД
 * @return array|bool|false Возвращает массив с данными пользователя | false
 */
function getAuthUser($connection)
{
    if (!isset($_SESSION['user'])) {
        return false;
    }

    return getUserByEmail($_SESSION['user']['email'], $connection);
}

/**
 * Функция получения данных пользователя по его email
 * @param string $email Email пользователя
 * @param mysqli object $connection Объект подключения к БД
 * @return array|false Возвращает данные пользователя | false в случае отсутствия пользователя в БД
 */
function getUserByEmail($email, $connection)
{
    $sql =
        'SELECT * FROM users ' .
        'WHERE email = ?';
    $values = [mysqli_real_escape_string($connection, $email)];

    $user = dbFetchData($connection, $sql, $values);
    $user = filterData($user, 'name');

    return $user ? $user[0] : false;
}
