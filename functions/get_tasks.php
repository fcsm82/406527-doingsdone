<?php
/**
 * Function to receive a list of tasks for a specified user
 * @param integer $user_id user id
 * @param mysqli object $connection Object of connection to the database
 * @return array|null
 */
function getTasksByUser($user_id, $connection)
{
    $sql =
        'SELECT t.id, t.name, t.create_time, t.term_time, t.complete_time, t.is_completed, t.file FROM tasks t ' .
        'JOIN users u ON t.user_id = u.id ' .
        'WHERE t.user_id = ?';

    $values = [$user_id];

    $list_tasks = dbFetchData($connection, $sql, $values);
    $list_tasks = filterData($list_tasks, 'name');

    return $list_tasks;
}

/**
 * Function to get a list of tasks with the filter
 * @param integer $user_id user id
 * @param mysqli object $connection Object of connection to the database
 * @param string $filter
 * @return array|null
 */
function getTasksByUserByFilter($user_id, $connection, $filter)
{
    switch ($filter) {
        case 'all':
            return getTasksByUser($user_id, $connection);

        case 'today':
            return getTasksByUserToday($user_id, $connection);

        case 'tomorrow':
            return getTasksByUserTomorrow($user_id, $connection);

        case 'overdue':
            return getTasksByUserOverdue($user_id, $connection);

        default:
            die('Некорретный фильтр');
    }
}

/**
 * Function to get a list of tasks with the date 'today'.
 * @param integer $user_id user id
 * @param mysqli object $connection Object of connection to the database
 * @return array|null
 */
function getTasksByUserToday($user_id, $connection)
{
    $sql =
        'SELECT t.id, t.name, t.create_time, t.term_time, t.complete_time, t.is_completed, t.file FROM tasks t ' .
        'JOIN users u ON t.user_id = u.id ' .
        'WHERE t.user_id = ? AND DATE(t.term_time) = CURDATE() AND DATE(t.term_time) < DATE_ADD(CURDATE(), INTERVAL 1 day)';

    $values = [$user_id];

    $list_tasks = dbFetchData($connection, $sql, $values);
    $list_tasks = filterData($list_tasks, 'name');

    return $list_tasks;
}

/**
 * Function to get a list of tasks with the date 'tomorrow'.
 * @param integer $user_id user id
 * @param mysqli object $connection Object of connection to the database
 * @return array|null
 */
function getTasksByUserTomorrow($user_id, $connection)
{
    $sql =
        'SELECT t.id, t.name, t.create_time, t.term_time, t.complete_time, t.is_completed, t.file FROM tasks t ' .
        'JOIN users u ON t.user_id = u.id ' .
        'WHERE t.user_id = ? AND DATE(t.term_time) > CURDATE() AND DATE(t.term_time) < DATE_ADD(CURDATE(), INTERVAL 2 day)';

    $values = [$user_id];

    $list_tasks = dbFetchData($connection, $sql, $values);
    $list_tasks = filterData($list_tasks, 'name');

    return $list_tasks;
}

/**
 * Function to get a list of tasks with an overdue date
 * @param integer $user_id user id
 * @param mysqli object $connection Object of connection to the database
 * @return array|null
 */
function getTasksByUserOverdue($user_id, $connection)
{
    $sql =
        'SELECT t.id, t.name, t.create_time, t.term_time, t.complete_time, t.is_completed, t.file FROM tasks t ' .
        'JOIN users u ON t.user_id = u.id ' .
        'WHERE t.user_id = ? AND DATE(t.term_time) < CURDATE() ORDER BY t.term_time DESC';

    $values = [$user_id];

    $list_tasks = dbFetchData($connection, $sql, $values);
    $list_tasks = filterData($list_tasks, 'name');

    return $list_tasks;
}

/**
 * Function to get a list of tasks for a given project
 * @param integer $project_id user id
 * @param mysqli object $connection Object of connection to the database
 * @return array|null
 */
function getTasksByProject($project_id, $connection)
{
    $sql =
        'SELECT t.id, t.name, t.create_time, t.term_time, t.complete_time, t.is_completed, t.file, p.id AS project_id, p.name AS project_name FROM tasks t ' .
        'JOIN users u ON t.user_id = u.id ' .
        'JOIN projects p ON t.project_id = p.id ' .
        'WHERE project_id = ?';

    $values = [$project_id];

    $list_tasks = dbFetchData($connection, $sql, $values);
    $list_tasks = filterData($list_tasks, 'name');

    return $list_tasks;
}

/**
 * Function to get a list of tasks for a project with a filter
 * @param integer $project_id user id
 * @param mysqli object $connection Object of connection to the database
 * @param string $filter
 * @return array|null
 */
function getTasksByProjectByFilter($project_id, $connection, $filter)
{
    switch ($filter) {
        case 'all':
            return getTasksByProject($project_id, $connection);
        case 'today':
            return getTasksByProjectToday($project_id, $connection);
        case 'tomorrow':
            return getTasksByProjectTomorrow($project_id, $connection);
        case 'overdue':
            return getTasksByProjectOverdue($project_id, $connection);
        default:
            die('Uncorrected filter');
    }
}

/**
 * Function to get a list of tasks for the project with the execution date 'today'.
 * @param integer $project_id user id
 * @param mysqli object $connection Object of connection to the database
 * @return array|null
 */
function getTasksByProjectToday($project_id, $connection)
{
    $sql =
        'SELECT t.id, t.name, t.create_time, t.term_time, t.complete_time, t.is_completed, t.file, p.id AS project_id, p.name AS project_name FROM tasks t ' .
        'JOIN users u ON t.user_id = u.id ' .
        'JOIN projects p ON t.project_id = p.id ' .
        'WHERE project_id = ? AND DATE(t.term_time) = CURDATE() AND DATE(t.term_time) < DATE_ADD(CURDATE(), INTERVAL 1 day)';

    $values = [$project_id];

    $list_tasks = dbFetchData($connection, $sql, $values);
    $list_tasks = filterData($list_tasks, 'name');

    return $list_tasks;
}

/**
 * Function to get the list of tasks for the project with the date 'tomorrow'.
 * @param integer $project_id user id
 * @param mysqli object $connection Object of connection to the database
 * @return array|null
 */
function getTasksByProjectTomorrow($project_id, $connection)
{
    $sql =
        'SELECT t.id, t.name, t.create_time, t.term_time, t.complete_time, t.is_completed, t.file, p.id AS project_id, p.name AS project_name FROM tasks t ' .
        'JOIN users u ON t.user_id = u.id ' .
        'JOIN projects p ON t.project_id = p.id ' .
        'WHERE project_id = ? AND DATE(t.term_time) > CURDATE() AND DATE(t.term_time) < DATE_ADD(CURDATE(), INTERVAL 2 day)';

    $values = [$project_id];

    $list_tasks = dbFetchData($connection, $sql, $values);
    $list_tasks = filterData($list_tasks, 'name');

    return $list_tasks;
}

/**
 * Function to get a list of tasks for a project with an expired due date
 * @param @param integer $project_id user id
 * @param mysqli object $connection Object of connection to the database
 * @return array|null
 */
function getTasksByProjectOverdue($project_id, $connection)
{
    $sql =
        'SELECT t.id, t.name, t.create_time, t.term_time, t.complete_time, t.is_completed, t.file, p.id AS project_id, p.name AS project_name FROM tasks t ' .
        'JOIN users u ON t.user_id = u.id ' .
        'JOIN projects p ON t.project_id = p.id ' .
        'WHERE project_id = ? AND DATE(t.term_time) < NOW() ORDER BY t.term_time DESC';

    $values = [$project_id];

    $list_tasks = dbFetchData($connection, $sql, $values);
    $list_tasks = filterData($list_tasks, 'name');

    return $list_tasks;
}

/**
 * The function of obtaining the task by its identifier
 * @param $task_id task id
 * @param mysqli object $connection Object of connection to the database
 * @return string|null
 */
function getTaskById($task_id, $connection)
{
    $sql =
        'SELECT id, is_completed  FROM tasks ' .
        'WHERE id = ?';
    $values = [$task_id];

    $task = dbFetchData($connection, $sql, $values);
    return $task ? $task[0] : null;
}

/**
 * Task Search Function
 * @param string $search_data search query
 * @param string $user_id user id
 * @param mysqli object $connection Object of connection to the database
 * @return array|null
 */
function getTasksBySearchByUser($search_data, $user_id, $connection)
{
    $sql =
        'SELECT t.id, t.name, t.create_time, t.term_time, t.complete_time, t.is_completed, t.file, p.name AS project_name FROM tasks t ' .
        'JOIN users u ON t.user_id = u.id ' .
        'JOIN projects p ON t.project_id = p.id ' .
        'WHERE t.user_id = ? AND MATCH(t.name) AGAINST(? IN BOOLEAN MODE)';

    $values = [
        $user_id,
        $search_data
    ];

    $list_tasks = dbFetchData($connection, $sql, $values);
    $list_tasks = filterData($list_tasks, 'name');

    return $list_tasks;
}
