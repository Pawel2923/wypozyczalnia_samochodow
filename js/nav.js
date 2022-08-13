const wrapper = document.querySelector(".mobile-nav-wrapper");
const openButton = document.querySelector(".mobile-nav .open");
const closeButton = document.querySelector(".mobile-nav .close");

if (openButton != null) {
  openButton.addEventListener("click", () => {
    wrapper.classList.remove("wrapper-transform");
    document.querySelector("body").style.overflow = "hidden";
  });
}

if (closeButton != null) {
  closeButton.addEventListener("click", () => {
    wrapper.classList.add("wrapper-transform");

    document.querySelector("body").style.overflow = "auto";
  });
}