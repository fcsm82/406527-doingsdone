<?php /** @noinspection SpellCheckingInspection */

require APP_DIR . '/.env.development';

return [
        'db' => [
            'host' => getenv(('HOST')),
            'user' => getenv(('USER')),
            'password' => getenv(('PASSWORD')),
            'database' => getenv(('DATABASE'))
        ]
    ];
