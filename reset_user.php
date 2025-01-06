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

// Delete existing user
Db::table('user')->where('username', 'Jiantao')->delete();

// Create new user with known password
$password = password_hash('123456', PASSWORD_DEFAULT);
Db::table('user')->insert([
    'username' => 'Jiantao',
    'password' => $password,
    'email' => 'prcaurora@139.com',
    'status' => 1,
    'create_time' => date('Y-m-d H:i:s'),
    'update_time' => date('Y-m-d H:i:s')
]);

echo "User recreated with password: 123456\n";
