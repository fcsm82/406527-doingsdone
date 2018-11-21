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
function countTasks ($list_tasks, $project) {
    $amount_tasks = 0;
    foreach ($list_tasks as $task) {
        if ($task['category'] === $project) {
            $amount_tasks ++;
        }
    }
    return $amount_tasks;
}

// функция фильтрации данных для защиты от XSS атаки
function filter_data($list_tasks, $filterKey) {
    foreach ($list_tasks as $key => $task) {
        $list_tasks[$key][$filterKey] = strip_tags($task[$filterKey]);
    }
    return $list_tasks;
}

