//const mqtt = require('mqtt')
const sqlite3 = require('sqlite3');
const db = require('./lib/database');

new sqlite3.Database('./homeqtt.db', sqlite3.OPEN_READWRITE, (err) => {
    if (err && err.code == "SQLITE_CANTOPEN") {
        db.createDatabase();
        console.log("Database created !");
        return;
        } else if (err) {
            console.error(err);
            process.exit(1);
    }
});