<?php
header('Content-Type: application/json'); 
if(isset($_GET["goto"]) && !empty($_GET["goto"])){
    header("Location: ".$_GET["goto"]);
}

$return_msg = array();

require_once(__DIR__ . '/co_bdd.php');
/* Check if all table are created */
$db_array = array("config", "user","room","light","powermeter");
$tableQ = $db->query("SELECT name FROM sqlite_schema WHERE type = 'table' AND name NOT LIKE 'sqlite_%'");

$results_array = array();
while ($row = $tableQ->fetchArray()) {
    $results_array[] = $row[0];
}
$compare = array_diff($db_array,$results_array);
if(empty($compare)){
    array_push($return_msg,"Database: OK");

    /* Check if all MQTT config are created (no check if there are empty !) */
    $mqtt_array = array("mqtt_protocol","mqtt_tls","mqtt_check_cert","mqtt_broker","mqtt_port","mqtt_username","mqtt_password");
    $mqttQ = $db->query("SELECT name, value FROM config WHERE name LIKE 'mqtt%'");
    $mqtt_results_array = array();
    while ($row = $mqttQ->fetchArray()) {
        $mqtt_results_array[] = $row[0];
    }
    $compare_mqtt = array_diff($mqtt_array,$mqtt_results_array);
    if(empty($compare_mqtt)){
        array_push($return_msg,"MQTT config: OK");
    }
    else{
        http_response_code(400);
        array_push($return_msg,"MQTT config: Error missing ".count($compare_mqtt)." info");
    }
    /* Check if there is at least one user created */
    $userQ = $db->query("SELECT * FROM user");
    $user = $userQ->fetchArray();
    while ($row = $userQ->fetchArray()) {
    }
    if($user){
        array_push($return_msg,"User created: OK");
    }
    else{
        http_response_code(400);
        array_push($return_msg,"User created: Error no user detected");
    }
}
else{
    http_response_code(400);
    array_push($return_msg,"Database: Error missing ".count($compare)." table");
}

$status = exec("sudo systemctl is-active homeqtt");
if($status == "active"){
    array_push($return_msg, "HomeQTT is running !");
}
else{
    exec("sudo systemctl start homeqtt");
    exec("sudo systemctl enable homeqtt");
    $status = exec("sudo systemctl is-active homeqtt");
    if($status == "active"){
        array_push($return_msg, "HomeQTT is running !");
    }
    else{
        http_response_code(400);
        array_push($return_msg,"HomeQTT can't be started. Status returned: ".$status);
    }
}

echo json_encode($return_msg);