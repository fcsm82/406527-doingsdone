<?php
// подключаем файл с функциями и данными
require_once ('functions.php');
require_once ('data.php');

// показывать или нет выполненные задачи
$show_complete_tasks = rand(0, 1);

// формируем контент страницы
$page_content = include_template('index.php', ['task' => $list_tasks]);

// задаем заголовок страницы
$title = 'Дела в поряке';

// формируем гланую страницу
$layout_content = include_template('layout.php', [
    'content' => $page_content,
    'projects' => $list_projects,
    'title' => $title
]);
print($layout_content);
?>

