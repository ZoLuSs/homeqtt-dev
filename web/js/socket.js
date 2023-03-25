// Ecouteur d'événement pour le message socket.io
socket.on('light', function(data) {
    var element = document.getElementById('light_'+data.id);
    if (data.value === 'ON') {
      element.classList.add('active');
    } else {
      element.classList.remove('active');
    }
});

socket.on('connect', () => {
    console.log('Client MQTT connecté');
    showNotification("Connexion réussie", "success", 3000);
    loading.style.display = "none";
    if (myArray) {
        // Envoi du tableau avec socket.io vers "getStatus"
        console.log("myArray exist");
        socket.emit("getStatus", myArray);
      }
});

socket.on('disconnect', () => {
    console.log('Client MQTT déconnecté');
    showNotification("Connexion au websocket intérompue", "error", 5000);
    loading.style.display = "flex";
});

socket.on('reconnect', () => {
    console.log('Reconnexion au broker MQTT');
});

socket.on('error', (error) => {
    console.log('Erreur de connexion au broker MQTT:', error);
});

socket.on('offline', () => {
    console.log('Le client MQTT est déconnecté');
});