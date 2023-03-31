<?php
header('Content-Type: application/json'); 
if(isset($_GET["goto"]) && !empty($_GET["goto"])){
    header("Location: ".$_GET["goto"]);
}

session_start();
if(!$_SESSION["login"]){
    http_response_code(401);
    exit(json_encode("You need to login for submiting this form"));
}

if(isset($_POST['name']) && !empty($_POST['name'])){
    $name = $_POST['name'];
}else{
    http_response_code(400);
    exit(json_encode("The room name is missing"));
}

require_once('co_bdd.php');

$room_existQ = $db->prepare("SELECT COUNT(*) FROM rooms WHERE room_name= :name");
$room_existQ->bindValue(':name', $name, SQLITE3_TEXT);
$result = $room_existQ->execute();
$room_exist = $result->fetchArray()[0] > 0;
if($room_exist){
    http_response_code(400);
    exit(json_encode("There is already a room with this name !"));
}

$room_lastorderQ = $db->query('SELECT MAX("order") as max_order FROM rooms');
$result = $room_lastorderQ->fetchArray();
$room_lastorder = $result['max_order'];

if(is_null($room_lastorder)){
    $order = 0;
}else{
    $order = ++$room_lastorder ;
}

$insert = $db->prepare("INSERT INTO rooms ('room_name', 'order') VALUES (:room_name, :order)");
$insert->bindValue('room_name', $name, SQLITE3_TEXT);
$insert->bindValue('order', $order, SQLITE3_INTEGER);
$result = $insert-> execute();