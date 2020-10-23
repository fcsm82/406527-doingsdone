<?php /** @noinspection SpellCheckingInspection */

<<<<<<< HEAD
require APP_DIR . '/.env.production';
=======
// require APP_DIR . '/.env.development';
>>>>>>> 28c2e593fa0f3f71b1846e0da0083f13e2a61c8a

return [
        'db' => [
            'host' => $hostname,
            'user' => $username,
            'password' => $password,
            'database' => $database
        ]
    ];
