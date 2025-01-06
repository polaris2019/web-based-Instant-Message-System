<?php
require __DIR__ . '/vendor/autoload.php';

use think\facade\Db;

// Configure database connection
$config = [
    'default' => 'sqlite',
    'connections' => [
        'sqlite' => [
            'type'     => 'sqlite',
            'database' => __DIR__ . '/database/database.sqlite',
            'prefix'   => '',
            'debug'    => true,
        ],
    ],
];

// Initialize database connection
Db::setConfig($config);

// Query the user
$user = Db::table('user')->where('username', 'Jiantao')->find();

if ($user) {
    echo "User found:\n";
    echo "Username: {$user['username']}\n";
    echo "Password hash length: " . strlen($user['password']) . "\n";
    echo "Password starts with $2y$: " . (strpos($user['password'], '$2y$') === 0 ? 'Yes' : 'No') . "\n";
} else {
    echo "User not found\n";
}
