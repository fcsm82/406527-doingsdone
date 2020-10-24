<?php
/**
 * The function of obtaining the list of projects by a specified user
 
 * @param int $user_id user ID
 * @param mysqli object $connection Object of connection to DB
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
 * Function to define a project by its id
 * @param int $project_id project id
 * @param mysqli object $connection Object of connection to DB
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
 * The function of obtaining project ID by its name
 * @param string $project_name project name
 * @param int $user_id user id
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
