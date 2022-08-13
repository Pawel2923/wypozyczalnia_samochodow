const mobileNav = document.querySelector(".mobile-nav-top .nav-wrapper");
const openButton = document.querySelector(".open");
const closeButton = document.querySelector(".nav-wrapper .close");

if (openButton != null) {
  const openMenu = () => {
    mobileNav.classList.remove("wrapper-transform");
    document.querySelector("body").style.overflow = "hidden";

    if (window.innerWidth < 800) {
      let startClientX;
      document.addEventListener("touchstart", (e) => {
        startClientX = e.touches[0].clientX;
      });
      let clientX;
      document.addEventListener("touchmove", (e) => {
        clientX = e.touches[0].clientX;
        if (startClientX < 30 && startClientX + 30 < clientX) {
          mobileNav.classList.add("wrapper-transform");

          document.querySelector("body").style.overflow = "auto";
        }
      });
    }
  };
  openButton.addEventListener("click", () => {
    openMenu();
  });

  if (window.innerWidth < 800) {
    const innerWidth = window.innerWidth;
    let startClientX;
    document.addEventListener("touchstart", (e) => {
      startClientX = e.touches[0].clientX;
    });
    let clientX;
    document.addEventListener("touchmove", (e) => {
      clientX = e.touches[0].clientX;
      if (innerWidth - clientX < 30 && startClientX + 30 > clientX) {
        openMenu();
      }
    });
  }
}

if (closeButton != null) {
  closeButton.addEventListener("click", () => {
    mobileNav.classList.add("wrapper-transform");

    document.querySelector("body").style.overflow = "auto";
  });
}

/*!
 * Run a callback function after scrolling has stopped
 * (c) 2017 Chris Ferdinandi, MIT License, https://gomakethings.com
 * @param  {Function} callback The callback function to run after scrolling
 * @param  {Integer}  refresh  How long to wait between scroll events [optional]
 */
function scrollStop(callback, refresh = 66) {
  // Make sure a valid callback was provided
  if (!callback || typeof callback !== "function") return;

  // Setup scrolling variable
  let isScrolling;

  // Listen for scroll events
  window.addEventListener(
    "scroll",
    function (event) {
      // Clear our timeout throughout the scroll
      window.clearTimeout(isScrolling);

      // Set a timeout to run after scrolling ends
      isScrolling = setTimeout(callback, refresh);
    },
    false
  );
}