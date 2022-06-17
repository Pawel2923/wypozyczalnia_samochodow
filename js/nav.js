const mobileNav = document.querySelector(".mobile-nav-top .nav-wrapper");
const openButton = document.querySelector(".mobile-nav-top .open");
const closeButton = document.querySelector(
  ".mobile-nav-top .nav-wrapper .close"
);

if (openButton != null) {
  const openMenu = () => {
    mobileNav.style.transform = "translateX(0)";
    mobileNav.style.webkitTransform = "translateX(0)";
    mobileNav.style.mozTransform = "translateX(0)";
    mobileNav.style.msTransform = "translateX(0)";
    mobileNav.style.oTransform = "translateX(0)";
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
          mobileNav.style.transform = "translateX(100%)";
          mobileNav.style.webkitTransform = "translateX(100%)";
          mobileNav.style.mozTransform = "translateX(100%)";
          mobileNav.style.msTransform = "translateX(100%)";
          mobileNav.style.oTransform = "translateX(100%)";
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
    mobileNav.style.transform = "translateX(100%)";
    mobileNav.style.webkitTransform = "translateX(100%)";
    mobileNav.style.mozTransform = "translateX(100%)";
    mobileNav.style.msTransform = "translateX(100%)";
    mobileNav.style.oTransform = "translateX(100%)";
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

if (window.innerWidth < 800) {
  let prevScrollPos = window.scrollY;

  window.addEventListener("scroll", () => {
    let currentScrollPos = window.scrollY;

    prevScrollPos > currentScrollPos
      ? (document.querySelector("nav.mobile-nav-top").style.top =
          "0")
      : (document.querySelector("nav.mobile-nav-top").style.top =
          "-100%");

    prevScrollPos = currentScrollPos;
  });
}
