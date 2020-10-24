<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Set the current directory
const APP_DIR = __DIR__;

// Connect files with functions
require_once APP_DIR . '/functions/database.php';
require_once APP_DIR . '/functions/functions.php';
require_once APP_DIR . '/functions/get_id.php';
require_once APP_DIR . '/functions/get_user.php';
require_once APP_DIR . '/functions/add.php';
require_once APP_DIR . '/functions/validators.php';

if (!file_exists(APP_DIR . '/config.php')) {
    die('Based on configphp, create a file config.php, specifying the settings for connecting to the database.');
}
// Connect the file with settings
$config = require APP_DIR . '/config.php';
// Connect to the database
$connection = dbConnect($config['db']);

// set the page title
$title = 'Registering an account';

// form validation error array
$errors = null;
$reg_data = null;

session_start();

// verify user authentication
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

// create page content
$page_content = includeTemplate('register.php', [
    'reg_data' => $reg_data,
    'errors' => $errors
]);

// create a page with the addition of the task
$layout_content = includeTemplate('layout.php', [
    'page_content' => $page_content,
    'title' => $title
]);

print($layout_content);
