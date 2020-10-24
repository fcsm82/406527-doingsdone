<?php /** @noinspection PhpInconsistentReturnPointsInspection */

/**
 * Функция подключения к БД
 * @param array $config с параметрами подключения
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
 * Создает подготовленное выражение на основе готового SQL запроса и переданных данных
 * @param $link mysqli Ресурс соединения
 * @param $sql string SQL запрос с плейсхолдерами вместо значений
 * @param array $data Данные для вставки на место плейсхолдеров
 * @return mysqli_stmt Подготовленное выражение
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
 * Функция получения записей из БД
 * @param $link mysqli Ресурс соединения
 * @param $sql string SQL запрос с плейсхолдерами вместо значений
 * @param array $data Данные для вставки на место плейсхолдеров
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
 * Функция вставки записей из БД
 * @param $link mysqli Ресурс соединения
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
 * Формирует prepare sql запрос к таблице $table из полей fields, значение по которым в массиве $data не NULL
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
