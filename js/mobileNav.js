const date = new Date();
const hour = date.getHours();
const username = document.querySelector(".card script[src='js/mobileNav.js']").getAttribute("value");
let welcomeMessage = "Dzień dobry ";

if (hour > 19 || hour < 5) {
  welcomeMessage = "Dobry wieczór ";
}

welcomeMessage = welcomeMessage + `<b>${username}</b>`;
document.write(welcomeMessage);
