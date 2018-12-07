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
 *
 */
function addTask ($user_id, $connection)
{
    $sql =
        "INSERT INTO tasks (term_time, name, user_id, project_id, file) VALUES ".
        "(?, ?, ?, ?, ?)";

    $values =
        [
            (new DateTime($_POST['date']))->format('Y-m-d H:i:s'),
            $_POST['name'],
            $user_id,
            $_POST['project'],
            '/' . $_FILES['preview']['name']
        ];

    dbInsertData($connection, $sql, $values);
}
