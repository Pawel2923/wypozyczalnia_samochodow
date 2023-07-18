import checkInput from "./checkInput.js";

const main = () => {
    checkInput(document.querySelector('.subscription-form form input[name="newsletter-mail"]'));
};

export default main;
