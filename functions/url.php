<?php
/**
 * Функция формирования URL-запроса
 * @param int $project_id Идентификатор проекта
 * @return string
 */
function getUrlByProject($project_id)
{
    $data = ['project_id' => $project_id];

    if (isset($_GET['filter'])) {
        $data['filter'] = $_GET['filter'];
    }

    if (isset($_GET['show_completed'])) {
        $data['show_completed'] = $_GET['show_completed'];
    }

    $scriptname = 'index.php';
    $query = http_build_query($data);
    return '/' . $scriptname . '?' . $query;
}


/**
 * Функция формирования URL для фильтра задач
 * @param null $filter
 * @return string
 */
function buildUrlForFilter($filter = null)
{
    $data = [];

    if (isset($_GET['project_id'])) {
        $data['project_id'] = $_GET['project_id'];
    }

    if ($filter !== null) {
        $data['filter'] = $filter;
    }

    if (isset($_GET['show_completed'])) {
        $data['show_completed'] = $_GET['show_completed'];
    }

    $scriptname = 'index.php';
    $query = http_build_query($data);
    return '/' . $scriptname . '?' . $query;
}

/**
 * Функция формирования URL для выбора завершенных задач
 * @param $show_complete_tasks
 * @return string
 */
function buildUrlForComplete($show_complete_tasks)
{
    $data = [];

    if (isset($_GET['project_id'])) {
        $data['project_id'] = $_GET['project_id'];
    }

    if (isset($_GET['filter'])) {
        $data['filter'] = $_GET['filter'];
    }

    $data['show_completed'] = $show_complete_tasks;

    $scriptname = 'index.php';
    $query = http_build_query($data);
    return '/' . $scriptname . '?' . $query;
}

/**
 * Функция формирования URL для завершенных задач
 * @param $task_id
 * @param $is_completed
 * @param $scriptname
 * @return string
 */
function buildUrlForTasks($task_id, $is_completed, $scriptname)
{
    if (isset($_GET['project_id'])) {
        $data['project_id'] = $_GET['project_id'];
    }

    if (isset($_GET['filter'])) {
        $data['filter'] = $_GET['filter'];
    }

    if (isset($_GET['show_completed'])) {
        $data['show_completed'] = $_GET['show_completed'];
    }


    $data ['task_id'] = $task_id;
    $data ['set_status'] = $is_completed;

    $query = http_build_query($data);
    return '/' . $scriptname . '?' . $query;
}
