<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Set the current directory
const APP_DIR = __DIR__;

// Connect files with functions
require_once APP_DIR . '/functions/database.php';
require_once APP_DIR . '/functions/functions.php';
require_once APP_DIR . '/functions/get_tasks.php';

require_once APP_DIR . '/functions/change.php';
require_once APP_DIR . '/functions/time.php';
require_once APP_DIR . '/functions/url.php';

if (!file_exists(APP_DIR . '/config.php')) {
    die('На основе config.sample.php создайте файл config.php, указав в нём настройки для подключениия к БД');
}
// Connect the file with settings
$config = require APP_DIR . '/config.php';
// Connect to the database
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
    $loc = 'Location: ' . $url;
    header($loc);
}
