<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
// Set the current directory
const APP_DIR = __DIR__;

// Connect files with functions
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
if (!file_exists(APP_DIR . '/config.php')) {
    die('Based on config.php, create a file config.php, specifying the settings for connecting to the database');
}
// Connect the file with settings
$config = require APP_DIR . '/config.php';
// Connect to the database
$connection = dbConnect($config['db']);

// set the page title
$title = 'Doingsdone';


// verify user authentication
$user = getAuthUser($connection);

if (!$user) {
    // create a page for an unauthorized user
    $layout_content = includeTemplate('guest.php', [
        'title' => $title
    ]);
    print($layout_content);
    exit();
}

$user_id = $user['id'];
$list_projects = getProjectsByUser($user_id, $connection);
$filter = $_GET['filter'] ?? null;
$list_tasks = isset($filter) ? getTasksByUserByFilter($user_id, $connection, $filter) : getTasksByUser($user_id,
    $connection);
$show_complete_tasks = isset($_GET['show_completed']) ? changeShowTasks($_GET['show_completed']) : 0;
$template = 'index.php';


if (isset($_GET['search'])) {
    $search_data = trim($_GET['search']) ?? null;

    $list_tasks = getTasksBySearchByUser($search_data, $user_id, $connection);

    if (empty($list_tasks)) {
        $template = 'search.php';
    }
}


if (isset($_GET['project_id'])) {
    $project_id = $_GET['project_id'];
    $project = getProjectById($project_id, $connection);

    if (!$project) {
        die(http_response_code(404));
    }
    $list_tasks = isset($filter) ? getTasksByProjectByFilter($project_id, $connection,
        $filter) : getTasksByProject($project_id, $connection);
}

// create page content
$page_content = includeTemplate($template, [
    'list_tasks' => $list_tasks,
    'filter' => $filter,
    'show_complete_tasks' => $show_complete_tasks
]);

// form a home page
$layout_content = includeTemplate('layout.php', [
    'user' => $user,
    'list_projects' => $list_projects,
    'page_content' => $page_content,
    'title' => $title
]);
print($layout_content);
