const mqtt = require('mqtt')
const process = require('process')
process.chdir(__dirname)
const sqlite3 = require('sqlite3');
const { Server } = require("socket.io");
//const { instrument } = require("@socket.io/admin-ui");
const jwt = require('jsonwebtoken');

const io = new Server({ /* options */ });
var JWT_KEY;
var db = new sqlite3.Database('homeqtt.db', sqlite3.OPEN_READWRITE, (err) => {
    if (err && err.code == "SQLITE_CANTOPEN") {
      console.log(err);
        console.log("no database detected !");
        console.log("Please, launch the web configuration before running the node app");
        } else if (err) {
            console.error(err);
            process.exit(1);
    } else{
      console.log("Database connected !");
      db.get('SELECT value FROM config WHERE name = "JWT_KEY"', (err, row) => {
        if ( err ) {
          console.log(err.message);
        }          
        JWT_KEY = row.value.toString();
      });

    }
});

io.use(function(socket, next){
  if (socket.handshake.query && socket.handshake.query.token){
    jwt.verify(socket.handshake.query.token, JWT_KEY, function(err, decoded) {
      if (err) return next(new Error('Authentication error'));
      socket.decoded = decoded;
      console.log(socket.decoded);
      next();
    });
  }
  else {
    next(new Error('Authentication error'));
  }    
})
.on('connection', function(socket) {
    // Connection now authenticated to receive further events
    socket.on('message', function(message) {
        io.emit('message', message);
    });
});

io.listen(4002);