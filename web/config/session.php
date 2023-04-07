<?php
ini_set('session.gc_maxlifetime', 14400);
session_cache_expire(14400);
session_start();
if(isset($_SESSION["login"])){
    if(!$_SESSION["login"]){
        http_response_code(401);
        header("Location: /login");
        exit(json_encode("You need to login for accessing this page !"));
    }
}
else{
    http_response_code(401);
    header("Location: /login");
    exit(json_encode("Session variable has been delete !"));
}


echo "gc_maxlifetime: " . ini_get('session.gc_maxlifetime') . " / session.cookie_lifetime: " . ini_get('session.cookie_lifetime') . " / session.gc_probability: " .  ini_get('session.gc_probability') . " / session.gc_divisor: " .  ini_get('session.gc_divisor') . " / session.save_path: " .  ini_get('session.save_path');
echo var_dump('session');