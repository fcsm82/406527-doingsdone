<?php
/**
 * Функция подсчета остатка времени до даты выполнения задачи
 * @param $term_time
 * @return float|null
 */
function hoursToDate($term_time)
{
    if (!$term_time) {
        return null;
    }
    $secs_in_hour = 3600;
    $ts = time();
    $ts_end = strtotime($term_time);
    $ts_diff = $ts_end - $ts;
    return floor($ts_diff / $secs_in_hour);
}

/** функция форматирования времени
 * @param string $time
 * @return string|null
 * @throws Exception
 */
function formatTime($time)
{
    if (!$time) {
        return null;
    }
    return (new DateTime($time))->format('d.m.Y');
}
