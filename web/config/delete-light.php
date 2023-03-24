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

if(isset($_GET['id']) && !empty($_GET['id'])){
    $id = $_GET['id'];
}else{
    http_response_code(400);
    exit(json_encode("Accessory id missing"));
}

require_once('co_bdd.php');

$topic_usedQ = $db->prepare("SELECT COUNT(*) FROM light WHERE id= :id");
$topic_usedQ->bindValue(':id', $id, SQLITE3_TEXT);
$result = $topic_usedQ->execute();
$topic_used = $result->fetchArray()[0] > 0;
if(!$topic_used){
    http_response_code(400);
    exit(json_encode("There is no light with this id"));
}

$delete = $db->prepare("DELETE FROM light WHERE id = :id");
$delete->bindValue('id', $id, SQLITE3_INTEGER);

// Exécution de la requête préparée
$result = $delete->execute();

// Vérification de la suppression
if ($db->changes() > 0) {
    echo "La ligne a été supprimée avec succès.";
} else {
    echo "Erreur lors de la suppression de la ligne.";
}

// Fermeture de la connexion à la base de données
$db->close();

require_once(__DIR__.'/homeqtt-mgmt.php');
restart_homeqtt();