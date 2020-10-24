<?php
/**
 * The function to calculate the remaining time until the date the task is performed
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

/** Time formatting function
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
