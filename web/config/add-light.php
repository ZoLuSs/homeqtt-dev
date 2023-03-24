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
    exit(json_encode("Accessory name missing"));
}

if(isset($_POST['room']) && !empty($_POST['room'])){
    $room = $_POST['room'];
}else{
    http_response_code(400);
    exit(json_encode("Room is missing"));
}

if(isset($_POST['type']) && !empty($_POST['type'])){
    $type = $_POST['type'];
}else{
    http_response_code(400);
    exit(json_encode("Room is missing"));
}

if(isset($_POST['setOn']) && !empty($_POST['setOn'])){
    $setOn = $_POST['setOn'];
}else{
    http_response_code(400);
    exit(json_encode("setOn is missing"));
}

if(isset($_POST['getOn']) && !empty($_POST['getOn'])){
    $getOn = $_POST['getOn'];
}else{
    http_response_code(400);
    exit(json_encode("getOn is missing"));
}

if(isset($_POST['payloadOn']) && !empty($_POST['payloadOn'])){
    $payloadOn = $_POST['payloadOn'];
}else{
    http_response_code(400);
    exit(json_encode("payloadOn is missing"));
}

if(isset($_POST['payloadOff']) && !empty($_POST['payloadOff'])){
    $payloadOff = $_POST['payloadOff'];
}else{
    http_response_code(400);
    exit(json_encode("payloadOff is missing"));
}


require_once('co_bdd.php');

$insert = $db->prepare("INSERT INTO light ('name', 'room', 'type', 'icon', 'getOn', 'setOn', 'payloadOn', 'payloadOff') VALUES (:name, :room, :type, :icon, :getOn, :setOn, :payloadOn, :payloadOff)");
$insert->bindValue('name', $name, SQLITE3_TEXT);
$insert->bindValue('room', $room, SQLITE3_INTEGER);
$insert->bindValue('type', $type, SQLITE3_TEXT);
$insert->bindValue('icon', "lightbulb", SQLITE3_TEXT);
$insert->bindValue('getOn', $getOn, SQLITE3_TEXT);
$insert->bindValue('setOn', $setOn, SQLITE3_TEXT);
$insert->bindValue('payloadOn', $payloadOn, SQLITE3_TEXT);
$insert->bindValue('payloadOff', $payloadOff, SQLITE3_TEXT);
$result = $insert-> execute();