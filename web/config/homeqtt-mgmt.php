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

function restart_homeqtt(){
    exec("sudo systemctl restart homeqtt");
    $status = exec("sudo systemctl is-active homeqtt");
    if($status == "active"){
    }
    else{
        http_response_code(400);
        exit(json_encode("HomeQTT can't be started. Status returned: "));
    }
}