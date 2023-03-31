const mqtt = require('mqtt');
const process = require('process');
process.chdir(__dirname);
const sqlite3 = require('sqlite3');
const { Server } = require("socket.io");
const jwt = require('jsonwebtoken');
const database = require('./lib/database');

const io = new Server({ /* options */ });
let JWT_KEY;

const db = new sqlite3.Database('homeqtt.db', sqlite3.OPEN_READWRITE, (err) => {
  if (err && err.code == "SQLITE_CANTOPEN") {
    console.log(err);
    console.log("no database detected !");
    console.log("Please, launch the web configuration before running the node app");
  } else if (err) {
    console.error(err);
    process.exit(1);
  } else {
    console.log("Database connected !");
    db.get('SELECT value FROM config WHERE name = "JWT_KEY"', (err, row) => {
      if (err) {
        console.log(err.message);
      }
      JWT_KEY = row.value.toString();
    });
  }
});

io.use(function(socket, next){
  if (socket.handshake.query && socket.handshake.query.token){
    jwt.verify(socket.handshake.query.token, JWT_KEY, function(err, decoded) {
      if (err) {
        return next(new Error('Authentication error'));
      }
      socket.decoded = decoded;
      next();
    });
  } else {
    next(new Error('Authentication error'));
  }    
})
.on('connection', function(socket) {
  // Connection now authenticated to receive further events
  socket.on('message', function(message) {
    io.emit('message', message);
  });

  socket.on('getStatus', async function(message) {
    console.log('getStatus:', message);
      // Analyse de la donnée reçue par websocket pour extraire les IDs des lumières
      //const receivedData = JSON.parse(message);
      /*const receivedData = message;
      const receivedLightIds = receivedData.light.map(item => item.id); 

      // Récupération de la liste de toutes les lumières depuis la base de données
      const lightStatus = {};
      //console.log(receivedData);
      console.log(receivedLightIds);

        await db.all(`SELECT id, status FROM light WHERE id IN (${receivedLightIds.join(',')})`, (err, rows) => {
            rows.forEach((row) => {
              lightStatus[row.id] = {
                id: row.id,
                value: row.status
              };
            });
          
        });

        // Envoyer les données
        message.light.forEach((light) => {
          const status = lightStatus[light.id];
          if (status) {
            io.emit('light', status);
          }
        });*/

  })
});

io.listen(4002);

async function getMqttConfig() {
  return new Promise((resolve, reject) => {
    db.all('SELECT * FROM config', (err, rows) => {
      if (err) {
        reject(err);
      } else {
        const configDB = {};
        rows.forEach(function(row) {
          configDB[row.name.toString()] = row.value.toString();
        });

        const config = {
          url: `${configDB.mqtt_protocol}://${configDB.mqtt_broker}:${configDB.mqtt_port}`,
          options: {
            clientId: 'homeqtt',
            username: configDB.mqtt_username,
            password: configDB.mqtt_password,
            rejectUnauthorized: !Boolean(configDB.mqtt_check_cert),
          },
        };
        resolve(config);
      }
    });
  });
}

async function getAllTopic() {
  return new Promise((resolve, reject) => {
    var topics = [];
    db.all("SELECT * FROM topics WHERE topic_type LIKE 'get%'", (err, rows) => {
      if (err) {
        console.error(err.message);
      }
      rows.forEach((row) => {
        topics.push(row.topic_name);
      });
    });

    /*db.all("SELECT id, getOn, payloadOn, payloadOff FROM light", function(err, rows) {
      if (err) {
        console.error(err.message);
      } else {
        // Parcours de toutes les valeurs "getOn" de la table
        rows.forEach(function(row) {
          // Création du topic MQTT correspondant à la valeur "getOn"
          topic.light.push([row.id, row.getOn, row.payloadOn, row.payloadOff]);
        });
        resolve(topic);
      }
    });*/
    resolve(topics);
  });
}

(async function() {
  try {
    const config = await getMqttConfig();
    const allTopic = await getAllTopic();
    const client = mqtt.connect(config.url, config.options);
    //console.log(allTopic);

    client.on('connect', () => {
      console.log('Client MQTT connecté');
      client.subscribe(allTopic, function (err) {
        if (!err) {
          console.log(`Souscription aux topics suivant réussie:`);
          allTopic.forEach(topic => console.log(topic));
        }
      });
    });

    client.on('reconnect', () => {
      console.log('Reconnexion au broker MQTT');
    });

    client.on('error', (error) => {
      console.log('Erreur de connexion au broker MQTT:', error);
    });

    client.on('offline', () => {
      console.log('Le client MQTT est déconnecté');
    });

    // Gérer les événements de messages du client MQTT
    client.on('message', async function (topic, message) {
      //console.log('Message reçu:', topic, message.toString());
      try{
        const accessoryId = await database.getAccessoryIdFromTopic(topic);
        const accessoryType = await database.getAccessoryTypeFromAccessoryId(accessoryId);

        switch (accessoryType) {
          case "light":
            const rowOn = await database.getParameterByAccessoryIdAndName(accessoryId, "payloadOn");
            const rowOff = await database.getParameterByAccessoryIdAndName(accessoryId, "payloadOff");
            if (rowOn.parameters_value === message.toString()) {
              await database.updateValueByValueNameAndAccessoryId(accessoryId, 'on', 1);
              io.emit('accessory', {id: accessoryId, type: accessoryType, valueName: 'on', value: 1});
            } else if (rowOff.parameters_value === message.toString()) {
              await database.updateValueByValueNameAndAccessoryId(accessoryId, 'on', 0);
              io.emit('accessory', {id: accessoryId, type: accessoryType, valueName: 'on', value: 0});
            } else {
              console.log("Le message ne correspond à aucune valeur de parameter_value");
            }
            break;
        }
      } catch(err){
        console.error(err);
      }
    });
  } catch (err) {
    console.error(err);
    process.exit(1);
  }
})();

//