const names = ["login", "password", "password-confirm", "old-password"];

names.forEach((name) => {
  const target = document.querySelector(`form input[name='${name}']`);
  if (target) {
    target.addEventListener("invalid", () => {
      target.classList.add("subscription-input-invalid2");
    });

    target.addEventListener("keyup", () => {
      target.classList.remove("subscription-input-invalid2");
    });

    const targetLabel = document.querySelector(`.${name} label`);

    if (target.value != "")
      targetLabel.classList.remove("form-label-transform-start");
    else targetLabel.classList.add("form-label-transform-start");

    target.addEventListener("focus", () =>
      targetLabel.classList.add("form-label-transform")
    );

    target.addEventListener("focusout", () => {
      if (target.value == 0) {
        targetLabel.classList.remove("form-label-transform");
        targetLabel.classList.add("form-label-transform-end");
      }
    });
  }
});

document.querySelector(".back").addEventListener("click", () => {
  window.location = "./index.php";
});
