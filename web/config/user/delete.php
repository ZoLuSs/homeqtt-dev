<?php
header('Content-Type: application/json'); 
if(isset($_GET["goto"]) && !empty($_GET["goto"])){
    header("Location: ".$_GET["goto"]);
}

require_once(__DIR__.'/../session.php');
require_once(__DIR__.'/../co_bdd.php');

$jsonData = file_get_contents('php://input');
$array = json_decode($jsonData, true);
$userid = $array['userid'];

if(empty($userid)){
    http_response_code(400);
    exit(json_encode("userid is missing"));
}

$userQ = $db->query('SELECT id, username FROM user ORDER BY ID ASC');
while ($row = $userQ->fetchArray()) {
  $countUser++;
}

if($countUser <= 1){
    http_response_code(403);
    exit(json_encode("You can't delete the last user"));
}

$user_deleteQ = $db->prepare('DELETE FROM user WHERE id = :id');
$user_deleteQ->bindValue(':id', $userid);
$result = $user_deleteQ->execute();

if($userid == $_SESSION['userid']){
    include('../../logout.php');
}