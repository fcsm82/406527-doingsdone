<?php
// Задаем текущую директорию
const APP_DIR = __DIR__;

// Подключаем файлы с функциями
require_once APP_DIR . '/functions/database.php';
require_once APP_DIR . '/functions/functions.php';
require_once APP_DIR . '/functions/get_tasks.php';
require_once APP_DIR . '/functions/get_projects.php';
require_once APP_DIR . '/functions/get_id.php';
require_once APP_DIR . '/functions/get_user.php';
require_once APP_DIR . '/functions/add.php';
require_once APP_DIR . '/functions/change.php';
require_once APP_DIR . '/functions/time.php';
require_once APP_DIR . '/functions/url.php';
require_once APP_DIR . '/functions/validators.php';

session_start();

// Подключаем файл с настройками
$config = require APP_DIR . '/config.php';
// Подключаемся к БД
$connection = dbConnect($config['db']);

$title = 'Добавление проекта';


if (!getAuthUser($connection)) {
    header("Location: /index.php");
    exit();
}

$user = getAuthUser($connection);

if ($user) {
    $user_id = $_SESSION['user']['id'];


    // массив с ошибками валиции формы
    $errors = null;
    $project_data = null;

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $project_data = $_POST;

        $result = validateProjectForm($project_data, $connection);


        if ($result === true) {
            addProject($user_id, $connection, $project_data);
            header("Location: /index.php");
            exit();
        } else {
            $errors = $result;
            $list_projects = getProjectsByUser($user_id, $connection);
        }
    }
    $list_projects = getProjectsByUser($user_id, $connection);

    // формируем контент страницы
    $page_content = includeTemplate('add_project.php', [
        'list_projects' => $list_projects,
        'project_data' => $project_data,
        'errors' => $errors
    ]);

    // формируем страницу с добавлением задачи
    $layout_content = includeTemplate('layout.php', [
        'user' => $user,
        'page_content' => $page_content,
        'list_projects' => $list_projects,
        'title' => $title
    ]);

    print($layout_content);
}
