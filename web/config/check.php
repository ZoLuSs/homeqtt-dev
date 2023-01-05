<?php
header('Content-Type: application/json'); 
if(isset($_GET["goto"]) && !empty($_GET["goto"])){
    header("Location: ".$_GET["goto"]);
}

if (file_exists('../../homeqtt.db')) {
    $db = new SQLite3('../../homeqtt.db');
    $results = $db->query("SELECT name FROM sqlite_schema WHERE type = 'table' AND name NOT LIKE 'sqlite_%'");
    while ($row = $results->fetchArray()) {
        echo $row["name"];
    }
   
}else{
    http_response_code(400);
    exit(json_encode("Database doesn't exist"));
}