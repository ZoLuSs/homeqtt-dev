<?php
header('Content-Type: application/json'); 
if(isset($_GET["goto"]) && !empty($_GET["goto"])){
    header("Location: ".$_GET["goto"]);
}

$return_msg = array();

if (file_exists('../../homeqtt.db')) {
    /* Check if all table are created */
    $db_array = array("config", "user","icons","room","light","powermeter");
    $db = new SQLite3('../../homeqtt.db');
    $tableQ = $db->query("SELECT name FROM sqlite_schema WHERE type = 'table' AND name NOT LIKE 'sqlite_%'");

    $results_array = array();
    while ($row = $tableQ->fetchArray()) {
        $results_array[] = $row[0];
    }
    $compare = array_diff($db_array,$results_array);
    if(empty($compare)){
        array_push($return_msg,"Database: OK");

        /* Check if all MQTT config are created (no check if there are empty !) */
        $mqtt_array = array("mqtt_protocol","mqtt_tls","mqtt_host","mqtt_port","mqtt_username","mqtt_password");
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
   
}else{
    http_response_code(400);
    array_push($return_msg,"Database: Error no database found");
}

$test = json_encode($return_msg);
echo $test;

$test2 = exec("pm2 pid homeqtt");
echo $test2;

$starthomeqtt = exec("pm2 start app.js --name homeqtt");
echo $starthomeqtt;

$test2 = exec("pm2 pid homeqtt");
echo $test2;