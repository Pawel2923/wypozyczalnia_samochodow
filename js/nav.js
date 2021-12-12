const mobileNav = document.querySelector('.mobile-nav .nav-wrapper');
const openButton = document.querySelector('.mobile-nav .open');
const closeButton = document.querySelector('.mobile-nav .nav-wrapper .close');

if (openButton != null) {
    const openMenu = () => {
        mobileNav.style.transform = "translateX(0)";
        mobileNav.style.webkitTransform = "translateX(0)";
        mobileNav.style.mozTransform = "translateX(0)";
        mobileNav.style.msTransform = "translateX(0)";
        mobileNav.style.oTransform = "translateX(0)";
        document.querySelector('body').style.overflow = "hidden";
    };
    openButton.addEventListener('click', () => {
        openMenu();
    });
    const innerWidth = window.innerWidth;
    document.addEventListener('touchmove', (e) => {
        const clientX = e.touches[0].clientX;

        if (innerWidth - clientX < 30) {
            openMenu();
        }
    });
}

if (closeButton != null) {
    closeButton.addEventListener('click', () => {
        mobileNav.style.transform = "translateX(100%)";
        mobileNav.style.webkitTransform = "translateX(100%)";
        mobileNav.style.mozTransform = "translateX(100%)";
        mobileNav.style.msTransform = "translateX(100%)";
        mobileNav.style.oTransform = "translateX(100%)";
        document.querySelector('body').style.overflow = "auto";
    });
}

const mobileLogged = document.querySelector('.mobile-nav .logged');
const mobileLoggedMenu = document.querySelector('.mobile-nav .logged-menu');
const mLMenuOverlay = document.querySelector('.mobile-logged-menu-overlay');

if (mobileLogged != null && mobileLoggedMenu != null) {
    mobileLogged.addEventListener('click', () => {
        mobileLoggedMenu.classList.toggle('show-logged-menu'); 
        
        if (mLMenuOverlay != null) {
            mLMenuOverlay.style.display = "block";
            mLMenuOverlay.addEventListener('click', () => {
                mobileLoggedMenu.classList.remove('show-logged-menu');
                mLMenuOverlay.style.display = "none";
            });
        }
    });
}