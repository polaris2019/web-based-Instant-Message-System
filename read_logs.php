<?php
$logFile = __DIR__ . '/runtime/log/202412/23.log';
if (file_exists($logFile)) {
    echo file_get_contents($logFile);
} else {
    echo "Log file not found: $logFile";
}
