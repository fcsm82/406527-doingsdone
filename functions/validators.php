<?php
const ERROR_EMPTY_FIELD = 'Обязательное к заполнению поле';
const ERROR_LENGTH_FIELD = 'Количество символов в поле должно быть ';
const ERROR_PROJECT_ID = 'Необходимо выбрать проект';
const ERROR_DATE_FIELD = 'Введите дату в формате ДД.ММ.ГГГГ';
const ERROR_EMAIL_EXIST = 'Пользователь с указанным адресом эл. почты уже зарегистрирован';
const ERROR_PROJECT_EXIST = 'Прооект с указанным именем уже существует';
const ERROR_EMPTY_LOGIN = 'Введите имя пользователя';
const ERROR_EMPTY_PASSWORD = 'Введите пароль';
const ERROR_WRONG_USER = 'Пользователя не существует';
const ERROR_WRONG_PASSWORD = 'Неверный пароль';
const ERROR_WRONG_EMAIL = 'Введите корректный адрес электронной почты';

/**
 * Функция валидации формы
 * @param array $task_data Массив $_POST
 * @param mysqli object $connection Объект подключения к БД
 * @return array|bool Возращает true или массив с ошибками
 */
function validateTaskForm($task_data, $connection)
{
    $results = [];

    $results['name'] = validateName($task_data['name']);
    $results['project'] = validateProject($task_data['project'], $connection);
    $results['date'] = validateCompletionDate($task_data['date']);

    if (isset($_FILES['file_tmp_name'])) {
        $results['preview'] = validateAttachment($task_data['file_name'], $task_data['file_tmp_name']);
    }

    $errors = getErrors($results);

    return $errors ? $errors : true;
}

/**
 * Функция валидации поля формы "Название задачи"
 * @param string $name данные из массива $_POST
 * @return bool|string Возращает true или текст ошибки
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
 * Функция валидации поля формы "Проект"
 * @param int $project_id данные из массива $_POST
 * @param mysqli object $connection Объект подключения к БД
 * @return bool|string Возращает true или текст ошибки
 */
function validateProject($project_id, $connection)
{
    $project = getProjectById($project_id, $connection);
    if ($project == null) {
        return ERROR_PROJECT_ID;
    }
    return true;
}

/**
 * Функция валидации поля формы "Дата"
 * @param $input_date дата
 * @return bool|string Возращает true или текст ошибки
 */
function validateCompletionDate($input_date)
{
    if (!empty($input_date)) {
        $format = 'd.m.Y';
        $date_obj = DateTime::createFromFormat($format, $input_date);
        if ($date_obj && $date_obj->format($format) == $input_date) {
            return true;
        }
        return ERROR_DATE_FIELD;
    }
    return true;
}

/**
 * Функция проверки длины строки
 * @param string $string текстовая строка
 * @param int $min Минимальное количество символов в строке
 * @param int $max Максимальное количество символов в строке
 * @return bool|string Возращает true или текст ошибки
 */
function checkLength($string, $min, $max)
{
    $length = mb_strlen($string);
    if ($length < $min || $length > $max) {
        return ERROR_LENGTH_FIELD . 'от ' . $min . ' до ' . $max . ' символов';
    }
    return true;
}

/**
 * Фнукция валидации поля "Файл"
 * @param string $file_name имя файла из массива $_FILES
 * @param $file_tmp_name временное имя файла из массива $_FILES
 * @return bool Возращает true
 */
function validateAttachment($file_name, $file_tmp_name)
{
    $target = APP_DIR .'/'. basename($file_name);
    move_uploaded_file($file_tmp_name, $target);
    return true;
}

/**
 * Функция валидации формы
 * @param array $reg_data Массив $_POST
 * @param mysqli object $connection Объект подключения к БД
 * @return array|bool Возращает true или массив с ошибками
 */
function validateRegForm($reg_data, $connection)
{
    $results = [];

    $results['email'] = validateEmail($reg_data['email'], $connection);
    $results['password'] = validatePassword($reg_data['password']);
    $results['name'] = validateName($reg_data['name']);

    $errors = getErrors($results);

    return $errors ? $errors : true;
}

/**
 * Функция валидации Email
 * @param string $email Email введенный пользователем
 * @param mysqli object $connection Объект подключения к БД
 * @return bool|string Возвращает true | текст ошибки
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
 * Функция валидации пароля
 * @param string $password Пароль введенный пользователем
 * @return bool|string Возвращает true | текст ошибки
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
 * @param array $auth_data Массив $_POST
 * @param mysqli object $connection Объект подключения к БД
 * @return array|bool Возращает true или массив с ошибками
 */
function validateAuthForm($auth_data, $connection)
{
    $results = [];

    $results['email'] = validateLogin($auth_data['email']);
    $results['password'] = validateInputPassword($auth_data['password']);

    $errors = getErrors($results);

    return $errors ? $errors : true;
}

/**
 * Функция валидации логина пользователя
 * @param string $login логин/email пользователя
 * @return bool|string Возвращает true | текст ошибки
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
 * Функция валидации пароля, введенного пользователем
 * @param string $password пароль пользователя
 * @return bool|string Возвращает true | текст ошибки
 */
function validateInputPassword($password)
{
    if (empty($password)) {
        return ERROR_EMPTY_PASSWORD;
    }
    return true;
}

/**
 * Функция проверки подлинности пользователя
 * @param array $auth_data Массив $_POST
 * @param mysqli object $connection Объект подключения к БД
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
 * Функция агреирования ошибок валидации формы
 * @param array $results Массив с результатами валидации полей формы
 * @return array $errors Массив с ошибками
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
 * Функция проверки авторизации пользователя
 * @param mysqli object $connection Объект подключения к БД
 * @return array|bool|false Возвращает массив с данными пользователя | false
 */
function getAuthUser($connection)
{
    if (!isset($_SESSION['user'])) {
        return false;
    } else {
        $user = getUserByEmail($_SESSION['user']['email'], $connection);
    }
    return $user;
}

/**
 * Функция валидации формы
 * @param array $project_data Массив $_POST
 * @return array|bool Возращает true или массив с ошибками
 */
function validateProjectForm($project_data, $connection)
{
    $results = [];
    $results['name'] = validateNameProject($project_data['name'], $connection);


    $errors = getErrors($results);

    return $errors ? $errors : true;
}

function validateNameProject($name, $connection)
{
    $name = trim($name);
    if (empty($name)) {
        return ERROR_EMPTY_FIELD;
    }
    $check_length = checkLength($name, 1, 255);
    if ($check_length !== true) {
        return $check_length;
    }

    $id = getProjectIdByName($name, $connection);

    if (!empty($id)) {
        return ERROR_PROJECT_EXIST;
    }

    return true;
}
