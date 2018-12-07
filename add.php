<?php
// подключаем файл с функциями и данными
const APP_DIR = __DIR__;
require_once APP_DIR . '/functions/database.php';
require_once APP_DIR . '/functions/functions.php';
require_once APP_DIR . '/functions/data.php';
require_once APP_DIR . '/functions/form.php';

$config = require APP_DIR . '/config.php';
$connection = dbConnect($config['db']);

$user_id = 1;

$list_projects = getProjectsByUser($user_id, $connection);
$list_tasks = getTasksByUser($user_id, $connection);

$classname = null;
$error = null;
$input_error = [
    'name' => null,
    'date' => null,
    'project' => null,
    'preview' => null
];

// формируем контент страницы
$page_content = includeTemplate('add.php', [
    'list_projects' => $list_projects,
    'classname' => $classname,
    'input_error' => $input_error,
    'error' => $error
]);

// задаем заголовок страницы
$title = 'Добавление задачи';

// формируем страницу с добавлением задачи
$layout_content = includeTemplate('layout.php', [
    'page_content' => $page_content,
    'list_projects' => $list_projects,
    'title' => $title
]);


if ($_SERVER['REQUEST_METHOD'] === 'POST')
{
    // Список полей формы
    $fields = ['name', 'project', 'date' , 'preview'];

    if (!isFormValidated($fields)) {
        $classname = 'form__input--error';
        $error = '<p class="form__message">Пожалуйста, исправьте ошибки в форме</p>';
        $page_content = includeTemplate('add.php', [
            'list_projects' => $list_projects,
            'classname' => $classname,
            'input_error' => $input_error,
            'error' => $error
        ]);
        $layout_content = includeTemplate('layout.php', [
            'page_content' => $page_content,
            'list_projects' => $list_projects,
            'list_tasks' => $list_tasks,
            'title' => $title
        ]);

        print($layout_content);
    }
    else {
        addTask ($user_id, $connection);
        header("Location: /index.php");
    }
}
else {
    print($layout_content);
}

