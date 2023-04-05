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
    $room_id = $_POST['room'];
}else{
    http_response_code(400);
    exit(json_encode("Room is missing"));
}

if(isset($_POST['type']) && !empty($_POST['type'])){
    $type_detail = $_POST['type'];
}else{
    http_response_code(400);
    exit(json_encode("Type is missing"));
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

if(isset($_POST['payloadFormatter']) && !empty($_POST['payloadFormatter'])){
    $payloadFormatter = $_POST['payloadFormatter'];
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
/*
$topic_usedQ = $db->prepare("SELECT COUNT(*) FROM light WHERE getOn= :getOn");
$topic_usedQ->bindValue(':getOn', $getOn, SQLITE3_TEXT);
$result = $topic_usedQ->execute();
$topic_used = $result->fetchArray()[0] > 0;
if($topic_used){
    http_response_code(400);
    exit(json_encode("There is already a topic that use this getOn topic"));
}

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
*/

// Préparation de la requête d'insertion dans la table Accessories
$insertAccessory = $db->prepare('INSERT INTO accessories (accessory_name, accessory_type, accessory_type_detail, room_id) VALUES (:accessory_name, :accessory_type, :accessory_type_detail, :room_id)');

// Liaison des valeurs à insérer avec les paramètres de la requête
$insertAccessory->bindValue(':accessory_name', $name);
$insertAccessory->bindValue(':accessory_type', 'light');
$insertAccessory->bindValue(':accessory_type_detail', $type_detail);
$insertAccessory->bindValue(':room_id', $room_id);
$insertAccessory->execute();
// Récupération de l'identifiant de l'accessoire inséré
$accessoryId = $db->lastInsertRowID();

/// Add topic getOn
$insertTopic = $db->prepare('INSERT INTO topics (topic_name, topic_type, payload_formatter, accessory_id) VALUES (:topic_name, :topic_type, :payload_formatter, :accessory_id)');
$insertTopic->bindValue(':topic_name', $getOn);
$insertTopic->bindValue(':topic_type', 'getOn');
if(isset($payloadFormatter)){
    $insertTopic->bindValue(':payload_formatter', $payloadFormatter);
}else{
    $insertTopic->bindValue(':payload_formatter', null, SQLITE3_NULL);
}
$insertTopic->bindValue(':accessory_id', $accessoryId);
$insertTopic->execute();
// Récupération de l'identifiant de l'accessoire inséré
$topicId = $db->lastInsertRowID();

/// Add topic setOn
$insertTopic = $db->prepare('INSERT INTO topics (topic_name, topic_type, accessory_id) VALUES (:topic_name, :topic_type, :accessory_id)');
$insertTopic->bindValue(':topic_name', $setOn);
$insertTopic->bindValue(':topic_type', 'setOn');
$insertTopic->bindValue(':accessory_id', $accessoryId);
$insertTopic->execute();

/// Add parameters
$insertParameter = $db->prepare('INSERT INTO parameters (parameters_name, parameters_value, accessory_id) VALUES (:parameters_name, :parameters_value, :accessory_id)');
$insertParameter->bindValue(':parameters_name', 'payloadOn');
$insertParameter->bindValue(':parameters_value', $payloadOn);
$insertParameter->bindValue(':accessory_id', $accessoryId);
$insertParameter->execute();
$insertParameter = $db->prepare('INSERT INTO parameters (parameters_name, parameters_value, accessory_id) VALUES (:parameters_name, :parameters_value, :accessory_id)');
$insertParameter->bindValue(':parameters_name', 'payloadOff');
$insertParameter->bindValue(':parameters_value', $payloadOff);
$insertParameter->bindValue(':accessory_id', $accessoryId);
$insertParameter->execute();

/// Add value
$insertParameter = $db->prepare('INSERT INTO "values" (value_name, value, accessory_id, timestamp, topic_id) VALUES (:value_name, :value, :accessory_id, :timestamp, :topic_id)');
$insertParameter->bindValue(':value_name', "on");
$insertParameter->bindValue(':value', 0);
$insertParameter->bindValue(':accessory_id', $accessoryId);
$insertParameter->bindValue(':parameters_value', $payloadOn);
$insertParameter->bindValue(':topic_id', $topicId);
$insertParameter->execute();

require_once(__DIR__.'/homeqtt-mgmt.php');
restart_homeqtt();