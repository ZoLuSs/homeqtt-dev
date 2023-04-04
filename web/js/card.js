const cards = document.querySelectorAll(".card.light");

cards.forEach((card) => {
  card.addEventListener("click", function() {
    const id = this.id;
    // Faites quelque chose avec l'ID récupéré
    console.log(`L'élément cliqué a l'ID: ${id}`);
  });
});