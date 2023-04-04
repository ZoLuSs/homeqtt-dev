<?php
header('Content-Type: application/json'); 
if(isset($_GET["goto"]) && !empty($_GET["goto"])){
    header("Location: ".$_GET["goto"]);
}

if (!file_exists('../../homeqtt.db')) {
    $db = new SQLite3('../../homeqtt.db');

    // Création de la table "user"
    $db->exec('CREATE TABLE "user" (
        "id" INTEGER PRIMARY KEY AUTOINCREMENT,
        "username" TEXT,
        "password" BLOB
    )');
    
    // Création de la table "config"
    $db->exec('CREATE TABLE "config" (
        "id" INTEGER PRIMARY KEY AUTOINCREMENT,
        "name" TEXT,
        "value" BLOB
    )');
    
    $db->exec("CREATE TABLE rooms (
        room_id INTEGER PRIMARY KEY,
        room_name TEXT,
        'order' INTEGER
    )");

    // Ajout de la contrainte d'unicité sur la colonne room_name
    $db->exec("ALTER TABLE rooms ADD CONSTRAINT unique_room_name UNIQUE (room_name);");

    // Table "Accessories"
    $db->exec("CREATE TABLE accessories (
        accessory_id INTEGER PRIMARY KEY,
        accessory_name TEXT,
        accessory_type TEXT,
        accessory_type_detail TEXT,
        accessory_icon TEXT,
        room_id INTEGER,
        FOREIGN KEY (room_id) REFERENCES rooms(room_id)
    )");

    // Table "Topics"
    $db->exec("CREATE TABLE topics (
        topic_id INTEGER PRIMARY KEY,
        topic_name TEXT,
        topic_type TEXT,
        payload_formatter TEXT,
        accessory_id INTEGER,
        FOREIGN KEY (accessory_id) REFERENCES accessories(accessory_id)
    )");

    // Table "Parameters"
    $db->exec("CREATE TABLE parameters (
        parameters_id INTEGER PRIMARY KEY,
        parameters_name TEXT,
        parameters_value TEXT,
        accessory_id INTEGER,
        FOREIGN KEY (accessory_id) REFERENCES accessories(accessory_id)
    )");

    // Table "Values"
    $db->exec("CREATE TABLE 'values' (
        value_id INTEGER PRIMARY KEY,
        value_name TEXT,
        value TEXT,
        accessory_id INTEGER,
        timestamp INTEGER,
        topic_id INTEGER,
        FOREIGN KEY (topic_id) REFERENCES topics(topic_id)
    )");
    
    // Insertion de la clé JWT
    $JWT_KEY = bin2hex(random_bytes(64));
    $insert = $db->prepare("INSERT INTO config ('name', 'value') VALUES ('JWT_KEY',:JWT_KEY)");
    $insert->bindValue('JWT_KEY', $JWT_KEY, SQLITE3_BLOB);
    $result = $insert->execute();
    
    // Fermeture de la base de données
    $db->close();
}
else{
    http_response_code(500);
    echo json_encode("Can't create database: Database already exist");
}