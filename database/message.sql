CREATE TABLE IF NOT EXISTS `message` (
    `id` INTEGER PRIMARY KEY AUTOINCREMENT,
    `sender_id` INTEGER NOT NULL,
    `receiver_id` INTEGER NOT NULL,
    `content` TEXT NOT NULL,
    `read_status` INTEGER DEFAULT 0,
    `create_time` DATETIME,
    `update_time` DATETIME,
    FOREIGN KEY (`sender_id`) REFERENCES `user` (`id`),
    FOREIGN KEY (`receiver_id`) REFERENCES `user` (`id`)
);
