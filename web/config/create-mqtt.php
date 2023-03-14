<?php
header('Content-Type: application/json'); 
if(isset($_GET["goto"]) && !empty($_GET["goto"])){
    header("Location: ".$_GET["goto"]);
}

require_once('co_bdd.php');

$mqtt_set = $db->querySingle('SELECT value FROM config WHERE name="mqtt_protocol"');
if(!is_null($mqtt_set)){
    http_response_code(400);
    exit(json_encode("MQTT already configured"));
}

if(isset($_POST['protocol']) && !empty($_POST['protocol'])){
    if($_POST['protocol'] == "mqtt" || $_POST['protocol'] == "ws"){
        $protocol = $_POST['protocol'];
    }else{
        http_response_code(400);
        exit(json_encode("This protocol is not allowed"));
    }
}else{
    http_response_code(400);
    exit(json_encode("The protocol is missing"));
}

if(isset($_POST['tls'])){
    $tls = "true";
}else{
    $tls = "false";
}

if(isset($_POST['check_cert'])){
    $check_cert = "true";
}else{
    $check_cert = "false";
}

if(isset($_POST['broker']) && !empty($_POST['broker'])){
    $broker = $_POST['broker'];
}else{
    http_response_code(400);
    exit(json_encode("The broker is missing"));
}

if(isset($_POST['port']) && !empty($_POST['port'])){
    if(is_numeric($_POST['port'])){
        $port = $_POST['port'];
    }
    else{
        http_response_code(400);
        exit(json_encode("The port is not a numeric value"));
    }
}else{
    http_response_code(400);
    exit(json_encode("The port is missing"));
}

if(isset($_POST['username']) && !empty($_POST['username'])){
    $username = $_POST['username'];
}else{
    http_response_code(400);
    exit(json_encode("The username is missing"));
}

if(isset($_POST['password']) && !empty($_POST['password'])){
    $password = $_POST['password'];
}else{
    http_response_code(400);
    exit(json_encode("The password is missing"));
}

$insert = $db->prepare("INSERT INTO config ('name', 'value') VALUES ('mqtt_protocol',:protocol),('mqtt_tls',:tls),('mqtt_check_cert',:check_cert),('mqtt_broker',:broker),('mqtt_port',:port), ('mqtt_username',:username), ('mqtt_password',:password)");
$insert->bindValue('protocol', $protocol, SQLITE3_TEXT);
$insert->bindValue('tls', $tls, SQLITE3_BLOB);
$insert->bindValue('check_cert', $check_cert, SQLITE3_BLOB);
$insert->bindValue('broker', $broker, SQLITE3_BLOB);
$insert->bindValue('port', $port, SQLITE3_BLOB);
$insert->bindValue('username', $username, SQLITE3_BLOB);
$insert->bindValue('password', $password, SQLITE3_BLOB);
$result = $insert-> execute();