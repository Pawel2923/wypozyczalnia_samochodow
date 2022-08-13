const mobileNav = document.querySelector(".mobile-nav-top .nav-wrapper");
const openButton = document.querySelector(".mobile-nav .open");
const closeButton = document.querySelector(".mobile-nav-top .nav-wrapper .close");

if (openButton != null) {
  openButton.addEventListener("click", () => {
    mobileNav.classList.remove("wrapper-transform");
    document.querySelector("body").style.overflow = "hidden";
  });
}

if (closeButton != null) {
  closeButton.addEventListener("click", () => {
    mobileNav.classList.add("wrapper-transform");

    document.querySelector("body").style.overflow = "auto";
  });
}