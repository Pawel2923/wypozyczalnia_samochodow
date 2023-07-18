import main from "./main.js";
import checkInput from "./checkInput.js";

main();
const formInputs = document.querySelectorAll('main form input, main form textarea');

formInputs.forEach(input => {
    checkInput(input);
});