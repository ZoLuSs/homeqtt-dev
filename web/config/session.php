<?php
/*
1 min = 60s
1h = 60min = 3600s
2h = 120min = 7200s
4h = 240min = 14400s
24h = 1440min = 86400s
2j = 48h = 2880min = 172800
*/
ini_set('session.gc_maxlifetime', 14400); // Durée d'expiration par PHP (en s) -> Ne sert a rien seul
ini_set('session.cookie_lifetime', 86400); // Durée avant expiration du cookie par le navigateur (en s)

$cookieParams = session_get_cookie_params();
$cookieParams["httponly"] = true;
if(empty($_SERVER['HTTPS'])){
    $cookieParams["secure"] = false;
}else{
    $cookieParams["secure"] = true;
}

session_set_cookie_params($cookieParams["lifetime"], $cookieParams["path"], $cookieParams["domain"], $cookieParams["secure"], $cookieParams["httponly"]);

session_save_path(dirname(dirname(__DIR__)) . '/sessions');

session_start();

if (basename($_SERVER['PHP_SELF']) !== 'login.php') {
    if (isset($_SESSION["login"]) && $_SESSION["login"]) {
    } else {
        $_SESSION = array();
        if (ini_get("session.use_cookies")) {
            $params = session_get_cookie_params();
            setcookie(session_name(), '', time() - 42000,
                $params["path"], $params["domain"],
                $params["secure"], $params["httponly"]
            );
        }
        session_unset(); // Supprime toutes les variables de session
        session_destroy(); // Détruit la session en cours
        http_response_code(401);
        header("Location: /login");
        exit(json_encode("You need to login for accessing this page !"));
    }
} else {
    if (isset($_SESSION["login"]) && $_SESSION["login"]) {
        header("Location: /");
        exit();
    }
}