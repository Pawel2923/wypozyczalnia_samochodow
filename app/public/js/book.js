import checkInput from "./checkInput.js";

document.querySelectorAll("input").forEach((input) => {
  checkInput(input);
});

const rentInputs = document.querySelectorAll("section form input");

rentInputs.forEach((input) => {
  input.addEventListener("change", () => {
    const amount = document.querySelector('form input[name="amount"]').value;
    document.querySelector(".summary .amount").innerHTML =
      "Liczba godzin wynajmu: <h3>" + amount + "</h3>";
    const date = document.querySelector('form input[name="date"]').value;
    document.querySelector(".summary .date").innerHTML =
      "Data wynajmu: <h3>" + date + "</h3>";
    let total =
      amount *
      document.querySelector("script[src='js/book.js']").getAttribute("value");
    document.querySelector(".summary .price").innerHTML =
      "W sumie do zapłaty: <h3>" + total.toFixed(2) + "zł</h3>";
  });
});
