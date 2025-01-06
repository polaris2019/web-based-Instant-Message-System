<?php

return [
    // 是否开启命令行调试
    'debug'      => false,
    // 命令行配置
    'command'    => [
        // 指定命名空间
        'namespace' => 'app\command',
    ],
    // 指定迁移目录
    'path'       => app()->getRootPath() . 'database' . DIRECTORY_SEPARATOR . 'migrations',
    // 指定迁移表名
    'table'      => 'migrations',
    // 指定迁移版本
    'version_order' => 'creation',
    // 指定部署方式
    'deploy' => 'production'
];
