const mobileNav = document.querySelector('.mobile-nav .nav-wrapper');
const openButton = document.querySelector('.mobile-nav .open');
const closeButton = document.querySelector('.mobile-nav .nav-wrapper .close');

openButton.addEventListener('click', () => {
    mobileNav.style.transform = "translateX(0)";
    mobileNav.style.webkitTransform = "translateX(0)";
    mobileNav.style.mozTransform = "translateX(0)";
    mobileNav.style.msTransform = "translateX(0)";
    mobileNav.style.oTransform = "translateX(0)";
});

closeButton.addEventListener('click', () => {
    mobileNav.style.transform = "translateX(100%)";
    mobileNav.style.webkitTransform = "translateX(100%)";
    mobileNav.style.mozTransform = "translateX(100%)";
    mobileNav.style.msTransform = "translateX(100%)";
    mobileNav.style.oTransform = "translateX(100%)";
});