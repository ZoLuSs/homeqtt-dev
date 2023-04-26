<?php
header('Content-Type: application/json'); 
if(isset($_GET["goto"]) && !empty($_GET["goto"])){
    header("Location: ".$_GET["goto"]);
}

require_once(__DIR__.'/../session.php');
require_once(__DIR__.'/../co_bdd.php');

$jsonData = file_get_contents('php://input');
$array = json_decode($jsonData, true);
$roomid = $array['roomid'];

if(empty($roomid)){
    http_response_code(400);
    exit(json_encode("roomid is missing"));
}

$accessoryQ = $db->prepare('SELECT * FROM accessories WHERE room_id = :room_id');
$accessoryQ->bindValue(':room_id', $roomid);
$result = $accessoryQ->execute();
while ($row = $result->fetchArray()) {
    $countAccessory++;
  }
  
if($countAccessory > 0){
    http_response_code(403);
    exit(json_encode("You can't delete a room with accessory"));
}

$room_deleteQ = $db->prepare('DELETE FROM rooms WHERE room_id = :room_id');
$room_deleteQ->bindValue(':room_id', $roomid);
$result = $room_deleteQ->execute();