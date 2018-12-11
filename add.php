<?php
// подключаем файл с функциями и данными
const APP_DIR = __DIR__;
require_once APP_DIR . '/functions/database.php';
require_once APP_DIR . '/functions/functions.php';
require_once APP_DIR . '/functions/data.php';
require_once APP_DIR . '/functions/validators.php';

$config = require APP_DIR . '/config.php';
$connection = dbConnect($config['db']);

// задаем заголовок страницы
$title = 'Добавление задачи';

$user_id = 1;

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

// формируем страницу с добавлением задачи
$layout_content = includeTemplate('layout.php', [
    'page_content' => $page_content,
    'list_projects' => $list_projects,
    'title' => $title
]);

print($layout_content);

