<?php
/**
 * функция-шаблонизатор
 * @param $name
 * @param $data
 * @return
 */

function includeTemplate($name, $data) {
    $name = 'templates/' . $name;
    $result = '';

    if (!file_exists($name)) {
        return $result;
    }

    ob_start();
    extract($data);
    require $name;

    $result = ob_get_clean();

    return $result;
}

/**
 * функция подсчета количества задач для каждого проекта
 * @param array $list_tasks
 * @param $project
 * @return int
 */
// функция подсчета количества задач для каждого проекта
function countTasks ($list_tasks, $project) {
    $amount_tasks = 0;
    foreach ($list_tasks as $task) {
        if ($task['project_name'] === $project) {
            $amount_tasks ++;
        }
    }
    return $amount_tasks;
}

/**
 * функция фильтрации данных для защиты от XSS атаки
 * @param array $list_values
 * @param string $filterKey
 * @return array
 */
function filterData($list_values, $filterKey) {
    foreach ($list_values as $key => $value) {
        $list_values[$key][$filterKey] = strip_tags($value[$filterKey]);
    }
    return $list_values;
}

// функция подсчета остатка времени до даты выполнения задачи
function hoursToDate($task) {
    if (is_null($task['term_time'])) {
        return null;
    }
    $secs_in_hour = 3600;
    $ts = time();
    $ts_end = strtotime($task['term_time']);
    $ts_diff = $ts_end - $ts;
    $hours_diff = floor($ts_diff / $secs_in_hour);
    return $hours_diff;
}
/**
 * функция определения срочночти задачи
 * @param array $task
 * @return string
 */
function isImportant($task) {
    if (is_null($task['term_time'])) {
        return (print(''));
    }
    $hours_diff = hoursToDate($task);
    if ($hours_diff <= 24) {
        return (print('task--important'));
    }
    return (print(''));
}

//
function formatTime($time) {
    if (!$time) {
        return null;
    }
    return (new DateTime($time))->format('d.m.Y');
}
