const sqlite3 = require('sqlite3');

var db = {/*
    createDatabase: function() {
        var newdb = new sqlite3.Database('homeqtt.db', (err) => {
            if (err) {
                console.error(err);
                process.exit(1);
            }
            newdb.exec(`
            CREATE TABLE "user" (
                "id"    INTEGER,
                "username"  TEXT,
                "password"  TEXT,
            )

            CREATE TABLE "room" (
                "id"	INTEGER,
                "name"	TEXT,
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
                "id"	INTEGER,
                "icon"	INTEGER,
                "type"	TEXT,
                "getVolt"	TEXT,
                "getAmpere"	TEXT,
                "getWatt"	TEXT,
                "getHertz"	TEXT,
                "getVoltampere"	TEXT,
                "getConsumption"	TEXT,
                "volt"	INTEGER,
                "ampere"	INTEGER,
                "watt"	INTEGER,
                "hertz"	INTEGER,
                "consumption"	INTEGER,
                PRIMARY KEY("id" AUTOINCREMENT)
            );
                `, (err) => {
                    if (err) {
                        console.error(err);
                        process.exit(1);
                    }
                });
        });
    }*/
};

module.exports=db;