const settings = document.querySelectorAll(".all-settings main>div");
for (let i = 0; i < settings.length; i++) {
  settings[i].style.display = "none";
}
if (settings[0] !== undefined) {
  settings[0].classList.add("visible-settings");
  settings[0].style.display = "block";
}

const findSettings = (settingName) => {
  let settingsName = [];
  for (let i = 0; i < settings.length; i++) {
    settingsName[i] = settings[i].className;
  }
  for (let i = 0; i < settings.length; i++) {
    if (settingsName[i].includes("visible-settings")) {
      let name = settingsName[i];
      name = name.split(" ");
      settingsName[i] = name[0];
    }
  }

  for (let i = 0; i < settings.length; i++) {
    if (settingsName[i] === settingName) {
      if (window.innerWidth < 800) {
        closeMobileNav();
      }
      return i;
    }
  }
  return "EXIT";
};

const changeSettings = (settingName) => {
  let open = findSettings(settingName);
  if (open !== "EXIT") {
    let close = 0;
    for (let i = 0; i < settings.length; i++) {
      if (settings[i].className.indexOf("visible-settings") > -1) close = i;
    }

    if (open !== close) {
      document.querySelector("body").style.overflow = "hidden";

      settings[close].classList.remove("visible-settings");
      setTimeout(() => {
        settings[close].style.display = "none";
      }, 200);

      settings[open].style.display = "block";
      setTimeout(() => {
        settings[open].classList.add("visible-settings");
        document.querySelector("body").style.overflow = "initial";
      }, 200);
    }
  }
};

const vehLink = document.querySelector("nav.panel .veh-link");
if (vehLink != null) {
  vehLink.addEventListener("click", () => {
    changeSettings("vehicles");
  });
}

const usersLink = document.querySelector("nav.panel .users-link");
if (usersLink != null) {
  usersLink.addEventListener("click", () => {
    changeSettings("users");
  });
}

const settingsLink = document.querySelector("nav.panel .settings-link");
if (settingsLink != null) {
  settingsLink.addEventListener("click", () => {
    changeSettings("settings");
  });
}

const profileLink = document.querySelector("nav.panel .profile-link");
if (profileLink != null) {
  profileLink.addEventListener("click", () => {
    changeSettings("profile");
  });
}

const openMobileNav = () => {
  document.querySelector("nav.panel").style.transform = "translateX(0)";
  document.body.style.overflow = "hidden";
  document.querySelector(".mobile-nav .overlay").style.display = "block";
  setTimeout(() => {
    document.querySelector(".mobile-nav .overlay").style.opacity = 1;
  }, 2);
  if (window.innerWidth < 800) {
    let startClientX;
    document.addEventListener("touchstart", (e) => {
      startClientX = e.touches[0].clientX;
    });
    let clientX;
    document.addEventListener("touchmove", (e) => {
      clientX = e.touches[0].clientX;
      if (startClientX > 30 && startClientX - 30 > clientX) {
        closeMobileNav();
      }
    });
  }
};

const closeMobileNav = () => {
  document.querySelector("nav.panel").style.transform = "translateX(-100%)";
  document.body.style.overflow = "auto";
  document.querySelector(".mobile-nav .overlay").style.opacity = 0;
  setTimeout(() => {
    document.querySelector(".mobile-nav .overlay").style.display = "none";
  }, 200);
};

const homeSettings = () => {
  document.querySelectorAll(".home-option").forEach((option) => {
    let optionClassname = option.classList.value.split(" ");
    optionClassname = optionClassname[optionClassname.length - 1];

    option.addEventListener("click", () => {
      changeSettings(optionClassname);
      if (optionClassname === 'inbox') {
        let prevHref = window.location.pathname.split("/");
        prevHref.pop();
        window.location.pathname = `${prevHref[prevHref.length-1]}/admin/${optionClassname}.php`;
      } else {
        window.location.hash = `#${optionClassname}`;
      }
    });
  });
};

if (window.location.hash === "#vehicles") {
  changeSettings("vehicles");
} else if (window.location.hash === "#users") {
  changeSettings("users");
} else if (window.location.hash === "#settings") {
  changeSettings("settings");
} else if (window.location.hash === "#profile") {
  changeSettings("profile");
}

document.querySelector(".mobile-nav .open").addEventListener("click", () => {
  openMobileNav();
});
document.querySelector(".mobile-nav .overlay").addEventListener("click", () => {
  closeMobileNav();
});

if (window.innerWidth < 800) {
  let startClientX;
  document.addEventListener("touchstart", (e) => {
    startClientX = e.touches[0].clientX;
  });
  let clientX;
  document.addEventListener("touchmove", (e) => {
    clientX = e.touches[0].clientX;
    if (startClientX < 30 && startClientX + 30 < clientX) {
      openMobileNav();
    }
  });
}

const closeButton = document.querySelector(".message .close");
const msgWrapper = document.querySelector(".message-wrapper");
const msgOverlay = document.querySelector(".message-wrapper .overlay");

if (closeButton != null && msgWrapper != null && msgOverlay != null) {
  closeButton.addEventListener("click", () => {
    msgWrapper.style.display = "none";
  });
  msgOverlay.addEventListener("click", () => {
    msgWrapper.style.display = "none";
  });
}

const mobileLoggedMenuHandler = () => {
  if (window.innerWidth < 800) {
    const mobileLogged = document.querySelector(".logged");
    const mobileLoggedMenu = document.querySelector(".logged-menu");
    const mLMenuOverlay = document.querySelector(".mobile-logged-menu-overlay");

    if (mobileLogged != null && mobileLoggedMenu != null) {
      mobileLogged.addEventListener("click", () => {
        mobileLoggedMenu.classList.toggle("show-logged-menu");

        if (mLMenuOverlay != null) {
          mLMenuOverlay.style.display = "block";
          mLMenuOverlay.addEventListener("touchend", () => {
            mobileLoggedMenu.classList.remove("show-logged-menu");
            mLMenuOverlay.style.display = "none";
          });
        }
      });
    }
  }
};

window.addEventListener("resize", () => {
  if (window.innerWidth > 800)
    document.querySelector("nav.panel").style.transform = "translateX(0)";
  else closeMobileNav();

  mobileLoggedMenuHandler();
});

homeSettings();
mobileLoggedMenuHandler();
