<?php
header('Content-Type: application/json'); 
if(isset($_GET["goto"]) && !empty($_GET["goto"])){
    header("Location: ".$_GET["goto"]);
}

require_once(__DIR__.'/../session.php');

$jsonData = file_get_contents('php://input');
$array = json_decode($jsonData, true);

if(empty($array)){
    http_response_code(400);
    exit(json_encode("No data have been sent"));
}

require_once(__DIR__.'/../co_bdd.php');

foreach($array as $data) {
    $room_existQ = $db->prepare("UPDATE rooms SET `order` = :order WHERE room_name = :name");
    $room_existQ->bindValue(':name', $data[0], SQLITE3_TEXT);
    $room_existQ->bindValue(':order', $data[1], SQLITE3_INTEGER);
    $result = $room_existQ->execute();
}