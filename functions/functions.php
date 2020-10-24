<?php
/**
 * Function-template
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
 * Function to filter data to protect from XSS-atacks
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
 * Function to determine importance of task
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
