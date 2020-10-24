<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Specify the current directory
const APP_DIR = __DIR__;

// Connect files with functions
require_once APP_DIR . '/functions/database.php';
require_once APP_DIR . '/functions/functions.php';

require_once APP_DIR . '/functions/get_id.php';
require_once APP_DIR . '/functions/get_user.php';


require_once APP_DIR . '/functions/time.php';
require_once APP_DIR . '/functions/url.php';
require_once APP_DIR . '/functions/validators.php';

const ERROR_VALID_FORM = 'Please correct the errors in the form';
const ERROR_VERIFY_USER = 'You entered the wrong email/password';

session_start();

if (!file_exists(APP_DIR . '/config.php')) {
    die('Based on config.php, create a file config.php, specifying the settings for connecting to the database.');
}
// Connect the file with settings
$config = require APP_DIR . '/config.php';
// Connect to the database
$connection = dbConnect($config['db']);

$title = 'Sign in';

// form validation error array
$errors = null;

// form error message
$form_message = null;

// authentication details
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

// create page content
$page_content = includeTemplate('auth.php', [
    'auth_data' => $auth_data,
    'form_message' => $form_message,
    'errors' => $errors
]);

// create a page with the addition of the task
$layout_content = includeTemplate('layout.php', [
    'page_content' => $page_content,
    'title' => $title
]);

print($layout_content);
