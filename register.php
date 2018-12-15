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

// задаем заголовок страницы
$title = 'Регистрация аккаунта';

// массив с ошибками валиции формы
$errors = null;
$reg_data = null;

// проверяем авторизацию пользователя
$user = getAuthUser($connection);

if ($user) {
    // формируем страницу для авторизованного пользователя
    $layout_content = includeTemplate('index.php', [
        'title' => $title
    ]);
    print($layout_content);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $reg_data = $_POST;

    $result = validateRegForm($reg_data, $connection);

    if ($result === true) {
        addUser($connection, $reg_data);

        session_start();
        $user = getUserByEmail($reg_data['email'], $connection);

        $_SESSION['user'] = $user;
        header("Location: /index.php");
        exit();
    } else {
        $errors = $result;
    }
}

// формируем контент страницы
$page_content = includeTemplate('register.php', [
    'reg_data' => $reg_data,
    'errors' => $errors
]);

// формируем страницу с добавлением задачи
$layout_content = includeTemplate('layout.php', [
    'page_content' => $page_content,
    'title' => $title
]);

print($layout_content);
