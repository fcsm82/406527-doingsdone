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
$list_tasks = getTasksByUser($user_id, $connection);

// формируем контент страницы
$page_content = includeTemplate('add.php', [
    'list_projects' => $list_projects,
]);

// задаем заголовок страницы
$title = 'Добавление задачи';

// формируем страницу с добавлением задачи
$layout_content = includeTemplate('layout.php', [
    'page_content' => $page_content,
    'list_projects' => $list_projects,
    'list_tasks' => $list_tasks,
    'title' => $title
]);



if ($_SERVER['REQUEST_METHOD'] === 'POST')
{
    $result = addTask ($user_id, $connection);
    header("Location: index.php");
}
print($layout_content);
