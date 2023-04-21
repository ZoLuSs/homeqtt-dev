const cards_light = document.querySelectorAll(".card.light");

cards_light.forEach((card) => {
  let isLongClick = false;
  let timerId;

  function handleClick() {
    const id = card.id;
    const type = card.getAttribute("data-type");
    const isActive = card.classList.contains("active");

    if (!isLongClick) {
      const accessoryID = this.id.substring(10);
      const payload = isActive ? "off" : "on";

      setAccessory = {
        "accessoryID": accessoryID,
        "set": "setOn",
        "payload": payload
      }
      socket.emit("setAccessory", setAccessory);
    }
    isLongClick = false;
  }

  function handleLongClick() {
    console.log(`Long click on light with accessory ID: ${card.id} of type: ${card.getAttribute("data-type")}`);
    isLongClick = true;
  }

  function handleMouseDown() {
    timerId = setTimeout(handleLongClick, 500);
  }

  function handleMouseUp() {
    clearTimeout(timerId);
  }

  card.addEventListener("mousedown", handleMouseDown);
  card.addEventListener("mouseup", handleMouseUp);
  card.addEventListener("click", handleClick);

  const observer = new MutationObserver(function(mutations) {
    mutations.forEach(function(mutation) {
      if (mutation.type === "attributes") {
        const attributeName = mutation.attributeName;
        if (
          attributeName === "data-hue" ||
          attributeName === "data-sat" ||
          attributeName === "data-ct" ||
          attributeName === "data-dim"
        ) {
          setBackground(card, card.getAttribute("data-type"));
        }
      }
    });
  });

  observer.observe(card, {
    attributes: true,
    attributeFilter: ["data-hue", "data-sat", "data-ct", "data-dim"],
  });

  setBackground(card, card.getAttribute("data-type"));
});


function setBackground(card, type) {
  switch (type) {
    case "rgb":
      const hue = card.getAttribute("data-hue");
      const sat = card.getAttribute("data-sat");
      card.style.backgroundColor = `hsl(${hue}, ${sat}%, 50%)`;
      break;
    case "hue":
      const hueValue = card.getAttribute("data-hue");
      card.style.backgroundColor = `hsl(${hueValue}, 100%, 50%)`;
      break;
    case "cct":
      const ctValue = card.getAttribute("data-ct");
      if (ctValue === "cold") {
        card.style.backgroundColor = "#e0e0ff";
      } else if (ctValue === "warm") {
        card.style.backgroundColor = "#ffd9b3";
      } else {
        card.style.backgroundColor = "#f2f2f2";
      }
      break;
    case "dimmable":
      const dimValue = card.getAttribute("data-dim");
      card.style.backgroundColor = `rgba(0, 0, 0, ${dimValue / 100})`;
      break;
  }
}
