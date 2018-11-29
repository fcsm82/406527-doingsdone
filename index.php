<?php
// подключаем файл с функциями и данными
const APP_DIR = __DIR__;
require_once APP_DIR . '/functions/database.php';
require_once APP_DIR . '/functions/functions.php';

//подключение к БД
$host = 'localhost';
$user = 'root';
$password = '';
$database = 'doingsdone';
$link = db_connect($host, $user, $password, $database);

$user_id = 1;
$sql = "SELECT p.name  FROM projects p ".
    "JOIN users u ON p.user_id = u.id ".
    "WHERE p.user_id = ?";
$values = [$user_id];
$stmt = db_get_prepare_stmt($link, $sql, $data = []);
$list_projects = db_fetch_data($link, $sql, $values);
$list_projects = filter_data($list_projects, 'name');


$sql =  "SELECT t.name, t.complete_time, t.is_completed, t.file, p.name AS project_name FROM tasks t ".
    "JOIN users u ON t.user_id = u.id ".
    "JOIN projects p ON t.project_id = p.id ".
    "WHERE t.user_id = ?";

#$stmt = db_get_prepare_stmt($link, $sql, $data = []);
$list_tasks = db_fetch_data($link, $sql, $values);
$list_tasks = filter_data($list_tasks, 'name');


// показывать или нет выполненные задачи
$show_complete_tasks = rand(0, 1);

// формируем контент страницы
$page_content = include_template('index.php', [
    'list_tasks' => $list_tasks,
    'show_complete_tasks' => $show_complete_tasks
]);

// задаем заголовок страницы
$title = 'Дела в поряке';

// формируем гланую страницу
$layout_content = include_template('layout.php', [
    'page_content' => $page_content,
    'list_projects' => $list_projects,
    'list_tasks' => $list_tasks,
    'title' => $title
]);
print($layout_content);
