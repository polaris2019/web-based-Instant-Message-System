<?php
namespace app\model;

use think\Model;
use think\facade\Db;

class Message extends Model
{
    // 设置数据表名
    protected $table = 'message';
    
    // 设置字段信息
    protected $schema = [
        'id'          => 'int',
        'sender_id'   => 'int',
        'receiver_id' => 'int',
        'content'     => 'string',
        'read_status' => 'int',
        'create_time' => 'datetime',
        'update_time' => 'datetime',
    ];

    // 自动写入时间戳
    protected $autoWriteTimestamp = true;
    protected $createTime = 'create_time';
    protected $updateTime = 'update_time';

    // 关联发送者
    public function sender()
    {
        return $this->belongsTo(User::class, 'sender_id');
    }

    // 关联接收者
    public function receiver()
    {
        return $this->belongsTo(User::class, 'receiver_id');
    }

    // 获取最近的会话列表
    public static function getRecentConversations($userId)
    {
        // 获取与当前用户相关的所有对话
        $messages = self::where(function ($query) use ($userId) {
            $query->where('sender_id', $userId)
                  ->whereOr('receiver_id', $userId);
        })
        ->order('create_time', 'desc')
        ->select()
        ->toArray();

        $conversations = [];
        $processedUsers = [];

        // 处理消息，按用户分组
        foreach ($messages as $message) {
            $otherUserId = $message['sender_id'] == $userId ? $message['receiver_id'] : $message['sender_id'];
            
            // 如果这个用户的会话已经处理过，跳过
            if (isset($processedUsers[$otherUserId])) {
                continue;
            }

            // 获取未读消息数量
            $unreadCount = self::where([
                ['sender_id', '=', $otherUserId],
                ['receiver_id', '=', $userId],
                ['read_status', '=', 0]
            ])->count();

            // 获取用户信息
            $otherUser = User::find($otherUserId);
            if (!$otherUser) {
                continue;
            }

            // 添加到会话列表
            $conversations[] = [
                'user' => [
                    'id' => $otherUser->id,
                    'username' => $otherUser->username
                ],
                'last_message' => [
                    'content' => $message['content'],
                    'create_time' => $message['create_time']
                ],
                'unread_count' => $unreadCount
            ];

            $processedUsers[$otherUserId] = true;
        }

        return $conversations;
    }

    // 获取两个用户之间的对话记录
    public static function getConversation($userId1, $userId2)
    {
        return self::where(function ($query) use ($userId1, $userId2) {
            $query->where([
                ['sender_id', '=', $userId1],
                ['receiver_id', '=', $userId2]
            ])->whereOr([
                ['sender_id', '=', $userId2],
                ['receiver_id', '=', $userId1]
            ]);
        })
        ->order('create_time', 'asc')
        ->select()
        ->each(function ($message) {
            $message->sender;
            $message->receiver;
            return $message;
        });
    }
}
