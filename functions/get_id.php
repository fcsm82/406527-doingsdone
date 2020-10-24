<?php

/**
 * @param string $email User email
 * @param mysqli object $connection Object of connection to DB
 * @return bool|string return false or user id
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
