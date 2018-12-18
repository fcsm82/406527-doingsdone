<?php
/**
 * Функция добавлениязадачи в БД
 * @param int $user_id ID пользователя
 * @param mysqli object $connection Объект подключения к БД
 * @param array $project_data Данные из формы добавления задачи
 * @throws Exception
 */
function addProject($user_id, $connection, $project_data)
{
    $sql =
        'INSERT INTO projects (name, user_id) VALUES ' .
        '(?, ?)';

    $values =
        [
            $project_data['name'],
            $user_id
        ];

    dbInsertData($connection, $sql, $values);
}

/**
 * Функция добавления пользователя в БД
 * @param mysqli object $connection Объект подключения к БД
 * @param array $reg_data Данные из формы регистрации пользователя
 */
function addUser($connection, $reg_data)
{
    $sql =
        'INSERT INTO users (email, password, name) VALUES ' .
        '(?, ?, ?)';

    $values =
        [
            $reg_data['email'],
            $password = password_hash($reg_data['password'], PASSWORD_DEFAULT),
            $reg_data['name']
        ];

    dbInsertData($connection, $sql, $values);
}

/**
 * Функция добавлениязадачи в БД
 * @param int $user_id ID пользователя
 * @param mysqli object $connection Объект подключения к БД
 * @param array $task_data Данные из формы добавления задачи
 * @throws Exception
 */
function addTask($user_id, $connection, $task_data)
{
    if (!empty($task_data['date'])) {
        $sql =
            'INSERT INTO tasks (term_time, name, user_id, project_id, file) VALUES ' .
            '(?, ?, ?, ?, ?)';

        $values =
            [
                (new DateTime($task_data['date']))->format('Y-m-d H:i:s'),
                $task_data['name'],
                $user_id,
                $task_data['project'],
                $task_data['file_name']
            ];
    } else {
        $sql =
            'INSERT INTO tasks (name, user_id, project_id, file) VALUES ' .
            '(?, ?, ?, ?)';

        $values =
            [
                $task_data['name'],
                $user_id,
                $task_data['project'],
                $task_data['file_name']
            ];
    }


    dbInsertData($connection, $sql, $values);
}
