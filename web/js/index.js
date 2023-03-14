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