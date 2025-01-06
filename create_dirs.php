<?php
// Create directories if they don't exist
$dirs = [
    __DIR__ . '/app/view/chat',
];

foreach ($dirs as $dir) {
    if (!is_dir($dir)) {
        mkdir($dir, 0777, true);
        echo "Created directory: $dir\n";
    }
}

// Move chat view file if it exists in the wrong location
$oldPath = __DIR__ . '/view/chat/index.html';
$newPath = __DIR__ . '/app/view/chat/index.html';

if (file_exists($oldPath)) {
    if (!file_exists($newPath)) {
        copy($oldPath, $newPath);
        echo "Copied file from $oldPath to $newPath\n";
    }
    unlink($oldPath);
    echo "Deleted old file: $oldPath\n";
}
