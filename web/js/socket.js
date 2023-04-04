// Ecouteur d'événement pour le message socket.io
socket.on('accessory', function(data) {
    const items = Array.isArray(data) ? data : [data];
    // items contiendra soit data (s'il est déjà un tableau), soit un tableau contenant uniquement data
    items.forEach((item) => {
      const element = document.getElementById(`accessory_${item.id}`);
      switch (item.type) {
        case "light":
          switch (item.valueName) {
            case "on":
              if (item.value) {
                element.classList.add('active');
              } else {
                element.classList.remove('active');
              }
              break;
          }
          break;
      }
    });
  });
  

socket.on('connect', () => {
    showNotification("Connexion réussie", "success", 3000);
    loading.style.display = "none";
    if (myArray) {
        // Envoi du tableau avec socket.io vers "getStatus"
        console.log("myArray exist");
        console.log(myArray);
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
            // Envoi du tableau avec socket.io vers "getStatus"
            console.log("myArray exist");
            console.log(myArray);
            socket.emit("getStatus", myArray);
});

socket.on('error', (error) => {
    console.log('Erreur de connexion au broker MQTT:', error);
});

socket.on('offline', () => {
    console.log('Le client MQTT est déconnecté');
});