<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Set current directory
const APP_DIR = __DIR__;

// Import files with functions
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
if (!file_exists(APP_DIR . '/config.php')) {
    die('Please chnage config.php to your settings for database');
}
// Import file with settings
$config = require APP_DIR . '/config.php';
// Connecting to database
$connection = dbConnect($config['db']);

$title = 'Add project';


if (!getAuthUser($connection)) {
    header('Location: /index.php');
    exit();
}

$user = getAuthUser($connection);

if ($user) {
    $user_id = $_SESSION['user']['id'];

    // array with errors of form's validation
    $errors = null;
    $project_data = null;

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $project_data = $_POST;

        $result = validateProjectForm($project_data, $user_id, $connection);

        if ($result === true) {
            addProject($user_id, $connection, $project_data);
            header('Location: /index.php');
            exit();
        }
        $errors = $result;
    }
    $list_projects = getProjectsByUser($user_id, $connection);

    // create page content
    $page_content = includeTemplate('add_project.php', [
        'list_projects' => $list_projects,
        'project_data' => $project_data,
        'errors' => $errors
    ]);

    // create a page with the addition of the task
    $layout_content = includeTemplate('layout.php', [
        'user' => $user,
        'page_content' => $page_content,
        'list_projects' => $list_projects,
        'title' => $title
    ]);

    print($layout_content);
}
