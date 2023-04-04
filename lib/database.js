const sqlite3 = require('sqlite3');
const db = new sqlite3.Database('homeqtt.db', sqlite3.OPEN_READWRITE);

function getAccessoryIdFromTopic(topicName) {
    return new Promise((resolve, reject) => {
        db.get(`SELECT accessory_id FROM topics WHERE topic_name = ?`, [topicName], (err, row) => {
        if (err) {
            console.log(err.message);
            reject(err);
        } else if (row) {
            resolve(row.accessory_id);
        } else {
            reject("No row found");
        }
        });
    });
}

function getAccessoryTypeFromAccessoryId(accessoryId) {
    return new Promise((resolve, reject) => {
        db.get(`SELECT accessory_type FROM accessories WHERE accessory_id = ? `, [accessoryId], (err, row) => {
        if (err) {
            reject(err.message);
        } else if (row) {
            resolve(row.accessory_type);
        } else {
            reject(`Accessory with id ${accessoryId} not found in database`);
        }
        });
    });
}

function getParameterByAccessoryIdAndName(accessoryId, parametersName) {
    return new Promise((resolve, reject) => {
        db.get(`SELECT * FROM parameters WHERE accessory_id = ? AND parameters_name = ?`, [accessoryId, parametersName], (err, row) => {
            if (err) {
            reject(err.message);
            } else if (row) {
            resolve(row);
            } else {
            reject(`Parameters with id ${accessoryId} and ${parametersName} not found in database`);
            }
        });
    });
}

function getPayloadFormater(topicName){
    return new Promise((resolve, reject) => {
        db.get(`SELECT payload_formatter FROM topics WHERE topic_name = ?`, [topicName], (err, row) => {
        if (err) {
            console.log(err.message);
            reject(err);
        } else if (row) {
            resolve(row.payload_formatter);
        } else {
            reject("No row found");
        }
        });
    });
}

function getValueByAccessoryIdAndName(accessoryId, valueName) {
    return new Promise((resolve, reject) => {
        db.get(`SELECT value FROM 'values' WHERE accessory_id = ? AND value_name = ?`, [accessoryId, valueName], (err, row) => {
            if (err) {
            reject(err.message);
            } else if (row) {
            resolve(row.value);
            } else {
            reject(`Value with id ${accessoryId} and name ${parametersName} not found in database`);
            }
        });
    });
}

function updateValueByValueNameAndAccessoryId(accessoryId, valueName, newValue) {
return new Promise((resolve, reject) => {
    const now = Date.now();
    db.run(`UPDATE "values" SET value = ?, timestamp = ? WHERE accessory_id = ? AND value_name = ?`, [newValue, now, accessoryId, valueName], function(err) {
    if (err) {
        reject(err);
    } else {
        resolve(`Updated ${this.changes} rows`);
    }
    });
});
}

module.exports = {
    getAccessoryIdFromTopic,
    getAccessoryTypeFromAccessoryId,
    getParameterByAccessoryIdAndName,
    getPayloadFormater,
    getValueByAccessoryIdAndName,
    updateValueByValueNameAndAccessoryId
  };