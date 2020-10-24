<?php
/**
 * User authentication verification function
 * @param mysqli object $connection Object of connection to the database
 * @return array|bool|false Returns an array with user data | false
 */
function getAuthUser($connection)
{
    if (!isset($_SESSION['user'])) {
        return false;
    }

    return getUserByEmail($_SESSION['user']['email'], $connection);
}

/**
 * Function to receive user data by email
 * @param string $email user email
 * @param mysqli object $connection Object of connection to the database
 * @return array|false Returns user data | false in case the user is absent in the database
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
