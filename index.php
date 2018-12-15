<?php
// Задаем текущую директорию
const APP_DIR = __DIR__;

// Подключаем файлы с функциями
require_once APP_DIR . '/functions/database.php';
require_once APP_DIR . '/functions/functions.php';
require_once APP_DIR . '/functions/data.php';
require_once APP_DIR . '/functions/validators.php';

session_start();

// Подключаем файл с настройками
$config = require APP_DIR . '/config.php';
// Подключаемся к БД
$connection = dbConnect($config['db']);

// задаем заголовок страницы
$title = 'Дела в поряке';

// показывать или нет выполненные задачи
$show_complete_tasks = rand(0, 1);

// проверяем авторизацию пользователя
$user = getAuthUser($connection);

if (!$user) {
    // формируем страницу для неавторизованного пользователя
    $layout_content = includeTemplate('guest.php', [
        'title' => $title
    ]);
    print($layout_content);
}

    $user_id = $user['id'];
    $list_projects = getProjectsByUser($user_id, $connection);

    if (isset($_GET['project_id'])) {
        $project_id = $_GET['project_id'];
        $project = getProjectById($project_id, $connection);

        if (!$project) {
            die(http_response_code(404));
        } else {
            $list_tasks = getTasksByProject($project_id, $connection);
        }
    } else {
        $list_tasks = getTasksByUser($user_id, $connection);
    }

    // формируем контент страницы
    $page_content = includeTemplate('index.php', [
        'list_tasks' => $list_tasks,
        'show_complete_tasks' => $show_complete_tasks
    ]);

    // формируем гланую страницу
    $layout_content = includeTemplate('layout.php', [
        'user' => $user,
        'list_projects' => $list_projects,
        'page_content' => $page_content,
        'title' => $title
    ]);
    print($layout_content);
