<?php
namespace app\controller;

use app\BaseController;
use app\model\Message;
use app\model\User;
use think\facade\Session;
use think\facade\View;
use think\facade\Log;

class ChatController extends BaseController
{
    protected $user = null;

    protected function initialize()
    {
        parent::initialize();
        $userId = Session::get('user_id');
        if ($userId) {
            $this->user = User::find($userId);
            if ($this->user) {
                $this->user->last_login = date('Y-m-d H:i:s');
                $this->user->save();
            }
        }
    }

    public function index()
    {
        if (!$this->user) {
            return redirect('/user/login');
        }
        
        View::assign([
            'user' => $this->user,
            'page_title' => 'Chat - IM System'
        ]);
        
        return View::fetch('chat/index');
    }

    public function getOnlineUsers()
    {
        if (!$this->user) {
            return json(['code' => 0, 'msg' => 'Not logged in']);
        }

        // 获取所有用户（除了当前用户）
        $users = User::where('id', '<>', $this->user->id)
            ->select()
            ->map(function ($user) {
                // 检查用户是否在线（30秒内活跃）
                $isOnline = strtotime($user->last_login) > time() - 30;
                return [
                    'id' => $user->id,
                    'username' => $user->username,
                    'last_login' => $user->last_login,
                    'status' => $isOnline ? 'online' : 'offline',
                    'unread_count' => Message::where([
                        ['sender_id', '=', $user->id],
                        ['receiver_id', '=', $this->user->id],
                        ['read_status', '=', 0]
                    ])->count()
                ];
            });

        return json(['code' => 1, 'data' => $users]);
    }

    public function getConversation($id = null)
    {
        if (!$this->user) {
            Log::error('getConversation: User not logged in');
            return json(['code' => 0, 'msg' => 'Not logged in']);
        }

        Log::info('getConversation: Current user info: ' . json_encode([
            'id' => $this->user->id,
            'username' => $this->user->username
        ]));
        Log::info('getConversation: Request for user ID: ' . $id);
        
        if (!$id) {
            Log::error('getConversation: Missing user ID');
            return json(['code' => 0, 'msg' => 'Missing user ID']);
        }

        $otherUser = User::find($id);
        if (!$otherUser) {
            Log::error('getConversation: User not found - ID: ' . $id);
            return json(['code' => 0, 'msg' => 'User not found']);
        }

        Log::info('getConversation: Getting messages between users ' . $this->user->id . ' and ' . $id);
        
        // 获取与该用户的历史消息
        $query = Message::where(function ($query) use ($id) {
            $query->where(function ($q) use ($id) {
                $q->where('sender_id', $this->user->id)
                  ->where('receiver_id', $id);
            })->whereOr(function ($q) use ($id) {
                $q->where('sender_id', $id)
                  ->where('receiver_id', $this->user->id);
            });
        })
        ->order('create_time', 'asc');

        // 记录SQL语句
        Log::info('getConversation: SQL Query: ' . $query->buildSql());
        
        $messages = $query->select()->toArray();

        Log::info('getConversation: Found ' . count($messages) . ' messages with content: ' . json_encode($messages));

        // 标记消息为已读
        $unreadCount = Message::where([
            ['sender_id', '=', $id],
            ['receiver_id', '=', $this->user->id],
            ['read_status', '=', 0]
        ])->update(['read_status' => 1]);

        Log::info('getConversation: Marked ' . $unreadCount . ' messages as read');

        return json(['code' => 1, 'data' => $messages]);
    }

    public function checkUpdates()
    {
        if (!$this->user) {
            Log::error('checkUpdates: User not logged in');
            return json(['code' => 0, 'msg' => 'Not logged in']);
        }

        $lastCheck = input('get.last_check', '1970-01-01 08:00:00');
        $userId = input('get.user_id');

        Log::info('checkUpdates: Checking messages after ' . $lastCheck . ' for user ' . $userId);

        if (!$userId) {
            Log::error('checkUpdates: Missing user ID');
            return json(['code' => 0, 'msg' => 'Missing user ID']);
        }

        // 获取双方之间的新消息
        $query = Message::where(function ($query) use ($userId) {
            $query->where(function ($q) use ($userId) {
                $q->where('sender_id', $this->user->id)
                  ->where('receiver_id', $userId);
            })->whereOr(function ($q) use ($userId) {
                $q->where('sender_id', $userId)
                  ->where('receiver_id', $this->user->id);
            });
        })
        ->where('create_time', '>', $lastCheck)
        ->order('create_time', 'asc');

        // 记录SQL查询
        Log::info('checkUpdates: SQL Query: ' . $query->buildSql());

        $newMessages = $query->select()->toArray();

        Log::info('checkUpdates: Found ' . count($newMessages) . ' new messages');

        if (!empty($newMessages)) {
            // 标记接收到的消息为已读
            Message::where([
                ['sender_id', '=', $userId],
                ['receiver_id', '=', $this->user->id],
                ['read_status', '=', 0]
            ])->update(['read_status' => 1]);

            Log::info('checkUpdates: Returning new messages with create_time > ' . $lastCheck);
        } else {
            Log::info('checkUpdates: No new messages found');
        }

        return json([
            'code' => 1, 
            'data' => [
                'messages' => $newMessages,
                'last_check' => date('Y-m-d H:i:s')
            ]
        ]);
    }
}
