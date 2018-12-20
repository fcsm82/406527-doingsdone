<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Задаем текущую директорию
const APP_DIR = __DIR__;

// Подключаем файлы с функциями
require_once APP_DIR . '/functions/database.php';
require_once APP_DIR . '/functions/functions.php';

require_once APP_DIR . '/functions/get_tasks.php';
require_once APP_DIR . '/functions/get_projects.php';
require_once APP_DIR . '/functions/get_id.php';
require_once APP_DIR . '/functions/get_user.php';
require_once APP_DIR . '/functions/add.php';
require_once APP_DIR . '/functions/change.php';
require_once APP_DIR . '/functions/time.php';
require_once APP_DIR . '/functions/url.php';
require_once APP_DIR . '/functions/validators.php';
require_once APP_DIR . '/functions/file.php';

session_start();

if (!file_exists(APP_DIR . '/config.php')) {
    die('На основе config.sample.php создайте файл config.php, указав в нём настройки для подключениия к БД');
}
// Подключаем файл с настройками
$config = require APP_DIR . '/config.php';
// Подключаемся к БД
$connection = dbConnect($config['db']);

$title = 'Добавление задачи';

$user = getAuthUser($connection);
if (!$user) {
    header('Location: /index.php');
    exit();
}

    $user_id = $user['id'];

    // массив с ошибками валиции формы
    $errors = null;
    $task_data = null;

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $task_data = $_POST;


        $result = validateTaskForm($task_data, $connection);


        if ($result === true) {
            $task_data['file_name'] = getFileName();
            addTask($user_id, $connection, $task_data);
            header('Location: /index.php');
            exit();
        }

        $errors = $result;
    }

    $list_projects = getProjectsByUser($user_id, $connection);
    $list_tasks = getTasksByUser($user_id, $connection);

    // формируем контент страницы
    $page_content = includeTemplate('add_task.php', [
        'list_projects' => $list_projects,
        'task_data' => $task_data,
        'errors' => $errors
    ]);

    // формируем страницу с добавлением задачи
    $layout_content = includeTemplate('layout.php', [
        'user' => $user,
        'page_content' => $page_content,
        'list_projects' => $list_projects,
        'title' => $title
    ]);

    print($layout_content);
