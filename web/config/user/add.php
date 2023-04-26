<?php
header('Content-Type: application/json'); 
if(isset($_GET["goto"]) && !empty($_GET["goto"])){
    header("Location: ".$_GET["goto"]);
}

require_once(__DIR__.'/../session.php');
require_once(__DIR__.'/../co_bdd.php');

if(isset($_POST['username']) && !empty($_POST['username'])){
    $username = $_POST['username'];
}else{
    http_response_code(400);
    exit(json_encode("Username is missing"));
}

if(isset($_POST['password']) && !empty($_POST['password'])){
    $password = $_POST['password'];
}else{
    http_response_code(400);
    exit(json_encode("The password is missing"));
}

$user_existQ = $db->prepare('SELECT username FROM user WHERE username = :username');
$user_existQ->bindValue(':username', $username, SQLITE3_TEXT);
$result = $user_existQ->execute();
$user_exist = $result->fetchArray()[0] > 0;
if($user_exist){
    http_response_code(400);
    exit(json_encode("This username is already used"));
}

$passwordHash = password_hash($password, PASSWORD_BCRYPT);
$insert = $db->prepare("INSERT INTO user ('username', 'password') VALUES (:username,:password)");
$insert->bindValue(':username', $username, SQLITE3_TEXT);
$insert->bindValue(':password', $passwordHash, SQLITE3_BLOB);
$result = $insert-> execute();