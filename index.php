<?php
// подключаем файл с функциями и данными
const APP_DIR = __DIR__;
require_once APP_DIR . '/functions/database.php';
require_once APP_DIR . '/functions/functions.php';
require_once APP_DIR . '/functions/data.php';

$config = require APP_DIR . '/config.php';
$connection = dbConnect($config['db']);

$user_id = 1;
$list_projects = getProjectsByUser($user_id, $connection);

if (isset($_GET['project_id'])) {
    $project_id = $_GET['project_id'];
    $project = getProjectById($project_id, $connection);

    if (!$project) {
        die(http_response_code(404));
    }
    else {
        $list_tasks = getTasksByProject($project_id, $connection);
    }
}
else {
    $list_tasks = getTasksByUser($user_id, $connection);
}

// показывать или нет выполненные задачи
$show_complete_tasks = rand(0, 1);

// формируем контент страницы
$page_content = includeTemplate('index.php', [
    'list_tasks' => $list_tasks,
    'show_complete_tasks' => $show_complete_tasks
]);
$side_content = includeTemplate('side_content.php', [
    'list_projects' => $list_projects
]);

// задаем заголовок страницы
$title = 'Дела в поряке';

// формируем гланую страницу
$layout_content = includeTemplate('layout.php', [
    'page_content' => $page_content,
    'side_content' => $side_content,
    'title' => $title
]);
print($layout_content);

