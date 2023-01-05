const location = document
  .querySelector("script[class='script-changeLocation']")
  .getAttribute("value");
const timeout = document
  .querySelector("script[class='script-changeLocation']")
  .getAttribute("id");

setTimeout(() => {
  window.location = `${location}`;
}, timeout);
