<?php
// Задаем текущую директорию
const APP_DIR = __DIR__;

// Подключаем файлы с функциями
require_once APP_DIR . '/functions/database.php';
require_once APP_DIR . '/functions/functions.php';
require_once APP_DIR . '/functions/data.php';
require_once APP_DIR . '/functions/validators.php';

const ERROR_VALID_FORM = 'Пожалуйста, исправьте ошибки в форме';
const ERROR_VERIFY_USER = 'Вы ввели неверный email/пароль';

session_start();

// Подключаем файл с настройками
$config = require APP_DIR . '/config.php';
// Подключаемся к БД
$connection = dbConnect($config['db']);

$title = 'Вход на сайт';

// массив с ошибками валиции формы
$errors = null;

// сообщение об ошибках в форме
$form_message = null;

// данные авторизации
$auth_data = null;

$user = getAuthUser($connection);
if ($user) {
    header("Location: /index.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $auth_data = $_POST;
    $result = validateAuthForm($auth_data, $connection);

    if ($result === true) {
        $result = verifyUser($auth_data, $connection);


        if ($result === true) {
            $user = getUserByEmail($auth_data['email'], $connection);
            $_SESSION['user'] = $user;

            header("Location: /index.php");
            exit();
        }

        $errors = $result;
        $form_message = ERROR_VERIFY_USER;
    } else {
        $errors = $result;
        $form_message = ERROR_VALID_FORM;
    }
}

// формируем контент страницы
$page_content = includeTemplate('auth.php', [
    'auth_data' => $auth_data,
    'form_message' => $form_message,
    'errors' => $errors
]);

// формируем страницу с добавлением задачи
$layout_content = includeTemplate('layout.php', [
    'page_content' => $page_content,
    'title' => $title
]);

print($layout_content);
