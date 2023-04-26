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
    document.addEventListener('click', function(event) {
        if (!element.contains(event.target)) {
            element.classList.remove(className);
        }else{
            element.classList.toggle(className)
        }
    });
    document.addEventListener('touch', function(event) {
        if (!element.contains(event.target)) {
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
  notification.style.setProperty("--index", notificationCount + 1);
  notifications.appendChild(notification);

  setTimeout(() => {
    notification.style.opacity = 1;
  }, 100);

  if (duration > 0) {
    setTimeout(() => {
      hideNotification(notification);
    }, duration);
  }

  notification.addEventListener("click", () => {
    hideNotification(notification);
  });

  notificationCount++;
}

function hideNotification(notification) {
  notification.style.opacity = 0;

  setTimeout(() => {
    notification.parentNode.removeChild(notification);

    notificationCount--;

    const notifications = document.querySelectorAll(".notification");
    for (let i = 0; i < notifications.length; i++) {
      notifications[i].style.setProperty("--index", i + 1);
    }
  }, 300);
}

loading = document.getElementById("modal");

function sendJSON(url, data, endurl){
    fetch(url, {
        method: "POST",
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify(data)
    })
    .then(response => {
        if (response.status >= 200 && response.status <= 299) {
            window.location.href = endurl;
            loading.style.display = "none";
        } else {
            loading.style.display = "none";
        }
        return response.json();
    })
    .then(result=>{
        showNotification(result, "error", 5000);
    });
}