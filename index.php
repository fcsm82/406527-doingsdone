<?php
// подключаем файл с функциями и данными
require_once ('functions.php');
//require_once ('data.php');

//подключение к БД
$con = mysqli_connect(localhost, root, test,doingsdone);
if ($con == false) {
    print("Ошибка подключения: " . mysqli_connect_error());
}
else {
    print("Соединение установлено");
}
mysqli_set_charset($con, "utf8");

$sql = "SELECT p.id, p.name, user_id, u.name FROM projects p
        JOIN users u ON p.user_id = u.id";

$result = mysqli_query($con, $sql);
$list_tasks = mysqli_fetch_all($result, MYSQLI_ASSOC);

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
