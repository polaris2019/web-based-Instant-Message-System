<?php

return [
    // 默认使用的数据库连接配置
    'default'         => env('database.driver', 'sqlite'),

    // 自定义时间查询规则
    'time_query_rule' => [],

    // 自动写入时间戳字段
    'auto_timestamp'  => true,

    // 时间字段取出后的默认时间格式
    'datetime_format' => 'Y-m-d H:i:s',

    // 时间字段配置 配置格式：create_time,update_time
    'datetime_field'  => '',

    // 数据库连接配置信息
    'connections'     => [
        'sqlite' => [
            // 数据库类型
            'type'            => 'sqlite',
            // 数据库文件路径
            'database'        => env('database.database', app()->getRootPath() . 'database/database.sqlite'),
            // 数据库编码默认采用utf8
            'charset'         => 'utf8',
            // 数据库表前缀
            'prefix'          => env('database.prefix', ''),
            // 数据库调试模式
            'debug'           => env('database.debug', true),
            // 数据库部署方式:0 集中式(单一服务器),1 分布式(主从服务器)
            'deploy'          => 0,
            // 数据库读写是否分离 主从式有效
            'rw_separate'     => false,
            // 监听SQL
            'trigger_sql'     => env('app.debug', true),
            // 开启字段缓存
            'fields_cache'    => false,
            // Required for migration
            'hostname'        => '',
            'hostport'        => '',
            'username'        => '',
            'password'        => '',
        ],
    ],
];
