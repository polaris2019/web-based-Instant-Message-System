<?php
// +----------------------------------------------------------------------
// | 应用设置
// +----------------------------------------------------------------------

return [
    // 应用的命名空间
    'app_namespace'    => '',
    // 是否启用路由
    'with_route'       => true,
    // 默认应用
    'default_app'      => 'index',
    // 默认时区
    'default_timezone' => 'Asia/Shanghai',

    // 应用映射（自动多应用模式有效）
    'app_map'          => [],
    // 域名绑定（自动多应用模式有效）
    'domain_bind'      => [],
    // 禁止URL访问的应用列表（自动多应用模式有效）
    'deny_app_list'    => [],

    // 异常页面的模板文件
    'exception_tmpl'   => app()->getThinkPath() . 'tpl/think_exception.tpl',

    // 错误显示信息,非调试模式有效
    'error_message'    => '页面错误！请稍后再试～',
    // 显示错误信息
    'show_error_msg'   => true,
    // 是否开启调试模式
    'app_debug'        => true,
    
    // Cookie 设置
    'cookie'           => [
        // cookie 名称前缀
        'prefix'    => '',
        // cookie 保存时间
        'expire'    => 7200,
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
    
    // Session 设置
    'session'          => [
        // session name
        'name'           => 'PHPSESSID',
        // SESSION_ID的提交变量,解决flash上传跨域
        'var_session_id' => '',
        // 驱动方式 支持file cache
        'type'           => 'file',
        // 存储连接标识 当type使用cache的时候有效
        'store'          => null,
        // 过期时间
        'expire'         => 7200,
        // 前缀
        'prefix'         => '',
    ],
];
