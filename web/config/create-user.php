<?php
header('Content-Type: application/json'); 
if(isset($_GET["goto"]) && !empty($_GET["goto"])){
    header("Location: ".$_GET["goto"]);
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


if (file_exists('../../homeqtt.db')) {
    $passwordHash = password_hash($password, PASSWORD_DEFAULT);
    $db = new SQLite3('../../homeqtt.db');
    $insert = $db->prepare("INSERT INTO user ('username', 'password') VALUES (:username,:password)");
    $insert->bindValue(':username', $username, SQLITE3_TEXT);
    $insert->bindValue(':password', $passwordHash, SQLITE3_BLOB);
    $result = $insert-> execute();
}else{
    http_response_code(400);
    exit(json_encode("Database doesn't exist"));
}