<?php

use think\migration\Migrator;
use think\migration\db\Column;

class CreateTables extends Migrator
{
    public function change()
    {
        // Create users table
        $this->table('user', ['engine' => 'InnoDB'])
            ->addColumn('username', 'string', ['limit' => 50])
            ->addColumn('password', 'string', ['limit' => 255])
            ->addColumn('email', 'string', ['limit' => 100])
            ->addColumn('last_login', 'timestamp', ['null' => true])
            ->addColumn('status', 'integer', ['default' => 1])  // 1: active, 0: inactive
            ->addTimestamps()
            ->addIndex(['username'], ['unique' => true])
            ->addIndex(['email'], ['unique' => true])
            ->create();

        // Create messages table
        $this->table('message', ['engine' => 'InnoDB'])
            ->addColumn('sender_id', 'integer')
            ->addColumn('receiver_id', 'integer')
            ->addColumn('content', 'text')
            ->addColumn('read_status', 'integer', ['default' => 0]) // 0: unread, 1: read
            ->addTimestamps()
            ->addForeignKey('sender_id', 'user', 'id', ['delete' => 'CASCADE'])
            ->addForeignKey('receiver_id', 'user', 'id', ['delete' => 'CASCADE'])
            ->create();
    }
}
