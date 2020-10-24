<?php /** @noinspection SpellCheckingInspection */

require APP_DIR . '/.env.development';

return [
        'db' => [
            'host' => $hostname,
            'user' => $username,
            'password' => $password,
            'database' => $database
        ]
    ];
