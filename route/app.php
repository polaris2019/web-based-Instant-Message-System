<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006~2018 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: liu21st <liu21st@gmail.com>
// +----------------------------------------------------------------------
use think\facade\Route;

// 严格定义首页路由
Route::get('$', 'Index/index')->pattern(['$' => '']);  // 只匹配根路径

// Public user routes (no auth required)
Route::group('user', function () {
    Route::get('register', 'UserController/registerPage');
    Route::get('login', 'UserController/loginPage');
    Route::post('register', 'UserController/register');
    Route::post('login', 'UserController/login');
});

// Protected user routes (auth required)
Route::group('user', function () {
    Route::post('logout', 'UserController/logout');
    Route::get('profile', 'UserController/profile');
})->middleware(['auth'])->pattern(['id' => '\d+']);

// Message routes
Route::group('message', function () {
    Route::post('send', 'MessageController/send');
    Route::post('mark-read', 'MessageController/markAsRead');
    Route::get('list/:user_id', 'MessageController/getMessages');
    Route::get('unread-count', 'MessageController/getUnreadCount');
})->middleware(['auth'])->pattern(['user_id' => '\d+']);

// Chat routes
Route::group('chat', function () {
    Route::get('/', 'ChatController/index');
    Route::get('online-users', 'ChatController/getOnlineUsers');
    Route::get('init/:user_id', 'ChatController/initChat');
    Route::get('updates', 'ChatController/checkUpdates');
    Route::get('conversation/:id', 'ChatController/getConversation');
    Route::get('recent', 'ChatController/getRecentConversations');
})->middleware(['auth'])->pattern(['id' => '\d+', 'user_id' => '\d+']);

// 添加一个 miss 路由来处理所有未匹配的路由
Route::miss(function() {
    return json(['code' => 404, 'msg' => 'Page not found']);
});
