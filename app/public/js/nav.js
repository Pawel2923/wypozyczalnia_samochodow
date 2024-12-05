const mobileNavWrapper = document.querySelector(".mobile-nav-wrapper");
const openButton = document.querySelector(".mobile-nav .open");
const closeButton = document.querySelector(".mobile-nav .close");

if (openButton != null) {
  openButton.addEventListener("click", () => {
    mobileNavWrapper.classList.remove("wrapper-transform");
    document.querySelector("body").style.overflow = "hidden";
  });
}

if (closeButton != null) {
  closeButton.addEventListener("click", () => {
    mobileNavWrapper.classList.add("wrapper-transform");
    document.querySelector("body").style.overflow = "auto";
  });
}

window.addEventListener("scroll", () => {
  const fixedNav = document.querySelector(".fixed-nav");
  if (window.innerWidth > 800) {
    const nav = document.querySelectorAll(".desktop-nav");
    const navHeight = nav[0].offsetHeight;
    if (window.pageYOffset > navHeight) {
      fixedNav.classList.add("fixed-nav-transform");
      fixedNav.style.opacity = 1;
    } else {
      fixedNav.classList.remove("fixed-nav-transform");
    }
  } else {
    fixedNav.classList.remove("fixed-nav-transform");
  }
});

const vehiclesBtn = document.getElementById("vehicles-button");

if (vehiclesBtn) {
  vehiclesBtn.addEventListener("click", () => {
    window.location = "user.php#vehicles";
  });
}
