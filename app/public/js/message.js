const messageCloseButton = document.querySelector(".message .close");
const messageWrapper = document.querySelector(".message-wrapper");
const messageOverlay = document.querySelector(".message-wrapper .overlay");

if (messageCloseButton != null && messageWrapper != null && messageOverlay != null) {
  messageWrapper.style.display = "flex";

  messageCloseButton.addEventListener("click", () => {
    messageWrapper.style.display = "none";
  });

  messageOverlay.addEventListener("click", () => {
    messageWrapper.style.display = "none";
  });
}
