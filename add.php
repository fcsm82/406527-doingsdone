<?php
// Задаем текущую директорию
const APP_DIR = __DIR__;

// Подключаем файлы с функциями
require_once APP_DIR . '/functions/database.php';
require_once APP_DIR . '/functions/functions.php';
require_once APP_DIR . '/functions/data.php';
require_once APP_DIR . '/functions/validators.php';

// Подключаем файл с настройками
$config = require APP_DIR . '/config.php';
// Подключаемся к БД
$connection = dbConnect($config['db']);

$title = 'Добавление задачи';

session_start();
$user = $_SESSION['user'];
$user_id = $_SESSION['user']['id'];

// массив с ошибками валиции формы
$errors = null;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $task_data = $_POST;

    $task_data['file_name'] = $_FILES['preview']['name'];
    $task_data['file_tmp_name'] = $_FILES['preview']['tmp_name'];

    $result = validateTaskForm($task_data, $connection);

    if ($result === true) {
        addTask ($user_id, $connection, $task_data);
        header("Location: /index.php");
    }
    else {
        $list_projects = getProjectsByUser($user_id, $connection);

        $errors = $result;

        $page_content = includeTemplate('add.php', [
            'list_projects' => $list_projects,
            'task_data' => $task_data,
            'errors' => $errors

        ]);
        $layout_content = includeTemplate('layout.php', [
            'user' => $user,
            'page_content' => $page_content,
            'list_projects' => $list_projects,
            'title' => $title
        ]);

        print($layout_content);
    }
}

$list_projects = getProjectsByUser($user_id, $connection);
$list_tasks = getTasksByUser($user_id, $connection);

// формируем контент страницы
$page_content = includeTemplate('add.php', [
    'list_projects' => $list_projects
]);
$side_content = includeTemplate('side_content.php', [
    'list_projects' => $list_projects
]);

// формируем страницу с добавлением задачи
$layout_content = includeTemplate('layout.php', [
    'user' => $user,
    'page_content' => $page_content,
    'side_content' => $side_content,
    'title' => $title
]);

print($layout_content);

