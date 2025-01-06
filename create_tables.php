<?php
try {
    $db = new PDO('sqlite:' . __DIR__ . '/database/database.db');
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Create message table
    $sql = file_get_contents(__DIR__ . '/database/message.sql');
    $db->exec($sql);
    echo "Message table created successfully\n";

} catch(PDOException $e) {
    echo "Error: " . $e->getMessage() . "\n";
}
