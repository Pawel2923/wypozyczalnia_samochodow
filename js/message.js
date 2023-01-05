const msgCloseButton = document.querySelector(".message .close");
const msgWrapper = document.querySelector(".message-wrapper");
const msgOverlay = document.querySelector(".message-wrapper .overlay");

if (msgWrapper) {
  msgWrapper.style.display = "flex";
}

if (msgCloseButton != null && msgWrapper != null && msgOverlay != null) {
  msgCloseButton.addEventListener("click", () => {
    msgWrapper.style.display = "none";
  });
  msgOverlay.addEventListener("click", () => {
    msgWrapper.style.display = "none";
  });
}
