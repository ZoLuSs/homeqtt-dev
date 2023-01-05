//const mqtt = require('mqtt')
const sqlite3 = require('sqlite3');
const db = require('./lib/database');

new sqlite3.Database('./homeqtt.db', sqlite3.OPEN_READWRITE, (err) => {
    if (err && err.code == "SQLITE_CANTOPEN") {
        console.log("no database detected !");
        console.log("Please, launch the web configuration before running the node app");
        } else if (err) {
            console.error(err);
            process.exit(1);
    }
});