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


require_once APP_DIR . '/functions/time.php';
require_once APP_DIR . '/functions/url.php';
require_once APP_DIR . '/functions/validators.php';

const ERROR_VALID_FORM = 'Пожалуйста, исправьте ошибки в форме';
const ERROR_VERIFY_USER = 'Вы ввели неверный email/пароль';

session_start();

if (!file_exists(APP_DIR . '/config.php')) {
    die('На основе config.sample.php создайте файл config.php, указав в нём настройки для подключениия к БД');
}
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
    header('Location: /index.php');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $auth_data = $_POST;
    $result = validateAuthForm($auth_data);

    if ($result === true) {
        $result = verifyUser($auth_data, $connection);


        if ($result === true) {
            $user = getUserByEmail($auth_data['email'], $connection);
            $_SESSION['user'] = $user;

            header('Location: /index.php');
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
