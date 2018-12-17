<?php
/**
 * Функция получения списка задач для заданного пользователя
 * @param int $user_id Идентификатор пользователя
 * @param mysqli object $connection Объект подключения к БД
 * @return array|null
 */
function getTasksByUser($user_id, $connection)
{
    $sql =
        "SELECT t.id, t.name, t.create_time, t.term_time, t.complete_time, t.is_completed, t.file, p.name AS project_name FROM tasks t ".
        "JOIN users u ON t.user_id = u.id ".
        "JOIN projects p ON t.project_id = p.id ".
        "WHERE t.user_id = ?";

    $values = [$user_id];

    $list_tasks = dbFetchData($connection, $sql, $values);
    $list_tasks = filterData($list_tasks, 'name');

    return $list_tasks;
}

function getTasksByUserByFilter($user_id, $connection, $filter)
{
    switch ($filter) {
        case 'all':
            $list_tasks = getTasksByUser($user_id, $connection);
            break;
        case 'today':
            $list_tasks = getTasksByUserToday($user_id, $connection);
            break;
        case 'tomorrow':
            $list_tasks = getTasksByUserTomorrow($user_id, $connection);
            break;
        case 'overdue':
            $list_tasks = getTasksByUserOverdue($user_id, $connection);
            break;
    }
    return $list_tasks;
}

function getTasksByUserToday($user_id, $connection)
{
    $sql =
        "SELECT t.id, t.name, t.create_time, t.term_time, t.complete_time, t.is_completed, t.file, p.name AS project_name FROM tasks t ".
        "JOIN users u ON t.user_id = u.id ".
        "JOIN projects p ON t.project_id = p.id ".
        "WHERE t.user_id = ? AND DATE(t.term_time) = CURDATE() AND DATE(t.term_time) < DATE_ADD(CURDATE(), INTERVAL 1 day)";

    $values = [$user_id];

    $list_tasks = dbFetchData($connection, $sql, $values);
    $list_tasks = filterData($list_tasks, 'name');

    return $list_tasks;
}

function getTasksByUserTomorrow($user_id, $connection)
{
    $sql =
        "SELECT t.id, t.name, t.create_time, t.term_time, t.complete_time, t.is_completed, t.file, p.name AS project_name FROM tasks t ".
        "JOIN users u ON t.user_id = u.id ".
        "JOIN projects p ON t.project_id = p.id ".
        "WHERE t.user_id = ? AND DATE(t.term_time) > CURDATE() AND DATE(t.term_time) < DATE_ADD(CURDATE(), INTERVAL 2 day)";

    $values = [$user_id];

    $list_tasks = dbFetchData($connection, $sql, $values);
    $list_tasks = filterData($list_tasks, 'name');

    return $list_tasks;
}

function getTasksByUserOverdue($user_id, $connection)
{
    $sql =
        "SELECT t.id, t.name, t.create_time, t.term_time, t.complete_time, t.is_completed, t.file, p.name AS project_name FROM tasks t ".
        "JOIN users u ON t.user_id = u.id ".
        "JOIN projects p ON t.project_id = p.id ".
        "WHERE t.user_id = ? AND DATE(t.term_time) < NOW() ORDER BY t.term_time DESC";

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
        "SELECT t.id, t.name, t.create_time, t.term_time, t.complete_time, t.is_completed, t.file, p.id AS project_id, p.name AS project_name FROM tasks t ".
        "JOIN users u ON t.user_id = u.id ".
        "JOIN projects p ON t.project_id = p.id ".
        "WHERE project_id = ?";

    $values = [$project_id];

    $list_tasks = dbFetchData($connection, $sql, $values);
    $list_tasks = filterData($list_tasks, 'name');

    return $list_tasks;
}

function getTasksByProjectByFilter($project_id, $connection, $filter)
{
    switch ($filter) {
            case 'all':
                $list_tasks = getTasksByProject($project_id, $connection);
                break;
            case 'today':
                $list_tasks = getTasksByProjectToday($project_id, $connection);
                break;
            case 'tomorrow':
                $list_tasks = getTasksByProjectTomorrow($project_id, $connection);
                break;
            case 'overdue':
                $list_tasks = getTasksByProjectOverdue($project_id, $connection);
                break;
        }
    return $list_tasks;
}

function getTasksByProjectToday($project_id, $connection)
{
    $sql =
        "SELECT t.id, t.name, t.create_time, t.term_time, t.complete_time, t.is_completed, t.file, p.id AS project_id, p.name AS project_name FROM tasks t ".
        "JOIN users u ON t.user_id = u.id ".
        "JOIN projects p ON t.project_id = p.id ".
        "WHERE project_id = ? AND DATE(t.term_time) = CURDATE() AND DATE(t.term_time) < DATE_ADD(CURDATE(), INTERVAL 1 day)";

    $values = [$project_id];

    $list_tasks = dbFetchData($connection, $sql, $values);
    $list_tasks = filterData($list_tasks, 'name');

    return $list_tasks;
}

function getTasksByProjectTomorrow($project_id, $connection)
{
    $sql =
        "SELECT t.id, t.name, t.create_time, t.term_time, t.complete_time, t.is_completed, t.file, p.id AS project_id, p.name AS project_name FROM tasks t ".
        "JOIN users u ON t.user_id = u.id ".
        "JOIN projects p ON t.project_id = p.id ".
        "WHERE project_id = ? AND DATE(t.term_time) > CURDATE() AND DATE(t.term_time) < DATE_ADD(CURDATE(), INTERVAL 2 day)";

    $values = [$project_id];

    $list_tasks = dbFetchData($connection, $sql, $values);
    $list_tasks = filterData($list_tasks, 'name');

    return $list_tasks;
}

function getTasksByProjectOverdue($project_id, $connection)
{
    $sql =
        "SELECT t.id, t.name, t.create_time, t.term_time, t.complete_time, t.is_completed, t.file, p.id AS project_id, p.name AS project_name FROM tasks t ".
        "JOIN users u ON t.user_id = u.id ".
        "JOIN projects p ON t.project_id = p.id ".
        "WHERE project_id = ? AND DATE(t.term_time) < NOW() ORDER BY t.term_time DESC";

    $values = [$project_id];

    $list_tasks = dbFetchData($connection, $sql, $values);
    $list_tasks = filterData($list_tasks, 'name');

    return $list_tasks;
}

function getTaskById($task_id, $connection)
{
    $sql =
        "SELECT id, is_completed  FROM tasks ".
        "WHERE id = ?";
    $values = [$task_id];

    $task = dbFetchData($connection, $sql, $values);
    return $task ? $task[0] : null;
}
