<?php
header('Content-Type: application/json'); 
if(isset($_GET["goto"]) && !empty($_GET["goto"])){
    header("Location: ".$_GET["goto"]);
}

if (!file_exists('../../homeqtt.db')) {
    $db = new SQLite3('../../homeqtt.db');
    $tables = 'CREATE TABLE "user" (
        "id"    INTEGER,
        "username"  TEXT,
        "password"  BLOB,
		PRIMARY KEY("id" AUTOINCREMENT)
    );
    CREATE TABLE "config" (
        "id"    INTEGER,
        "name"  TEXT,
        "value"  BLOB,
		PRIMARY KEY("id" AUTOINCREMENT)
    );
    CREATE TABLE "room" (
        "id"	        INTEGER,
        "name"	        TEXT,
        "background"	TEXT,
        PRIMARY KEY("id" AUTOINCREMENT)
    );
    CREATE TABLE "icons" (
        "id"	INTEGER,
        "name"	INTEGER,
        "svg"	BLOB,
        PRIMARY KEY("id" AUTOINCREMENT)
    );
    CREATE TABLE "light" (
        "id"	INTEGER,
        "type"	TEXT,
        "icon"	INTEGER,
        "getOn"	TEXT,
        "setOn"	TEXT,
        "on"    INTEGER,
        PRIMARY KEY("id" AUTOINCREMENT)
    );
    CREATE TABLE "powermeter" (
        "id"	            INTEGER,
        "icon"	            INTEGER,
        "type"	            TEXT,
        "getVolt"	        TEXT,
        "getAmpere"	        TEXT,
        "getWatt"	        TEXT,
        "getHertz"	        TEXT,
        "getVoltampere"	    TEXT,
        "getConsumption"    TEXT,
        "volt"	            INTEGER,
        "ampere"	        INTEGER,
        "watt"	            INTEGER,
        "hertz"	            INTEGER,
        "voltampere"	    INTEGER,
        "consumption"	    INTEGER,
        PRIMARY KEY("id" AUTOINCREMENT)
    );';
    $db->exec($tables);
    $JWT_KEY = bin2hex(random_bytes(64));
    $insert = $db->prepare("INSERT INTO config ('name', 'value') VALUES ('JWT_KEY',:JWT_KEY)");
    $insert->bindValue('JWT_KEY', $JWT_KEY, SQLITE3_BLOB);
    $result = $insert-> execute();
}
else{
    http_response_code(500);
    echo json_encode("Can't create database: Database already exist");
}