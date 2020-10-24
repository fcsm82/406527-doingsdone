<?php
const ERROR_EMPTY_FIELD = 'Required filed';
const ERROR_LENGTH_FIELD = 'The number of characters in the field should be ';
const ERROR_PROJECT_ID = 'Choose a project';
const ERROR_DATE_FIELD = 'Enter date in DD.MM.YYYYY format';
const ERROR_EMAIL_EXIST = 'User exist';
const ERROR_PROJECT_EXIST = 'Project exist';
const ERROR_EMPTY_LOGIN = 'Enter username';
const ERROR_EMPTY_PASSWORD = 'Enter password';
const ERROR_WRONG_USER = 'User does not exist';
const ERROR_WRONG_PASSWORD = 'Wrong password';
const ERROR_WRONG_EMAIL = 'Invalid e-mail';

/**
 * Form Validation Function
 * @param array $task_data array $_POST
 * @param mysqli object $connection Object of connection to the database
 * @return array|bool Returns true or an array with errors
 */
function validateTaskForm($task_data, $connection)
{
    $results = [];

    $results['name'] = validateName(getValueByKey($task_data, 'name'));
    $results['project'] = validateProject(getValueByKey($task_data, 'project'), $connection);
    $results['date'] = validateCompletionDate(getValueByKey($task_data, 'date'));

    $errors = getErrors($results);

    return $errors ?: true;
}

/**
 * Validation function of the "Task name" form field
 * @param string $name data from array $_POST
 * @return bool|string true | error text
 */
function validateName($name)
{
    $name = trim($name);
    if (empty($name)) {
        return ERROR_EMPTY_FIELD;
    }
    $check_length = checkLength($name, 1, 255);
    if ($check_length !== true) {
        return $check_length;
    }
    return true;
}

/**
 * Validation function of the "Project" form field
 * @param int $project_id data from array $_POST
 * @param mysqli object $connection Object of connection to the database
 * @return bool|string true | error text
 */
function validateProject($project_id, $connection)
{
    $project = getProjectById($project_id, $connection);

    if ($project === null && !empty($task_data[$project_id])) {
        return ERROR_PROJECT_ID;
    }
    return true;
}

/**
 * Validation function of the "Date" form field
 * @param $input_date date
 * @return bool|string true | error text
 */
function validateCompletionDate($input_date)
{
    if (!empty($input_date)) {

        $format = 'Y-m-d';
        $date_obj = DateTime::createFromFormat($format, $input_date);

        if ($date_obj && $date_obj->format($format) === $input_date) {
            return true;
        }
        return ERROR_DATE_FIELD;
    }
    return true;
}

/**
 * String length check function
 * @param string $string text string
 * @param int $min Minimum number of characters per line
 * @param int $max Maximum number of characters per line
 * @return bool|string true | error text
 */
function checkLength($string, $min, $max)
{
    $length = mb_strlen($string);
    if ($length < $min || $length > $max) {
        return ERROR_LENGTH_FIELD . 'from ' . $min . ' to ' . $max . ' symbols';
    }
    return true;
}

/**
 * Функция валидации формы
 * @param array $reg_data array $_POST
 * @param mysqli object $connection Object of connection to the database
 * @return array|bool true | error text
 */
function validateRegForm($reg_data, $connection)
{
    $results = [];

    $results['email'] = validateEmail(getValueByKey($reg_data, 'email'), $connection);
    $results['password'] = validatePassword(getValueByKey($reg_data, 'password'));
    $results['name'] = validateName(getValueByKey($reg_data, 'name'));

    $errors = getErrors($results);

    return $errors ?: true;
}

/**
 * Email Validation Function
 * @param string $email Email entered by the user
 * @param mysqli object $connection Object of connection to the database
 * @return bool|string true | error text
 */
function validateEmail($email, $connection)
{
    if (empty($email)) {
        return ERROR_EMPTY_FIELD;
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        return ERROR_WRONG_EMAIL;
    }

    $id = getIdByEmail($email, $connection);

    if (!empty($id)) {
        return ERROR_EMAIL_EXIST;
    }

    $check_length = checkLength($email, 1, 255);
    if ($check_length !== true) {
        return $check_length;
    }
    return true;
}

/**
 * Password validation function
 * @param string $password Password entered by the user
 * @return bool|string true | error text
 */
function validatePassword($password)
{
    if (empty($password)) {
        return ERROR_EMPTY_FIELD;
    }
    $check_length = checkLength($password, 6, 255);
    if ($check_length !== true) {
        return $check_length;
    }
    return true;
}

/**
 * Функция валидации формы
 * @param array $auth_data array $_POST
 * @param mysqli object $connection Object of connection to the database
 * @return array|bool true | error text
 */
function validateAuthForm($auth_data)
{
    $results = [];

    $results['email'] = validateLogin(getValueByKey($auth_data, 'email'));
    $results['password'] = validateInputPassword(getValueByKey($auth_data, 'password'));

    $errors = getErrors($results);

    return $errors ?: true;
}

/**
 * User Login Validation Function
 * @param string $login user login/email
 * @return bool|string true | error text
 */
function validateLogin($login)
{
    if (empty($login)) {
        return ERROR_EMPTY_LOGIN;
    }

    if (!filter_var($login, FILTER_VALIDATE_EMAIL)) {
        return ERROR_WRONG_EMAIL;
    }
    return true;
}

/**
 * Function to validate the password entered by the user
 * @param string $password user password
 * @return bool|string true | error text
 */
function validateInputPassword($password)
{
    if (empty($password)) {
        return ERROR_EMPTY_PASSWORD;
    }
    return true;
}

/**
 * User authentication function
 * @param array $auth_data array $_POST
 * @param mysqli object $connection Object of connection to the database
 * @return bool
 */
function verifyUser($auth_data, $connection)
{
    $user = getUserByEmail($auth_data['email'], $connection);

    if (isset($user)) {
        return password_verify($auth_data['password'], $user['password']) ? true : false;
    }
    return false;
}


/**
 * Function of aggregation of form validation errors
 * @param array $results Array with form fields validation results
 * @return array $errors Array of errors
 */
function getErrors($results)
{
    $errors = [];

    foreach ($results as $key => $result) {
        if ($result !== true) {
            $errors[$key] = $result;
        }
    }
    return $errors;
}


/**
 * Form Validation Function
 * @param array $project_data array $_POST
 * @param integer $user_id
 * @param mysqli object $connection Object of connection to the database
 * @return array|bool true | error text
 */
function validateProjectForm($project_data, $user_id, $connection)
{
    $results = [];
    $results['name'] = validateNameProject(getValueByKey($project_data, 'name'), $user_id, $connection);

    $errors = getErrors($results);

    return $errors ?: true;
}


/**
 * Validation function of the field with the project name
 * @param string $name
 * @param integer $user_id
 * @param mysqli object $connection Object of connection to the database
 * @return bool|string
 */
function validateNameProject($name, $user_id, $connection)
{
    $name = trim($name);
    if (empty($name)) {
        return ERROR_EMPTY_FIELD;
    }
    $check_length = checkLength($name, 1, 255);
    if ($check_length !== true) {
        return $check_length;
    }

    $id = getProjectIdByNameAndUser($name, $user_id, $connection);

    if (!empty($id)) {
        return ERROR_PROJECT_EXIST;
    }

    return true;
}

/**
 * The function of obtaining a value by its key in an array
 * @param $array
 * @param $key
 * @return null
 */
function getValueByKey($array, $key)
{
    return $array[$key] ?? null;
}
