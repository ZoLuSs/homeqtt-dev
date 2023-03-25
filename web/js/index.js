if (document.getElementById("clock")) {
    document.getElementById("clock").innerHTML = formatedCurrentTime("Hhi");

    setInterval(function() {
        document.getElementById("clock").innerHTML = formatedCurrentTime("Hhi");
    }, 100);
}

function formatedCurrentTime(format){
    var now = new Date();
    var hours = now.getHours();
    var minutes = now.getMinutes();
    var seconds = now.getSeconds();

    hours = (hours < 10) ? "0" + hours : hours;
    minutes = (minutes < 10) ? "0" + minutes : minutes;
    seconds = (seconds < 10) ? "0" + seconds : seconds;

    switch(format){
        case "H:i:s":
            data = hours + ":" + minutes + ":" + seconds;
            break;

        case "Hhi":
            data = hours + "h" + minutes;
            break;

        default:
            data = hours + ":" + minutes + ":" + seconds;
            break;
    }

    return data;
}

function classOnClickMGMT(element, className) {
    // Ajoute un écouteur d'événements "click" sur le document
    document.addEventListener('click', function(event) {
        // Vérifie si l'événement de clic ne s'est pas produit à l'intérieur de l'élément
        if (!element.contains(event.target)) {
            // Supprime la classe de l'élément
            element.classList.remove(className);
        }else{
            element.classList.toggle(className)
        }
    });
    document.addEventListener('touch', function(event) {
        // Vérifie si l'événement de clic ne s'est pas produit à l'intérieur de l'élément
        if (!element.contains(event.target)) {
            // Supprime la classe de l'élément
            element.classList.remove(className);
        }else{
            element.classList.toggle(className)
        }
    });
}

classOnClickMGMT(document.getElementById('add'), "show");
classOnClickMGMT(document.getElementById('setup'), "show");

let notificationCount = 0;
const notificationMargin = 10;
const notificationHeight = 50;

function showNotification(message, level, duration) {
  const notifications = document.getElementById("notifications");

  // Créer une nouvelle notification
  const notification = document.createElement("div");
  notification.classList.add("notification");
  notification.classList.add(level);
  notification.textContent = message;

  // Ajouter un attribut CSS pour positionner la notification
  notification.style.setProperty("--index", notificationCount + 1);

  // Ajouter la notification à la liste des notifications
  notifications.appendChild(notification);

  // Animer l'affichage de la notification
  setTimeout(() => {
    notification.style.opacity = 1;
  }, 100);

  // Cacher la notification après un certain temps
  if (duration > 0) {
    setTimeout(() => {
      hideNotification(notification);
    }, duration);
  }

  // Ajouter un gestionnaire d'événements pour cacher la notification lorsque l'utilisateur clique dessus
  notification.addEventListener("click", () => {
    hideNotification(notification);
  });

  // Incrémenter le compteur de notifications
  notificationCount++;
}

function hideNotification(notification) {
  // Animer la disparition de la notification
  notification.style.opacity = 0;

  // Supprimer la notification du DOM après l'animation
  setTimeout(() => {
    notification.parentNode.removeChild(notification);

    // Décrémenter le compteur de notifications
    notificationCount--;

    // Réajuster la position des notifications restantes
    const notifications = document.querySelectorAll(".notification");
    for (let i = 0; i < notifications.length; i++) {
      notifications[i].style.setProperty("--index", i + 1);
    }
  }, 300);
}