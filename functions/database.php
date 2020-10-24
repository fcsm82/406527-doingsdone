<?php /** @noinspection PhpInconsistentReturnPointsInspection */

/**
 * Function to connect to DB
 * @param array $config with params of connection
 * @return mysqli
 */
function dbConnect($config)
{
    $con = mysqli_connect($config['host'], $config['user'], $config['password'], $config['database']);
    if (!$con) {
        die('Ошибка подключения: ' . mysqli_connect_error());
    }

    mysqli_set_charset($con, 'utf8');
    return $con;
}

/**
 * Create prepared statement using SQL query and transfered data
 * @param $link mysqli resource of connection
 * @param $sql string SQL query with placeholder instead of values
 * @param array $data Values to insert instead of placeholders
 * @return mysqli_stmt Prepaired statement
 */
function dbGetPrepareStmt($link, $sql, $data = [])
{
    $stmt = mysqli_prepare($link, $sql);

    if ($data) {
        $types = '';
        $stmt_data = [];

        foreach ($data as $value) {
            $type = null;

            if (is_int($value)) {
                $type = 'i';
            } elseif (is_string($value)) {
                $type = 's';
            } elseif (is_float($value)) {
                $type = 'd';
            }

            if ($type) {
                $types .= $type;
                $stmt_data[] = $value;
            }
        }

        $values = array_merge([$stmt, $types], $stmt_data);

        $func = 'mysqli_stmt_bind_param';
        $func(...$values);
    }

    return $stmt;
}

/**
 * Function to retrieve records from DB
 * @param $link mysqli resource of connection
 * @param $sql string SQL query with placeholder instead of values
 * @param array $data Values to insert instead of placeholders
 * @return array|null
 */
function dbFetchData($link, $sql, $data = [])
{
    $result = [];
    $stmt = dbGetPrepareStmt($link, $sql, $data);
    mysqli_stmt_execute($stmt);
    $res = mysqli_stmt_get_result($stmt);
    if ($res) {
        $result = mysqli_fetch_all($res, MYSQLI_ASSOC);
    }
    mysqli_stmt_close($stmt);
    return $result;
}

/**
 * Function to insert records to DB
 * @param $link mysqli resource of connection
 * @param $sql
 * @param array $data
 * @return bool|int|string
 */
function dbInsertData($link, $sql, $data = [])
{
    $stmt = dbGetPrepareStmt($link, $sql, $data);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
}

/**
 * Create prepared sql query for $table from fields with values in array $data not equal NULL
 * @param string $table
 * @param array $fields
 * @param array $data
 * @return string
 */
function buildPrepareSqlWithoutNullFields($table, $fields, $data)
{
    $columns = [];
    $valuesTemplate = [];

    foreach ($fields as $field) {
        if ($data[$field] !== null) {
            $columns[] = $field;
            $valuesTemplate[] = '?';
        }
    }

    $sql = 'INSERT INTO '
        . $table
        . ' (' . implode(', ', $columns) . ') VALUES (' . implode(', ', $valuesTemplate) . ')';

    return $sql;
}
