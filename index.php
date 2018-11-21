<?php
// подключаем файл с функциями и данными
require_once ('functions.php');
require_once ('data.php');

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
?>

