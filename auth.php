<?php
// Задаем текущую директорию
const APP_DIR = __DIR__;

// Подключаем файлы с функциями
require_once APP_DIR . '/functions/database.php';
require_once APP_DIR . '/functions/functions.php';
require_once APP_DIR . '/functions/data.php';
require_once APP_DIR . '/functions/validators.php';

// Подключаем файл с настройками
$config = require APP_DIR . '/config.php';
// Подключаемся к БД
$connection = dbConnect($config['db']);

$title = 'Вход на сайт';

// массив с ошибками валиции формы
$errors = null;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $auth_data = $_POST;

    $result = validateAuthForm($auth_data, $connection);

    if ($result === true) {
        $user = getUserbyEmail($auth_data['email'], $connection);
        session_start();
        $_SESSION['user'] = $user;
        header("Location: /index.php");
    }

    else {
        $errors = $result;

        $page_content = includeTemplate('auth.php', [
            'auth_data' => $auth_data,
            'errors' => $errors

        ]);

        $layout_content = includeTemplate('layout.php', [
            'page_content' => $page_content,
            'title' => $title
        ]);

        print($layout_content);
    }
}

// формируем контент страницы
$page_content = includeTemplate('auth.php', [

]);

// формируем страницу с добавлением задачи
$layout_content = includeTemplate('layout.php', [
    'page_content' => $page_content,
    'title' => $title
]);

print($layout_content);




