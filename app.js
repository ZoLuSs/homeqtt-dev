//const mqtt = require('mqtt')
const sqlite3 = require('sqlite3');
const db = require('./lib/database');
const { Server } = require("socket.io");
const jwt = require('jsonwebtoken');
const io = new Server({ /* options */ });

new sqlite3.Database('./homeqtt.db', sqlite3.OPEN_READWRITE, (err) => {
    if (err && err.code == "SQLITE_CANTOPEN") {
        console.log("no database detected !");
        console.log("Please, launch the web configuration before running the node app");
        } else if (err) {
            console.error(err);
            process.exit(1);
    }
});

io.use(function(socket, next){
    if (socket.handshake.query && socket.handshake.query.token){
      jwt.verify(socket.handshake.query.token, 'SECRET_KEY', function(err, decoded) {
        if (err) return next(new Error('Authentication error 1'));
        socket.decoded = decoded;
        next();
      });
    }
    else {
      next(new Error('Authentication error 2'));
    }    
  })
  .on('connection', function(socket) {
      // Connection now authenticated to receive further events
  
      socket.on('message', function(message) {
          io.emit('message', message);
      });
  });

io.listen(4002);