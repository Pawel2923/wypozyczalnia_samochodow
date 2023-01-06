document.querySelectorAll(".edit-profile input").forEach((input) => {
  input.addEventListener("keypress", () => {
    document.querySelector("form .buttons").style.display = "flex";
  });

  input.addEventListener("click", () => {
    if (input.getAttribute("type") !== "email")
      input.setSelectionRange(0, input.value.length);
  });
});

document
  .querySelector('main form button[type="reset"]')
  .addEventListener("click", () => {
    document.querySelector("form .buttons").style.display = "none";
  });
