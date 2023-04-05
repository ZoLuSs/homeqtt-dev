<?php
ini_set('session.gc_maxlifetime', 14400);

session_start();
if(!$_SESSION["login"]){
    http_response_code(401);
    header("Location: /login");
    exit(json_encode("You need to login for accessing this page !"));
}