//const mqtt = require('mqtt')
const process = require('process')
process.chdir(__dirname)
const sqlite3 = require('sqlite3');
const db = require('./lib/database');
const { Server } = require("socket.io");
const { instrument } = require("@socket.io/admin-ui");
const jwt = require('jsonwebtoken');

const io = new Server({ /* options */ });

new sqlite3.Database('homeqtt.db', sqlite3.OPEN_READONLY, (err) => {
    if (err && err.code == "SQLITE_CANTOPEN") {
      console.log(err);
        console.log("no database detected !");
        console.log("Please, launch the web configuration before running the node app");
        } else if (err) {
            console.error(err);
            process.exit(1);
    } else{
      console.log("Database connected !");
    }
});

io.on("connection", (socket) => {
  console.log("Socket connection");
});

io.use(function(socket, next){
  console.log("IO");
    if (socket.handshake.query && socket.handshake.query.token){
      console.log("Handshake");
      jwt.verify(socket.handshake.query.token, 'SECRET_KEY', function(err, decoded) {
        if (err) return next(new Error('Authentication error 1'));
        console.log("Check Token: ");
        socket.decoded = decoded;
        console.log(decoded);
        next();
      });
    }
    else {
      next(new Error('Authentication error 2'));
    }    
  }).on('connection', function(socket) {
      // Connection now authenticated to receive further events
  console.log("Connection");
      socket.on('message', function(message) {
          io.emit('message', message);
      });
  });

  instrument(io, {
    auth: false,
    mode: "development",
  });

io.listen(4002);