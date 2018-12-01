<?php

/**
 * @param int $user_id
 * @param mysqli object $connection
 * @return array
 */
function getProjectsByUser($user_id, $connection)
{
    $sql = "SELECT p.name  FROM projects p ".
        "JOIN users u ON p.user_id = u.id ".
        "WHERE p.user_id = ?";
    $values = [$user_id];

    $list_projects = dbFetchData($connection, $sql, $values);
    $list_projects = filterData($list_projects, 'name');
    return $list_projects;
}

function getTasksByUser($user_id, $connection)
{
    $sql =  "SELECT t.name, t.term_time, t.complete_time, t.is_completed, t.file, p.name AS project_name FROM tasks t ".
        "JOIN users u ON t.user_id = u.id ".
        "JOIN projects p ON t.project_id = p.id ".
        "WHERE t.user_id = ?";

    $values = [$user_id];

    $list_tasks = dbFetchData($connection, $sql, $values);
    $list_tasks = filterData($list_tasks, 'name');

    return $list_tasks;
}
