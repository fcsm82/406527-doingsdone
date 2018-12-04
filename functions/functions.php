<?php
/**
 * Функция-шаблонизатор
 * @param $name
 * @param $data
 * @return false|string
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

/**
 * Функция подсчета остатка времени до даты выполнения задачи
 * @param $term_time
 * @return float|null
 */
function hoursToDate($term_time) {
    if (!$term_time) {
        return null;
    }
    $secs_in_hour = 3600;
    $ts = time();
    $ts_end = strtotime($term_time);
    $ts_diff = $ts_end - $ts;
    $hours_diff = floor($ts_diff / $secs_in_hour);
    return $hours_diff;
}
/**
 * функция определения срочноcти задачи
 * @param array $task
 * @return string
 */
function isImportant($term_time) {
    if (!$term_time) {
        return false;
    }
    $hours_diff = hoursToDate($term_time);
    if ($hours_diff <= 24) {
        return true;
    }
    return false;
}

/** функция форматирования времени
 * @param timestamp $time
 * @return string|null
 * @throws Exception
 */
function formatTime($time) {
    if (!$time) {
        return null;
    }
    return (new DateTime($time))->format('d.m.Y');
}
