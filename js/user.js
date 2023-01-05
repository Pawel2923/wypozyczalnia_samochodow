document.querySelectorAll(".edit-profile input").forEach((input) => {
  input.addEventListener("keypress", () => {
    document.querySelector("form .buttons").style.display = "flex";
  });
});

document
  .querySelector('main form button[type="reset"]')
  .addEventListener("click", () => {
    document.querySelector("form .buttons").style.display = "none";
  });
