<?php
// Задаем текущую директорию
const APP_DIR = __DIR__;

// Подключаем файлы с функциями
require_once APP_DIR . '/functions/database.php';
require_once APP_DIR . '/functions/functions.php';
require_once APP_DIR . '/functions/get_tasks.php';

require_once APP_DIR . '/functions/change.php';
require_once APP_DIR . '/functions/time.php';
require_once APP_DIR . '/functions/url.php';


// Подключаем файл с настройками
$config = require APP_DIR . '/config.php';
// Подключаемся к БД
$connection = dbConnect($config['db']);

if (isset($_GET['task_id'])) {
    $task_id = $_GET['task_id'];
    $status = (int)$_GET['set_status'];


    $task = getTaskById($task_id, $connection);



    if (!$task) {
        die(http_response_code(404));
    }

    changeTaskStatus($task, $status, $connection);


    $url = buildUrlForTasks($task['id'], $task['is_completed'], 'index.php');
    $loc = "Location: ". $url;
    header($loc);
}
