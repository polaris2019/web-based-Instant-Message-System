<?php
namespace app\controller;

use app\BaseController;
use app\model\Message;
use app\model\User;
use think\facade\Session;
use think\facade\Log;

class MessageController extends BaseController
{
    protected $user = null;

    protected function initialize()
    {
        parent::initialize();
        $userId = Session::get('user_id');
        Log::info('MessageController initialize - User ID: ' . $userId);
        if ($userId) {
            $this->user = User::find($userId);
            Log::info('MessageController initialize - Found user: ' . ($this->user ? 'yes' : 'no'));
        }
    }

    // Send a message
    public function send()
    {
        Log::info('MessageController send - Starting');
        Log::info('MessageController send - POST data: ' . json_encode(input('post.')));
        
        if (!$this->user) {
            Log::warning('MessageController send - User not logged in');
            return json(['code' => 0, 'msg' => 'Not logged in']);
        }

        $receiverId = input('post.receiver_id');
        $content = input('post.content');

        Log::info('MessageController send - Receiver ID: ' . $receiverId);
        Log::info('MessageController send - Content: ' . $content);

        if (!$receiverId || !$content) {
            Log::warning('MessageController send - Missing parameters');
            return json(['code' => 0, 'msg' => 'Missing required parameters']);
        }

        $receiver = User::find($receiverId);
        if (!$receiver) {
            Log::warning('MessageController send - Receiver not found');
            return json(['code' => 0, 'msg' => 'Receiver not found']);
        }

        try {
            Log::info('MessageController send - Creating message');
            $message = new Message;
            $message->sender_id = $this->user->id;
            $message->receiver_id = $receiverId;
            $message->content = $content;
            $message->read_status = 0;
            
            if ($message->save()) {
                Log::info('MessageController send - Message saved successfully');
                return json(['code' => 1, 'msg' => 'Message sent successfully', 'data' => $message]);
            } else {
                Log::error('MessageController send - Failed to save message');
                return json(['code' => 0, 'msg' => 'Failed to save message']);
            }
        } catch (\Exception $e) {
            Log::error('MessageController send - Exception: ' . $e->getMessage());
            return json(['code' => 0, 'msg' => 'Failed to send message']);
        }
    }

    // Mark messages as read
    public function markAsRead()
    {
        if (!$this->user) {
            return json(['code' => 0, 'msg' => 'Not logged in']);
        }

        $senderId = input('post.sender_id');
        if (!$senderId) {
            return json(['code' => 0, 'msg' => 'Missing sender ID']);
        }

        try {
            Message::where([
                ['receiver_id', '=', $this->user->id],
                ['sender_id', '=', $senderId],
                ['read_status', '=', 0]
            ])->update(['read_status' => 1]);

            return json(['code' => 1, 'msg' => 'Messages marked as read']);
        } catch (\Exception $e) {
            Log::error('Failed to mark messages as read: ' . $e->getMessage());
            return json(['code' => 0, 'msg' => 'Failed to mark messages as read']);
        }
    }

    // Get unread message count
    public function getUnreadCount()
    {
        if (!$this->user) {
            return json(['code' => 0, 'msg' => 'Not logged in']);
        }

        try {
            $count = Message::where([
                ['receiver_id', '=', $this->user->id],
                ['read_status', '=', 0]
            ])->count();

            return json(['code' => 1, 'data' => ['count' => $count]]);
        } catch (\Exception $e) {
            Log::error('Failed to get unread count: ' . $e->getMessage());
            return json(['code' => 0, 'msg' => 'Failed to get unread count']);
        }
    }

    // Get messages between two users
    public function getMessages()
    {
        if (!$this->user) {
            return json(['code' => 0, 'msg' => 'Not logged in']);
        }

        $otherUserId = input('get.user_id');
        if (!$otherUserId) {
            return json(['code' => 0, 'msg' => 'Missing user ID']);
        }

        try {
            $messages = Message::where(function ($query) use ($otherUserId) {
                $query->where([
                    ['sender_id', '=', $this->user->id],
                    ['receiver_id', '=', $otherUserId]
                ])->whereOr([
                    ['sender_id', '=', $otherUserId],
                    ['receiver_id', '=', $this->user->id]
                ]);
            })
            ->order('created_at', 'asc')
            ->select();

            return json(['code' => 1, 'data' => $messages]);
        } catch (\Exception $e) {
            Log::error('Failed to get messages: ' . $e->getMessage());
            return json(['code' => 0, 'msg' => 'Failed to get messages']);
        }
    }

    // Get recent messages
    public function getRecentMessages()
    {
        if (!$this->user) {
            return json(['code' => 0, 'msg' => 'Not logged in']);
        }

        try {
            $messages = Message::where('sender_id|receiver_id', $this->user->id)
                ->order('created_at', 'desc')
                ->limit(20)
                ->select();

            return json(['code' => 1, 'data' => $messages]);
        } catch (\Exception $e) {
            Log::error('Failed to get recent messages: ' . $e->getMessage());
            return json(['code' => 0, 'msg' => 'Failed to get recent messages']);
        }
    }
}
