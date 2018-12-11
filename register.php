<?php
// подключаем файл с функциями и данными
const APP_DIR = __DIR__;
require_once APP_DIR . '/functions/database.php';
require_once APP_DIR . '/functions/functions.php';
require_once APP_DIR . '/functions/data.php';
require_once APP_DIR . '/functions/validators.php';

$config = require APP_DIR . '/config.php';
$connection = dbConnect($config['db']);

// задаем заголовок страницы
$title = 'Регистрация аккаунта';

$user_id = 1;

// массив с ошибками валиции формы
$errors = null;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $reg_data = $_POST;

    $result = validateRegForm($reg_data, $connection);

    if ($result === true) {
        addUser ($connection, $reg_data);
        header("Location: /index.php");
    }
    else {
        $errors = $result;

        $page_content = includeTemplate('register.php', [
            'reg_data' => $reg_data,
            'errors' => $errors

        ]);
        $side_content = includeTemplate('register_side_content.php', [

        ]);
        $layout_content = includeTemplate('layout.php', [
            'page_content' => $page_content,
            'side_content' => $side_content,
            'title' => $title
        ]);

        print($layout_content);
    }
}

// формируем контент страницы
$page_content = includeTemplate('register.php', [

]);

$side_content = includeTemplate('register_side_content.php', [

]);

// формируем страницу с добавлением задачи
$layout_content = includeTemplate('layout.php', [
    'page_content' => $page_content,
    'side_content' => $side_content,
    'title' => $title
]);

print($layout_content);
