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
        'SELECT p.id, p.name, (SELECT count(*) FROM tasks WHERE project_id=p.id AND is_completed=0) AS task_count FROM projects p ' .
        'JOIN users u ON p.user_id = u.id ' .
        'LEFT JOIN tasks t ON p.id = t.project_id ' .
        'WHERE p.user_id = ? GROUP BY p.id ' .
        'ORDER BY p.name';
    $values = [$user_id];

    $list_projects = dbFetchData($connection, $sql, $values);
    $list_projects = filterData($list_projects, 'name');
    return $list_projects;
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
        'SELECT id AS project_id, name  FROM projects ' .
        'WHERE id = ?';
    $values = [$project_id];

    $project = dbFetchData($connection, $sql, $values);
    return $project ? $project[0] : null;
}

/**
 * Функция получения ID проекта по его названию
 * @param string $project_name Название проекта
 * @param int $user_id Идентификатор пользователя
 * @param $connection
 * @return array|null
 */
function getProjectIdByNameAndUser($project_name, $user_id, $connection)
{
    $sql =
        'SELECT id, name  FROM projects ' .
        'WHERE name = ? AND user_id = ?';
    $values =
        [
            $project_name,
            $user_id
        ];

    return dbFetchData($connection, $sql, $values);
}
