<?php
/**
 * Функция-шаблонизатор
 * @param $name
 * @param $data
 * @return false|string
 */
function includeTemplate($name, $data)
{
    $name = 'templates/' . $name;
    $result = '';

    if (!file_exists($name)) {
        return $result;
    }

    ob_start();
    extract($data, EXTR_OVERWRITE);
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
function filterData($list_values, $filterKey)
{
    foreach ($list_values as $key => $value) {
        $list_values[$key][$filterKey] = strip_tags($value[$filterKey]);
    }
    return $list_values;
}

/**
 * Функция определения срочноcти задачи
 * @param $term_time
 * @return bool
 */
function isImportant($term_time)
{
    if (!$term_time) {
        return false;
    }
    $hours_diff = hoursToDate($term_time);
    return $hours_diff <= 24;
}
