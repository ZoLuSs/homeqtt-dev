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