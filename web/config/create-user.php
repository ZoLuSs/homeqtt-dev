<?php
header('Content-Type: application/json'); 
if(isset($_GET["goto"]) && !empty($_GET["goto"])){
    header("Location: ".$_GET["goto"]);
}

require_once('co_bdd.php');

$user_exist = $db->querySingle('SELECT username FROM user');
if(!is_null($user_exist)){
    session_start();
    if(!$_SESSION["login"]){
        http_response_code(401);
        exit(json_encode("You need to login for submiting this form"));
    }
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

$passwordHash = password_hash($password, PASSWORD_DEFAULT);
$insert = $db->prepare("INSERT INTO user ('username', 'password') VALUES (:username,:password)");
$insert->bindValue(':username', $username, SQLITE3_TEXT);
$insert->bindValue(':password', $passwordHash, SQLITE3_BLOB);
$result = $insert-> execute();