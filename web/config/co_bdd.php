<?php
if (file_exists(__DIR__ . '/../../homeqtt.db')) {
    $db = new SQLite3(__DIR__ . '/../../homeqtt.db');
}
else{
    http_response_code(400);
    exit(json_encode("Database doesn't exist"));
}