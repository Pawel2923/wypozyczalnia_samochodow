const checkInput = (input) => {
  input.addEventListener("invalid", () => {
    input.classList.add("subscription-input-invalid");
  });
  input.addEventListener("keyup", () => {
    input.classList.remove("subscription-input-invalid");
  });
};

export default checkInput;