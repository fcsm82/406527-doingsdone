<?php

/**
 * Функция получения списка проектов по заданному пользователю
 * @param int $user_id Идентификатор пользователя
 * @param mysqli object $connection Объект подключения к БД
 * @return array
 */
function getProjectsByUser($user_id, $connection)
{
    $sql =
        "SELECT p.id, p.name, COUNT(t.id) AS task_count FROM projects p ".
        "JOIN users u ON p.user_id = u.id ".
        "LEFT JOIN tasks t ON p.id = t.project_id ".
        "WHERE p.user_id = ? GROUP BY p.id ".
        "ORDER BY p.name";
    $values = [$user_id];

    $list_projects = dbFetchData($connection, $sql, $values);
    $list_projects = filterData($list_projects, 'name');
    return $list_projects;
}

/**
 * Функция получения списка задач для заданного пользователя
 * @param int $user_id Идентификатор пользователя
 * @param mysqli object $connection Объект подключения к БД
 * @return array|null
 */
function getTasksByUser($user_id, $connection)
{
    $sql =
        "SELECT t.name, t.create_time, t.term_time, t.complete_time, t.is_completed, t.file, p.name AS project_name FROM tasks t ".
        "JOIN users u ON t.user_id = u.id ".
        "JOIN projects p ON t.project_id = p.id ".
        "WHERE t.user_id = ?";

    $values = [$user_id];

    $list_tasks = dbFetchData($connection, $sql, $values);
    $list_tasks = filterData($list_tasks, 'name');

    return $list_tasks;
}

/**
 * Функция получения списка задач по заданному проекту
 * @param int $project_id Идентификатор проекта
 * @param mysqli object $connection Объект подключения к БД
 * @return array|null
 */
function getTasksByProject($project_id, $connection)
{
    $sql =
        "SELECT t.name, t.create_time, t.term_time, t.complete_time, t.is_completed, t.file, p.id AS project_id, p.name AS project_name FROM tasks t ".
        "JOIN users u ON t.user_id = u.id ".
        "JOIN projects p ON t.project_id = p.id ".
        "WHERE project_id = ?";

    $values = [$project_id];

    $list_tasks = dbFetchData($connection, $sql, $values);
    $list_tasks = filterData($list_tasks, 'name');

    return $list_tasks;
}

/**
 * Функция формирования URL-запроса
 * @param int $project_id Идентификатор проекта
 * @return string
 */
function getUrlByProject($project_id)
{
    $data = ['project_id' => $project_id];

    $scriptname = 'index.php';
    $query = http_build_query($data);
    $url = "/" . $scriptname . "?" . $query;

    return $url;
}

/**
 * Функция определения проекта по его  id
 * @param int $project_id Идентификатор проекта
 * @param mysqli object $connection Объект подключения к БД
 * @return array|null
 */
function getProjectById($project_id, $connection)
{
    $sql =
        "SELECT id AS project_id, name  FROM projects ".
        "WHERE id = ?";
    $values = [$project_id];

    $project = dbFetchData($connection, $sql, $values);
    return $project ? $project[0] : null;
}
/** Функция получения ID проекта по его названию
 * @param string $project_name Название проекта
 * @param mysqli object $connection Объект подключения к БД
 * @return array|null
 */
function getProjectIdByName($project_name, $connection)
{
    $sql =
        "SELECT name AS project_name, id  FROM projects ".
        "WHERE $project_name = ?";
    $values = [$project_name];

    $project = dbFetchData($connection, $sql, $values);
    return $project;
}

/**
 * @param ыекштп $email Email пользователя
 * @param mysqli object $connection Объект подключения к БД
 * @return bool|string Возвращает false или id пользователя
 */
function getIdByEmail ($email, $connection) {
    $sql =
        "SELECT id FROM users ".
        "WHERE email = ?";
    $values = [$email];

    $result = dbFetchData($connection, $sql, $values);
    if (!$result) {
        return false;
    }

    return $result[0]['id'];
}

/**
 * Функция добавлениязадачи в БД
 * @param int $user_id ID пользователя
 * @param mysqli object $connection Объект подключения к БД
 * @param array $task_data Данные из формы добавления задачи
 * @throws Exception
 */
function addTask ($user_id, $connection, $task_data)
{

    $sql =
        "INSERT INTO tasks (term_time, name, user_id, project_id, file) VALUES ".
        "(?, ?, ?, ?, ?)";

    $values =
        [
            (new DateTime($task_data['date']))->format('Y-m-d H:i:s'),
            $task_data['name'],
            $user_id,
            $task_data['project'],
            $task_data['file_name']
        ];

    dbInsertData($connection, $sql, $values);
}

/**
 * Функция добавления пользователя в БД
 * @param mysqli object $connection Объект подключения к БД
 * @param array $reg_data Данные из формы регистрации пользователя
 */
function addUser ($connection, $reg_data)
{

    $sql =
        "INSERT INTO users (email, password, name) VALUES ".
        "(?, ?, ?)";

    $values =
        [
            $reg_data['email'],
            $password = password_hash($reg_data['password'], PASSWORD_DEFAULT),
            $reg_data['name']
        ];

    dbInsertData($connection, $sql, $values);
}

/**
 * Функция получения данных пользователя по его email
 * @param string $email Email пользователя
 * @param mysqli object $connection Объект подключения к БД
 * @return array|null Возвращает данные пользователя | null в случае отсутствия пользователя в БД,
 */
function getUserbyEmail ($email, $connection) {
    $sql =
        "SELECT * FROM users ".
        "WHERE email = ?";
    $values = [mysqli_real_escape_string($connection, $email)];

    $user = dbFetchData($connection, $sql, $values);

    return $user ? $user[0] : false;
}
