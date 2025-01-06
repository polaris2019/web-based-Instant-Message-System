<?php
require __DIR__ . '/vendor/autoload.php';

use think\facade\Db;

// Load .env file
$env = parse_ini_file('.env', true);

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

// Query all users
$users = Db::table('user')->select();

// Display users
echo "Users in database:\n";
foreach ($users as $user) {
    echo "ID: {$user['id']}, Username: {$user['username']}, Email: {$user['email']}\n";
}
