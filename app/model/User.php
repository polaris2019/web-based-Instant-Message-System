<?php

namespace app\model;

use think\Model;

class User extends Model
{
    // Define the table name if it differs from the class name
    protected $name = 'user';

    // Define the primary key if it differs from 'id'
    protected $pk = 'id';

    // Enable auto timestamp fields
    protected $autoWriteTimestamp = true;

    // Define the fields that can be mass-assigned
    protected $fillable = ['username', 'password', 'email', 'last_login', 'status'];

    // Hide sensitive fields from JSON/array output
    protected $hidden = ['password'];

    // Define any type conversion
    protected $type = [
        'id'         => 'integer',
        'status'     => 'integer',
        'last_login' => 'datetime',
    ];

    // Get messages sent by this user
    public function sentMessages()
    {
        return $this->hasMany(Message::class, 'sender_id');
    }

    // Get messages received by this user
    public function receivedMessages()
    {
        return $this->hasMany(Message::class, 'receiver_id');
    }

    // Update last login time
    public function updateLastLogin()
    {
        $this->last_login = date('Y-m-d H:i:s');
        $this->save();
    }

    // Get unread message count
    public function getUnreadMessageCount()
    {
        return Message::where([
            ['receiver_id', '=', $this->id],
            ['read_status', '=', 0]
        ])->count();
    }

    // Get recent conversations
    public function getRecentConversations($limit = 20)
    {
        return Message::getRecentConversations($this->id, $limit);
    }

    // Verify password
    public function verifyPassword($password)
    {
        return password_verify($password, $this->password);
    }
}
