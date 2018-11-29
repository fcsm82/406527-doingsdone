<?php
// функция-шаблонизатор
function include_template($name, $data) {
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
// функция подсчета количества задач для каждого проекта
function countTasks ($list_tasks, $project_name) {
    $amount_tasks = 0;
    foreach ($list_tasks as $task) {
        if ($task['project_name'] === $project_name) {
            $amount_tasks ++;
        }
    }
    return $amount_tasks;
}

// функция фильтрации данных для защиты от XSS атаки
function filter_data($list_values, $filterKey) {
    foreach ($list_values as $key => $value) {
        $list_values[$key][$filterKey] = strip_tags($value[$filterKey]);
    }
    return $list_values;
}
// функция подсчета остатка времени до даты выполнения задачи
function hours_to_date($task) {
    $secs_in_hour = 3600;
    $ts = time();
    $ts_end = strtotime($task['complete_time']);
    $ts_diff = $ts_end - $ts;
    $hours_diff = floor($ts_diff / $secs_in_hour);
    return $hours_diff;
}
