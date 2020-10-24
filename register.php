<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Задаем текущую директорию
const APP_DIR = __DIR__;

// Подключаем файлы с функциями
require_once APP_DIR . '/functions/database.php';
require_once APP_DIR . '/functions/functions.php';
require_once APP_DIR . '/functions/get_id.php';
require_once APP_DIR . '/functions/get_user.php';
require_once APP_DIR . '/functions/add.php';
require_once APP_DIR . '/functions/validators.php';

if (!file_exists(APP_DIR . '/config.php')) {
    die('На основе config.sample.php создайте файл config.php, указав в нём настройки для подключениия к БД');
}
// Подключаем файл с настройками
$config = require APP_DIR . '/config.php';
// Подключаемся к БД
$connection = dbConnect($config['db']);

// задаем заголовок страницы
$title = 'Регистрация аккаунта';

// массив с ошибками валиции формы
$errors = null;
$reg_data = null;

session_start();

// проверяем авторизацию пользователя
$user = getAuthUser($connection);
if ($user) {
    header('Location: /index.php');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $reg_data = $_POST;

    $result = validateRegForm($reg_data, $connection);

    if ($result === true) {
        addUser($connection, $reg_data);

        session_start();
        $user = getUserByEmail($reg_data['email'], $connection);

        $_SESSION['user'] = $user;
        header('Location: /index.php');
        exit();
    }
    $errors = $result;
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
