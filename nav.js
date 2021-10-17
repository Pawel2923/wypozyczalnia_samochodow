const mobileNav = document.querySelector('.mobile-nav .nav-wrapper');
const openButton = document.querySelector('.mobile-nav .open');
const closeButton = document.querySelector('.mobile-nav .nav-wrapper .close');

openButton.addEventListener('click', () => {
    mobileNav.style.transform = "translateX(0)";
    console.log("Kliknięto ." + openButton.className);
});

closeButton.addEventListener('click', () => {
    mobileNav.style.transform = "translateX(100%)";
    console.log("Zamknięto menu");
});