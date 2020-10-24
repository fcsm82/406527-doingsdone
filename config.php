<?php /** @noinspection SpellCheckingInspection */

require APP_DIR . '/.env.production';

return [
        'db' => [
            'host' => $hostname,
            'user' => $username,
            'password' => $password,
            'database' => $database
        ]
    ];
