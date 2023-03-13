<?php
header('Content-Type: application/json'); 
if(isset($_GET["goto"]) && !empty($_GET["goto"])){
    header("Location: ".$_GET["goto"]);
}

$db = new SQLite3(__DIR__ . '/../../homeqtt.db');

$house_exist = $db->querySingle("SELECT name, value FROM config WHERE name LIKE 'house_%'");
if(!is_null($house_exist)){
    http_response_code(400);
    exit(json_encode("House exist, nothing to do here."));
}

if(isset($_POST['housename']) && !empty($_POST['housename'])){
    $housename = $_POST['housename'];
}else{
    http_response_code(400);
    exit(json_encode("The house name is missing"));
}

require_once('co_bdd.php');

$insert = $db->prepare("INSERT INTO config ('name', 'value') VALUES ('house_name',:house_name)");
$insert->bindValue('house_name', $housename, SQLITE3_TEXT);
$result = $insert-> execute();