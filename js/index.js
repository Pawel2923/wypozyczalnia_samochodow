import main from "./main.js";

const carButton = document.querySelectorAll(".car-button");

carButton.forEach((button) => {
  button.addEventListener("click", () => {
    const vehicleID = button.value * 1;
    window.location = `book.php?vehicle-id=${vehicleID}`;
  });
});

main();