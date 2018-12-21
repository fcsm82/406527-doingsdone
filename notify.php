<?php

// Задаем текущую директорию
const APP_DIR = __DIR__;

// Подключаем файлы с функциями
require_once APP_DIR . '/functions/database.php';
require_once APP_DIR . '/vendor/autoload.php';
require_once APP_DIR . '/functions/get_tasks.php';

// Подключаем файл с настройками
$config = require APP_DIR . '/config.php';
// Подключаемся к БД
$connection = dbConnect($config['db']);

$transport = new Swift_SmtpTransport($config['mailer']['host'], $config['mailer']['port']);
$transport->setUsername($config['mailer']['username']);
$transport->setPassword($config['mailer']['password']);
$transport->setEncryption($config['mailer']['encryption']);

$mailer = new Swift_Mailer($transport);

foreach (getUrgentTasks($connection) as $task) {

    $email = $task['email'];
    $user_name = $task['user_name'];
    $date = $task['term_time'];
    $task_name = $task['name'];
    $message = new Swift_Message();
    $message->setSubject('Уведомление от сервиса «Дела в порядке»');
    $message->setFrom(['keks@phpdemo.ru' => 'Дела в порядке']);
    $message->setTo([$email => $user_name]);
    $message->setBody(htmlspecialchars("Уважаемый, $user_name. У вас запланирована задача $task_name на $date"));
    $message->setContentType('text/plain');
    $mailer->send($message);
}



