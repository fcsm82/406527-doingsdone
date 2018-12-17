<?php
// Задаем текущую директорию
const APP_DIR = __DIR__;

// Подключаем файлы с функциями
require_once APP_DIR . '/functions/database.php';
require_once APP_DIR . '/functions/functions.php';

require_once APP_DIR . '/functions/get_tasks.php';
require_once APP_DIR . '/functions/get_projects.php';
require_once APP_DIR . '/functions/get_user.php';

require_once APP_DIR . '/functions/change.php';
require_once APP_DIR . '/functions/time.php';
require_once APP_DIR . '/functions/url.php';
require_once APP_DIR . '/functions/validators.php';

session_start();

// Подключаем файл с настройками
$config = require APP_DIR . '/config.php';
// Подключаемся к БД
$connection = dbConnect($config['db']);

// задаем заголовок страницы
$title = 'Дела в поряке';



// проверяем авторизацию пользователя
$user = getAuthUser($connection);

if (!$user) {
    // формируем страницу для неавторизованного пользователя
    $layout_content = includeTemplate('guest.php', [
        'title' => $title
    ]);
    print($layout_content);
}

else {
    $user_id = $user['id'];
    $filter = null;
    $list_projects = getProjectsByUser($user_id, $connection);

    if (isset($_GET['project_id'])) {
        $project_id = $_GET['project_id'];
        $project = getProjectById($project_id, $connection);

        if (!$project) {
            die(http_response_code(404));
        } else {
            $filter = isset($_GET['filter']) ? $_GET['filter'] : null;
            $list_tasks = (isset($filter)) ? getTasksByProjectByFilter($project_id, $connection, $filter) : getTasksByProject($project_id, $connection);
        }
    } else {
        $filter = isset($_GET['filter']) ? $_GET['filter'] : null;
        $list_tasks = (isset($filter)) ? getTasksByUserByFilter($user_id, $connection, $filter) : getTasksByUser($user_id, $connection);
    }

    $show_complete_tasks = (isset($_GET['show_completed'])) ? changeShowTasks($_GET['show_completed']) : 0;


// формируем контент страницы
    $page_content = includeTemplate('index.php', [
        'list_tasks' => $list_tasks,
        'filter' => $filter,
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

}


