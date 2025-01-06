<?php
// +----------------------------------------------------------------------
// | 会话设置
// +----------------------------------------------------------------------

return [
    // session name
    'name'           => 'PHPSESSID',
    // SESSION_ID的提交变量,解决flash上传跨域
    'var_session_id' => '',
    // 驱动方式 支持file cache
    'type'           => 'file',
    // 存储连接标识 当type使用cache的时候有效
    'store'          => null,
    // 过期时间（秒）
    'expire'         => 7200,
    // 前缀
    'prefix'         => '',
    // cookie 设置
    'cookie'         => [
        // cookie 名称前缀
        'prefix'    => '',
        // cookie 保存时间
        'expire'    => 0,
        // cookie 保存路径
        'path'      => '/',
        // cookie 有效域名
        'domain'    => '',
        // cookie 启用安全传输
        'secure'    => false,
        // httponly 设置
        'httponly'  => false,
        // 是否使用 setcookie
        'setcookie' => true,
        // samesite 设置
        'samesite'  => 'Lax',
    ],
];
